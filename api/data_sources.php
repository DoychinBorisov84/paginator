<?php

// echo (json_encode($_GET)); 
// die();
// echo json_encode(array('cat' => 'Meaw', 'dog' => 'Bobo')); 

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
    foreach($dsn->query('SELECT * from users', PDO::FETCH_ASSOC) as $row) {
        $data[] = $row;
        // print_r($row);
    }
    $dsn = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

 echo json_encode($data);



// header('Location: ../index.php&data=api');




