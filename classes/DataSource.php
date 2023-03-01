<?php
/**
 * class DataSource - creating instances of our data source classes
 */
class DataSource 
{
    private $source; 

    public function __construct($source)
    {
        try {
            $source = ucfirst($source);
            
            $this->source = new $source();
        } catch (\Throwable $th) {
            echo 'Fail to create DataSource object: ' . $th->getMessage();
        }
    }

    public function getSource()
    {
        return $this->source;
    }
}