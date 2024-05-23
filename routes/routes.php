<?php 
trait routes
{
    public $baseUrl = "http://localhost/php_project/";
    public $assetURL = $this->baseUrl . "assets/";
    public $assetCssURL = $this->assetURL . "assets/css/";
    public $assetJsURL = $this->assetURL . "assets/js/";
    public $assetImageURL = $this->assetURL . "assets/images/";
    public $adminLoginURL = $this->baseUrl . "admin/login.php";
    public $adminDashboardURL = $this->baseUrl . "admin/dashboard.php";
    public $logoutURL = $this->baseUrl . "admin/logout.php";
}