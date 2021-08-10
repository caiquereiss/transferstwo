<?php

namespace App\Jobs;

use App\Services\TransactionNotifyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyUser implements ShouldQueue
{   
    use Dispatchable, Queueable, InteractsWithQueue;
    private $payee;

    /**
     * Crie uma nova instância de trabalho.
     *@param User $payee
     * @return void
     */
    public function __construct(int $payee)
    {
        $this->payee = $payee;
    }

    /**
     * Executa o trabalho.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        try {
            
            (new TransactionNotifyService)->send($this->payee);
            Log::channel('notification')->info('Notificação enviada com sucesso!');
        } catch (\Exception $e) {
            Log::channel('notification')->error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
