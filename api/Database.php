<?php
// include_once('classes/interface/DataInterface.php');
include_once('/var/www/html/training/paginator/classes/interface/DataInterface.php'); // FIX when complete ajax spl_loading


// TODO: make the class polymorphic and remove hardcoded data/props etc
class Database implements DataInterface
{
    private $database;
    private $host;
    private $database_name;
    private $user;
    private $password;
    private $dsn;
    private $connection;
    private $pdo_options = [];
    private $data;
    private $dataSize;


    public function __construct()
    {
        $this->database = 'mysql';
        $this->host = 'localhost';
        $this->database_name = 'test_users';
        $this->user = 'root';
        $this->password = '';
        $this->dsn = $this->database . ':host=' . $this->host . ';dbname=' . $this->database_name;

        // Set the DB connection
        $this->setConnection();

        // Get all data at build up
        $this->getAllData();

        // Set data size
        // $this->setDataTotalSize($this->getAllData());
    }

    /**
     * Set PDO connection
     * 
     * @return void
     */
    public function setConnection()
    {
        try {
            $this->connection = new PDO($this->dsn, $this->user, $this->password, $this->pdo_options);

        } catch (\PDOException $e) {
            print "Database Error: ". $e->getMessage();
            die();
        }
    }

    /**
     * Make database query
     * 
     * @return mixed
     */
    public function dbQuery($query_string, $pdo_fetch_mode = PDO::FETCH_ASSOC)
    {
        // Prepare the query string
        // var_dump($this->connection->query($query_string, $pdo_fetch_mode)->fetchAll());
        return $this->connection->query($query_string, $pdo_fetch_mode);
    }

    /**
     * Summary of getAllUsers
     * 
     * @return mixed
     */
    public function getAllData()
    {
        // TODO: make polymorphic with naming etc...
        $data = [];
        $query_string = "SELECT * FROM users";

        // $this->data = $this->dbQuery($query_string)->fetchAll();

        foreach ($this->dbQuery($query_string) as $row) {
            $row['address'] = json_decode($row['address']);
            $data[] = $row;
        }

        // return $this->data;
        // echo json_encode($data);
        return $data;
    }


    public function getData()
    {
        // return "database method from class ". get_class($this) ."  returned";
        return $this->getAllData();
    }

    public function setData($data)
    {
        // var_dump($data);
        $this->data = $data;

        $this->setDataTotalSize($data);
    }

    public function setDataTotalSize($data = NULL)
    {
        // var_dump($data);
        // $this->dataSize = $data;
        if(!$data){
            $this->dataSize = sizeof($this->getAllData());
        }else{
            $this->dataSize = sizeof($data);
        }
        return $this->dataSize;
    }

    public function getDataTotalSize()
    {
        // return sizeof($this->data);
        return $this->dataSize;
        
    }
}