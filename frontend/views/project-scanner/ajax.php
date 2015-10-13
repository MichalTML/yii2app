<?php
header("Content-Type: application/json", true);
use frontend\models\ProjectImporter;
use frontend\models\DB;
use frontend\models\ExcelImporter;
use frontend\models\ProjectSaver;

//$_POST['name'] = 'PROJEKT_P51_kontorla_wizyjna_4_wiaderek_JOKEY';

if (isset($_POST['name'])){
   $projectName = $_POST['name'];
   
   shell_exec("cp -R /media/data/NAS/TMA/TMA_KONST_TEMP/$projectName /media/data/app_data/project_data");
   
   $projectImporter = new ProjectImporter($_POST['name']);
   
   $excelImporter = new ExcelImporter($projectImporter->fileList);
   $saveProject = new ProjectSaver(DB::getConnection(), $excelImporter->files);
   $saveProject->importProjecteData( $projectImporter->projectsDatas, $projectImporter->filesCount);
   $saveProject->importAssembliesData( $projectImporter->projectsDatas);
   $saveProject->importProjectMainFiles( $projectImporter->mainProjectFiles, $projectImporter->filesCount );
   $saveProject->importAssembliesMainFiles( $projectImporter->mainAssemblyFiles, $projectImporter->filesCount );
   $saveProject->importAssembliesFiles( $projectImporter->assembliesFiles, $projectImporter->filesCount );
   
   $saveProject->fileCount;
   $projectImportStatus = ['error' => ''];
   $json = array_merge($projectImportStatus, $saveProject->fileCount);
   echo json_encode($json);
}

//$_POST['state'] = 'no';
//$_POST['sygnature'] = 54;
if (isset($_POST['state']) & isset($_POST['sygnature']) ){
    $state = $_POST['state'];
    $sygnature = $_POST['sygnature'];
    $saveProject = new ProjectSaver(DB::getConnection());
    $saveProject->finalize($state, $sygnature);
    $json = $saveProject->status;
    echo json_encode($json);
}

