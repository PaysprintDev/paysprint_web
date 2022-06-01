<?php

namespace App\Imports;

use App\ImportExcel;
use App\Tax as Tax;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class InvoiceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public $queryData;

    public function __construct($data)
    {
        $this->queryData = $data;

    }

    public function model(array $row)
    {

        $dataInfo = [];

        $trans_date = Date::excelToDateTimeObject($row['transaction_date']);
        $payment_due_date = Date::excelToDateTimeObject($row['payment_due_date']);



        $getTax = Tax::where('id', $this->queryData['single_tax'])->first();


        $taxAmount = ($getTax->rate / 100) * $row['amount'];

        $totalAmount = $row['amount'] + $taxAmount;

        if($row['invoice'] == "" || $row['invoice'] == null){
            $invoice_no = 'PS_'.date('Ymds');
        }
        else{
            $invoice_no = $row['invoice'];
        }


        return new ImportExcel([
            'transaction_date' => $trans_date->format('d-m-Y'), 
            'invoice_no' => $invoice_no,
            'payee_ref_no' => $row['customer_id'],
            'name' => $row['name'],
            'transaction_ref' => $row['transaction_ref'],
            'description' => $row['description'],
            'amount' => $row['amount'],
            'payment_due_date' => $payment_due_date->format('d-m-Y'),
            'payee_email' => $row['customer_email'],
            'address' => $row['customer_address'],
            'customer_id' => $row['customer_id'],
            'service' => $this->queryData['service'],
            'installpay' => $this->queryData['installpay'],
            'installlimit' => $this->queryData['installlimit'],
            'uploaded_by' => $this->queryData['ref_code'],
            'merchantName' => $this->queryData['client_realname'],
            'recurring' => $this->queryData['recurring_service'],
            'reminder' => $this->queryData['reminder_service'],
            'tax' => $this->queryData['single_tax'],
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount, 
            'remaining_balance' => $totalAmount
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
