<?php
class Restapi implements DataInterface
{
    private $data;
    private $dataSize;    

     /**
      * Set data || generate default data & trigger to set dataSize
     */
    public function setData($data = [])
    {
        $this->data = $data;

        // Set dataSize
        $this->setDataSize($data);
    }

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
        if(!$data){
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
}