<?php
require_once('classes/Base.php');

$base = new Base();

// TODO: SPL Autoloader approach

// $dataSource = $_GET['dataSource'];
// $paginator = new Paginator(new DataSource($dataSource));


// $paginator = new Paginator();
// Integrate via DI into Paginator ?
// Paginator instance for the content
// Can we achieve ajax returned Obj generated on <select> change to be available initially, so we can instantiate here?
// var_dump($paginator);
 ?> 
 
    <!-- Header -->
    <?php include ($base->getTemplatesPath('header')); ?>
    
    <!-- Content -->
    <?php include ($base->getTemplatesPath('content')); ?>    

    <!-- Footer -->
   <?php include( $base->getTemplatesPath('footer') );