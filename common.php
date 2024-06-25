<?php
require_once ('db.php');
$object = new database('php_project');
$baseUrl = $object->baseUrl;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if ($_POST['role_id']) {
        $roleId = $_POST['role_id'];
        // echo json_encode(['role'=>$roleId]);exit;
        gettype($object->getRoleWisePriviledges($roleId));
        // echo json_encode(['data' => $userWiseRoles]);
    }
}