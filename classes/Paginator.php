<?php
/**
 * Paginator class 
 * 
 */
class Paginator
{
    private $total_images = 50; // total item incoming API, Database, CONST int ...

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
        return $total_pages = ceil($this->getTotalImages() / $this->images_per_page);
    }

    /**
     * Get total images count
     * 
     */
    public function getTotalImages()
    {
        return $this->total_images;
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
     * @return string|int
     */
    public function getCurrentPage() 
    {
        // Assign current page value based on GET
        $this->current_page = isset($this->sanitizeGetParams()['page']) ? $this->sanitizeGetParams()['page'] : null;

        if (is_null($this->current_page)){
            $this->current_page = 1; // default value if ['page'] param not set up
        }elseif (!is_numeric($this->current_page)) {
            header('Location: index.php'); // only numeric params
        }
        else{
            if($this->current_page >= $this->getTotalPages()){
                $this->current_page = $this->getTotalPages(); // max page value
            }elseif ($this->current_page <= 0) {
                $this->current_page =  1; // min page value
            }
        }

        return $this->current_page;
    }

    /**
     * * Get http-query string for the pagination
     * 
     * @param mixed $page
     * 
     * @return mixed
     */
    public function getPageURL($page = FALSE)
    {
        $query = $_GET; //http-query
        $current_page = $query['page'];

        if($page){
            $query['page'] = $page;
        }

        $url = http_build_query($query);

        return $_SERVER['PHP_SELF'].'?'.$url;
    }

     /**
     * Sanitize GET input
     * TODO: accept [] of parameters to sanitize
     * @return array
     */
    public function sanitizeGetParams()
    {
        // List of allowed GET parameters to check against     
        $availableGetParams = array('page', 'dataSource');
        $availableGetParamsKeys = array_flip($availableGetParams);

        $parameterSecured = [];

        if(!empty($_GET)){ 
            foreach ($_GET as $parameter => $value) {
                if(!array_key_exists($parameter, $availableGetParamsKeys)){
                    header('Location: index.php'); 
                    die;
                }
                # TODO: create Validation class to handle the process, with error msg to display ...
                // Sanitize            
                $parameterSanitized[$parameter] = trim(htmlspecialchars($_GET[$parameter]));
                
                // Validate
                $parameterValidated[$parameter] = $this->validateGetParams($parameterSanitized);
                // var_dump($parameterValidated);

                if($parameterValidated[$parameter] === FALSE){
                    header('Location: index.php');
                    die;
                }
                
                $parameterSecured[$parameter] = $parameterValidated[$parameter];
            }
        }
        
        return $parameterSecured;
    }

    /**
     * Validate GET input
     * 
     * @param array $parameter
     * 
     * @return string
     */
    public function validateGetParams($parameter)
    {
        $validatedParameters = [];

        // Validate GET params 
        foreach ($parameter as $key => $value) {
            if($key == 'page'){
                $validatedParameters = filter_var($value, FILTER_VALIDATE_FLOAT);
            }elseif ($key == 'dataSource'){
                // var_dump($key, $value); die;
                $options = ['api', 'database', '50items'];

                $validatedParameters = $value;
                if(!in_array($value, $options)){
                    $validatedParameters = FALSE;
                }
                // var_dump($validatedParameters); die;
            }
            # TODO: add updated list of GET param checks
        }
        return $validatedParameters;
    }

    /**
     * Get current images offset, based on the get page parameter
     * 
     * @return float|int
     */
    public function getCurrentPageImageOffset() {
        $offset = (($this->getCurrentPage() * $this->images_per_page) - $this->images_per_page) + 1; // +1 -> counting from the 1st item       

        if($this->getCurrentPage() <= 0){
            $offset = 1; // first item to begin
        }

        return $offset;
    }

    /**
     * Get previous page
     * 
     * @return string
     */
    public function getPreviousPage()
    {
        $query = $_GET; // current http-query
        $query['page'] = $_GET['page']; // current http-query {page} param


        if($this->getCurrentPage() == 1){
            return '#';
        }else if($this->getCurrentPage() >= $this->getTotalPages()){
            $query['page'] =  $this->getTotalPages() - 1 ;
            $newQuery = http_build_query($query);
            $previous_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
            return $previous_page;

            // return $this->getTotalPages() - 1;
        }
        $query['page'] =  $this->getCurrentPage() - 1 ;
        $newQuery = http_build_query($query);
        return $previous_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;

        // return $previous_page = $this->getCurrentPage() - 1;
    }

    /**
     * Get next page
     * @return string
     */
    public function getNextPage($last_page = false)
    {        
        // $uri = "index.php?page=";
        $query = $_GET; // current http-query
        // $query['page'] = $_GET['page']; // current http-query {page} param

        if($this->getCurrentPage() == $this->getTotalPages()){
            return '#';        
        }elseif ($last_page == true){
            $query['page'] = $this->getTotalPages();
            $newQuery = http_build_query($query);
            return $next_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
            // return $next_page = "{$uri}{$this->getTotalPages()}";
        }
        else {
                // var_dump ($_SERVER['REQUEST_URI'], $_GET, $_SERVER['PHP_SELF']);
            // $query = $_GET;
            $query['page'] = $_GET['page'] + 1;
            $newQuery = http_build_query($query);
            $next_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
            return $next_page;
            // var_dump($query, $newQuery, $next_page);
                // die;

            // $next_page = $this->getCurrentPage() + 1;
            // return "{$uri}{$next_page}";
        }  
    }

}
