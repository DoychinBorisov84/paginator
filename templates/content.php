<?php
// echo $counter_images_current_page;
    echo '<div class="container text-center">';
    
    for ($i = 0; $i < $total_rows; $i++) {                
        echo '<div class="row">'; // start row                
        for($k = 0; $k < 4; $k++){ // items 
            if ($counter_images_current_page <= $total_images) {
                echo '<div class="col">
                    <div class="card">
                        <img src="'.$base->getAssetsPath().'/bottle.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title -- '.$counter_images_current_page.'</h5>
                            <p class="card-text">Card content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>';
                $counter_images_current_page++;
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
            <a class="page-link '.$current_page <= 1 ? "disabled" : "" .' href="index.php?page=' .previousPage($current_page, $total_pages).'">Previous</a>
        </li>';
    // <!-- Iterrator pages -->
        echo'<li class="page-item" data-activepage="1"><a class="page-link" href="index.php?page=1">1</a></li>
            <li class="page-item" data-activepage="2"><a class="page-link" href="index.php?page=2">2</a></li>';
        
        if($current_page >= 3){
            echo'<li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item" data-activepage="'. $current_page .'"><a class="page-link" href="index.php?page='. $current_page .'">'.$current_page.'</a></li>';
         }
        
    // <!-- Next Page -->
    echo '<li class="page-item" data-activepage="1">                    
        <a class="page-link'. $current_page >= $total_pages ? "disabled" : "" .'"  
        href="index.php?page='. nextPage($current_page, $total_pages) .'">Next</a>
    </li>';

    // <!-- Last Page -->
    echo '<li class="page-item">
        <a class="page-link'. $current_page >= $total_pages ? "link-danger" : "" .'" href="index.php?page='. $total_pages .'">Last Page</a>
    </li>';

    echo'</ul>
        </nav>
    </div>';
?>

