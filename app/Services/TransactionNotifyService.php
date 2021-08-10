<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

/**
 * Essa classe é responsável por notificar o sucesso da transação!
 *
 * */ 
class TransactionNotifyService
{
    public  const MOCKY_URL = 'http://o4d9z.mocklab.io/notify';

    
    /**
     * Método de envio de notificação.
     *
     * @param int $payee
     * @return void
     * @throws \Exception
     */
    public function send(int $payee): void
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