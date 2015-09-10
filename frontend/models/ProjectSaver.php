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

    public function __construct( $db, $filter ) {

        $this->db = $db;
        $this->filterDatas = $filter;
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

                    if ( $stmt->execute() )
                    {
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
                    $file[ 'name' ] = 'skip';
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
        }
        $this->checkLogs();
        $this->clearLog();
    }

    public function importAssembliesFiles( $data, $count ) {

        foreach ( $data as $projectId => $files ) {
            $projectId = intval( $projectId );
            $fileCount = 0;
            foreach ( $files as $assemblieId => $file ) {
                $newAssemblieId = $projectId . $assemblieId;
                foreach ( $file as $record ) {
                    $filterData = $record[ 'sygnature' ] . ' ' . $record[ 'name' ];

//                    if ( $this->filterFile( $this->filterDatas, $filterData ) )
//                    {

                        $typeId = intval( $record[ 'typeId' ] );
                        $check = $this->db->prepare( "SELECT * FROM project_assemblies_files WHERE (path=:path AND projectId=:projectId AND name=:name AND ext=:ext AND assemblieId=:assemblieId AND size=:size)" );
                        $check->bindparam( ':path', $record[ 'path' ] );
                        $check->bindparam( ':projectId', $projectId );
                        $check->bindparam( ':name', $record[ 'name' ] );
                        $check->bindparam( ':ext', $record[ 'ext' ] );
                        $check->bindparam( ':assemblieId', $newAssemblieId );
                        //$check->bindparam( ':sygnature', $file['sygnature'] );
                        $check->bindparam( ':size', $record[ 'size' ] );

                        if ( $check->execute() & count( $check->fetchAll() ) > 0 )
                        {

                            $result[ $record[ 'name' ] . '.' . $record[ 'ext' ] ] = ['name' => $record[ 'name' ],
                                'path' => $record[ 'path' ], 'ext' => $record[ 'ext' ], 'error' => 'record already in table' ];
                            $this->raport[ $projectId ][ $newAssemblieId ][ 'assmblieFiles' ] = $result;
                            $record[ 'name' ] = 'skip';
                        }
                        if ( $record[ 'name' ] != 'skip' )
                        {
                            $stmt = $this->db->prepare( "INSERT INTO project_assemblies_files 
                        (projectId, assemblieId, typeId, name, path, size, createdAt, updatedAt, ext, sygnature) VALUES (:projectId, :assemblieId, :typeId, :name, :path, :size, :createdAt, :updatedAt, :ext, :sygnature)" );

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
//                            $stmt->bindparam( ':flag', $this->filterData[ 'flag' ] );
//                            $stmt->bindparam( ':thickness', $this->filterData[ 'thickness' ] );   ADD THIS AFTER FILTER IS READY
//                            $stmt->bindparam( ':material', $this->filterData[ 'material' ] );
//                            $stmt->bindparam( ':quanity', $this->filterData[ 'quanity' ] );

                            $fileCount++;
                            if ( $stmt->execute() )
                            {
                                $result[ $record[ 'name' ] . '.' . $record[ 'ext' ] ] = ['name' => $record[ 'name' ],
                                    'typeId' => $record[ 'typeId' ], 'path' => $record[ 'path' ], 'ext' => $record[ 'ext' ],
                                    'size' => $record[ 'size' ], 'createdAt' => $record[ 'creation' ], 'updatedAt' => $record[ 'modify' ],
                                    'sygnature' => $record[ 'sygnature' ], 'assemblyId' => $newAssemblieId ];
                                $this->log[ $projectId ][ $newAssemblieId ] = $result;
                                $fileCount;
                            } else
                            {
                                $result[ $record[ 'name' ] . '.' . $record[ 'ext' ] ] = ['name' => $record[ 'name' ],
                                    'path' => $record[ 'path' ], 'ext' => $record[ 'ext' ], 'error' => 'CRITICAL SAVE DATABASE ERROR' ];
                                $this->error[ $projectId ][ $newAssemblieId ] = $result;
                                return false;
                            }
                        }
//                    }
                }
                $countFiles = $count[ $projectId ][ 'assemblyFiles' ];
                $this->log[ $projectId ][ 'assemblyFiles' ] = $countFiles;
                $this->log[ $projectId ][ 'assemblyFilesAdded' ] = $fileCount;
            }
        }
        $this->checkLogs();
        $this->clearLog();
    }

    public function filterFile( $filterFile, $data ) {
//        foreach ( $filterFile as $filter ) {
//            if ( $data == $filter[ 'name' ] )
//            {
//                if ( !isset( $filter[ 'thickness' ] ) )
//                {
//                    $filter[ 'thickness' ] = '';
//                }
//                $result = [
//                    'quanity' => $filter[ 'quanity' ],
//                    'thickness' => $filter[ 'thickness' ],
//                    'material' => $filter[ 'material' ],
//                    'flag' => 1
//                ];
//
//                return $this->filterData = $result;
//            }
//        }
//        return false;
        return true;
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

}
