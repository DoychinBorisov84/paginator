<?php
// require('DataSource.php');
/**
 * Paginator class  
 * 
 */
class Paginator
{
    // private $total_items = 50; // total item incoming API, Database, CONST int ...
    private $items_per_page = 12; // ?User Input -- our needs for the grid
    private $items_per_row = 4; // ?? CONST for easy and more gridable rows our needs for the grid
    private $current_page;
    private $dataSource;
    // private $dataSourceData;

    public function __construct(DataSource $dataSource)
    {        
        $this->setDataSource($dataSource);

        // Set the page based on http GET param
        // $this->getCurrentPage();
    }

    /**
     * Set Datasource $dataSource
     */
    public function setDataSource($dataSource)
    {
        //TODO: Sanitize && refactor If we got Database, REST Api or Default ... set the Paginator props below; bring out into method
        $this->dataSource = $dataSource;
    }

    /**
     * Set dataSource data
     */
    public function setDataSourceData($data)
    {
        $this->dataSource->getSource()->setData($data);
    }

    /**
     * Get dataSource data
     */
    public function getDataSourceData()
    {
        return $this->dataSource->getSource()->getData();
    }

    public function getDataSourceDataSize()
    {
        return $this->dataSource->getSource()->getDataSize();
    }

    public function getDataSourceType()
    {
        return get_class($this->dataSource->getSource());
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
        return ceil($this->getDataSourceDataSize() / $this->items_per_page);
    }

    /**
     * Set total images count, based on data-source
     * 
     */
    // public function setTotalItems($total_items)
    // {
    //     $this->total_items = $total_items;
    // }

    /**
     * Get total images count
     * 
     * @return int
     */
    // public function getTotalImages()
    // {
    //     return $this->total_items;
    // }
    

    /**
     * 
     * Get total rows per page
     */
    public function getTotalRows()
    {
        return ceil($this->items_per_page / $this->items_per_row);        
    }

    public function setCurrentPage($currentPageUrl)
    {
    //  Sanitize | Valudate the new param $current_url, passed from ajax requuest
        $url = parse_url($currentPageUrl);

        parse_str($url['query'], $httpQuery);
        $pageNow = $httpQuery['page'];

        // $this->current_page = $page;
        // if(!$page){
        //     $this->current_page = isset($this->sanitizeGetParams()['page']) ? $this->sanitizeGetParams()['page'] : null;
        // }

        if (is_null($pageNow)){
            $this->current_page = 1; // default value if ['page'] param not set up
        }elseif (!is_numeric($pageNow)) {
            header('Location: index.php'); // only numeric params
        }else{
            if($pageNow >= $this->getTotalPages()){
            // if($this->current_page >= $this->getDataSourceDataSize()){
                $this->current_page = $this->getTotalPages(); // max page value
            }elseif ($pageNow <= 0) {
                $this->current_page =  1; // min page value
            }
            else {
                $this->current_page = $pageNow;
            }
        }        
        // var_dump($currentPageUrl, $this->current_page, $pageNow);
        return $this->current_page;
        // die;
    }
    /**
     * Get current | min/max page
     * 
     * @return string|int
     */
    public function getCurrentPage($pageNum = null, $currentPageUrl = null, $parseAsUrl = false) 
    {

        // Sanitize | Valudate the new param $current_url, passed from ajax requuest
        // $url = parse_url($currentPageUrl);

        // parse_str($url['query'], $httpQuery);
        // $pageNow = $httpQuery['page'];

        // // $this->current_page = $page;
        // // if(!$page){
        // //     $this->current_page = isset($this->sanitizeGetParams()['page']) ? $this->sanitizeGetParams()['page'] : null;
        // // }

        // if (is_null($pageNow)){
        //     $this->current_page = 1; // default value if ['page'] param not set up
        // }elseif (!is_numeric($pageNow)) {
        //     header('Location: index.php'); // only numeric params
        // }else{
        //     if($pageNow >= $this->getTotalPages()){
        //     // if($this->current_page >= $this->getDataSourceDataSize()){
        //         $this->current_page = $this->getTotalPages(); // max page value
        //     }elseif ($pageNow <= 0) {
        //         $this->current_page =  1; // min page value
        //     }
        //     else {
        //         $this->current_page = $pageNow;
        //     }
        // }        
        // // var_dump($currentPageUrl, $this->current_page, $pageNow);
        // return $this->current_page;
        // die;
        




        if($parseAsUrl && $currentPageUrl){
            if($pageNum){
                 // Sanitize | Valudate the new param $current_url, passed from ajax requuest
                $url = parse_url($currentPageUrl);

                parse_str($url['query'], $httpQuery);
                // $pageNow = $httpQuery['page'];

                // if($this->getCurrentPage($pageNow) == $this->getTotalPages()){
                //     return '#';        
                // }elseif ($lastPage == true){
                //     $httpQuery['page'] = $this->getTotalPages();
                // }
                // else {
                //     $httpQuery['page'] = $pageNow + 1;
                // } 

                $httpQuery['page'] = $pageNum;

                $url['query'] = http_build_query($httpQuery);
                $pageAsUrl = $url['path'].'?'.$url['query'];

                return $pageAsUrl;
                // var_dump($httpQuery, $url, $next_page);
                // die;
            }else{
                $url = parse_url($currentPageUrl);

                // parse_str($url['query'], $httpQuery);

                // $pageNow = $httpQuery['page'];

                // if($this->getCurrentPage($pageNow) == $this->getTotalPages()){
                //     return '#';        
                // }elseif ($lastPage == true){
                //     $httpQuery['page'] = $this->getTotalPages();
                // }
                // else {
                //     $httpQuery['page'] = $pageNow + 1;
                // } 

                // $httpQuery['page'] = $pageNum;

                // $url['query'] = http_build_query($httpQuery);
                $pageAsUrl = $url['path'].'?'.$url['query'];

                return $pageAsUrl;
            }
        }

        return $this->current_page;







        // Assign current page value based on GET
        // If we make ajax call the init is the class Initiator => $_GET['page] is not setted up => manual setup here
        // $this->current_page = $page;
        // if(!$page){
        //     $this->current_page = isset($this->sanitizeGetParams()['page']) ? $this->sanitizeGetParams()['page'] : null;
        // }

        // // var_dump($this->sanitizeGetParams()['page'], $_SERVER['REQUEST_URI']);
        // // var_dump($this->current_page);
        // if (is_null($this->current_page)){
        //     $this->current_page = 1; // default value if ['page'] param not set up
        // }elseif (!is_numeric($this->current_page)) {
        //     header('Location: index.php'); // only numeric params
        // }
        // else{
        //     if($this->current_page >= $this->getTotalPages()){
        //     // if($this->current_page >= $this->getDataSourceDataSize()){
        //         $this->current_page = $this->getTotalPages(); // max page value
        //     }elseif ($this->current_page <= 0) {
        //         $this->current_page =  1; // min page value
        //     }
        // }        
        //  return $this->current_page;
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
        $offset = ( ($current_page * $this->items_per_page) - $this->items_per_page + 1);
        if($current_page <= 0){
            $offset = 1; // first item to begin
        }
        if(!$current_page){
            $offset = (($this->getCurrentPage() * $this->items_per_page) - $this->items_per_page) + 1; // +1 -> counting from the 1st item       
    
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
    public function getPreviousPage($currentPageUrl)
    {
        // Sanitize | Valudate the new param $current_url, passed from ajax requuest
        $url = parse_url($currentPageUrl);

        parse_str($url['query'], $httpQuery);
        $pageNow = $httpQuery['page'];

        if($this->getCurrentPage() == 1){
            return '#';
        }elseif($this->getCurrentPage() >= $this->getTotalPages()){
            $httpQuery['page'] = $this->getTotalPages() - 1;

            // die('sa');
            // $query['page'] =  $this->getTotalPages() - 1 ;
            // $newQuery = http_build_query($query);
            // $previous_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
            // return $previous_page;

            // return $this->getTotalPages() - 1;
        }else{
            $httpQuery['page'] = $this->getCurrentPage() - 1;
        }
        $url['query'] = http_build_query($httpQuery);
        $previous_page = $url['path'].'?'.$url['query'];

        return $previous_page;


        // $query['page'] =  $this->getCurrentPage() - 1 ;
        // $newQuery = http_build_query($query);
        // return $previous_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;






        // if(!$current_page_ajax && !$total_page_ajax){
        //     $query = $_GET; // current http-query
        //     $query['page'] = isset($_GET['page']) ? $_GET['page'] : $this->current_page; // current http-query {page} param
    
    
        //     if($this->getCurrentPage() == 1){
        //         return '#';
        //     }elseif($this->getCurrentPage() >= $this->getTotalPages()){
        //         // die('sa');
        //         $query['page'] =  $this->getTotalPages() - 1 ;
        //         $newQuery = http_build_query($query);
        //         $previous_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
        //         return $previous_page;
    
        //         // return $this->getTotalPages() - 1;
        //     }
        //     $query['page'] =  $this->getCurrentPage() - 1 ;
        //     $newQuery = http_build_query($query);
        //     return $previous_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
    
            // return $previous_page = $this->getCurrentPage() - 1;
        // }else{
        //     if($current_page_ajax == 1){
        //         return '#';
        //     }elseif($current_page_ajax >= $total_page_ajax){
        //         $previous_page = $current_page_ajax - 1;
        //         $implement_uri_not_relying_which_script_is_calling_it = '/paginator/index.php?dataSource='. strtolower($this->getDataSourceType()) .'&page=' . $previous_page;
        //         return $implement_uri_not_relying_which_script_is_calling_it;
        //     }else{
        //         $previous_page = $current_page_ajax - 1;
        //         $implement_uri_not_relying_which_script_is_calling_it = '/paginator/index.php?dataSource='. strtolower($this->getDataSourceType()) .'&page=' . $previous_page;
        //         return $implement_uri_not_relying_which_script_is_calling_it;
        //     }
        // }
    }

    /**
     * Get next page
     * @return string
     */
    public function getNextPage($lastPage = false, $currentPageUrl = null)
    {    
        // Sanitize | Valudate the new param $current_url, passed from ajax requuest
        $url = parse_url($currentPageUrl);

        parse_str($url['query'], $httpQuery);
        $pageNow = $httpQuery['page'];

        if($this->getCurrentPage($pageNow) == $this->getTotalPages()){
            return '#';        
        }elseif ($lastPage == true){
            $httpQuery['page'] = $this->getTotalPages();
        }
        else {
            $httpQuery['page'] = $pageNow + 1;
        } 
        $url['query'] = http_build_query($httpQuery);
        $next_page = $url['path'].'?'.$url['query'];

        return $next_page;
        // var_dump($httpQuery, $url, $next_page);
        // die;

        

        

        // if(!$current_page_ajax && !$total_pages_ajax){
        //     // $uri = "index.php?page=";
        //     $query = $_GET; // current http-query
        //     // $query['page'] = $_GET['page']; // current http-query {page} param
        //     $current_page = isset($_GET['page']) ? $_GET['page'] : $this->current_page; // current http-query {page} param
    
    
        //     if($this->getCurrentPage() == $this->getTotalPages()){
        //         return '#';        
        //     }elseif ($lastPage == true){
        //         $query['page'] = $this->getTotalPages();
        //         $newQuery = http_build_query($query);
        //         return $next_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
        //         // return $next_page = "{$uri}{$this->getTotalPages()}";
        //     }
        //     else {
        //             // var_dump ($_SERVER['REQUEST_URI'], $_GET, $_SERVER['PHP_SELF']);
        //         // $query = $_GET;
        //         // $query['page'] = $_GET['page'] + 1;
        //         $query['page'] = $current_page + 1;
        //         $newQuery = http_build_query($query);
        //         $next_page = $_SERVER['PHP_SELF'] .'?'. $newQuery;
        //         return $next_page;
        //         // var_dump($query, $newQuery, $next_page);
        //             // die;
    
        //         // $next_page = $this->getCurrentPage() + 1;
        //         // return "{$uri}{$next_page}";
        //     }
        // }else{
        //     // TODO: reimplement the above
        //     if($current_page_ajax == $total_pages_ajax){
        //         return '#';  
        //     }elseif($lastPage == TRUE){
        //         $implement_uri_not_relying_which_script_is_calling_it = '/paginator/index.php?dataSource='. strtolower($this->getDataSourceType()) .'&page=' . $total_pages_ajax;
        //         return $implement_uri_not_relying_which_script_is_calling_it;
        //     }
        //     else{
        //         $next_page = $current_page_ajax + 1;
        //         $implement_uri_not_relying_which_script_is_calling_it = '/paginator/index.php?dataSource='. strtolower($this->getDataSourceType()) .'&page=' . $next_page;
        //         // strtolower($this->getDataSourceType());
        //         return $implement_uri_not_relying_which_script_is_calling_it;
        //     }
        // }

    }

    public function __toArray(){
        return call_user_func('get_object_vars', $this);
    }

}
