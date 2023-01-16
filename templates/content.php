<?php
$paginator = new Paginator();
echo $paginator->currentPage();
// die;

//     $total_images = 50; // total item incoming API, Database, CONST int ...

//     $images_per_page = 12; // ?User Input -- our needs for the grid
//     // $images_per_row = 4; // ?? CONST for easy and more gridable rows our needs for the grid

//     $total_pages = ceil($total_images/$images_per_page);
//     // $total_rows = ceil($images_per_page / $images_per_row);
//     $total_rows = ceil($images_per_page / 4); // total rows is default=hardcoded 
    
//     $current_page = $_GET['page'] >= $total_pages ? $total_pages : ($_GET['page'] < 0 ? 1 : $_GET['page']); // first|last|$_GET[page] -> page
//     $previous_page = $current_page - 1;
//     $next_page = $current_page <= 0 ? 2 : $current_page + 1;

//     $counter_images_current_page = get_current_page_image_offset($current_page, $images_per_page);
    
//     // Get the current page offset of items
//     function get_current_page_image_offset($current_page, $images_per_page) {
//         $offset = (($current_page * $images_per_page) - $images_per_page) + 1; // +1 to begin counting from the 1st item       

//         if($current_page <= 0){
//             // $offset = ((1 * $images_per_page) - $images_per_page) + 1; // +1 to begin counting from the 1st item
//             $offset = 1;
//         }

//         return $offset;
//     };

// function nextPage($current_page, $total_pages, $last_page = false){
//     $uri = "index.php?page=";
//     if($current_page == $total_pages){
//         return '#';        
//     }elseif ($last_page == true){
//         return $next_page = "{$uri}{$total_pages}";
//     }
//     else {
//         $next_page = $current_page + 1;
//         return "{$uri}{$next_page}";
//     }
// }

// function previousPage($current_page, $total_pages){
//     if($current_page == 1){
//         return '#';
//     }else if($current_page >= $total_pages){
//         return $total_pages - 1;
//     }
// }

// // TODO: to be replaced by Pagination class methods
// // Get previous page class
// $previous_page_class = function() use ($current_page) {
//     return $current_page <= 1 ? 'disabled' : '';
// };

// // Get next page class
// $next_page_class = function () use ($current_page, $total_pages) {
//     return $current_page >= $total_pages ? "disabled" : "";    
// };

// // Get last page class
// $last_page_class = function () use ($current_page, $total_pages) {
//     return $current_page >= $total_pages ? "link-danger" : "";
// };

// var_dump($previous_page_class($current_page), $current_page, $total_pages);
// echo $counter_images_current_page;
    echo '<div class="container text-center">';
    
    for ($i = 0; $i < $paginator->getTotalRows(); $i++) {                
        echo '<div class="row">'; // start row                
        for($k = 0; $k < 4; $k++){ // items 
            if ($paginator->getCurrentPageImageOffset() <= $paginator::$total_images) {
                echo '<div class="col">
                    <div class="card">
                        <img src="'.$base->getAssetsPath().'/bottle.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title -- '.$paginator->getCurrentPageImageOffset().'</h5>
                            <p class="card-text">Card content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>';
                $paginator->getCurrentPageImageOffset() + 1;
            }else{
                echo '<div class="col"></div>'; // empty img col
            }
        }
        echo '</div>'; // end row
    }
    echo '</div>';

    //<!-- Pagination -->
    echo '<div class="container-lg p-4">';
    echo '<nav aria-label="Page navigation">
         <ul class="pagination pagination-lg justify-content-center">';
    // <!-- Previous Page -->
        echo'<li class="page-item">
            <a class="page-link '.$paginator->getPreviousPageClass() .'" href="index.php?page='. $paginator->getPreviousPage().'">Previous</a>
        </li>';
    // <!-- Iterrator pages -->
        echo'<li class="page-item" data-activepage="1"><a class="page-link" href="index.php?page=1">1</a></li>
            <li class="page-item" data-activepage="2"><a class="page-link" href="index.php?page=2">2</a></li>';
        
        if($paginator->getCurrentPage() >= 3){
            echo'<li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item" data-activepage="'. $paginator->getCurrentPage() .'"><a class="page-link" href="index.php?page='. $paginator->getCurrentPage() .'">'.$paginator->getCurrentPage().'</a></li>';
            }
        
    // <!-- Next Page -->
        echo '<li class="page-item">                    
            <a class="page-link '. $paginator->getNextPageClass() .'"  
            href="'. $paginator->getNextPage() .'">Next</a>
        </li>';

    // <!-- Last Page -->
        echo '<li class="page-item">
            <a class="page-link '. $paginator->getLastPageClass() .'" href="'. $paginator->getNextPage(true) .'">Last Page</a>
        </li>';

        echo'</ul>
        </nav>
    </div>';
?>

