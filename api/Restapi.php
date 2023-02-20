<?php
// include_once('classes/interface/DataInterface.php');
include_once('/var/www/html/training/paginator/classes/interface/DataInterface.php'); // FIX when complete ajax spl_loading


class Restapi implements DataInterface
{
    private $data;

    private $dataSize;    

    public function setData($data)
    {
        // var_dump($data);
        $this->data = $data;

        $this->setDataTotalSize($data);
    }

    public function getData()
    {
        return $this->data;
    }
    
    /**
     * Set the data total size
     * @param array $data
     */ 
    public function setDataTotalSize($data)
    {
        $this->dataSize = sizeof($data);
    }

   /**
     * Get the data total size
     * @return mixed
     */
    public function getDataTotalSize()
    {
        return $this->dataSize;
    }
}