<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Organization;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReportMail;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SendDailyReport extends Command
{
    protected $signature = 'report:daily';
    protected $description = 'Отправка ежедневного отчета по шаблону';

    public function handle()
    {
        Log::info('Инициализация отправки ежедневного отчета');
        
        $yesterday = Carbon::yesterday();
        $reportDate = $yesterday->format('d.m.Y');
        
        try {
            $this->info("Формируем отчет за {$reportDate}...");
            $reportPath = $this->generateReport($yesterday);
            
            if (!$reportPath) {
                throw new \Exception('Не удалось сформировать отчет');
            }
            
            $this->info("Отправляем отчет на email...");
            Mail::to('dadmont2@gmail.com')
                ->send(new DailyReportMail($reportPath, $reportDate));
            
            $this->info("Отчет за {$reportDate} успешно отправлен!");
            Log::info("Отчет отправлен: {$reportPath}");
            
            return 0;
            
        } catch (\Exception $e) {
            $errorMsg = "Ошибка при отправке отчета: " . $e->getMessage();
            $this->error($errorMsg);
            Log::error($errorMsg);
            return 1;
        }
    }

    protected function generateReport($date)
    {
        $organizations = Organization::with(['representatives'])
            ->whereDate('created_at', $date->toDateString())
            ->get();
            
        if ($organizations->isEmpty()) {
            $this->info('Нет данных для отчета за ' . $date->format('d.m.Y'));
            return null;
        }


        $templatePath = storage_path('app/Reports/template.xlsx');
        $reportName = 'Отчет_ДОУ_' . $date->format('Y-m-d') . '.xlsx';
        $reportPath = storage_path('app/Reports/' . $reportName);
        
        if (!copy($templatePath, $reportPath)) {
            throw new \Exception('Не удалось создать копию шаблона');
        }

        $spreadsheet = IOFactory::load($reportPath);
        $sheet = $spreadsheet->getSheetByName('ДОУ');
        $this->fillReportData($sheet, $organizations);
        
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($reportPath);
        
        return $reportPath;
    }

    protected function fillReportData($sheet, $organizations)
    {
        $currentRow = 6; 
        
        foreach ($organizations as $index => $org) {
            // данные организации
            $sheet->setCellValue('A'.$currentRow, $index + 1);
            $sheet->setCellValue('B'.$currentRow, $org->full_name);
            $sheet->setCellValue('C'.$currentRow, $org->short_name);
            $sheet->setCellValue('D'.$currentRow, $org->locality);
            $sheet->setCellValue('E'.$currentRow, $org->municipal_district);
            $sheet->setCellValue('F'.$currentRow, $org->region);
            $sheet->setCellValue('G'.$currentRow, $org->inn ?? '');
            $sheet->setCellValue('H'.$currentRow, $org->ogrn ?? '');
            $sheet->setCellValue('I'.$currentRow, $org->email);
            $sheet->setCellValue('J'.$currentRow, $org->phone);

            // данные представителей
            foreach ($org->representatives as $repIndex => $rep) {
                if ($repIndex >= 10) break; 
                
                $startCol = 11 + ($repIndex * 6);
                $sheet->setCellValueByColumnAndRow($startCol, $currentRow, $rep->accord);
                $sheet->setCellValueByColumnAndRow($startCol + 1, $currentRow, $rep->name);
                $sheet->setCellValueByColumnAndRow($startCol + 2, $currentRow, $rep->position);
                $sheet->setCellValueByColumnAndRow($startCol + 3, $currentRow, $rep->phone);
                $sheet->setCellValueByColumnAndRow($startCol + 4, $currentRow, $rep->snils);
                $sheet->setCellValueByColumnAndRow($startCol + 5, $currentRow, $rep->email);
            }
            
            $currentRow++;
        }
    }
}
