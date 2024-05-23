<?php
require_once '../common.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    unset($_SESSION['user']);
    echo json_encode(array('status'=> 'success','message'=> 'Logged out successfully'));
}