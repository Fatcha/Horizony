<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DateOfBirth
 *
 * @author Bri
 */
namespace App\Models\Fatcha\Helpers;

class DateUtility {

    private $current_num_year;
    private $current_num_month;
    private $current_num_day;

    private $current_num_month_days;

    public $birth_num_year;
    public $birth_num_month;
    public $birth_num_day;

    private $yy;
    private $mm;
    private $dd;

    public $age;
    
    const ISO8601 = 'Y-m-d\TH:i:sP';

    public function __construc()
    {
        $this->current_num_year = date("Y");
        $this->current_num_month = date("m");
        $this->current_num_day = date("j");
        $this->current_num_month_days = date("t");
    }

    private function birthday_before_today()
    {
        $this->yy = $this->current_num_year - $this->birth_num_year;
        $this->mm = $this->current_num_month - $this->birth_num_month - 1;
        $this->dd = $this->birth_num_month_days - $this->birth_num_day + $this->current_num_day;
        if($this->dd > $this->current_num_month_days)
        {
            $this->mm += 1;
            $this->dd -= $this->current_num_month_days;
        }
    }

    private function birthday_on_today()
    {
        $this->yy = $this->current_num_year - $this->birth_num_year;
        $this->mm = 0;
        $this->dd = 0;
    }

    private function birthday_after_today()
    {
        $this->yy = $this->current_num_year - $this->birth_num_year - 1;
        $this->mm = $this->birth_num_month + $this->current_num_month - 1;
        $this->dd = $this->birth_num_month_days - $this->birth_num_day + $this->current_num_day;
        if($this->dd > $this->current_num_month_days)
        {
            $this->mm += 1;
            $this->dd -= $this->current_num_day;
        }
    }

    public function calculate_age()
    {
        $this->birth_num_month_days = date( "t", mktime(0, 0, 0, $this->birth_num_month, $this->birth_num_day, $this->birth_num_year) );
        if($this->current_num_month > $this->birth_num_month)
        {
            $this->birthday_before_today();
        }
        if($this->current_num_month < $this->birth_num_month)
        {
            $this->birthday_after_today();
        }
        if($this->current_num_month == $this->birth_num_month)
        {
            if($this->current_num_day == $this->birth_num_day)
            {
                $this->birthday_on_today();
            }
            if($this->current_num_day < $this->birth_num_day)
            {
                $this->birthday_after_today();
            }
            if($this->current_num_day > $this->birth_num_day)
            {
                $this->birthday_before_today();
            }
        }
        $this->age = $this->yy . ' years, ' . $this->mm . ' months, ' . $this->dd . ' days';
    }
    public static function getAge($dateYMD){

       $today=date("Y/m/d");
       $diff = abs(strtotime($today) - strtotime($dateYMD));
       return floor($diff/(60*60*24*365));
    }
    /*
     * Get date from age
     */
     public static function getDateFromAge($age){
         $today=strtotime(date("Y-m-d"));
         /*Must have $age + 1
          * Because a person born  at J-1year +1 day has the same year yet.
          */
         $timeElapsed=($age+1)*(60*60*24*365);
         $timeElapsed=$today- strtotime(date('Y-m-d', $timeElapsed));
         return date('Y-m-d', $timeElapsed);
     }
     
     public static function getTimeElapsed($date_string,$type="all"){
        $now=strtotime(date("Y-m-d H:i:s"));
        $d2 = strtotime($date_string); 
        //echo ;
        $return="";
        //$nb_jours = $diff->H; 
        $seconds=$now-$d2;
        
        if($type=="seconds"){
            return $seconds;
        }
        
        $arrayReturn=array();
        if($seconds<60){
            //moins d'une minute
            return $seconds." secondes";
        }else if($seconds<3600){
            $min=floor($seconds/60);
            if($min>1){
                return $min." minutes";
                
            }else{
               return $min." minute"; 
            }
            
        
        }else if($seconds<(3600*24)){
            $hours=floor($seconds/3600);
            if($hours>1){
                    $return.=" heures";
                }else{
                    $return.=" heure";
                }
            return floor($seconds/3600).$return;
        
        }else if($seconds>(3600*24)){
            $day=floor(($seconds/3600)/24);
            $hours=(floor($seconds/3600)%24);
            $return= $day." jour(s) ";
            if($hours>0){
                
                $return.=$hours;
                if($hours>1){
                    $return.=" heures";
                }else{
                    $return.=" heure";
                }
            }
            return $return;
        }
        return ;
     }
     
     public static function dateFromDBToFrontend($dateDBFormat , $dateFormat= 'd-m-Y'){
         return date($dateFormat,  strtotime($dateDBFormat));
     }
     public static function dateFromFrontendToDB($dateFrontFormat){
         $date = str_replace('/', '-', $dateFrontFormat);
         return date('Y-m-d', strtotime($date));
     }
     
     
}
?>