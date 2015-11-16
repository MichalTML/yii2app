<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="password-reset">
    <p>Hello,</p>
    <p>New note has been created:</p>
    <p>Eement name: <b><?= Html::encode($fileData->name) ?></b></p>
    <p>Note: "<b><?= Html::encode($noteData->note) ?></b>"</p>
    <p>Created by: <b><?= Html::encode($userData->username) ?></b></p>
    <p>To answer note, follow the link below: </b></p>
    <p><?= Html::a('take to me file', $link) ?></p>
     <table>
 <tr>
  <td colspan="4" style="border-bottom: 3px solid #88CD00; padding: 0 0 2px 0;">

    <span  style="display:'' ;">
     <span  style="font-size: 13px; font-family: 'arial'; font-weight: bold;">New Comment</span>  
    </span>
    <span  style="display: none !important;"> 
     <span  style="font-size: 11px; font-family: 'arial'; "></span>,
    </span>
    <span  style="display:'' ;"> 
     <span  style="font-size: 11px; font-family: 'arial'; ">TMA - Project Manager</span>
    </span>
 
  </td>
 </tr>
 <tr>
  <td valign="top" style="padding: 7px 16px 0 0;">
   <div  style="float: left; display:'' ;">
    <img  width="259" height="87" src="http://www.tma-automation.com/wp-content/themes/TM-Automation/images/logo_pm.png"/>
   </div>
  </td>
  <td valign="top" style="padding: 7px 0 0 0;">
   <div style="padding: 2px 0 0 0;">
    <div  style="display:'';">
     <span style="font-size: 11px; color: #808080; font-family: 'arial';">Admin:</span>
     <span  style="font-size: 11px; font-family: 'arial';">Michal Kungonda</span>
    </div>
    <div  style="display:'' ;">
     <span style="font-size: 11px; color: #808080; font-family: 'arial';">Email:</span>
     <span><a href="mailto:michal.kungonda@tma-automation.com" target="_blank" style="font-size: 11px; color: #000; text-decoration: none; font-family: 'arial';" >michal.kungonda@tma-automation.com</a></span>
    </div>
    <div  style="display:'' ;">
     <span style="font-size: 11px; color: #808080; font-family: 'arial';">Website:</span>
     <span><a href="http://www.pm.tma-automation.com" target="_blank" style="color: #000; text-decoration: none; font-size: 11px; font-family: 'arial';" >www.pm.tma-automation.com</a></span>
    </div>
   </div>
  </td>
 </tr>
</table>
<br />
<span style="font-size: 13px;">This is automated message, please do not reply.
</span>