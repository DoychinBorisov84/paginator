<?php
class DefaultData implements DataInterface
{
    private $data;

    private $dataSize;

    /**
     * Set data || generate default data & trigger to set dataSize
     */
    public function setData($data = [])
    {
        $this->data = $data;

        if(empty($data)){
            $this->data = $this->generateDefaultData();
        }

        // Set dataSize
        $this->setDataSize($this->data);
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
    public function setDataSize($data)
    {        
        if(empty($data)){
            $this->dataSize = sizeof($this->getData());
            return;
        }
        $this->dataSize = sizeof($data);
    }

    /**
     * Get the data total size
     * @return mixed
     */
    public function getDataSize()
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