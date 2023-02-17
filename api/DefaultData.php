<?php
// include_once('classes/interface/DataInterface.php');
include_once('/var/www/html/training/paginator/classes/interface/DataInterface.php'); // fix when done ajax spl_load

class DefaultData implements DataInterface
{
    private $data;

    private $dataSize;

    // public function getAllData()
    // {
    //     $this->data = array_fill(0, 50, array_fill(10, 50, 'boom'));
    //     return $this->data;
    // }

    public function getData()
    {
        // return "default interface method from class ". get_class($this) ." returned";
        return $this->data;
    }

    public function setData($data)
    {
        // var_dump($data);
        // $this->data = $data;        
        $this->data = array_fill(0, 50,  [
            'avatar' => '/paginator/assets/default.jpg',
            'first_name' => 'Dummy Name',
            'email' => 'dummy@example.com',
            'address' =>[
                'country' => 'Dummy Country',
                'city' => 'Dummy City',
            ]
        ]);


        $this->setDataTotalSize($data);
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