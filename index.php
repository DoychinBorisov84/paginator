<?php
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
 
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items Pagination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        /* img{
            width: 30px;
            height: 60px;
        } */
    </style>
  </head>
  <body>
    
    <div class="container text-center">        
            <?php            
            for ($i = 0; $i < $total_rows; $i++) {                
                echo '<div class="row">'; // start row                
                for($k = 0; $k < 4; $k++){ // items 
                    if ($counter_images_current_page <= $total_images) {
                        echo '<div class="col">
                            <div class="card">
                                <img src="bottle.jpg" class="card-img-top" alt="...">
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
            ?>           
    </div>

    <div class="container-lg p-4">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-lg justify-content-center">
                <!-- Previous Page -->
                <li class="page-item">
                    <a class="page-link <?php echo $current_page <= 1 ? 'disabled' : ''; ?>" href="index.php?page=<?php previousPage($current_page, $total_pages); ?>">Previous</a>
                </li>
                <!-- Iterrator pages -->
                <li class="page-item" data-activepage="1"><a class="page-link" href="index.php?page=1">1</a></li>
                <li class="page-item" data-activepage="2"><a class="page-link" href="index.php?page=2">2</a></li>
                <?php
                if($current_page >= 3){ ?>
                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                    <li class="page-item" data-activepage="<?php echo $current_page; ?>"><a class="page-link" href="index.php?page=<?php echo $current_page; ?>"><?php echo $current_page; ?></a></li>
                <?php }
                ?>
                <!-- Next Page -->
                <li class="page-item" data-activepage="1">                    
                    <a class="page-link <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>"  
                    href="index.php?page=<?php nextPage($current_page, $total_pages);?>">Next</a>
                </li>                
                <!-- Last Page -->
                <li class="page-item">
                    <a class="page-link <?php echo $current_page >= $total_pages ? 'link-danger' : ''; ?>" href="index.php?page=<?php echo $total_pages; ?>">Last Page</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    <!-- pagination active page class -->
    <script type="text/javascript">
            var current_page = <?php echo $_GET['page']; ?>;
            var li_element = document.querySelector('[data-activepage="'+current_page+'"]');
            li_element.classList.add('active');
            console.log(current_page, li_element);
    </script>

  </body>
</html>