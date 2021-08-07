<?php

namespace App\Services;

use App\Exceptions\ExceptionTransaction;
use App\Repositories\UserRepository;
// use App\Jobs\SendNotificationJob;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    private $repository;
    private $userService;


    public function __construct(
        TransactionRepository $repository,
        UserService $userService

    ) {
        $this->repository = $repository;
        $this->userService = $userService;
 
    }

    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    public function findOrFail(int $id): Transaction
    {
        return $this->repository->findOrFail($id);
    }

    public function save(array $attributes, User $user): Transaction
    {
        $transaction = $this->repository->create($attributes);
        $payerWallet = $this->userService->findOrFail($transaction->payer);
        $payeeWallet = $this->userService->findOrFail($transaction->payee);

        // if ($payerWallet->user->id !== $user->id) {
        //     throw TransactionExceptions::walletDoesNotBelongToLoggedUser();
        // }

        if ($transaction->value > $payerWallet->wallet) {
            throw TransactionExceptions::valueGreaterThanAvailableValueInWallet();
        }

        DB::transaction(function () use ($transaction, $payerWallet, $payeeWallet) {
            $payerWalletValue = $payerWallet->wallet - $transaction->value;
            $this->userService->update($payerWallet, ['wallet' => $payerWalletValue]);

            $payeeWalletValue = $payeeWallet->wallet + $transaction->value;
            $this->walletService->update($payeeWallet, ['wallet' => $payeeWalletValue]);

            $this->repository->save($transaction);
            
        });

        // dispatch(new SendNotificationJob());

        return $transaction;
    }
}