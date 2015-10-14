<?php
header("Content-Type: application/json", true);
use frontend\models\ProjectImporter;
use frontend\models\DB;
use frontend\models\ExcelImporter;
use frontend\models\ProjectSaver;

//$_POST['name'] = 'PROJEKT_P55_tma_robots_mp100eco_PROPLASTIK';

if (isset($_POST['name'])){
   $projectName = $_POST['name'];
   
   //shell_exec("cp -Ru /media/data/NAS/TMA/TMA_KONST_TEMP/$projectName /media/data/app_data/project_data");
   shell_exec("rsync -avh --no-compress --progress /media/data/NAS/TMA/TMA_KONST_TEMP/$projectName /media/data/app_data/project_data");
   /* ProjectImporter class
    * purpose: scanning dest folder and getting all info into mylti dim. arrrays
    */
   $projectImporter = new ProjectImporter($_POST['name']); 
   /* ExcelImporter class
    * purpose: getting all data from excel file to multi dim. array
    */
   $excelImporter = new ExcelImporter($projectImporter->fileList);
   /* ProjectSaver class
    * purpose: saving data to mySql
    */
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
//$_POST['sygnature'] = 55;
//$_POST['projectName'] = 'aa';
if (isset($_POST['state']) & isset($_POST['sygnature']) &  isset($_POST['projectName']) ){
    $projectName = $_POST['projectName'];
    $state = $_POST['state'];
    $sygnature = $_POST['sygnature'];
    $saveProject = new ProjectSaver(DB::getConnection());
    $saveProject->finalize($state, $sygnature);
    shell_exec("rm -R /media/data/app_data/project_data/$projectName");
    $json = $saveProject->status;
    echo json_encode($json);
}

