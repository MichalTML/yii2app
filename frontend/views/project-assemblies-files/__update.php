<?php

use kartik\helpers\Html;
use kartik\file\FileInput;
use yii\helpers\Url;
?>

<div class="row">
    <div class="col-sm-7 drop-zone" title="drop new files here">
        <?php
        initialPreview: "<div class='file-preview-text'>" +
    "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
    "Filename.xlsx" + "</div>";
        // Usage with ActiveForm and model
        //change here: need to add image_path attribute from another table and add square bracket after image_path[] for multiple file upload.
         echo FileInput::widget([
                'name' => 'attachment_48[]',
                'id' => 'input-700',
                'options'=>[
                    'multiple'=> true,
                       ],
                'pluginOptions' => [
                    'allowedFileExtensions'=>['dft','pdf','dxf', 'par', 'asm', 'psm'],
                    'uploadUrl' => Url::to(['/project-assemblies-files/upload']),
                    'uploadExtraData' => [
                        'fileId' => $fileId,
                        'projectId' => $projectId,
                    ],
                    'maxFileCount' => 6,
                    'showPreview' => true,
                    'showCaption' => false,
                    'showUploadedThumbs' => false, 
                ]
        ]);
    ?>
        
    </div>
    <div class="col-sm-4 drop-list">
        <table class='element-table'>
            <thead>
                <td><b>Element - Files</b></td>
                <td><b>Status</b></td>
            </thead>
     <?php
     
        foreach($elementsList as $element){
                echo '<tr><td class="data" data-file="' . $element['name'].'.'.$element['ext'] . '" title="Created at: ' . $element['createdAt'] . '">' . $element['name'] . '.' . $element['ext'] . '</td>';
                echo '<td class="status" data-file="' . $element['name'].'.'.$element['ext'] . '"><i class="fa fa-ban fa-2x"></i>
</td></tr>';   
        }
     ?>
            </table>
            <table class='element-table'>
            <thead>
                <td><b>ASM - Files</b></td>
                <td><b>Status</b></td>
            </thead>
     <?php
        foreach($asmList as $element){
                echo '<tr><td class="data" data-file="' . $element['name'].'.'.$element['ext'] . '" title="Created at: ' . $element['createdAt'] . '">' . $element['name'] . '.' . $element['ext'] . '</td>';
                echo '<td class="status" data-file="' . $element['name'].'.'.$element['ext'] . '"><i class="fa fa-ban fa-2x"></i>
</td></tr>';   
        }
     ?>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 update-element"></div>
    <div class="col-sm-5 update-element">
        
    </div>
</div>

<?php
$this->registerJs("
    /// file input conf
    $('#input-700').fileinput({
        uploadAsync: true,
    });
    
    $('#input-700').on('fileloaded', function() {
        $('.file-object').remove();
        $('.file-preview-frame').each(function(){
            $(this).removeAttr('style');
            $(this).css('height', '100px');
            $(this).css('width', '100%');
        });
    });
    
    $('#input-700').on('fileuploaded', function(event, data, previewId, index) {
        $('.status[data-file=\\'' + data.response.name + '\\']').css('color', '#87cd00');
        $('.status[data-file=\\'' + data.response.name + '\\']').empty();
        $('.status[data-file=\\'' + data.response.name + '\\']').append('<i class=\\'fa fa-check fa-2x\\'></i>');
    });
    


");