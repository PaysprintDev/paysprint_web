<?php 

namespace App\Imports;
use App\SurveyExcel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;


class SurveyImport implements ToModel, WithHeadingRow
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


        


        return new SurveyExcel([
            
            'email' => $row['email'],
            'reason' => $row['reason'],
            
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }


}












?>