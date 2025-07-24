<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Organization;
use App\Exports\Org_With_Rep_Export;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;
use Illuminate\Support\Facades\Log;

class SendDailyReport extends Command
{
    protected $signature = 'report:daily';

    protected $description = 'Отправить ежедневный отчет';

    public function handle()
{
    Log::info('Отчет запущен');

    $yesterday = now();
    $organizations = Organization::with(['representatives' => function($query) use ($yesterday) {
        $query->whereDate('created_at', '=', $yesterday->toDateString());
    }])->whereDate('created_at', '=', $yesterday->toDateString())->get();

    $rows = [];

    foreach ($organizations as $org) {
        if ($org->representatives->isEmpty()) {
            $rows[] = [
                $org->full_name,
                $org->region,
                $org->email,
                '', '', ''
            ];
        } else {
            foreach ($org->representatives as $rep) {
                $rows[] = [
                    $org->full_name,
                    $org->region,
                    $org->email,
                    $rep->name,
                    $rep->position,
                    $rep->phone,
                ];
            }
        }
    }

    if(empty($rows)){
        $this->info('Нет записей за вчерашний день для отчета.');
        return 0;
    }

    $export = new Org_With_Rep_Export($rows);

    $filePath = storage_path('app/reports/daily_report.xlsx');
    Excel::store($export, 'reports/daily_report.xlsx');

    try {
        Mail::to('dadmont2@gmail.com')->send(new DailyReportMail($filePath));
        $this->info('Отчет отправлен успешно');
        Log::info('Отчет отправлен успешно');
    } catch (\Exception $e) {
        $this->error('Ошибка при отправке отчета: ' . $e->getMessage());
        Log::error('Ошибка при отправке отчета: ' . $e->getMessage());
    }

    $this->info('Отчет отправлен успешно');
}

}
