<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>
<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
    
    <div class ="col-xs-4 pull-left tma-raport"></div>

    <div class="col-xs-4 pull-right">
        <br />
        <?=
       '<h3>Attendance List</h3>'.
           '<h4>' . date('F', mktime(0,0,0,$month)) . ' ' . $year . '</h4>';
?>
        
    </div>
</div>


<div class="CSSTableGenerator" >
                <table >
                    <tr>
                        <td colspan=2 style="width:130px; font-weight: bold">
                            Day
                        </td>
                        <td style="border-right:0px; font-weight: bold">
                            <?=
                            $user->firstName. ' ' . $user->lastName;
?>
                        </td>
                    </tr>

<?php 
                foreach($data as $datas){
                $patern = '/'.$year.'-'.$month.'-/';
                $day = preg_replace($patern, '',$datas->date);
                $day = ltrim($day, '0');
                $days[] = $day;
                
                }
               
                
    for($i = 1; $i <= date('t'); $i++){
        
        $day = date('l', mktime(0,0,0,08,$i,2015));
 
        if(  $day == 'Sunday' || $day == 'Saturday'  ){
            
            echo '<tr class="weekend"><td style="border-right: 0px; text-align: right; width:110px; font-weight: bold; "> ' . $i . '</td><td style="text-align: left; width:110px">' . $day . '</td><td>';
                    if(  in_array( $i, $days )){
                        echo 'Obecny';
                    }
            echo '</td></tr>';
        } else {
            
            echo '<tr><td style="border-right: 0px; text-align: right; width:110px; font-weight: bold;"> ' . $i . '</td><td style="text-align: left; width:110px">' . $day . '</td><td>';
             if(  in_array( $i, $days )){
                    echo 'Obecny';
             }
             echo'</td></tr>';
        }
    }
    ?>
                </table>
            </div>