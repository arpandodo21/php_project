<?php
require_once '../common.php';
$userData = $object->getUserFromSession();

// print_r($userData);die();
if ($userData == '') {
    $object->redirect($object->baseUrl.'admin/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    