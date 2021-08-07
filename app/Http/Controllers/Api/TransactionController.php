<?php

namespace App\Http\Controllers\Api;
// use App\Repositories\UserRepository;
// use App\Services\UserService;

use App\Enumerators\TransactionPermission;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    private $transactionService;
    

    public function __construct(TransactionService $service)
    {
        $this->transactionService = $service;
       
    }

    public function index()
    {
        
        $transactions = $this->transactionService->getAll();
        return response($transactions);
    }

    public function show(int $id)
    {
        
        $transaction = $this->transactionService->findOrFail($id);
        return response($transaction);
    }

    public function store(Request $request)
    {
        
        $validate = $this->validate($request, [
            'value' => 'required|numeric',
            'payer' => 'required|int|different:payee|exists:users,id,deleted_at,NULL,is_store,0',
            'payee' => 'required|int|different:payer|exists:users,id,deleted_at,NULL'
        ]);
        $user = auth()->user();
        //  $user =  $this-> user();
        $transaction = $transaction = $this->transactionService->save($validate, $user);
        return response($transaction)->json('aqui');
        // return response($transaction, Response::HTTP_CREATED);
    }
}