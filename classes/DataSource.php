<?php
namespace Paginator\Classes;
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
            $class = "Paginator\\Api\\{$source}";
            
            $this->source = new $class();
        } catch (\Throwable $th) {
            echo 'Fail to create DataSource object of type: '. $source . ', ' . $th->getMessage();
        }
    }

    public function getSource()
    {
        return $this->source;
    }
}