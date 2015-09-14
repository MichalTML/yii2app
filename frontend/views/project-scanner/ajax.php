<?php
header("Content-Type: application/json", true);
use frontend\models\ProjectImporter;
use frontend\models\DB;
use frontend\models\ExcelImporter;
use frontend\models\ProjectSaver;

$output = shell_exec('cp -R  /media/data/NAS/TMA/TMA_KONST_TEMP/project /media/data/app_data/project_data');
echo "<pre>$output</pre>";


//$_POST['name'] = 'PROJEKT_P45_kontrola_wizyjna_pokrywek_JOKEY';
if (isset($_POST['name'])){
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



//$this->log[ $projectId ][ 'mainProjectFiles' ] = $countFiles;
//            $this->log[ $projectId ][ 'mainProjectFilesAdded' ] = $fileCount;