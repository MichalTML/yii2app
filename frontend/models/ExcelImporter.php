<?php

namespace frontend\models;

class ExcelImporter
{

    public $file = '';
    public $label = ['A' => 'Lp', 'B' => 'name', 'C' => 'quanity', 'D' => 'thickness', 'E' => 'material' ];
    public $iteration = 1;
    public $files = [ ];

    public function __construct( $file ) {

        if ( !file_exists( $file ) )
        {
            exit( "File load error!" );
        }
        $this->file = $file;
        $this->readFile();
        $this->renameKeys();
    }

    public function readFile() {

        $objReader = \PHPExcel_IOFactory::createReaderForFile( $this->file );
        $objPHPExcel = $objReader->load( $this->file );
        $objPHPExcel->setActiveSheetIndex( 0 );
        foreach ( $objPHPExcel->getWorksheetIterator() as $worksheet ) {
            foreach ( $worksheet->getRowIterator() as $row ) {
                $cellIterator = $row->getCellIterator();
                $this->cellDataExtractor($cellIterator);
                $this->iteration++;
            }
        }
        return $this->files; // saving data
    }
    
    
    private function cellDataExtractor($cells){
        foreach ( $cells as $cell ) { // itterating throught Excel cells
             
                    if ( !empty( $cell->getFormattedValue()) ) // filtering out empty cells
                    {
                       //var_dump($cell->getFormattedValue());
                        $name = preg_replace( '/[0-9]/', '', $cell->getCoordinate() ); // getting letter cord ex. 'A'
                        
                            if ( isset( $this->label[ $name ] ) && !empty( $cell->getFormattedValue() ) )
                            { // Filtering only needed cells / empty out
                                $formatCell = trim($cell->getFormattedValue());
                                $formatData = explode(' ', $formatCell);
                                
                                $formattedParts = [];
                                if(count($formatData) > 1){ // check if data needs format
                                    for($x = 0; $x < count($formatData); $x++ ){ // deleteing spaces from material name
                                        if(strlen($formatData[$x]) > 1){
                                            $formattedParts[] = $formatData[$x];
                                        }
                                        $formatted =  implode(' ', $formattedParts);   
                                    } 
                                } else {
                                    $formatted = $formatData[0];
                                }
                                
                                $this->files[ $this->iteration ][ $this->label[ $name ] ] = $formatted;
                                
                            } elseif ( isset( $this->label[ $name ] ) && empty( $cell->getFormattedValue() ) ){
                                
                                $this->files[ $this->iteration ][ $this->label[ $name ] ] = 'not applicable';
                                
                            }
                    }
                               
        
                }
               
    }
    

    public function renameKeys() { // formating data table with names

        foreach ( $this->files as $file => $key ) {
            if ( isset( $key[ 'nazwa' ] ) )
            {
                $this->files[ $key[ 'nazwa' ] ] = $this->files[ $file ];
                unset( $this->files[ $file ] );
            }
        }
        return $this->files;
    }

}
