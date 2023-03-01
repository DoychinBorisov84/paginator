<?php
echo '<div class="container text-center">';

    echo '<a type="button" class="btn btn-secondary btn-lg" href="'.$base->getHome().'">Home</a>';

    // Form with the available data options
    echo '
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg" name="dataSource" id="dataSource">
                <option value="" selected>Choose Data Source</option>
                <option value="restapi">Rest API</option>
                <option value="database">Database</option>
                <option value="defaultData">Default (50 Items)</option>
            </select>
        ';

        echo '<div class="row">'; // start row                
            echo '<div class="col">
                <div class="card">
                    <img src="'.$base->getAssetsPath().'/chart.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Title: <strong>Default title</strong></h5>
                        <p class="card-text">Content ...</p>
                        <a href="#" class="btn btn-primary">Read more</a>
                    </div>
                </div>
            </div>';
        echo '</div>'; // end row
    
    echo '</div>'; // end container

    //<!-- Pagination -->
    echo '<div class="container-lg p-4">';
    echo '<nav aria-label="Page navigation">
         <ul class="pagination pagination-lg justify-content-center">';
         
    // <!-- Previous Page -->
        echo'<li class="page-item">
            <a class="page-link " href="" id="previous-page">Previous</a>
        </li>';

    // <!-- Iterrator pages -->
        echo'<li class="page-item" data-activepage="1"><a class="page-link" href="">1</a></li>
            <li class="page-item" data-activepage="2"><a class="page-link" href="">2</a></li>';
    
        echo'<li class="page-item iterator-block"><a class="page-link" href="#">...</a></li>
                <li class="page-item iterator-block" data-activepage=""><a class="page-link" href="" id="current-page"></a></li>';
        
    // <!-- Next Page -->
        echo '<li class="page-item">                    
            <a class="page-link " href="" id="next-page">Next</a>
        </li>';

    // <!-- Last Page -->
        echo '<li class="page-item">
            <a class="page-link " href="" id="last-page">Last Page</a>
        </li>';

        echo'</ul>
        </nav>
    </div>';
?>

