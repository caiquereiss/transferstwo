<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Http;

/**
 * Essa classe é responsável por notificar o sucesso da transação!
 *  */ 
class TransactionNotifyService
{
    public  const MOCKY_URL = 'http://o4d9z.mocklab.io/notify';

    
    /**
     * Método de envio de notificação.
     *
     * @param User $payee
     * 
     */
    public function send(int $payee) 
    {
        try {

            $response = Http::get(self::MOCKY_URL, [
                'payee' => $payee
            ]);

        } catch(\Exception $e) {
            throw new \Exception('Não foi possivel enviar a notificação!');
        }
    }
}