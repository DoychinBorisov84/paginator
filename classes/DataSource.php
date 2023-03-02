<?php
namespace Paginator\Classes;

// use Paginator\Classes\Interfaces\DataInterface as DataInterface;
use Paginator\Api\Database as Database;
use Paginator\Api\DefaultData as DefaultData;
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
            echo 'Fail to create DataSource object of type: '. $source . ', ' . $th->getMessage();
        }
    }

    public function getSource()
    {
        return $this->source;
    }
}