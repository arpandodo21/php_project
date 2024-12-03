<?php
require_once './../../common.php';

// Set the output to be JSON
header('Content-Type: application/json');

// Get parameters from DataTables
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];

// Query to get total number of records
$totalRecordsQuery = "SELECT COUNT(*) AS count FROM providers";
$totalRecordsResult = $object->conn->query($totalRecordsQuery);
if ($totalRecordsResult) {
    $totalRecords = $totalRecordsResult->fetch_assoc()['count'];
} else {
    echo json_encode(array(
        "draw" => intval($draw),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array(),
        "error" => $object->conn->error // Return error message
    ));
    exit;
}

// Query to get filtered records
$filteredRecordsQuery = "SELECT COUNT(*) AS count FROM providers WHERE provider_type LIKE '%$searchValue%' OR provider_name LIKE '%$searchValue%'";
$filteredRecordsResult = $object->conn->query($filteredRecordsQuery);
if ($filteredRecordsResult) {
    $totalFiltered = $filteredRecordsResult->fetch_assoc()['count'];
} else {
    echo json_encode(array(
        "draw" => intval($draw),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array(),
        "error" => $object->conn->error // Return error message
    ));
    exit;
}

// Query to get data
$dataQuery = "SELECT id, provider_type, provider_name FROM providers WHERE provider_type LIKE '%$searchValue%' OR provider_name LIKE '%$searchValue%' LIMIT $start, $length";
$dataResult = $object->conn->query($dataQuery);
if ($dataResult) {
    $data = array();
    while ($row = $dataResult->fetch_assoc()) {
        $data[] = array(
            $row['id'],
            $row['first_name'],
            $row['last_name'],
            $row['handle']
        );
    }

    // Prepare the response
    $response = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($totalRecords),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );

    // Send the response back to DataTables
    echo json_encode($response);
} else {
    echo json_encode(array(
        "draw" => intval($draw),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array(),
        "error" => $object->conn->error // Return error message
    ));
}
