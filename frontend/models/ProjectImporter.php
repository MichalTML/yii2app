<?php
namespace frontend\models;

class ProjectImporter
{

    public $projectsRootDirectory = 'e:\tma_projekty\\'; // project root path
    public $projectMainTables = ['data', 'project', 'orders' ];
    public $rootStructure = [
        'project' => ['Projekt', 'projket', 'Project', 'project' ],
        'data' => ['files', 'Files' ],
        'orders' => ['orders', 'Orders' ]
    ];
    public $projects;
    public $projectsDatas = [ ];
    public $assembliesPaths = [ ];
    public $fileList;
    public $mainProjectFiles;
    public $mainAssemblyFiles;
    public $assembliesFiles;
    public $filesCount = [ ];
    public $summary = ['error' => ''];

    public function __construct($projectName) {
        $this->projects = array_values( array_diff( scandir( $this->projectsRootDirectory ), array( '..', '.' ) ) );
        //var_dump($this->projects);
        // remove this loop to get all projects from root dir
        foreach($this->projects as $id => $name){
            if($name !== $projectName){
                unset($this->projects[$id]);
            }   
        }
        if(count($this->projects) < 1 ){
                $error = 'Check if '. $projectName .' data exists and are valid, then try again.';
                $this->summary['error'] = $error;
                $info = json_encode($this->summary); 
                echo $info;
                exit;
            }
        $this->getProjectData();
        $this->getAssembliesPaths();
        $this->getFileList();
        $this->getMainFiles();
        $this->getMainAssemblyFiles();
        $this->getAssemblyFiles();
    }
    
    // switching coding, unused method
    public function encode_array( $array, $state ) {

        if ( $state == 1 )
        {
            foreach ( $array as $key => $value ) {
                if ( is_array( $value ) )
                {
                    $array[ $key ] = $this->encode_array( $value, 1 );
                } else
                {
                    $array[ $key ] = mb_convert_encoding( $value, 'Windows-1252', 'UTF-8' );
                }
            }

            return $array;
        }
        if ( $state == 2 )
        {
            foreach ( $array as $key => $value ) {
                if ( is_array( $value ) )
                {
                    $newKey = iconv('windows-1250','UTF-8', $key);
                    $array[ $newKey] = $array[ $key ]; 
                    unset($array[$key]);
                    $array[ $newKey ] = $this->encode_array( $value, 2 );
                } else
                {
                   //$array[ $key ] = mb_convert_encoding( $value, 'Windows-1250', 'UTF-16');
                    $array[ $key ] = iconv('windows-1250','UTF-8', $value);
                }
            }

            return $array;
        }
    }
    
    // get excel file LIST 
    function getFileList() {
        foreach ( $this->projectsDatas as $project ) {
            $mainProjectFiles = new \FilesystemIterator( $project[ 'root' ] );
            foreach ( $mainProjectFiles as $fileInfo ) {
                if ( $fileInfo->isFile() )
                {
                    if ( $fileInfo->getExtension() === 'ods' )
                    {
                        $this->fileList = $fileInfo->getPathname();
                    }
                }
            }
        }
    }
    
    // formating file sizes, to display more friendly data info
    function formatSize( $bytes ) {

        $kilo = 1024;
        $mega = $kilo * 1024;
        $giga = $mega * 1024;
        $tera = $giga * 1024;

        if ( $bytes < $kilo )
        {
            return $bytes . ' B';
        }
        if ( $bytes < $mega )
        {
            return round( $bytes / $kilo, 2 ) . ' KB';
        }
        if ( $bytes < $giga )
        {
            return round( $bytes / $mega, 2 ) . ' MB';
        }
        if ( $bytes < $tera )
        {
            return round( $bytes / $giga, 2 ) . ' GB';
        }
        return round( $bytes / $tera, 2 ) . ' TB';
    }
    
    // method used for path changing, not used in autoimport process
    public function setNewPath( $path ) {

        $this->projectsRootDirectory = $path;
        $this->projects = array_values( array_diff( scandir( $path ), array( '..', '.' ) ) );
        echo 'New root path, set to: ' . $this->projectsRootDirectory . '<br />';
    }

    
    public function getProjectData() {


// Get all projects main folder name into an array
// Get project path / name / id into and array
        for ( $i = 0; $i < count( $this->projects ); $i++ ) {

            //get project id
            $nameFragments = explode( '_', $this->projects[ $i ] );
            $projectId = preg_replace( '/^p/i', '', $nameFragments[ 1 ] );

            $this->projectsDatas[ $projectId ][ 'id' ] = $projectId;
            

            //get project path
            $projectPath = $this->projectsRootDirectory . $this->projects[ $i ] . '/';

            $this->projectsDatas[ $projectId ][ 'path' ] = $projectPath;
            
            //get project name
            $nameFragments[ 0 ] = '';
            $nameFragments[ 1 ] = '';
            
            $projectName = trim( implode( ' ', $nameFragments ) );

            $this->projectsDatas[ $projectId ][ 'name' ] = $projectName;
            
            //get project root path
            foreach ( $this->rootStructure[ 'project' ] as $name ) {
                $tempPath = $projectPath . 'P' . $projectId . '_' . $name . '/';
                if ( file_exists( $tempPath ) )
                {
                    $this->projectsDatas[ $projectId ][ 'root' ] = $tempPath;
                }
            }

            //get project assembplies
            $assembliesList = array_values( array_diff( scandir( $this->projectsDatas[ $projectId ][ 'root' ] ), array( '..', '.' ) ) );
            foreach ( $assembliesList as $name ) {
                if ( preg_match( '/^[0-9]{2}[a-z\s]*/i', $name ) )
                {
                    $fragments = explode( '_', $name );
                    $assemblieId = $fragments[ 0 ];
                    $fragments[ 0 ] = '';
                    $assemblieLabel = trim( implode( '_', $fragments ), '_' );
                    $this->projectsDatas[ $projectId ][ 'assemblies' ][ $assemblieId ] = $assemblieLabel;
                }
            }
                            

            $projectFiles = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $this->projectsDatas[ $projectId ][ 'root' ] ),\RecursiveIteratorIterator::SELF_FIRST );

            $projectFileCount = 0;
            foreach ( $projectFiles as $file ) {
                if ( $file->isFile() )
                {
                    $projectFileCount++;
                }
            }

            $this->projectsDatas[ $projectId ][ 'files' ] = $projectFileCount;
        }
    }

    public function getAssembliesPaths() {
        foreach ( $this->projectsDatas as $project ) {
            $pId = $project[ 'id' ];
            foreach ( $project[ 'assemblies' ] as $id => $name ) {
                $assembliesPaths[ $id ] = $project[ 'root' ] . $id . '_' . $name;
            }
             $this->assembliesPaths[ $pId ] = $assembliesPaths;
             $assembliesPaths = [];
        }
           return $this->assembliesPaths; 
    }

    public function getMainFiles() {

        foreach ( $this->projectsDatas as $project ) {
            $fileCount = 0;
            $mainProjectFiles = new \FilesystemIterator( $project[ 'root' ] );
            foreach ( $mainProjectFiles as $fileInfo ) {
                if ( $fileInfo->isFile() )
                {
                    $ProjectFilesInfo[ $project[ 'id' ] ][] = [
                        'name' => preg_replace( '/.[a-z]*$/i', '', $fileInfo->getFilename() ),
                        'path' => $fileInfo->getPathname(),
                        'size' => $this->formatSize( $fileInfo->getSize() ),
                        'modify' => gmdate( "Y-m-d H:i:s", $fileInfo->getMTime() ),
                        'creation' => gmdate( "Y-m-d H:i:s", $fileInfo->getCTime() ),
                        'ext' => $fileInfo->getExtension(),
                        
                    ];
                    $fileCount++;
                }
                
            }
            $this->filesCount[ $project[ 'id' ] ][ 'mainProjectFiles' ] = $fileCount;
        }

        return $this->mainProjectFiles = $ProjectFilesInfo;
    }

    public function getMainAssemblyFiles() {
        foreach ( $this->assembliesPaths as $projectId => $paths ) {
            $fileCount = 0;
            foreach ( $paths as $id => $path ) {
              
                $mainAssemblyFiles = new \FilesystemIterator( $path );
                foreach ( $mainAssemblyFiles as $fileInfo ) {
                    if ( $fileInfo->isFile() )
                    {
                        $partsName = explode( '_', $fileInfo->getFilename() );
                        
                        if ( count( $partsName ) >= 2 )
                        {
                            $sygnature = $partsName[ 0 ];
                            $partsName[ 0 ] = '';
                            $fileName = implode( ' ', $partsName );
                        } else
                        {
                            $fileName = preg_replace( '/.[a-z]*$/i', '', $fileInfo->getFilename() );
                            $sygnature = 'subcontractor';
                        }

                        $assemblyFileInfo[ $projectId ][] = [
                            'assebmlyId' => $id,
                            'sygnature' => $sygnature,
                            'name' => trim( preg_replace( '/.[a-z]*$/i', '', $fileName ) ),
                            'fullName' => $fileName,
                            'path' => $fileInfo->getPathname(),
                            'size' => $this->formatSize( $fileInfo->getSize() ),
                            'modify' => gmdate( "Y-m-d H:i:s", $fileInfo->getMTime() ),
                            'creation' => gmdate( "Y-m-d H:i:s", $fileInfo->getCTime() ),
                            'ext' => $fileInfo->getExtension(),
                        ];
                        $fileCount++;
                    }
                }
            }
            $this->filesCount[ $projectId][ 'mainAssemblyFiles' ] = $fileCount;
        }

        return $this->mainAssemblyFiles = $assemblyFileInfo;
    }

    public function getAssemblyFiles() {

        foreach ( $this->assembliesPaths as $projectId => $project ) {
            $fileCount = 0;
            foreach ( $project as $id => $path ) {
                $assemblyPartDir = new \FilesystemIterator( $path );

                foreach ( $assemblyPartDir as $dir ) {
                    if ( !$dir->isFile() )
                    {
                        $assemblyPartFile = new \FilesystemIterator( $dir );
  
                        foreach ( $assemblyPartFile as $fileInfo ) {

                            $nameParts = explode(' ', $fileInfo->getFilename());
                            if(  preg_match( '/[0-9]{2}\-[0-9]{2}\-[0-9]{2}/', $nameParts[0])){
                                $sygnature = trim($nameParts[0]);
                                $sygnatureParts = explode('-', $nameParts[0]);
                                $typeId = $sygnatureParts[1];
                                $nameParts[0] = '';
                                $nameParts[count($nameParts) - 1] = preg_replace('/\.'.$fileInfo->getExtension().'/', '', $nameParts[count($nameParts) - 1] );
                                $fileName = trim(implode(' ', $nameParts));
                            } else {
                                $nameParts[count($nameParts) - 1] = preg_replace('/\.'.$fileInfo->getExtension().'/', '', $nameParts[count($nameParts) - 1] );
                                $fileName = trim(implode(' ', $nameParts));
                                $typeId = '0';
                                $sygnature = 'none';
                            }
                                    
                            $assemblieFiles[ $projectId ][ $id ][] = [
                                'name' => $fileName,
                                'fullName' => $sygnature . ' ' . $fileName,
                                'path' => $fileInfo->getPathname(),
                                'sygnature' => $sygnature,
                                'projectId' => $projectId,
                                'size' => $this->formatSize( $fileInfo->getSize() ),
                                'modify' => gmdate( "Y-m-d H:i:s", $fileInfo->getMTime() ),
                                'creation' => gmdate( "Y-m-d H:i:s", $fileInfo->getCTime() ),
                                'assemblieId' => $id,
                                'typeId' => $typeId,
                                'ext' => $fileInfo->getExtension(),
                            ];
                            $fileCount++;
                        }
                    }
                }
            }
            $this->filesCount[ $projectId ][ 'assemblyFiles' ] = $fileCount;
            
        }
       $this->assembliesFiles = $assemblieFiles;
    }

}

//$project = new ProjectImporter;

//var_dump($project->projectsDatas);
//var_dump($project->getAssembliesPaths());
//var_dump($project->getMainFiles());
//var_dump($project->getMainAssemblyFiles());
//var_dump($project->getAssemblyFiles());



