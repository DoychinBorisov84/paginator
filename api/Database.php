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
            print "Database Connection Error: ". $e->getMessage();
            die();
        }
    }

    /**
     * Make database query
     * 
     * @return array|mixed
     */
    public function dbQuery($query_string, $pdo_fetch_mode = PDO::FETCH_ASSOC)
    {
        return $this->connection->query($query_string, $pdo_fetch_mode);
    }

    /**
      * Set data || generate default data & trigger to set dataSize
     */
    public function setData($data = [])
    {
        $this->data = $data;
        
        if(empty($data)) {
            $this->data = $this->generateDatabaseData();
        }

        // Set dataSize
        $this->setDataTotalSize($this->data);
    }

    /**
     * Return database data
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set dataSize
     */
    public function setDataTotalSize($data)
    {        
        if(empty($data)){
            $this->dataSize = sizeof($this->getData());
            return;
        }
        $this->dataSize = sizeof($data);
    }

    /**
     * Get dataSize
     * 
     * @return int
     */
    public function getDataSize()
    {
        return $this->dataSize;        
    }

     /**
     * Generate default data
     * @return array
     */
    private function generateDatabaseData()
    {
        $data = [];
        $query_string = "SELECT * FROM users";

        foreach ($this->dbQuery($query_string)->fetchAll() as $row) {
            $row['address'] = json_decode($row['address']);
            $data[] = $row;
        }

        return $data;
    }
}