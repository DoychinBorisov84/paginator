<?php
// include_once('classes/interface/DataInterface.php');
include_once('/var/www/html/training/paginator/classes/interface/DataInterface.php'); // fix when done ajax spl_load

class DefaultData implements DataInterface
{
    private $data;

    private $dataSize;

    public function __construct()
    {
        // $this->setData($data);
    }

    
    /**
     * @param mixed $data
     * Sets the data
     */
    public function setData($data = NULL)
    {
        $this->data = $data;

        if(!$data){
            $this->data = $this->generateDefaultData();
        }

        $this->setDataTotalSize($this->data);
    }

    /**
     * Get the data
     * @return array
     */
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

    /**
     * Generate default data
     */
    private function generateDefaultData()
    {
        $data = [];
        $data = array_fill(0, 50,  [
            'avatar' => '/paginator/assets/default.jpg',
            'first_name' => 'Dummy Name',
            'email' => 'dummy@example.com',
            'address' =>[
                'country' => 'Dummy Country',
                'city' => 'Dummy City',
            ]
        ]);

        return $data;
    }
}