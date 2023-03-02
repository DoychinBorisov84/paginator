<?php
// namespace Paginator\Classes;

use Paginator\Classes\DataSource as DataSource;
// use Paginator\Api\Database as Database;
use Paginator\Api\DefaultData as DefaultData;
/**
 * Paginator class  
 * 
 */
class Paginator
{
    private $items_per_page = 12; // ?dynamic | user input
    private $items_per_row = 4; // ?dynamic | user input
    private $current_page;
    private $dataSource;

    public function __construct(DataSource $dataSource)
    {        
        $this->setDataSource($dataSource);
    }

    /**
     * Set Datasource $dataSource
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * Set dataSource data
     * 
     * @param array $data based on the passed [] of data when creating
     */
    public function setDataSourceData(array $data)
    {
        // var_dump( $this->dataSource->getSource());
        $this->dataSource->getSource()->setData($data);
    }

    /**
     * Get data from the initialized DataSource
     * @return array
     */
    public function getDataSourceData() : array
    {
        return $this->dataSource->getSource()->getData();
    }

    /**
     * Get Initialized DataSource [] size
     * 
     * @return int
     */
    public function getDataSourceDataSize() : int
    {
        return $this->dataSource->getSource()->getDataSize();
    }

    /**
     * Get Initialized DataSource class name as string
     * 
     * @return string
     */
    public function getDataSourceType(): string
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
     * @return float|int     
     */
    public function getTotalPages()
    {
        return ceil($this->getDataSourceDataSize() / $this->items_per_page);
    }

    /**
     * 
     * Get total rows per page
     * 
     * @return float|int     
     */
    public function getTotalRows()
    {
        return ceil($this->items_per_page / $this->items_per_row);        
    }

    /**
     * Get items per row
     * 
     * @return int
     */
    public function getTotalItemsPerRow() : int
    {
        return $this->items_per_row;
    }

    /**
     * Set current page based on the http request parameters
     * 
     * @param string $currentPageUrl
     */
    public function setCurrentPage($currentPageUrl)
    {
        $parsedUrlArr = parse_url($currentPageUrl); 

        $legalQueryParameters = $this->sanitizeGetParams($parsedUrlArr);
        // Unvalid one|many http query parameters
        if(!$legalQueryParameters){
            $this->current_page = null;
            return null;  // illegal value -> set default
            die();
        }

        $this->current_page =  $legalQueryParameters['page'] ?? 1; // default page if missing http query param

        if($this->current_page >= $this->getTotalPages()){
            $this->current_page = $this->getTotalPages(); // max page value
        }elseif ($this->current_page <= 0) {
            $this->current_page =  1; // min page value
        }            
        
        return $this->current_page;        
    }

    /**
     * Get current | min/max page
     * 
     * @param bool $pageNum - specific page, @param string $currentPageUrl, @param bool $parseAsUrl - whether to parse
     * 
     * @return int|string|null
     */
    public function getCurrentPage($exactPageNum = false, $currentPageUrl = '', $parseAsUrl = false) 
    {
        if(is_null($this->current_page)){
            return null;            
            die;
        }        

        if($parseAsUrl && strlen($currentPageUrl) > 0){
            $parsedUrlArr = parse_url($currentPageUrl);       
            parse_str($parsedUrlArr['query'], $httpQuery);

            if($exactPageNum){
                $httpQuery['page'] = $exactPageNum;
            }else{
                $pageNow = $httpQuery['page'] ?? $this->getCurrentPage();

                if($pageNow >= $this->getTotalPages()){
                    $httpQuery['page'] = $this->getTotalPages();
                }elseif($pageNow <= 1){
                    $httpQuery['page'] = 1;
                }else{
                    $httpQuery['page'] = $pageNow;
                }
            }
            $parsedUrlArr['query'] = http_build_query($httpQuery);
            $pageAsUrl = $parsedUrlArr['path'].'?'.$parsedUrlArr['query'];
            
            return $pageAsUrl;
        }

        return $this->current_page;
    }

     /**
     * Sanitize http query string
     * 
     * @param array $parsedHttpUrl
     * 
     * @return array|null
     */
    public function sanitizeGetParams(array $parsedHttpUrl) : ?array
    {
        // Get the http-query url params as array
        parse_str($parsedHttpUrl['query'], $httpQuery);
        
        // List of allowed GET parameters to check against     
        $allowedGetParams = array('page', 'dataSource');
        $allowedGetParamsKeys = array_flip($allowedGetParams);

        $parameterSecured = [];

        foreach ($httpQuery as $parameter => $value) {
            // Unvalid http query param
            if(!array_key_exists($parameter, $allowedGetParamsKeys)){
                return null;
            }

            # TODO: create Validation|Sanitization class to handle the process, with error msg to display ...
            // Sanitize            
            $parameterSanitized[$parameter] = trim(htmlspecialchars($httpQuery[$parameter]));
            
            // Validate
            $parameterValidated[$parameter] = $this->validateGetParams($parameterSanitized);

            // Unvalid http query value
            if($parameterValidated[$parameter] === false){
                return null;
            }
            $parameterSecured[$parameter] = $parameterValidated[$parameter];
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

        // Validate http query params  
        foreach ($parameter as $key => $value) {
            if ($key == 'page'){
                $validatedParameters = filter_var($value, FILTER_VALIDATE_FLOAT);
            }elseif ($key == 'dataSource'){
                $options = ['restapi', 'database', 'defaultData'];

                $validatedParameters = $value;                
                if(!in_array($value, $options)){
                    $validatedParameters = false;
                }
            }
        }
        
        return $validatedParameters;
    }

    /**
     * Get current images offset, based on the get page parameter
     * 
     * @return float|int|null
     */
    public function getCurrentPageImageOffset($currentPageUrl = '') {   

        if(is_null($this->getCurrentPage())){
            return null;            
            die;
        }       
        
        //Remove Not needed, keeping for the index.php currently
        if(strlen($currentPageUrl) < 0){
            return $offset = (($this->getCurrentPage() * $this->items_per_page) - $this->items_per_page);
        }else{
            $pageNow = $this->getCurrentPage();
            
            // Currently allowing -+ values over our real pages to be used => set min|max page based on the below
            $offset = ( ($pageNow * $this->items_per_page) - $this->items_per_page);            
            if($pageNow <= 0){
                $offset = 0; // first item to start
            }elseif($pageNow > $this->getTotalPages()){
                $offset = ($this->getTotalPages() * $this->items_per_page) - $this->items_per_page;
            }
            return $offset;
        }
    }

    /**
     * Get previous page
     * 
     * @return string|null
     */
    public function getPreviousPage($currentPageUrl)
    {
        if(is_null($this->getCurrentPage())){
            return null;            
            die;
        }  
        
        // Get the [query] from the current page url Send
        $parsedUrlArr = parse_url($currentPageUrl);
        parse_str($parsedUrlArr['query'], $httpQuery);            
        
        $pageNow = $this->getCurrentPage();        
        if($pageNow == 1){
            return '#';
        }elseif($pageNow >= $this->getTotalPages()){
            $httpQuery['page'] = $this->getTotalPages() - 1;
        }else{
            $httpQuery['page'] = $pageNow - 1;
        }
        $parsedUrlArr['query'] = http_build_query($httpQuery);
        $previous_page = $parsedUrlArr['path'].'?'.$parsedUrlArr['query'];

        return $previous_page;
    }

    /**
     * Get next page
     * 
     * @param bool $lastPage - true to return the last page, @param string $currentPageUrl - http query string
     * 
     * @return string|null
     */
    public function getNextPage($lastPage = false, $currentPageUrl)
    {    
        if(is_null($this->getCurrentPage())){
            return null;            
            die;
        }  

        // Get the [query] from the current page url Send
        $parsedUrlArr = parse_url($currentPageUrl);
        parse_str($parsedUrlArr['query'], $httpQuery);  

        $pageNow = $this->getCurrentPage();
        if ($pageNow == $this->getTotalPages()){
            return '#';        
        }elseif ($lastPage == true){
            $httpQuery['page'] = $this->getTotalPages();
        }
        else {
            $httpQuery['page'] = $pageNow + 1;

            if($pageNow >= $this->getTotalPages()){
                $httpQuery['page'] = $this->getTotalPages();
            }elseif ($pageNow < 1){
                $httpQuery['page'] = 1;
            }
        } 
        
        $parsedUrlArr['query'] = http_build_query($httpQuery);
        $next_page = $parsedUrlArr['path'].'?'.$parsedUrlArr['query'];

        return $next_page;
    }
    
}
