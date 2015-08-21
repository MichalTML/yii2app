<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use kartik\mpdf\Pdf;

/**
 * Login form
 */
class PdfGenerator extends Model
{

    public $month;
    public $year;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [[ 'month', 'year' ], 'required' ],
        ];
    }

    public function getMonths() {
        $months = [
            '01' => "January", 
            '02' => "February", 
            '03' => "March",
            '04' => "April",
            '05' => "May",
            '06' => "June",
            '07' => "July",
            '08' => "August",
            '09' => "September",
            '10' => "October",
            '11' => "November",
            '12' => "December",
            ];
        
        return $months;
    }
    
    public function getYear() {
        $year = [
            '2014' => '2014',
            '2015' => '2015',
            ];
        
        return $year;
    }
    
      
    
    
}
