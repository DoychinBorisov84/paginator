<?php
// include_once('classes/interface/DataInterface.php');
include_once('/var/www/html/training/paginator/classes/interface/DataInterface.php'); // fix when done ajax spl_load

class DefaultData implements DataInterface
{
    private $data;

    public function getAllData()
    {
        $this->data = array_fill(0, 50, 'defaultData');
        return $this->data;
    }

    public function getData()
    {
        return "default interface method from class ". get_class($this) ." returned";
    }
}