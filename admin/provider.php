<?php
require_once './layouts/header.php';

?>
    <div id="layoutSidenav">
        <?php require_once './layouts/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $pageName; ?></h1>
                    
                </div>
            </main>
            

    <?php require_once './layouts/footer.php' ?>