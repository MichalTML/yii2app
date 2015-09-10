<?php
use yii\helpers\Url;
use kartik\spinner\Spinner;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="mainbox-upload">
    <div class="upload-info"><span>Select project</span>
        - import process will run in the background (can take up to 2 min.).<b>
        </b><select class="form-control" style="margin-top:5px" id="project" required="required">
            <option value="" disabled selected>Select project</option>
            <option>PROJEKT_P45_kontrola_wizyjna_pokrywek_JOKEY</option>
<?php 
    foreach($projectList as $id => $name){
    echo '<option>'.$name.'</option>';
    }
 ?>
        </select><button type="submit" id="import-project" class="btn btn-default">Import</button>
    </div></div>

</div>
<input id="url" type="hidden" value="<?php echo Url::toRoute( ['project-scanner/ajax']);?>"></input>
<?php
//echo '<button class="btn btn-primary btn-sm">';
//	echo Spinner::widget(['preset' => 'tiny', 'id' => 'spinner', 'align' => 'left', 'caption' => 'Loading &hellip;']);
//echo '</button>';
//?>
<script>
    
    
    $(function(){
    $("#import-project").click(function(){
        var $option = $("#project").val();
        var $url = $("#url").val();
        var formatData = {name: $option};
        $.ajax({
        type: "POST",
        url: $url,
        data: formatData, 
        error: function(msg){
            alert(msg);
        },
        success: function(msg){
            alert(msg);
        }
        });
    });
    
      // Hide it initially
    $(document).ajaxStart(function() {
        $("body").prepend("<div class=\"overlay\"></div>");
    $(".overlay").css({
    "position": "absolute", 
    "width": $(document).width(), 
    "height": $(document).height(),
    "z-index": 99999 
    }).fadeTo(0, 0.8);
    });
    
    $(document).ajaxStop(function() {
        $('.overlay').fadeOut('slow');
        
    });
});
    
</script>

     