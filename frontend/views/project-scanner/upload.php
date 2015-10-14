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
            <option selected disabled hidden value=''></option>
<?php 
        
    foreach($projectData as $project){
            echo '<option>'.$project['name'].'</option>';  
    }
 ?>
        </select>
        <?php 
        
    foreach($projectData as $project){
            $json[$project['name']] = $project['sygnature'];
    }
    ?>
    <button type="submit" id="import-project" class="btn btn-default">Import</button>
    </div></div>
<?php   
    if(isset($json)){
        $jsonFiles = json_encode( $json );
        echo '<div id="json" style="height: 0; width: 0;posistion: absolute; visibility: hidden;">' . $jsonFiles . '</div>';
    } else {
        $jsonFiles = '';
        echo '<div id="json" style="height: 0; width: 0;posistion: absolute; visibility: hidden;">' . $jsonFiles . '</div>';
    }
 ?>
        

</div>


<input id="url" type="hidden" value="<?php echo Url::toRoute( ['project-scanner/ajax']);?>"></input>

<?php ?>
<script>
$(document).ready(function(){
        var statusOption;
        $("#import-project").click(function(){
        var $jsonFile = $("#json").html();
        var $json = jQuery.parseJSON($jsonFile);
        var $option = $("#project").val();
        var $sygnature = $json[$option];
        if($option.length > 1){
            var $url = $("#url").val();
            var formatData = {name: $option};
            $.ajax({
                type: "POST",
                url: $url,
                data: formatData,
                dataType: "json", 
                error: function(msg){
                    console.log(msg);
                },
                success: function(msg){
                if(msg.error.length > 0){
                    var content = "<div class=\"upload-status\" id=\"upload-status\" style=\"font-size: 14px; color: red;\">" + msg.error + "</div>";
                    var item = $(content).hide().fadeIn(2000);
                } else {
                    var content = "<div class=\"upload-status2\" id=\"upload-status\" style=\"font-size: 16px; color: #87cd00\">Project Imported Correctly<div class=\"files-info\"><ul><li><b> Main Project Files</b> (" + msg.mainFiles + "): " + msg.mainFilesAdded + " (added)</li><li><b> Main Assemblies Files</b> (" + msg.assemblieMainFiles + "): " + msg.assemblieMainFilesAdded + " (added)<li><b>Assemblies Files</b> (" + msg.assemblieFiles + "): " + msg.assemblieFilesAdded  + " | " + msg.assemblieFilesFiltered + " (added)</li></div></div>";
                    var item = $(content).hide().fadeIn(2000);
                }   
                
                $("#infobox").append(item);
                if(msg.error.length > 0){
                var statusContent = "";
                } else {
                var statusContent = "<button class=\"btn btn-default\" id=\"revert\" style=\"margin-top: 10px; \">Revert</button>";
                }
                $("#upload-status").append(statusContent).on("click", "#revert", function () {
                    statusOption = "accept";
                    var formatData2 = {state: "no", projectName: $option, sygnature: $sygnature};
                    $.ajax({
                        type: "POST",
                        url: $url,
                        data: formatData2,
                        dataType: "json", 
                        error: function(msg){
                            var item = $("<div class=\"upload-status\" id=\"upload-status\" style=\"font-size: 16px; color: red\">"
                            + msg.status + "</div>").hide().fadeIn(2000);
                            $("#infobox").append(item);
                        },
                        success: function(msg){
                            var item = $("<div class=\"upload-status\" id=\"upload-status\" style=\"font-size: 16px; color: red\">"
                            + msg.status + "</div>").hide().fadeIn(2000);
                            $("#infobox").append(item);
                        }
        
                    }); 
                }); 
                if(msg.error.length > 0){
                var uploadStatus2 = "";
            } else {
                var uploadStatus2 = "<button class=\"btn btn-default\" id=\"accept\" style=\"margin-top: 10px; margin-right: 10px\">Accept</button>";
            }
                $("#upload-status").append(uploadStatus2).on("click", "#accept", function () {
                    statusOption = "accept";
                    var formatData2 = {state: "yes", projectName: $option, sygnature: $sygnature};
                    $.ajax({
                        type: "POST",
                        url: $url,
                        data: formatData2,
                        dataType: "json", 
                        error: function(msg){
                            var content = "<div class=\"upload-status\" id=\"upload-status\" style=\"font-size: 16px; color: red\">" + msg.status + "</div>";
                            var item = $(content).hide().fadeIn(2000);
                            $("#infobox").append(item);
                        },
                        success: function(msg){
                            var content = "<div class=\"upload-status\" id=\"upload-status\" style=\"font-size: 16px; color: #87cd00\">" + msg.status + "</div>";
                            var item = $(content).hide().fadeIn(2000);
                            $("#infobox").append(item);
                        }        
                    });
                });         
                }       
            });
        }
        });
    
         // Hide it initially
        $(document).ajaxStart(function() {
            if( statusOption === "accept"){
            $("#upload-status").fadeOut("fast");
            $(".overlay").css({
                "position": "absolute", 
                "width": $(document).width(), 
                "height": $(document).height(),
                "z-index": 99999 
            }).fadeTo(0, 0.8);    
            } else {
            $("#upload-info").fadeOut("slow");
            var item = $("<div class=\"upload-status\" id=\"upload\" \n\
            style=\"color: #87cd00; font-size: 18px;\" ><span id=\"font\">Importing Project...</span></div>").hide().fadeIn(1000);
            function blinker() {
                $("#font").fadeOut(1000).fadeIn(1000);
            }setInterval(blinker, 1000); //Runs every second
                $("#infobox").append(item);        
                $("body").prepend("<div class=\"overlay\"></div>");
                $(".overlay").css({
                    "position": "absolute", 
                    "width": $(document).width(), 
                    "height": $(document).height(),
                    "z-index": 99999 
                }).fadeTo(0, 0.8);
            }
        });
    
        $(document).ajaxStop(function() {
            if( statusOption === "accept"){
                $(".overlay").fadeOut("slow"); 
            } else {
                $("#upload").fadeOut("fast");
                $(".overlay").fadeOut("slow"); 
            } 
        });
    });
</script>