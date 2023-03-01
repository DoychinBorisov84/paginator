<?php
include_once(__DIR__.'/../config/ajax_common.php');

// Validate / Sanitize class? 
if(isset($_POST)){
    $data = $_POST['ajaxData'] ?? [];
    $currentPageUrl = $_POST['ajaxCurrentUrl'];
    $dataSourceType = $_POST['ajaxDataSourceType'];
}

// Implement as REST API ? 
class Initiator
{
    public function __construct()
    {
            echo 'Initiator init';
    }

}

$dataSource = new DataSource($dataSourceType);

$paginator = new Paginator($dataSource);
$paginator->setDataSourceData($data);
$paginator->setCurrentPage($currentPageUrl);

// var_dump(__CLASS__);

$response = [
    'next_page' => $paginator->getNextPage(FALSE, $currentPageUrl),
    'last_page' => $paginator->getNextPage(TRUE, $currentPageUrl),
    'current_page' => $paginator->getCurrentPage(),
    'previous_page' => $paginator->getPreviousPage($currentPageUrl),
    'get_page_1' => $paginator->getCurrentPage(1, $currentPageUrl, true),
    'get_page_2' => $paginator->getCurrentPage(2, $currentPageUrl, true),
    'get_page_current' => $paginator->getCurrentPage(false, $currentPageUrl, true),
    'total_pages' => $paginator->getTotalPages(),
    'total_rows' => $paginator->getTotalRows(),
    'total_items_per_row' => $paginator->getTotalItemsPerRow(),
    'total_items' => $paginator->getDataSourceDataSize(),    
    'current_page_images_offset' => $paginator->getCurrentPageImageOffset($currentPageUrl),
    'dataSource_type' => $paginator->getDataSourceType(),
    'dataSource_data' => $paginator->getDataSourceData()
];

// var_dump($_POST, $data);

echo json_encode($response);