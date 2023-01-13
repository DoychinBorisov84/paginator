<?php
require_once('classes/Base.php');
// Base::autoload();
$base = new Base();
// include_once('classes/Paginator.php');
// $base = new Base();
// $paginator = new Paginator();
// var_dump(get_included_files());
// echo $paginator->paginate();
echo $base->getTemplatesPath('content');

    $total_images = 50; // total item incoming API, Database, CONST int ...

    $images_per_page = 12; // ?User Input -- our needs for the grid
    // $images_per_row = 4; // ?? CONST for easy and more gridable rows our needs for the grid

    $total_pages = ceil($total_images/$images_per_page);
    // $total_rows = ceil($images_per_page / $images_per_row);
    $total_rows = ceil($images_per_page / 4); // total rows is default=hardcoded 
    
    $current_page = $_GET['page'] >= $total_pages ? $total_pages : ($_GET['page'] < 0 ? 1 : $_GET['page']); // first|last|$_GET[page] -> page
    $previous_page = $current_page - 1;
    $next_page = $current_page <= 0 ? 2 : $current_page + 1;

    $counter_images_current_page = get_current_page_image_offset($current_page, $images_per_page);
    
    // Get the current page offset of items
    function get_current_page_image_offset($current_page, $images_per_page) {
        $offset = (($current_page * $images_per_page) - $images_per_page) + 1; // +1 to begin counting from the 1st item       

        if($current_page <= 0){
            // $offset = ((1 * $images_per_page) - $images_per_page) + 1; // +1 to begin counting from the 1st item
            $offset = 1;
        }

        return $offset;
    };

function nextPage($current_page, $total_pages){
    if($current_page == $total_pages){
        echo '#';        
    }else {
        // var_dump($current_page + 1);
        echo $current_page + 1;
    }
}

function previousPage($current_page, $total_pages){
    if($current_page == 1){
        echo '#';
    }else if($current_page >= $total_pages){
        echo $total_pages - 1;
    }
}

    // var_dump(nextPage($current_page, $total_pages), $current_page, $total_pages);
    // var_dump($total_pages, $total_rows, $current_page, $counter_images_current_page);

 ?> 
    <!-- Header -->
    <?php include ($base->getTemplatesPath('header')); ?>
    
    <!-- Content -->
    <?php include ($base->getTemplatesPath('content')); ?>
    

    <!-- Footer -->
   <?php include( $base->getTemplatesPath('footer') );