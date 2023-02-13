<?php
// include_once('classes/interface/DataInterface.php');
include_once('/var/www/html/training/paginator/classes/interface/DataInterface.php'); // FIX when complete ajax spl_loading


class Restapi implements DataInterface
{
    private $data;

    private $dataSize;

    public function getAllData()
    {
        return ['dummy' => 222, 'gummy' => 333];
        
        // // TODO: make polymorphic with naming etc...
        // $query_string = "SELECT * FROM users";

        // $this->data = $this->dbQuery($query_string)->fetchAll();

        // return $this->data;
    }

    public function setData($data)
    {
        // var_dump($data);
        $this->data = $data;

        $this->setDataTotalSize($data);
    }

    public function getData()
    {
        // return "restapi method form class ". get_class($this) ." returned";
        // var_dump($this->data);
        echo json_encode($this->data);
    }
    
    public function setDataTotalSize($data)
    {
        // var_dump($data);
        $this->dataSize = $data;
    }
    public function getDataTotalSize()
    {
        // return sizeof($this->data);
        return $this->dataSize;
        
    }
}