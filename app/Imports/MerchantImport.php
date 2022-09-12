<?php

namespace App\Imports;

use App\UnverifiedMerchant;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;


class MerchantImport implements ToModel, WithHeadingRow
{
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */

	// public $queryData;

	// public function __construct($data)
	// {
	// 	$this->queryData = $data;
	// }


	public function model(array $row)
	{
			// dd($row);

		return new UnverifiedMerchant([
			'name' => $row['name'],
			'industry' => $row['nacsdescri'],
			'title' => $row['naicstitle'],
			'phone' => $row['phone'],
			'email' => $row['email'],
			'web_address' => $row['webaddress'],
			'streetno' => $row['streetno'],
			'streetname' => $row['streetname'],
			'streetaddress' => $row['street_add'],
			'postalcode' => $row['postalcode'],
			'character' => $row['character']
		]);
	}

	// public function headingRow(): int
	// {
	// 	return 1;
	// }
}
