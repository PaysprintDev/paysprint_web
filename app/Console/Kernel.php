<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\ApprovedUsersMove::class,
        Commands\AutoDepositOff::class,
        Commands\BvnListUpdate::class,
        Commands\ChargeFee::class,
        Commands\CheckTelephone::class,
        Commands\CronToConsumers::class,
        Commands\CronToMerchant::class,
        Commands\DailyExchange::class,
        Commands\DailyLimit::class,
        Commands\DocPendingList::class,
        Commands\ExbcCardRequest::class,
        Commands\ExistingAccounts::class,
        Commands\GenerateVirtualAccount::class,
        Commands\GetInvoiceCurrency::class,
        Commands\IdvCompletedList::class,
        Commands\IdvFailedList::class,
        Commands\IdvNotificationMessage::class,
        Commands\IdvPassedList::class,
        Commands\MailForVirtualAccount::class,
        Commands\MatchedUsersMove::class,
        Commands\MigrateToLevelOne::class,
        Commands\MonthlyLimit::class,
        Commands\MonthlyTransaction::class,
        Commands\MoveIndustry::class,
        Commands\MoveKybCompleted::class,
        Commands\NonMonthlyTransaction::class,
        Commands\NotificationPeriod::class,
        Commands\NotificationTable::class,
        Commands\NumberOfWithdrawals::class,
        Commands\NumberOfWithdrawalsForMerchant::class,
        Commands\PublishArchive::class,
        Commands\PublishExisting::class,
        Commands\QuickSetup::class,
        Commands\RefreshBid::class,
        Commands\RefundByCountryUpdate::class,
        Commands\RenewSub::class,
        Commands\ReportStatus::class,
        Commands\RewardPoint::class,
        Commands\RunQueue::class,
        Commands\SuspendedAccountList::class,
        Commands\TransactionLimits::class,
        Commands\TrullioVerification::class,
        Commands\UpdateStatementCountry::class,
        Commands\UserArchive::class,
        Commands\VirtualAccountTopUp::class,
        Commands\WeeklyLimit::class
        // Commands\DailyMetricsTask::class,
        // Commands\TestPSMoex::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('approvedusersmove:run')->cron('0 0 * * *');
        $schedule->command('autodepositoff:run')->cron('0 0 * * *');
        $schedule->command('bvnlistupdate:run')->cron('0 0 * * *');
        $schedule->command('chargefee:run')->cron('* * * * *');
        $schedule->command('checktelephone:run')->cron('*/5 * * * *');
        $schedule->command('crontoconsumer:run')->cron('0 9 * * 5');
        $schedule->command('crontomerchant:run')->cron('0 9 * * 1');
        $schedule->command('dailyexchange:run')->cron('0 2 * * *');
        $schedule->command('dailylimit:run')->cron('0 0 * * *');
        $schedule->command('docpendinglist:run')->cron('0 1 * * *');
        $schedule->command('exbccardrequest:run')->cron('0,30 * * * *');
        $schedule->command('existingaccount:run')->cron('0 5 1 * *');
        $schedule->command('generatevirtualaccount:run')->cron('*/5 * * * *');
        $schedule->command('getinvoicecurrency:run')->cron('*/5 * * * *');
        $schedule->command('idvcompletedlist:run')->cron('0 6 * * *');
        $schedule->command('idvfailedlist:run')->cron('0 2 * * *');
        $schedule->command('idvnotificationmessage:run')->cron('0 9 * * 1');
        $schedule->command('idvpassedlist:run')->cron('0 4 * * *');
        $schedule->command('mailtovirtualaccount:run')->cron('0 8 * * 4');
        $schedule->command('matchedusersmove:run')->cron('0 0 * * *');
        $schedule->command('migratetolevelone:run')->cron('* * * * *');
        $schedule->command('monthlylimit:run')->cron('0 0 1 * *');
        $schedule->command('monthlytransaction:run')->cron('0 7 28 * *');
        $schedule->command('moveindustry:run')->cron('0 0,12 * * *');
        $schedule->command('movekybcompleted:run')->cron('0 0,12 * * *');
        $schedule->command('nonmonthlytransaction:run')->cron('0 12 28 * *');
        $schedule->command('notificationperiod:run')->cron('*/5 * * * *');
        $schedule->command('notificationtable:run')->cron('* * * * *');
        $schedule->command('numberofwithdrawals:run')->cron('0 0 1 * *');
        $schedule->command('numberofwithdrawalsformerchant:run')->cron('0 0 * * 1');
        $schedule->command('publisharchive:run')->cron('0 0 * * *');
        $schedule->command('publishexisting:run')->cron('0 0 * * *');
        $schedule->command('quicksetup:run')->cron('10 15 1,15 * *');
        $schedule->command('refreshbid:run')->cron('59 23 * * *');
        $schedule->command('refundbycountryupdate:run')->cron('* * * * *');
        $schedule->command('renewsub:run')->cron('55 23 * * *');
        $schedule->command('reportstatus:run')->cron('* * * * *');
        $schedule->command('rewardpoint:run')->cron('0 13 26 * 1');
        $schedule->command('suspendedaccountlist:run')->cron('0 0 * * *');
        $schedule->command('transactionlimits:run')->cron('0,30 * * * *');
        $schedule->command('trullioverification:run')->cron('0,30 * * * *');
        $schedule->command('updatestatementcountry:run')->cron('* * * * *');
        $schedule->command('userarchive:run')->cron('0 0 1 * *');
        $schedule->command('virtualaccounttopup:run')->cron('* * * * *');
        $schedule->command('weeklylimit:run')->cron('0 0 * * 0');
        $schedule->command('mailqueue:run')->cron('*/1 * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
