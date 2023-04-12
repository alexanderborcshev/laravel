<?php

namespace App\Console\Commands;

use App\Http\Actions\Offer\OffersStatisticUpdate;
use Illuminate\Console\Command;

class OffersStatisticUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Offers statistic update';

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
     */
    public function handle()
    {
        (new OffersStatisticUpdate())->execute([]);
        return 0;
    }
}
