<?php
/**
 * Paginator class 
 * 
 */
class Paginator
{
    private $total_images = 50; // total item incoming API, Database, CONST int ...

    private $images_per_page = 12; // ?User Input -- our needs for the grid
    // $images_per_row = 4; // ?? CONST for easy and more gridable rows our needs for the grid

    // $total_pages = ceil($total_images/$images_per_page);

    // $total_rows = ceil($images_per_page / $images_per_row);
    // $total_rows = ceil($images_per_page / 4); // total rows is default=hardcoded 
    
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

    public function getTotalPages()
    {
        return $total_pages = ceil($this->total_images / $this->images_per_page);
    }
    /////////////////////////////
    // public function paginate()
    // {
    //     echo 'test paginate';
    // }
}
