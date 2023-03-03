<?php
require_once(__DIR__.'/config/ajax_common.php');
// var_dump($base->getTemplatesPath('header'));
 ?>
  
    <!-- Header -->
    <?php include ($base->getTemplatesPath('header')); ?>
    
    <!-- Content -->
    <?php include ($base->getTemplatesPath('content')); ?>    

    <!-- Footer -->
   <?php include( $base->getTemplatesPath('footer') );