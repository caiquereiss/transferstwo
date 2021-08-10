<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\TransactionException;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Classe responsavel por direcionar as requisições de transações.
 */
class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $service)
    {
        $this->transactionService = $service;
    }

    /**
     * Metodo para listar as transações
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = $this->transactionService->getAll();
        return response($transactions);
    }

    /**
     * Método para exibir as informações de uma transação especifica.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $transaction = $this->transactionService->findOrFail($id);
        return response($transaction);
    }

    /**
     * Método para solicitar a criação de uma transação.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $transactionData = $this->validate($request, [
                'value' => 'required|numeric',
                'payer' => 'required|int|different:payee|exists:users,id',
                'payee' => 'required|int|exists:users,id'
            ],[
                'payer.different' => 'O usuário pagador não pode ser o mesmo do recebedor',
                'payer.exists' => 'O usuário pagador é inválido.',
                'payee.exists' => 'O usuário recebedor é inválido.',
            ]);

            $transaction = $this->transactionService->process($transactionData);

            return response()->json(['message' => 'Transação realizada com sucesso!', 'data' => $transaction]);

        } catch (TransactionException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Oops, verifique os campos!', 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Oops...O servidor não está respondendo. Tente novamente mais tarde!'], 500);
        }

    }
}
