<?php
use yii\helpers\Url;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="mainbox-upload" id="infobox">
    <div class="upload-info" id="upload-info"><span>Select project</span>
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
        dataType: "json", 
        error: function(msg){
            alert(msg);
        },
        success: function(msg){
           if(msg.error.length > 0){
            var item = $('<div class="upload-status" id="upload-status" style="font-size: 14px; color: red;">' + msg.error + '</div>').hide().fadeIn(3000);
        } else {
            var item = $('<div class="upload-status2" id="upload-status" style="font-size: 16px; color: #87cd00">Project Imported Correctly\n\
<div class="files-info"><ul><li><b>Main Project Files</b> (' + msg.mainFiles + '): ' + msg.mainFilesAdded + ' (added)</li><li><b>Assemblies Files</b> (' + msg.assemblieFiles + '): ' + msg.assemblieFilesAdded + ' (added)<li><b>Main Assemblies Files</b> (' + msg.assemblieMainFiles + '): ' + msg.assemblieMainFilesAdded + ' (added)</li></div></div>').hide().fadeIn(3000);
        }
           $("#infobox").append(item); 
        }
        });
    });
    
      // Hide it initially
    $(document).ajaxStart(function() {
        $("#upload-info").fadeOut("slow");
        var item = $('<div class="upload-status" id="upload" style="color: #87cd00; font-size: 18px;" >Importing Project....</div>').hide().fadeIn(1000);
        $("#infobox").append(item);
        //$("#modalContent").append("<div class='status-info'>asdasdasdas</div>").fadeIn("slow");
        $("body").prepend("<div class=\"overlay\"></div>");
    $(".overlay").css({
    "position": "absolute", 
    "width": $(document).width(), 
    "height": $(document).height(),
    "z-index": 99999 
    }).fadeTo(0, 0.8);
    });
    
    $(document).ajaxStop(function() {
       // $("#infobox").hide("fast");
        $("#upload").fadeOut("fast");
        //$("#upload-info").fadeIn("slow");
        $('.overlay').fadeOut('slow'); 
        
    });
});
    
</script>

     