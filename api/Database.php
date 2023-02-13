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
     * @return void
     */
    public function getAllData()
    {
        // TODO: make polymorphic with naming etc...
        $query_string = "SELECT * FROM users";

        $this->data = $this->dbQuery($query_string)->fetchAll();

        return $this->data;
    }


    public function getData()
    {
        return "database method from class ". get_class($this) ."  returned";
    }
}