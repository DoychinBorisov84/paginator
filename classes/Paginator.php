<?php
// require('DataSource.php');
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

    private $dataSource;

    private $dataSourceData;

    public function __construct(DataSource $dataSource, $data)
    {
        // Todo method for sanitizing(pass only predefined from sanitizeGetParams()) the class ...
        // $this->dataSource = $this->sanitizeGetParams(); 

        $this->dataSource = $dataSource;        
        $this->setDataSource($dataSource);
        // var_dump($this->dataSource, $data);
        $this->setDataSourceData($data);

        // $this->current_page = $this->getCurrentPage();
        $this->getCurrentPage();
    }

    /**
     * Set dataSource
     */
    public function setDataSource($dataSource, $data = NULL)
    {
        // TODO: Sanitize...
        $this->dataSource = $dataSource;

        //TODO:  refactor If we got Database, REST Api or Default ... set the Paginator props below; bring out into method
        // var_dump(sizeof($this->dataSource->getSource()->getAllData()));
        // var_dump($this->dataSource);
        // var_dump($this->$dataSource->getDataSource()); die;
        // if($data){
        //     $this->$dataSource->getDataSource()->setData($data);
        // }

        // // Works for DB! How to impelement properly for many sources? The restapi is not being setted up to that point
        // if( get_class($this->dataSource) == "Database"){
        //     $this->setTotalImages(sizeof($this->dataSource->getSource()->getAllData()));
        // }
        // else{
        //     $this->
        // }
        return $this->dataSource;
    }

    public function setDataSourceData($data)
    {
        $this->dataSource->getSource()->setData($data);
        $this->dataSourceData = $data;

        // Set Paginator(DataSource $dataSource) props
            // var_dump($this->dataSourceData);
            // $this->setTotalImages(sizeof($data));
            // $this->setDataSourceDataSize(sizeof($data));
            // $this->current_page = $this->getCurrentPage();

        //
        
        return $this->dataSourceData;
    }

    public function getDataSourceData()
    {
        return $this->dataSource->getSource()->getData();
    }
    public function setDataSourceDataSize($dataSize)
    {
        $this->setTotalImages($dataSize);
        // var_dump($this->getTotalImages());
        $this->dataSource->getSource()->setDataTotalSize($dataSize);
    }
    public function getDataSourceDataSize()
    {
        return $this->dataSource->getSource()->getDataTotalSize();
    }

    /**
     * Get dataSource
     */
    public function getDataSource()
    {
        // return $this->dataSource;
        return $this->dataSource->getSource()->getData();

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
     * Set total images count, based on data-source
     * 
     */
    public function setTotalImages($total_images)
    {
        $this->total_images = $total_images;
    }

    /**
     * Get total images count
     * 
     * @return int
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
    public function getCurrentPage($page = NULL) 
    {
        // Assign current page value based on GET
        // If we make ajax call the init is the class Initiator => $_GET['page] is not setted up => manual setup here
        $this->current_page = $page;
        if(!$page){
            $this->current_page = isset($this->sanitizeGetParams()['page']) ? $this->sanitizeGetParams()['page'] : null;
        }

        // var_dump($this->current_page, $this->getTotalPages(), $this->getTotalImages(), $this->images_per_page);
        // var_dump($this->sanitizeGetParams()['page'], $_SERVER['REQUEST_URI']);
        if (is_null($this->current_page)){
            $this->current_page = 1; // default value if ['page'] param not set up
        }elseif (!is_numeric($this->current_page)) {
            header('Location: index.php'); // only numeric params
        }
        else{
            if($this->current_page >= $this->getTotalPages()){
            // if($this->current_page >= $this->getDataSourceDataSize()){
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
    public function getPageURL($page = FALSE, $ajax_call = NULL)
    {
        if(!$ajax_call){
            $query = $_GET; //http-query
            // $current_page = $query['page'];
            $current_page = isset($_GET['page']) ? $_GET['page'] : $this->current_page; // current http-query {page} param
    
            if($page){
                $query['page'] = $page;
            }
    
            $url = http_build_query($query);
            // var_dump($url);
            // die;
            return $_SERVER['PHP_SELF'].'?'.$url;
        }else{
            $href = parse_url($ajax_call);
            $ajax_query = $href['query'];
            $ajax_path = $href['path'];
            
            parse_str($ajax_query, $newQuery);
            if($page){
                $newQuery['page'] = $page;
            }

            $newPageQuery = http_build_query($newQuery);

            return $url = $ajax_path . '?' . $newPageQuery;
            // var_dump($newQuery);
            
            // if($page){

            // }
        }
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
                // var_dump($parameterSecured);
                // die;
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
            if ($key == 'page'){
                $validatedParameters = filter_var($value, FILTER_VALIDATE_FLOAT);
            }elseif ($key == 'dataSource'){
                // var_dump($key, $value); die;
                $options = ['restapi', 'database', 'default', 0];

                $validatedParameters = $value; // == 0 ? '50items' : $value;
                if(!in_array($value, $options)){
                    $validatedParameters = FALSE;
                }
                // var_dump(in_array($value, $options));
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
    public function getCurrentPageImageOffset($current_page = NULL) {
        $offset = ( ($current_page * $this->images_per_page) - $this->images_per_page + 1);
        if($current_page <= 0){
            $offset = 1; // first item to begin
        }
        if(!$current_page){
            $offset = (($this->getCurrentPage() * $this->images_per_page) - $this->images_per_page) + 1; // +1 -> counting from the 1st item       
    
            if($this->getCurrentPage() <= 0){
                $offset = 1; // first item to begin
            }
        }

        return $offset;
    }

    /**
     * Get previous page
     * 
     * @return string
     */
    public function getPreviousPage($current_page_ajax = NULL, $total_page_ajax = NULL)
    {
        if(!$current_page_ajax && !$total_page_ajax){
            $query = $_GET; // current http-query
            $query['page'] = isset($_GET['page']) ? $_GET['page'] : $this->current_page; // current http-query {page} param
    
    
            if($this->getCurrentPage() == 1){
                return '#';
            }elseif($this->getCurrentPage() >= $this->getTotalPages()){
                // die('sa');
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
        }else{
            if($current_page_ajax == 1){
                return '#';
            }elseif($current_page_ajax >= $total_page_ajax){
                $previous_page = $current_page_ajax - 1;
                $implement_uri_not_relying_which_script_is_calling_it = '/paginator/index.php?dataSource=restapi&page=' . $previous_page;
                return $implement_uri_not_relying_which_script_is_calling_it;
            }else{
                $previous_page = $current_page_ajax - 1;
                $implement_uri_not_relying_which_script_is_calling_it = '/paginator/index.php?dataSource=restapi&page=' . $previous_page;
                return $implement_uri_not_relying_which_script_is_calling_it;
            }
        }
    }

    /**
     * Get next page
     * @return string
     */
    public function getNextPage($last_page = FALSE, $current_page_ajax = NULL, $total_pages_ajax = NULL)
    {    
        if(!$current_page_ajax && !$total_pages_ajax){
            // $uri = "index.php?page=";
            $query = $_GET; // current http-query
            // $query['page'] = $_GET['page']; // current http-query {page} param
            $current_page = isset($_GET['page']) ? $_GET['page'] : $this->current_page; // current http-query {page} param
    
    
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
                // $query['page'] = $_GET['page'] + 1;
                $query['page'] = $current_page + 1;
                $newQuery = http_build_query($query);
                $next_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
                return $next_page;
                // var_dump($query, $newQuery, $next_page);
                    // die;
    
                // $next_page = $this->getCurrentPage() + 1;
                // return "{$uri}{$next_page}";
            }
        }else{
            // TODO: reimplement the above
            if($current_page_ajax == $total_pages_ajax){
                return '#';  
            }elseif($last_page == TRUE){
                $implement_uri_not_relying_which_script_is_calling_it = '/paginator/index.php?dataSource=restapi&page=' . $total_pages_ajax;
                return $implement_uri_not_relying_which_script_is_calling_it;
            }
            else{
                $next_page = $current_page_ajax + 1;
                $implement_uri_not_relying_which_script_is_calling_it = '/paginator/index.php?dataSource=restapi&page=' . $next_page;
                return $implement_uri_not_relying_which_script_is_calling_it;
            }
        }

    }

    public function __toArray(){
        return call_user_func('get_object_vars', $this);
    }

}
