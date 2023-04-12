<?php

namespace App\Console\Commands;

use App\Http\Actions\Accountant\BillIssue;
use Illuminate\Console\Command;
use Mpdf\MpdfException;

class BillIssueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bill:issue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bill issue';

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
        (new BillIssue())->execute([]);
        return 0;
    }
}
