<?php

namespace App\Exports;

use App\Statement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class TransactionExport implements FromCollection, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $queryData;

    public function __construct($data)
    {
        $this->queryData = $data;

    }

    public function collection()
    {

        $transaction_data = Statement::where('user_id', $this->queryData['email'])->where('activity', 'LIKE', '%'.$this->queryData['service'].'%')->whereBetween('trans_date', [$this->queryData['from'], $this->queryData['nextDay']])->orderBy('created_at', 'DESC')->get()->toArray();

        $transaction_array[] = array('Transaction Date', 'Description', 'Reference Code', 'Amount');

        foreach($transaction_data as $transactions)
        {

            if($transactions['credit'] > 0)

                $amount = "+".$this->queryData['currencyCode'].number_format($transactions['credit'], 2);

            else

                $amount = "-".$this->queryData['currencyCode'].number_format($transactions['debit']);

            $transaction_array[] = array(

            'Transaction Date'  => $transactions['trans_date'],
            'Description'   => $transactions['activity'],
            'Reference Code'    => $transactions['reference_code'],
            'Amount'  => $amount

            );
        }


        return collect($transaction_array);

    }



}


