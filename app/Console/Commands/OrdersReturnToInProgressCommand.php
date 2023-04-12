<?php

namespace App\Console\Commands;

use App\Http\Actions\Order\OrdersReturnToInProgress;
use Illuminate\Console\Command;
use Mpdf\MpdfException;

class OrdersReturnToInProgressCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:return-in-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Orders return to in_progress';

    /**
     * Создать новый экземпляр команды.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws MpdfException
     */
    public function handle()
    {
        (new OrdersReturnToInProgress())->execute([]);
        return 0;
    }
}
