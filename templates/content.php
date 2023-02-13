<?php 
// session_start();
// $pahgoooo = '<script> databaseCall() </script>';
// echo $pahgoooo;
?>
<?php

    echo '<div class="container text-center">';

    // Form with the available data options
    echo '
            <form action="index.php" method="GET">
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg" name="dataSource" id="dataSource">
                    <option value="0" selected>Choose Data Source</option>
                    <option value="restapi">Rest API</option>
                    <option value="database">Database</option>
                    <option value="defaultData">Default (50 Items)</option>
                </select>
                <input type="submit" class="btn btn-outline-primary" value="Load Selected Data">
            </form>
        ';

    $itemCounter = $paginator->getCurrentPageImageOffset();
    for ($i = 0; $i < $paginator->getTotalRows(); $i++) {                
        echo '<div class="row">'; // start row                
        for($k = 0; $k < 4; $k++){ // items per row
            if ($paginator->getCurrentPageImageOffset() <= $paginator->getTotalImages()) {
                echo '<div class="col">
                    <div class="card">
                        <img src="'.$base->getAssetsPath().'/no-image.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Title: <strong>'.$itemCounter.'</strong></h5>
                            <p class="card-text">Content ...</p>
                            <a href="#" class="btn btn-primary">Read more</a>
                        </div>
                    </div>
                </div>';
                $itemCounter ++;
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
            <a class="page-link '.$paginator->getPreviousPageClass() .'" href="'. $paginator->getPreviousPage().'">Previous</a>
        </li>';
    // <!-- Iterrator pages -->
        echo'<li class="page-item" data-activepage="1"><a class="page-link" href="'.$paginator->getPageURL(1).'">1</a></li>
            <li class="page-item" data-activepage="2"><a class="page-link" href="'.$paginator->getPageURL(2).'">2</a></li>';
        
        if($paginator->getCurrentPage() >= 3){
            echo'<li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item" data-activepage="'. $paginator->getCurrentPage() .'"><a class="page-link" href="'.$paginator->getPageURL($paginator->getCurrentPage()) .'">'.$paginator->getCurrentPage().'</a></li>';
        }
        
    // <!-- Next Page -->
        echo '<li class="page-item">                    
            <a class="page-link '. $paginator->getNextPageClass() .'"  
            href="'. $paginator->getNextPage() .'">Next</a>
        </li>';

    // <!-- Last Page -->
        echo '<li class="page-item">
            <a class="page-link '. $paginator->getLastPageClass() .'" href="'. $paginator->getNextPage(true) .'" id="last-page">Last Page</a>
        </li>';

        echo'</ul>
        </nav>
    </div>';
?>

    <!-- <script>
        databaseCall();
    </script> -->

