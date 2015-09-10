<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class InvoicesCheck
{

    private $db;
    public $data;

    public function __construct( $db ) {
        $this->db = $db;
        $this->statusCheck();
        $this->dateCheck();
    }

    public function statusCheck() {
        $query = 'SELECT * FROM invoices WHERE isAccepted = 1';
        $stmt = $this->db->prepare( $query );
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ( count( $result ) > 0 )
        {
            $this->data[ 'NewInvoices' ] = count( $result );

            foreach ( $result as $file ) {
                $this->data[ 'dates' ][] = $file[ 'creTime' ];
            }
        }
    }
    
    public function dateCheck() {
        if(!empty($this->data)){
            $currentDate = date('Y-m-d');
            $id = 0;
            foreach($this->data['dates'] as $data){
                $dateParts = explode(' ', $data);
                $date = $dateParts[0];
                $time = $dateParts[1];
                if($date == $currentDate){
                    $this->data['new'][$id]['date'] = $date;
                    $this->data['new'][$id]['time'] = $time;
                }
            $id++; 
        }
    }
    

}
}
