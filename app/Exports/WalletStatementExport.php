<?php

namespace App\Exports;

use App\Statement;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class WalletStatementExport implements FromCollection, ShouldAutoSize
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

        if ($this->queryData['user_id'] == "all") {
            $transaction_data = Statement::whereBetween('trans_date', [$this->queryData['from'], $this->queryData['nextDay']])->orderBy('created_at', 'DESC')->get()->toArray();
        } else {
            $transaction_data = Statement::where('user_id', $this->queryData['user_id'])->whereBetween('trans_date', [$this->queryData['from'], $this->queryData['nextDay']])->orderBy('created_at', 'DESC')->get()->toArray();
        }


        $transaction_array[] = array('Transaction Date', 'Name', 'Reference Code', 'Description', 'Amount');

        foreach ($transaction_data as $transactions) {

            $currencyCode = User::where('email', $transactions['user_id'])->first();

            if (isset($currencyCode)) {
                $currency = $currencyCode->currencyCode;

                if ($currencyCode->accountType == "Individual") {
                    $name = $currencyCode->name;
                } else {
                    $name = $currencyCode->businessname;
                }
            } else {
                $currency = "-";
                $name = "-";
            }

            if ($transactions['credit'] > 0)

                $amount = "+" . $currency . number_format($transactions['credit'], 2);

            else

                $amount = "-" . $currency . number_format($transactions['debit']);

            $transaction_array[] = array(

                'Transaction Date'  => $transactions['trans_date'],
                'Name'   => $name,
                'Reference Code'    => $transactions['reference_code'],
                'Description'   => $transactions['activity'],
                'Amount'  => $amount

            );
        }


        return collect($transaction_array);
    }
}
