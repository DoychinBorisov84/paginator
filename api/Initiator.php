<?php
// include_once('../classes/Paginator.php');
// include_once('../classes/DataSource.php');
include_once('../classes/BaseAjax.php');
$baseAjax = new BaseAjax();
// include_once('../classes/Base.php');
// $base = new Base();

if(isset($_POST)){
    $data = $_POST['ajaxData'] ?? [];
    $dataSize = $_POST['ajaxDataSize'] ?? NULL;
    $currentPage = $_POST['page'];
    $current_page_url = $_POST['current_url'];
    $dataSourceType = $_POST['dataSourceType'];
}

class Initiator
{
    // public function __construct()
    // {
            // Return obj
    // }

}

$dataSource = new DataSource($dataSourceType);
$paginator = new Paginator($dataSource);

$paginator->setDataSourceData($data);

$response = [
    // 'current_page_url' => $paginator->getPageURL(1),
    'get_page_1' => $paginator->getPageURL(1, $current_page_url),
    'get_page_2' => $paginator->getPageURL(2, $current_page_url),
    'get_page_dot' => $paginator->getPageURL('dot', $current_page_url),
    'get_page_current_page' => $paginator->getPageURL($currentPage, $current_page_url),
    'current_page' => $paginator->getCurrentPage($currentPage),
    'previous_page' => $paginator->getPreviousPage($currentPage, $paginator->getTotalItems()),
    'next_page' => $paginator->getNextPage(FALSE, $currentPage, $paginator->getTotalItems()),
    'last_page' => $paginator->getNextPage(TRUE, $currentPage, $paginator->getTotalItems()),
    'total_items' => $paginator->getTotalItems(),
    // 'dataSource_data_size' => $paginator->getDataSourceDataSize(),
    'total_images' => $paginator->getDataSourceDataSize(),
    'total_rows' => $paginator->getTotalRows(),
    'current_page_images_offset' => $paginator->getCurrentPageImageOffset($currentPage),
    'dataSource_type' => $paginator->getDataSourceType(),
    'dataSource_data' => $paginator->getDataSourceData()
];

// var_dump($_POST); die;
echo json_encode($response);