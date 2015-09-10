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
            exit( "File load error!" . EOL );
        }
        $this->file = $file;
        $this->readFile();
        $this->renameKeys();
    }

    public function readFile() {

        $objReader = \PHPExcel_IOFactory::createReaderForFile($this->file);
        $objPHPExcel = $objReader->load( $this->file );
        $objPHPExcel->setActiveSheetIndex( 0 );
//echo date('H:i:s') , " Iterate worksheets" , EOL;
        foreach ( $objPHPExcel->getWorksheetIterator() as $worksheet ) {
            //echo 'Worksheet - ' , $worksheet->getTitle() , EOL;
            foreach ( $worksheet->getRowIterator() as $row ) {
                //echo '    Row number - ' , $row->getRowIndex() , EOL;
                $cellIterator = $row->getCellIterator();
                //$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set

                foreach ( $cellIterator as $cell ) {
                    if ( !is_null( $cell ) )
                    {
                        $name = preg_replace( '/[0-9]/', '', $cell->getCoordinate() );
//                        $cell->getCalculatedValue();
//                        if($number == $this->iteration ){
//                            //$this->files = $cell->getCalculatedValue();
//                            var_dump($cell->getCalculatedValue());
//                            $this->iteration++;
//                        }

                        $this->files[ $this->iteration ][ $this->label[ $name ] ] = $cell->getCalculatedValue();
                    }
                }
                $this->iteration++;
            }
        }
        return $this->files;
    }

    public function renameKeys() {

        foreach ( $this->files as $file => $key ) {
            // var_dump($key['nazwa']);
            if ( isset( $key[ 'nazwa' ] ) )
            {

                $this->files[ $key[ 'nazwa' ] ] = $this->files[ $file ];
                unset( $this->files[ $file ] );
            }
        }
        return $this->files;
    }

}

?>