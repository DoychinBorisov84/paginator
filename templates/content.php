<?php
    // Paginator instance for the content
    $paginator = new Paginator();

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

