<?php
require_once './layouts/header.php';

?>
    <div id="layoutSidenav">
        <?php require_once './layouts/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $pageName; ?></h1>
                    <div class="row">
                    <div class="col-xl-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Role Priviledges
                            </div>
                            <div class="card-body"></div>
                        </div>
                    </div>
                </div>
                </div>
            </main>
            

    <?php require_once './layouts/footer.php' ?>