
<?php 
// session_start();
    echo '<div class="container text-center">';

    // Form
    echo '
            <form action="index.php" method="GET">
                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg" name="dataSource" id="dataSource">
                    <option value="0" selected>Choose Data Source</option>
                    <option value="api">API</option>
                    <option value="database">Database</option>
                    <option value="50items">50 Items</option>
                </select>
                <input type="submit" class="btn btn-outline-primary" value="Load Selected Data">
            </form>
        ';

        ?>
        <script>
            // var data = {};
            // console.log(apiData);
            $("#dataSource").on('change', function () {
                // get/set/redirect to index based on the dataSource params from the <select>
                var currentUrl = new URL(window.location.href);
                var params = new URLSearchParams(currentUrl.search);
                var selectedDatasource = $('#dataSource').find(":selected").val();

                params.set('dataSource', selectedDatasource);
                currentUrl.search = params;
                window.location.href = currentUrl;
                                
                // Make a proper data loading based on the GET param api/database/default50items
                // console.log(apiData);
                // apiCall();
                // return;
                
                // $('.row .col .card-body .card-text').each(function(index){
                //     console.log($(this).text());
                // });
                
                // Set data into session? cookie ?
                // document.cookie = 'items='+JSON.stringify(apiData);
                <?php // $_SESSION['items'] = '';?>
                // console.log(apiData);
            });
        </script>
        <?php

        
       // echo '<script type="text/javascript">test(); </script>';



        // If cases for checking the post param
        // if($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['dataSource'])){
        //     echo '<script type="text/javascript"> apiCall() </script>';
        //     var_dump(json_decode($_COOKIE['items'], true));
        //     die;
        // }
        // var_dump($_POST);
        // var_dump($_POST, json_decode($_COOKIE['items']));

        // $apiData = json_decode();
        // Get from session
        // if(){

        // }

    $itemCounter = $paginator->getCurrentPageImageOffset();
    for ($i = 0; $i < $paginator->getTotalRows(); $i++) {                
        echo '<div class="row">'; // start row                
        for($k = 0; $k < 4; $k++){ // items per row
            if ($paginator->getCurrentPageImageOffset() <= $paginator->getTotalImages()) {
                echo '<div class="col">
                    <div class="card">
                        <img src="'.$base->getAssetsPath().'/pesto.jpg" class="card-img-top" alt="...">
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
            <a class="page-link '. $paginator->getLastPageClass() .'" href="'. $paginator->getNextPage(true) .'">Last Page</a>
        </li>';

        echo'</ul>
        </nav>
    </div>';
?>

