<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repositorio de transações.
 */
class TransactionRepository
{    
    /**
     * Método para listar todas transações.
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection
    {
        return Transaction::all();
    }

    /**
     * Método para encontrar uma transaction especifica.
     * @param int $id
     * @return App\Models\Transaction
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Transaction
    {
        return Transaction::findOrFail($id);
    }

    /**
     * Método para preencher as informações da transação.
     * @param array $attributes
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function create(array $attributes): Transaction
    {
        return Transaction::make($attributes);
    }
    /**
     * Método para salvar uma transação.
     * @param Transaction $transaction
     * @return void
     */
    public function save(Transaction $transaction): void
    {
        $transaction->save();
    }
}