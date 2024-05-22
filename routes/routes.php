<?php 
trait Routes
{
    public $baseUrl = "http://localhost/php_project/";
    public $assetUrl = $this->baseUrl . "assets/";
    public $assetCss = $this->baseUrl . "assets/css/";
    public $assetJs = $this->baseUrl . "assets/js/";
    public $assetImage = $this->baseUrl . "assets/images/";
    public $adminLogin = $this->$baseUrl . "admin/login.php";
    public $adminDashboard = $this->$baseUrl . "admin/login.php";
    public $logout = $this->$baseUrl . "admin/logout.php";
}