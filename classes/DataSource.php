<?php
// include_once('api/Database.php');
// include_once('api/Restapi.php');
// include_once('api/DefaultData.php');
include_once('/var/www/html/training/paginator/api/Database.php');
include_once('/var/www/html/training/paginator/api/Restapi.php');
include_once('/var/www/html/training/paginator/api/DefaultData.php'); // FIX when complete ajax spl_loading



class DataSource 
{
    private $source; 

    public function __construct($source)
    {
        // Create, sanitize from source class and return ... only if class/dir/available ???
        // echo "Datasource of type $this->source constucted";
        $this->source = new $source();
    }

    public function getSource()
    {
        return $this->source;
    }
}