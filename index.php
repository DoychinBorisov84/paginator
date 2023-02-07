<?php
require_once('classes/Base.php');
// Base::autoload();
$base = new Base();

 // Paginator instance for the content
$dataSource = $_GET['dataSource'];
$paginator = new Paginator($dataSource);
var_dump($paginator->getDataSource());

 
// include_once('classes/Paginator.php');
// $base = new Base();
// $paginator = new Paginator();
// var_dump(get_included_files());
// echo $paginator->paginate();
// echo $base->getTemplatesPath('content');

    

    // var_dump(nextPage($current_page, $total_pages), $current_page, $total_pages);
    // var_dump($total_pages, $total_rows, $current_page, $counter_images_current_page);

 ?> 
    <!-- Header -->
    <?php include ($base->getTemplatesPath('header')); ?>
    
    <!-- Content -->
    <?php include ($base->getTemplatesPath('content')); ?>    

    <!-- Footer -->
   <?php include( $base->getTemplatesPath('footer') );