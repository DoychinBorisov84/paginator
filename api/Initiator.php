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
    // $urlParams = $_POST['dummy'];
}

// var_dump($_POST['page']);
// die;
class Initiator
{
    public function initiatePaginator()
    {
        //Data preparing
        return json_encode(array('data' => 1, 'bata' => 2));
    }

}

$dataSource = new DataSource('Restapi');
$paginator = new Paginator($dataSource, $data);
$paginator->setTotalImages($dataSize);
$paginator->setDataSourceData($data);
$paginator->setDataSourceDataSize($dataSize);
// $paginator->getCurrentPageImageOffset();
// $paginator->getNextPage($last);

$response = [
    'current_page' => $paginator->getCurrentPage($currentPage),
    'last_page' => $paginator->getNextPage(TRUE, $currentPage, $paginator->getTotalPages()),
    'next_page' => $paginator->getNextPage($currentPage),
    'total_pages' => $paginator->getTotalPages(),
    'total_images' => $paginator->getTotalImages(),
    'current_page_images_offset' => $paginator->getCurrentPageImageOffset($currentPage),
    'paginator_get_data_source_data_size' => $paginator->getDataSourceDataSize()
    // 'last_page' => $paginator->getNextPage($last)
];
echo json_encode($response);

// $array = (array) $paginator;
// echo json_encode($array);
// var_dump($array->__toArray()); 
// $dummy = new Dummy();

// var_dump($data, $dataSize);

// $class = new Initiator();
// $data = $class->initiatePaginator();
// echo $data;