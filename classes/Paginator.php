<?php
/**
 * Paginator class 
 * 
 */
class Paginator
{
    public static $total_images = 50; // total item incoming API, Database, CONST int ...

    private $images_per_page = 12; // ?User Input -- our needs for the grid

    private $images_per_row = 4; // ?? CONST for easy and more gridable rows our needs for the grid

    private $current_page;

    public function __construct()
    {
        $this->current_page = $this->getCurrentPage();
    }

    /**
     * Get previous page class
     */    
    public function getPreviousPageClass()
    {
        return $this->getCurrentPage() <= 1 ? 'disabled' : '';
    }

    /**
     * Get next page class
     */    
    public function getNextPageClass()
    {
        return $this->getCurrentPage() >= $this->getTotalPages() ? "disabled" : "";
    }

    /**
     *  Get last page class
     */    
    public function getLastPageClass()
    {
        return $this->getCurrentPage() >= $this->getTotalPages() ? "link-danger" : "";
    }

    /**
     * Get total pages based on the items loaded  
     *      
     */
    public function getTotalPages()
    {
        return $total_pages = ceil(self::$total_images / $this->images_per_page);
    }

    /**
     * 
     * Get total rows per page
     */
    public function getTotalRows()
    {
        return $total_rows = ceil($this->images_per_page / $this->images_per_row);        
    }

    /**
     * Get current | min/max page
     * 
     */
    public function getCurrentPage() 
    {
        // TODO: check for empty ['page'] param
        // $currentPage = (int) $this->sanitizeGetParams($_GET['page']) ?? 1;
        // var_dump($this->current_page);
        if(is_null($this->current_page)){
            $this->current_page = (int) $this->sanitizeGetParams();
            var_dump($this->current_page);
            // die;    
            if($this->current_page >= $this->getTotalPages()){
                $this->current_page = (int) $this->getTotalPages();
            }elseif ($this->current_page <= 0) {
                $this->current_page =  1;
            }
            // else{
            //     return $this->current_page;
            // }
        }

        return $this->current_page;
        // return $currentPage >= $total_pages ? $total_pages : ($_GET['page'] < 0 ? 1 : $_GET['page']); // first|last|$_GET[page] -> page        
    }

    /**
     * TODO: refactor
     */
    public function currentPage()
    {
        return $this->current_page;
    }

    /**
     * Get current images offset, based on the get page parameter
     * @return float|int
     */
    public function getCurrentPageImageOffset() {
        $offset = (($this->getCurrentPage() * $this->images_per_page) - $this->images_per_page) + 1; // +1 to begin counting from the 1st item       

        if($this->getCurrentPage() <= 0){
            // $offset = ((1 * $images_per_page) - $images_per_page) + 1; // +1 to begin counting from the 1st item
            $offset = 1;
        }

        return $offset;
    }

    /**
     * Get previous page
     */
    public function getPreviousPage()
    {
        if($this->getCurrentPage() == 1){
            return '#';
        }else if($this->getCurrentPage() >= $this->getTotalPages()){
            return $this->getTotalPages() - 1;
        }
        return $previous_page = $this->getCurrentPage() - 1;
    }

    /**
     * Get next page
     */
    public function getNextPage($last_page = false)
    {
        $uri = "index.php?page=";
        if($this->getCurrentPage() == $this->getTotalPages()){
            return '#';        
        }elseif ($last_page == true){
            return $next_page = "{$uri}{$this->getTotalPages()}";
        }
        else {
            $next_page = $this->getCurrentPage() + 1;
            return "{$uri}{$next_page}";
        }
        // return $next_page = $this->getCurrentPage() <= 0 ? 2 : $this->getCurrentPage() + 1;        
    }

    /**
     * Sanitize input
     * @param mixed $input
     * @return mixed
     */
    public function sanitizeGetParams()
    {
        // var_dump($input);        
        $availableGetOptions = array('page');
        $sanitizedParams = [];

        if(!empty($_GET)){            
            // var_dump($_GET);
            foreach ($availableGetOptions as $option) {
                if(!array_key_exists($option, $_GET)){
                    header('Location: index.php'); // return ('Get param not existing!'); // TODO: header with html-msg ? 
                    die;
                }
                $sanitizedParams[$option] = htmlspecialchars($_GET[$option], ENT_QUOTES);
            }
        }
        // sanitize
        return $sanitizedParams;
    }

    /////////////////////////////
    public function paginate()
    {
        echo 'test paginate';
    }
}
