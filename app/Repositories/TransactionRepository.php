<?php

namespace App\Repositories;
use App\Repositories\UserRepository;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{
    public function all(): Collection
    {
        return Transaction::all();
    }

    public function findOrFail(int $id): Transaction
    {
        return Transaction::findOrFail($id);
    }

    public function create(array $attributes): Transaction
    {
        return Transaction::make($attributes);
    }

    public function save(Transaction $transaction): void
    {
        $transaction->save();
    }
}