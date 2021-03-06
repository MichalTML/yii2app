<?php
namespace frontend\models;

use frontend\models\LogCreator;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProjectSaver
{

    private $db;
    public $raport = [ ];
    public $log = [ ];
    public $error = [ ];
    public $filterData = [ ];
    public $filterDatas = [ ];
    public $fileCount = ['mainFiles' => '', 'mainFilesAdded' => '', 'assemblieFiles' => '', 'assemblieFilesAdded' => '', 'assemblieMainFiles' => '', 'assemblieMainFilesAdded' => '' ];
    public $status = ['status' => ''];

    public function __construct( $db, $filter = null ) {         
        $this->db = $db;
        $this->filterDatas = $filter;
        
        $stmt = $this->db->prepare("TRUNCATE TABLE project_files_transfer_temp");
        $stmt->execute();
    }

    public function importProjecteData( $data, $files ) {     
        foreach ( $data as $project ) {
            $projectId = intval( $project[ 'id' ] );
            $check = $this->db->prepare( "SELECT * FROM project_file_data WHERE (projectId = :projectId)" );
            $check->bindparam( ':projectId', $projectId );
            
            if ( $check->execute() & count( $check->fetchAll() ) > 0 )
            {
                $result = ['files' => 'project datas', 'table' => 'project_file_data', 'error' => 'record already in table' ];
                $this->raport[ $projectId ][ 'data' ] = $result;
                $projectId = 'skip';
            }
            
            if ( $projectId != 'skip' )
            {
                $stmt = $this->db->prepare( "INSERT INTO project_file_data (projectId, path, root, files, assembliesMainFiles, projectMainFiles, assembliesFiles) VALUES (:projectId, :path, :root, :files, :assembliesMainFiles, :projectMainFiles, :assembliesFiles)" );
                $stmt->bindparam( ':projectId', $projectId );
                $stmt->bindparam( ':path', $project[ 'path' ] );
                $stmt->bindparam( ':root', $project[ 'root' ] );
                $stmt->bindparam( ':files', $project[ 'files' ] );
                $stmt->bindparam( ':assembliesMainFiles', $files[$projectId][ 'mainAssemblyFiles' ] );
                $stmt->bindparam( ':projectMainFiles', $files[$projectId][ 'mainProjectFiles' ] );
                $stmt->bindparam( ':assembliesFiles', $files[$projectId][ 'assemblyFiles' ] );             

                if ( $stmt->execute() )
                {
                    $tableName = 'project_file_data';
                    $tempTable = $this->db->prepare( "INSERT INTO project_files_transfer_temp (fileId, tableName) VALUES (:fileId, :tableName)" );
                    $tempTable->bindparam( ':fileId', $projectId );
                    $tempTable->bindparam( ':tableName', $tableName );
                    $tempTable->execute();
                    foreach ( $project as $key => $value ) {
                        if ( $key != 'assemblies' && $key != 'id' )
                        {
                            $result[ $key ] = $value;
                        }
                    }
                    $this->log[ $projectId ][ 'data' ] = $result;
                } else
                {
                    $this->error[ $projectId ] = ['files' => 'project datas', 'table' => 'project_file_data', 'error' => 'CRITICAL SAVE DATABASE ERROR' ];
                    return false;
                }
            }
        }
        $this->checkLogs();
        $this->clearLog();
        
    }

    public function importAssembliesData( $data ) {
        foreach ( $data as $project => $key ) {
            $projectId = intval( $key[ 'id' ] );
            foreach ( $key[ 'assemblies' ] as $id => $name ) {
                $path = $key[ 'root' ] . $id . ' ' . $name . '/';
                $assemblieId = $projectId . $id;
                $check = $this->db->prepare( "SELECT * FROM project_assemblies_data WHERE (id = :assemblieId)" );
                $check->bindparam( ':assemblieId', $assemblieId );

                if ( $check->execute() & count( $check->fetchAll() ) > 0 )
                {

                    $result[ $assemblieId ] = ['name' => $name, 'path' => $path, 'error' => 'record already in table' ];
                    $this->raport[ $projectId ] = $result;
                    $assemblieId = 'skip';
                }

                if ( $assemblieId != 'skip' )
                {
                    $stmt = $this->db->prepare( "INSERT INTO project_assemblies_data (id, projectId, path, name)
        VALUES (:id, :projectId, :path, :name)" );
                    $stmt->bindparam( ':projectId', $projectId );
                    $stmt->bindparam( ':id', $assemblieId );
                    $stmt->bindparam( ':path', $path );
                    $stmt->bindparam( ':name', $name );

                    if ( $stmt->execute())
                    {   
                        $tableName = 'project_assemblies_data';
                        $tempTable = $this->db->prepare( "INSERT INTO project_files_transfer_temp (fileId, tableName) VALUES (:fileId, :tableName)" );
                        $tempTable->bindparam( ':fileId', $path );
                        $tempTable->bindparam( ':tableName', $tableName );
                        $tempTable->execute();
                        $result[ $id ] = ['name' => $name, 'path' => $path, 'id' => $assemblieId ];
                        $this->log[ $projectId ] = $result;
                    } else
                    {
                        $result[ $assemblieId ] = ['name' => $name, 'path' => $path, 'error' => 'CRITICAL SAVE DATABASE ERROR' ];
                        $this->error[ $projectId ] = $result;
                        return false;
                    }
                }
            }
        }
        $this->checkLogs();
        $this->clearLog();
    }

    public function importProjectMainFiles( $data, $count ) {
        foreach ( $data as $project => $files ) {
            $projectId = intval( $project );
            $fileCount = 0;
            foreach ( $files as $file ) {
                $check = $this->db->prepare( "SELECT * FROM project_main_files WHERE (projectId = :projectId AND name = :name AND ext = :ext)" );
                $check->bindparam( ':projectId', $projectId );
                $check->bindparam( ':name', $file[ 'name' ] );
                $check->bindparam( ':ext', $file[ 'ext' ] );

                if ( $check->execute() & count( $check->fetchAll() ) > 0 )
                {
                    $result[ $file[ 'name' ] . '.' . $file[ 'ext' ] ] = ['name' => $file[ 'name' ],
                        'path' => $file[ 'path' ], 'ext' => $file[ 'ext' ], 'error' => 'record already in table' ];
                    $this->raport[ $projectId ] = $result;
                    
                    if($file['ext'] != 'ods' || $file['ext'] != 'xls' || $file['ext'] != 'xlsx'){
                        $file[ 'name' ] = 'skip';
                    }
                }

                if ( $file[ 'name' ] != 'skip' )
                {
                    $stmt = $this->db->prepare( "INSERT INTO project_main_files 
                        (projectId, ext, size, path, name, createdAt, updatedAt)
                        VALUES (:projectId, :ext, :size, :path, :name, :createdAt, :updatedAt)" );

                    $stmt->bindparam( ':projectId', $projectId );
                    $stmt->bindparam( ':ext', $file[ 'ext' ] );
                    $stmt->bindparam( ':size', $file[ 'size' ] );
                    $stmt->bindparam( ':path', $file[ 'path' ] );
                    $stmt->bindparam( ':name', $file[ 'name' ] );
                    $stmt->bindparam( ':createdAt', $file[ 'creation' ] );
                    $stmt->bindparam( ':updatedAt', $file[ 'modify' ] );
                    $fileCount++;
                    if ( $stmt->execute() )
                    {
                        $tableName = 'project_main_files';
                        $tempTable = $this->db->prepare( "INSERT INTO project_files_transfer_temp (fileId, tableName) VALUES (:fileId, :tableName)" );
                        $tempTable->bindparam( ':fileId', $file[ 'path' ] );
                        $tempTable->bindparam( ':tableName', $tableName );
                        $tempTable->execute();
                        
                        $result[ $file[ 'name' ] . '.' . $file[ 'ext' ] ] = ['name' => $file[ 'name' ], 'path' => $file[ 'path' ], 'ext' => $file[ 'ext' ], 'size' => $file[ 'size' ], 'createdAt' => $file[ 'creation' ], 'updatedAt' => $file[ 'modify' ] ];
                        $this->log[ $projectId ] = $result;
                    } else
                    {
                        $result[ $file[ 'name' ] . '.' . $file[ 'ext' ] ] = ['name' => $file[ 'name' ],
                            'path' => $file[ 'path' ], 'ext' => $file[ 'ext' ], 'error' => 'CRITICAL SAVE DATABASE ERROR' ];
                        $this->error[ $projectId ] = $result;
                        return false;
                    }
                }
            }
            $countFiles = $count[ $projectId ][ 'mainProjectFiles' ];
            $this->log[ $projectId ][ 'mainProjectFiles' ] = $countFiles;
            $this->log[ $projectId ][ 'mainProjectFilesAdded' ] = $fileCount;
            $this->fileCount['mainFiles'] = $countFiles;
            $this->fileCount['mainFilesAdded'] = $fileCount;
            
            
        }        
        $this->checkLogs();
        $this->clearLog();
    }

    public function importAssembliesMainFiles( $data, $count ) {
        foreach ( $data as $project => $files ) {
            $projectId = intval( $project );
            $fileCount = 0;
            foreach ( $files as $file ) {
                $assemblyId = $projectId . $file[ 'assebmlyId' ];
                $check = $this->db->prepare( "SELECT * FROM project_assemblies_main_files WHERE (projectId=:projectId AND name=:name AND ext=:ext AND assemblieId=:assemblieId AND size=:size)" );
                $check->bindparam( ':projectId', $projectId );
                $check->bindparam( ':name', $file[ 'name' ] );
                $check->bindparam( ':ext', $file[ 'ext' ] );
                $check->bindparam( ':assemblieId', $assemblyId );
                //$check->bindparam( ':sygnature', $file['sygnature'] );
                $check->bindparam( ':size', $file[ 'size' ] );

                if ( $check->execute() & count( $check->fetchAll() ) > 0 )
                {

                    $result[ $file[ 'name' ] . '.' . $file[ 'ext' ] ] = ['name' => $file[ 'name' ],
                        'path' => $file[ 'path' ], 'ext' => $file[ 'ext' ], 'error' => 'record already in table' ];
                    $this->raport[ $projectId ][ $assemblyId ] = $result;
                    $file[ 'name' ] = 'skip';
                }

                if ( $file[ 'name' ] != 'skip' )
                {
                    $stmt = $this->db->prepare( "INSERT INTO project_assemblies_main_files 
                        (projectId, assemblieId, name, path, size, createdAt, updatedAt, ext, sygnature)
                        VALUES (:projectId, :assemblieId, :name, :path, :size, :createdAt, :updatedAt, :ext, :sygnature)" );

                    $stmt->bindparam( ':projectId', $projectId );
                    $stmt->bindparam( ':assemblieId', $assemblyId );
                    $stmt->bindparam( ':sygnature', $file[ 'sygnature' ] );
                    $stmt->bindparam( ':ext', $file[ 'ext' ] );
                    $stmt->bindparam( ':size', $file[ 'size' ] );
                    $stmt->bindparam( ':path', $file[ 'path' ] );
                    $stmt->bindparam( ':name', $file[ 'name' ] );
                    $stmt->bindparam( ':createdAt', $file[ 'creation' ] );
                    $stmt->bindparam( ':updatedAt', $file[ 'modify' ] );
                    $fileCount++;
                    if ( $stmt->execute() )
                    {
                        $tableName = 'project_assemblies_main_files';
                        $tempTable = $this->db->prepare( "INSERT INTO project_files_transfer_temp (fileId, tableName) VALUES (:fileId, :tableName)" );
                        $tempTable->bindparam( ':fileId', $file[ 'path' ] );
                        $tempTable->bindparam( ':tableName', $tableName );
                        $tempTable->execute();
                        
                        $result[ $file[ 'name' ] . '.' . $file[ 'ext' ] ] = ['name' => $file[ 'name' ],
                            'path' => $file[ 'path' ], 'ext' => $file[ 'ext' ], 'size' => $file[ 'size' ],
                            'createdAt' => $file[ 'creation' ], 'updatedAt' => $file[ 'modify' ],
                            'sygnature' => $file[ 'sygnature' ], 'assemblyId' => $assemblyId ];
                        $this->log[ $projectId ][ $assemblyId ] = $result;
                    } else
                    {
                        $result[ $file[ 'name' ] . '.' . $file[ 'ext' ] ] = ['name' => $file[ 'name' ],
                            'path' => $file[ 'path' ], 'ext' => $file[ 'ext' ], 'error' => 'CRITICAL SAVE DATABASE ERROR' ];
                        $this->error[ $projectId ][ $assemblyId ] = $result;
                        return false;
                    }
                }
            }
            $countFiles = $count[ $projectId ][ 'mainAssemblyFiles' ];
            $this->log[ $projectId ][ 'mainAssemblyFiles' ] = $countFiles;
            $this->log[ $projectId ][ 'mainAssemblyFilesAdded' ] = $fileCount;
            $this->fileCount['assemblieMainFiles'] = $countFiles;
            $this->fileCount['assemblieMainFilesAdded'] = $fileCount;
        }
        $this->checkLogs();
        $this->clearLog();
    }

    public function importAssembliesFiles( $data, $count ) {
        $updateCount = 0;
        foreach ( $data as $projectId => $files ) {
            $projectId = intval( $projectId );
            $fileCount = 0;
            $excelFileCount = 0;
            
            foreach ( $files as $assemblieId => $file ) {
                $newAssemblieId = $projectId . $assemblieId;
                foreach ( $file as $record ) {
                    
                    if ( $this->filterFile( $this->filterDatas, $record['name'] ) )
                   {
                        
//                               if($this->filterData[ 'material' ] == "Aluminium"){
//                                                 die($record[ 'path' ] . ' | ' . $this->filterData[ 'thickness' ] . ' | ' . $this->filterData[ 'material' ] . ' | ' . $this->filterData[ 'quanity' ]  );
//                               
//                               }
                        $typeId = intval( $record[ 'typeId' ] );
                        /*
                         * check for file copies and count them
                         */
                        $copyCheck = $this->db->prepare( "SELECT * FROM project_assemblies_files WHERE (projectId=:projectId AND name=:name AND assemblieId=:assemblieId)" );
                        $copyCheck->bindparam( ':projectId', $projectId );
                        $copyCheck->bindparam( ':name', $record[ 'name' ] );
                        $copyCheck->bindparam( ':assemblieId', $newAssemblieId );
                        if ( $copyCheck->execute() & count( $copyCheck->fetchAll() ) == 0 )
                        {
                            $excelFileCount++;
                        }
                        
                        
                        $check = $this->db->prepare( "SELECT * FROM project_assemblies_files WHERE (projectId=:projectId AND name=:name AND ext=:ext)" );
 //                       $check->bindparam( ':sygnature', $record[ 'sygnature'] );
                        $check->bindparam( ':projectId', $projectId );
//                        $check->bindparam( ':path', $record[ 'path' ]);
                        $check->bindparam( ':name', $record[ 'name' ] );
                        $check->bindparam( ':ext', $record[ 'ext' ] );
//                        $check->bindparam( ':assemblieId', $newAssemblieId );
                        //$check->bindparam( ':sygnature', $file['sygnature'] );
//                        $check->bindparam( ':size', $record[ 'size' ] );
                        $check->execute();
                        if ( count( $check->fetchAll() ) > 0 )
                        {          
                            $result[ $record[ 'name' ] . '.' . $record[ 'ext' ] ] = ['name' => $record[ 'name' ],
                                'path' => $record[ 'path' ], 'ext' => $record[ 'ext' ], 'error' => 'record already in table' ];
                            $this->raport[ $projectId ][ $newAssemblieId ][ 'assmblieFiles' ] = $result;
                            $backupName = $record['name'];
                            $record[ 'name' ] = 'skip';
                            
                        }
                        if ( $record[ 'name' ] != 'skip' )
                        {
                            $stmt = $this->db->prepare( "INSERT INTO project_assemblies_files 
                        (projectId, assemblieId, typeId, name, path, size, createdAt, updatedAt, ext, sygnature, thickness, material, quanity) VALUES (:projectId, :assemblieId, :typeId, :name, :path, :size, :createdAt, :updatedAt, :ext, :sygnature, :thickness, :material, :quanity)" );

                            $stmt->bindparam( ':projectId', $projectId );
                            $stmt->bindparam( ':assemblieId', $newAssemblieId );
                            $stmt->bindparam( ':typeId', $typeId );
                            $stmt->bindparam( ':sygnature', $record[ 'sygnature' ] );
                            $stmt->bindparam( ':ext', $record[ 'ext' ] );
                            $stmt->bindparam( ':size', $record[ 'size' ] );
                            $stmt->bindparam( ':path', $record[ 'path' ] );
                            $stmt->bindparam( ':name', $record[ 'name' ] );
                            $stmt->bindparam( ':createdAt', $record[ 'creation' ] );
                            $stmt->bindparam( ':updatedAt', $record[ 'modify' ] );
                            $stmt->bindparam( ':thickness', $this->filterData[ 'thickness' ] );   //ADD THIS AFTER FILTER IS READY
                            $stmt->bindparam( ':material', $this->filterData[ 'material' ] );
                            $stmt->bindparam( ':quanity', $this->filterData[ 'quanity' ] );
                            
                            $fileCount++;
                            if ( $stmt->execute() )
                            {
                                $tableName = 'project_assemblies_files';
                                $tempTable = $this->db->prepare( "INSERT INTO project_files_transfer_temp (fileId, tableName) VALUES (:fileId, :tableName)" );
                                $tempTable->bindparam( ':fileId', $record[ 'path' ] );
                                $tempTable->bindparam( ':tableName', $tableName );
                                $tempTable->execute();
                                
                                $result[ $record[ 'name' ] . '.' . $record[ 'ext' ] ] = ['name' => $record[ 'name' ],
                                    'typeId' => $record[ 'typeId' ], 'path' => $record[ 'path' ], 'ext' => $record[ 'ext' ],
                                    'size' => $record[ 'size' ], 'createdAt' => $record[ 'creation' ], 'updatedAt' => $record[ 'modify' ],
                                    'sygnature' => $record[ 'sygnature' ], 'assemblyId' => $newAssemblieId ];
                                $this->log[ $projectId ][ $newAssemblieId ] = $result;
                            } else
                            {
                                $result[ $record[ 'name' ] . '.' . $record[ 'ext' ] ] = ['name' => $record[ 'name' ],
                                    'path' => $record[ 'path' ], 'ext' => $record[ 'ext' ], 'error' => 'CRITICAL SAVE DATABASE ERROR' ];
                                $this->error[ $projectId ][ $newAssemblieId ] = $result;
                                return false;
                            }
                        } else {

                             $stmt = $this->db->prepare( "UPDATE project_assemblies_files SET thickness=:thickness, material=:material, quanity=:quanity  WHERE path=:path" );
                            
//                            $stmt->bindparam( ':fileId', $check->id );
//                            $stmt->bindparam( ':projectId', $projectId );
//                           $stmt->bindparam( ':assemblieId', $newAssemblieId );
//                            $stmt->bindparam( ':typeId', $typeId );
//                            $stmt->bindparam( ':sygnature', $record[ 'sygnature' ] );
//                            $stmt->bindparam( ':ext', $record[ 'ext' ] );
//                            //$stmt->bindparam( ':name', $record[ 'name' ] );
                            $stmt->bindparam( ':path', $record[ 'path' ] );
                            $stmt->bindparam( ':thickness', $this->filterData[ 'thickness' ] );   //ADD THIS AFTER FILTER IS READY
                            $stmt->bindparam( ':material', $this->filterData[ 'material' ] );
                            $stmt->bindparam( ':quanity', $this->filterData[ 'quanity' ] );
                             //die($check->id . ' | ' . $record['ext'] . ' | ' . $record['path'] . ' | ' . $this->filterData[ 'thickness' ]);
                            $stmt->execute();
                            //var_dump($record[ 'path' ] );
                            //die();
                            $updateCount++;
                            
                            
                        }
                    }
                }

                $countFiles = $count[ $projectId ][ 'assemblyFiles' ];
                $this->log[ $projectId ][ 'assemblyFiles' ] = $countFiles;
                $this->log[ $projectId ][ 'assemblyFilesAdded' ] = $fileCount;
                $this->fileCount['assemblieFiles'] = $countFiles;
                $this->fileCount['assemblieFilesAdded'] = $fileCount;
                $this->fileCount['assemblieFilesFiltered'] = $excelFileCount;
                $this->fileCount['assemblieFilesUpdated'] = $updateCount;
                
            }
        }
        $this->checkLogs();
        $this->clearLog();
    }

    public function filterFile( $filterFile, $data ) {
        
        foreach ( $filterFile as $filter ) {              
                  
            if (isset($filter['name'])){
                $patternPatrs = explode('_', $filter['name']);
                $pattern = $patternPatrs[0];
                
                $namePatrs = explode('_', $data);
                $name = $namePatrs[0];
                
                    if($pattern == $name)
                    {
                        if ( !isset( $filter[ 'thickness' ] ) )
                        {
                            $filter[ 'thickness' ] = 0;
                        } else {
                           $needle = ['fi', 'm', 'M', 'Fi', 'fI'];
                           $filter[ 'thickness' ] = str_replace( ',', '.', $filter['thickness']);
                           $filter[ 'thickness' ] = str_replace( $needle, '', $filter['thickness']);
                        }
                        
                        if ( !isset( $filter[ 'quanity' ] ) )
                        {
                            $filter[ 'quanity' ] = 1;
                        }
                        
                        if ( !isset( $filter[ 'material' ] ) )
                        {
                            $filter[ 'material' ] = 'not applicable';
                        }
                        
                        $result = [
                            'quanity' => $filter[ 'quanity' ],
                            'thickness' => $filter[ 'thickness' ],
                            'material' => $filter[ 'material' ],
                        ];
//                        die($pattern . ' | '. $filter['name'] . ' | ' . $filter[ 'quanity' ] . ' | ' . $filter[ 'thickness' ] . ' | ' . $filter[ 'material' ] );
                        return $this->filterData = $result;
                }
            }
        }    
        return false;
    }

    public function checkLogs() {
        $createLog = new LogCreator;
        if ( !empty( $this->log ) )
        {
            $createLog->createLog( $this->log );
        }

        if ( !empty( $this->raport ) )
        {
            $createLog->createError( $this->raport );
        }
    }
    
    public function clearLog() {
        $this->log = [];
        $this->raport = [];
    }
    
    public function finalize($option, $sygnature = null, $projectName) {
     if($option === 'yes'){
         $stmt = $this->db->prepare("TRUNCATE TABLE project_files_transfer_temp");
         $stmt->execute();
         return $this->status['status'] = 'Project Data Saved';     
     } else {
        $check = $this->db->prepare( "SELECT fileId, tableName FROM project_files_transfer_temp");
        $check->execute();
        $result = $check->fetchAll();
        foreach($result as $data){
            switch($data['tableName']):
                case('project_file_data'):
                    $stmt = $this->db->prepare("DELETE FROM  project_file_data WHERE projectId = :fileId");
                    $stmt->bindparam( ':fileId', $data['fileId']);
                    $stmt->execute();
                    break;
                case('project_assemblies_data'):
                    $stmt = $this->db->prepare("DELETE FROM  project_assemblies_data WHERE path = :path");
                    $stmt->bindparam( ':path', $data['fileId'] );
                    $stmt->execute();
                    break;
                case('project_main_files'):
                    $stmt = $this->db->prepare("DELETE FROM  project_main_files WHERE path = :path");
                    $stmt->bindparam( ':path', $data['fileId'] );
                    $stmt->execute();
                    break;
                case('project_assemblies_main_files'):
                    $stmt = $this->db->prepare("DELETE FROM  project_assemblies_main_files WHERE path = :path");
                    $stmt->bindparam( ':path', $data['fileId'] );
                    $stmt->execute();
                    break;
                case('project_assemblies_files'):
                    $stmt = $this->db->prepare("DELETE FROM  project_assemblies_files WHERE path = :path");
                    $stmt->bindparam( ':path', $data['fileId'] );
                    $stmt->execute();
                    break;
            endswitch;
        }     
            shell_exec("rm -R /media/data/app_data/project_data/$projectName");
            $stmt = $this->db->prepare("TRUNCATE TABLE project_files_transfer_temp");
            $stmt->execute();
            return $this->status['status'] = 'Project Import process has been reverted.';
     }
     
    }
    
    public function statusChange($sygnature){
        $check = $this->db->prepare( "SELECT projectId FROM project_file_data WHERE projectId=:projectId" );
        $check->bindparam( ':projectId', $sygnature );
        $check->execute();
        if($check->fetchAll() > 0){
        $check = $this->db->prepare( "UPDATE project_data SET projectStatus=:projectStatus WHERE sygnature=:projectId" );
        $status = 1;
        $check->bindparam( ':projectId', $sygnature );
        $check->bindparam( ':projectStatus', $status);
        $check->execute(); 
        }
    }
    public function delete($sygnature) {
         $stmt = $this->db->prepare("DELETE FROM  project_assemblies_data WHERE projectId = :projectId");
         $stmt->bindparam( ':projectId', $sygnature );
         $stmt->execute();
         
         $stmt = $this->db->prepare("DELETE FROM  project_assemblies_files WHERE projectId = :projectId");
         $stmt->bindparam( ':projectId', $sygnature );
         $stmt->execute();
         
         $stmt = $this->db->prepare("DELETE FROM  project_assemblies_main_files WHERE projectId = :projectId");
         $stmt->bindparam( ':projectId', $sygnature );
         $stmt->execute();
         
         $stmt = $this->db->prepare("DELETE FROM  project_file_data WHERE projectId = :projectId");
         $stmt->bindparam( ':projectId', $sygnature );
         $stmt->execute();
         
         $stmt = $this->db->prepare("DELETE FROM  project_main_files WHERE projectId = :projectId");
         $stmt->bindparam( ':projectId', $sygnature );
         $stmt->execute();
         
         $this->status['status'] = 'Project Import process has been reverted.';
    }
    

}
