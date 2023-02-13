<?php
require_once('classes/Base.php');

$base = new Base();

 // Paginator instance for the content
$dataSource = $_GET['dataSource'];
// $paginator = new Paginator();

// Integrate via DI into Paginator ?
// Can we achieve ajax returned Obj generated on <select> change to be available initially, so we can instantiate here?
$paginator = $dataSource != 'defaultData' ? new Paginator(new DataSource($dataSource), 33) : new Paginator(new DataSource('defaultData'), 33);
// var_dump(get_declared_classes());

// $initiator = new Initiator();
// var_dump($initiator);

// $x = '<script type="text/javascript" src="js/custom.js"> test(); </script>';
// echo $x;
// var_dump($_COOKIE['response_size'] );    // $paginator->getDataSource()->getSource()
// var_dump($paginator, json_decode($_COOKIE['items'], true), $_COOKIE['response_size'] );    // $paginator->getDataSource()->getSource()
// var_dump($_COOKIE);    // $paginator->getDataSource()->getSource()


// $x = new DataSource(ucfirst($dataSource));
// echo $x->getSource()->getData();

 ?> 
    <!-- Header -->
    <?php include ($base->getTemplatesPath('header')); ?>
    
    <!-- Content -->
    <?php include ($base->getTemplatesPath('content')); ?>    

    <!-- Footer -->
   <?php include( $base->getTemplatesPath('footer') );