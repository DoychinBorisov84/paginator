<?php
// include_once('../classes/Paginator.php');
// include_once('../classes/DataSource.php');
include_once('../classes/BaseAjax.php');
$baseAjax = new BaseAjax();
// include_once('../classes/Base.php');
// $base = new Base();

// $data = $_POST['ajaxData'];
if(isset($_POST)){
    $data = $_POST['ajaxData'];
    $dataSize = $_POST['ajaxDataSize'];
    $currentPage = $_POST['page'];
    $current_page_url = $_POST['current_url'];
    $dataSourceType = $_POST['dataSourceType'];
    // $urlParams = $_POST['dummy'];
}

// var_dump($_POST);
// die;
class Initiator
{
    // public function initiatePaginator()
    // {
    //     //Data preparing
    //     return json_encode(array('data' => 1, 'bata' => 2));
    // }

}

$dataSource = new DataSource($dataSourceType);
$paginator = new Paginator($dataSource);

$paginator->setTotalImages($dataSize);
$paginator->setDataSourceData($data);
$paginator->setDataSourceDataSize($dataSize);
// $paginator->getCurrentPageImageOffset();
// $paginator->getNextPage($last);

$response = [
    // 'current_page_url' => $paginator->getPageURL(1),
    'get_page_1' => $paginator->getPageURL(1, $current_page_url),
    'get_page_2' => $paginator->getPageURL(2, $current_page_url),
    'get_page_dot' => $paginator->getPageURL('dot', $current_page_url),
    'get_page_current_page' => $paginator->getPageURL($currentPage, $current_page_url),
    'current_page' => $paginator->getCurrentPage($currentPage),
    'previous_page' => $paginator->getPreviousPage($currentPage, $paginator->getTotalPages()),
    'next_page' => $paginator->getNextPage(FALSE, $currentPage, $paginator->getTotalPages()),
    'last_page' => $paginator->getNextPage(TRUE, $currentPage, $paginator->getTotalPages()),
    'total_pages' => $paginator->getTotalPages(),
    'total_images' => $paginator->getTotalImages(),
    'total_rows' => $paginator->getTotalRows(),
    'current_page_images_offset' => $paginator->getCurrentPageImageOffset($currentPage),
    'paginator_get_data_source_data_size' => $paginator->getDataSourceDataSize(),
    'paginator_dataSource_type' => $paginator->getDataSourceType(),
    'all_data' => $paginator->getDataSourceData()
];

// var_dump($response); die;
echo json_encode($response);

// $array = (array) $paginator;
// echo json_encode($array);
// var_dump($array->__toArray()); 
// $dummy = new Dummy();

// var_dump($data, $dataSize);

// $class = new Initiator();
// $data = $class->initiatePaginator();
// echo $data;