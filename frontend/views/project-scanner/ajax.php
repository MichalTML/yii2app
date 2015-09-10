<?php
use frontend\models\ProjectImporter;
use frontend\models\DB;
use frontend\models\ExcelImporter;
use frontend\models\ProjectSaver;

   $projectImporter = new ProjectImporter($_POST['name']);
   $excelImporter = new ExcelImporter($projectImporter->fileList);
   $saveProject = new ProjectSaver(DB::getConnection(), $excelImporter->files);
   
   $saveProject->importProjecteData( $projectImporter->projectsDatas, $projectImporter->filesCount);
   $saveProject->importAssembliesData( $projectImporter->projectsDatas);
   $saveProject->importProjectMainFiles( $projectImporter->mainProjectFiles, $projectImporter->filesCount );
   $saveProject->importAssembliesMainFiles( $projectImporter->mainAssemblyFiles, $projectImporter->filesCount );
   $saveProject->importAssembliesFiles( $projectImporter->assembliesFiles, $projectImporter->filesCount );