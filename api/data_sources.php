<?php
// TODO: create new Paginator($source) .... and return to custom.js with all the props setted up for use
// include('../classes/Paginator.php');
// echo (json_encode($_GET));
// die;
// die();
// echo json_encode(array('cat' => 'Meaw', 'dog' => 'Bobo')); 

// Database Source
// Make DB request and prepare data, check params for &page&dataSource; 
$db = 'mysql';
$host = 'localhost';
$db_name = 'test_users';
$db_user = 'root';
$db_password = '';
$dsn = $db . ':' . 'host=' . $host . ';' . 'dbname=' . $db_name;// . ',' . $db_user . ',' . $db_pass;
$pdo_options = [];

// echo json_encode($dsn);
// die;

$data = [];
try {
    $dsn = new PDO($dsn, $db_user, $db_password, $pdo_options);
    // Prepare the JSON data for the custom.js
    foreach($dsn->query('SELECT * from users', PDO::FETCH_ASSOC) as $row) {
        $row['address'] = json_decode($row['address']);
        $data[] = $row;
    }
    // $data['count'] = sizeof($data); // pass the data
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
$dsn = null;

// var_dump($paginator);
// die;
// echo json_encode($data);
echo json_encode($data);



// header('Location: ../index.php&data=api');




