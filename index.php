<?php
require_once('classes/Base.php');

$base = new Base();

$dataSource = $_GET['dataSource'];
// $paginator = new Paginator();

// Integrate via DI into Paginator ?
// Paginator instance for the content
// Can we achieve ajax returned Obj generated on <select> change to be available initially, so we can instantiate here?
$paginator = $dataSource != 'defaultData' ? new Paginator(new DataSource($dataSource)) : new Paginator(new DataSource('defaultData'));

 ?> 
    <!-- Header -->
    <?php include ($base->getTemplatesPath('header')); ?>
    
    <!-- Content -->
    <?php include ($base->getTemplatesPath('content')); ?>    

    <!-- Footer -->
   <?php include( $base->getTemplatesPath('footer') );