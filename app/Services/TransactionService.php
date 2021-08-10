<?php

namespace App\Services;

use App\Exceptions\TransactionException;
use App\Exceptions\UnauthorizedTransactionException;
use App\Jobs\NotifyUser;
use App\Repositories\UserRepository;
// use App\Jobs\SendNotificationJob;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Essa classe é responsavel pela regra de negócio da transaction.
 */
class TransactionService
{
    private const  STATUS_CONFIRMED = '1';
    private const STATUS_CANCELLED = '2';
    private const AUTHORIZE_SERVICE_URL='https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

    private TransactionRepository $repository;
    private UserService $userService;

    public function __construct(
        TransactionRepository $repository,
        UserService $userService
    ) {
        $this->repository = $repository;
        $this->userService = $userService;
    }

        /**
     * Método para obter todas as transactions .
     * 
     */
    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Método para encontrar o id da transaction.
     *
     * @param Transaction $id
     * @return int
     */

    public function findOrFail(int $id): Transaction
    {
        return $this->repository->findOrFail($id);
    }


    /**
     * Método para validar os processos da transaction.
     *
     * @param Transaction $transaction
     * @throws TransactionException 
     */
    public function process(array $transactionData): Transaction
    {
        try {
            $transaction = $this->repository->create($transactionData);
            $payerWallet = $this->userService->findOrFail($transaction->payer);
            $payeeWallet = $this->userService->findOrFail($transaction->payee);

            $this->validatePayment($transaction, $payerWallet);

            DB::transaction(function () use ($transaction, $payerWallet, $payeeWallet) {
                $this->makePayment($transaction, $payerWallet, $payeeWallet);
            });

            dispatch(new NotifyUser($payeeWallet->id));
            return $transaction;

        } catch (UnauthorizedTransactionException $e) {
            $transaction->status = self::STATUS_CANCELLED;
            $this->repository->save($transaction);
            throw new TransactionException($e->getMessage());
        }
    }

    /**
     * Método para validar o pagamento.
     *
     * @param Transaction $transaction
     * @param User $payerWallet
     * @return void
     * @throws TransactionException
     */
    private function validatePayment($transaction, $payerWallet): void
    {
        if ($payerWallet->is_store == 1) {
            throw new TransactionException('Lojistas não podem efetuar pagamentos, apenas recebem.');
        }

        if ($transaction->value <= 0) {
            throw new TransactionException('O valor da transferência tem que ser maior que 0');
        }

        if ($transaction->value > $payerWallet->wallet) {
            $wallet = number_format($payerWallet->wallet, 2, ',', '.');
            $message = sprintf('Saldo insuficiente (R$ %s) para realizar essa transação.', $wallet);
            throw new TransactionException($message);
        }
    }

     /**
     * Método para realizar pagamento.
     *
     * @param Transaction $transaction
     * @param User $payerWallet | $payeeWallet
     * @return void
     * 
     */

    private function makePayment(Transaction $transaction, User $payerWallet, User $payeeWallet): void
    {
        $this->authorizePayment();

        $payerWalletValue = $payerWallet->wallet - $transaction->value;
        $this->userService->updateById($payerWallet->id, ['wallet' => $payerWalletValue]);

        $payeeWalletValue = $payeeWallet->wallet + $transaction->value;
        $this->userService->updateById($payeeWallet->id, ['wallet' => $payeeWalletValue]);

        $transaction->status = self::STATUS_CONFIRMED;
        $this->repository->save($transaction);
    }


    /**
     * Método para autorizar o pagamento.
     *@return void
     * @throws UnauthorizedTransactionException
     */

    private function authorizePayment(): void
    {
        $response = Http::get(self::AUTHORIZE_SERVICE_URL);
        if ($response->status() !== 200) {
            throw new UnauthorizedTransactionException('Transação não autorizada.');
        }
    }
}
