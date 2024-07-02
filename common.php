<?php
require_once ('db.php');
$object = new database('php_project');
$baseUrl = $object->baseUrl;

// for fetching
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'fetch_role') {
        $roleId = $_POST['role_id'];
        if($data = $object->getRoleWisePrivileges($roleId)){
            echo json_encode(['status'=>true,'privileges' =>$data]);
        }else{
            echo json_encode(['status'=>false]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'role_update') {
        $roleId = $_POST['role_id'];
        $privileges = $_POST['privileges'];
        if($object->updateRoleWisePrivileges($roleId,$privileges)){
            echo json_encode(['status'=>true,'message' =>'Role has been updated successfully!']);
        }else{
            echo json_encode(['status'=>false,'message' => 'Something went wrong!']);
        }
    }
}