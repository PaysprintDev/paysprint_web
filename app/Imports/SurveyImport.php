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
            'date' => date('d-m-Y h:i A', strtotime($row['date'])), 
            'email' => $row['email'],
             'Question_1' => $row['question_1_have_you_been_using_your_paysprint_consumer_account'],
            'Question_2' => $row['question_2_if_your_answer_to_the_question_above_is_yes_which_of_the_following_features_do_you_find_more_usefulinteresting_to_use_you_can_select_as_many_as_you_want'],
            'Question_3' => $row['question_3_how_frequently_do_you_use_your_paysprint_consumer_account'],
            'Question_4'=>$row['question_4_if_you_have_not_been_using_your_paysprint_account_would_you_like_to_share_the_reason_with_us_we_would_like_to_hear_your_thoughts'],
            'Question_5' => $row['question_5_are_you_aware_that_your_account_would_not_be_activated_if_you_have_not_completed_your_identity_verification'],
            'Question_6' => $row['question_6_can_you_suggest_to_us_if_there_are_other_ways_we_can_make_the_process_of_identity_verification_easier_for_you'],
            'Question_7' => $row['question_7_what_other_features_would_you_like_to_see_on_paysprint_as_a_consumer_can_you_kindly_share_your_thoughts_with_us'],
            'Question_8' => $row['question_8_on_a_scale_of_1_10_how_would_you_rate_your_paysprint_experience'],
            'Question_9' => $row['question_9_do_you_have_any_concerns_about_your_paysprint_service_or_experience_kindly_share_your_thought_with_us'],
            'Question_10' => $row['question_10_how_likely_are_you_to_recommend_paysprint_to_others']
            
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }


}












?>