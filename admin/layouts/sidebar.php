<div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- <div class="sb-sidenav-menu-heading">Core</div> -->
                        <a class="nav-link" href="<?php echo $object->baseUrl; ?>admin/dashboard.php">
                            <div class="sb-nav-link-icon active"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="<?php echo $object->baseUrl; ?>admin/products.php">
                            <div class="sb-nav-link-icon active"><i class="fa-brands fa-product-hunt"></i></div>
                            Products
                        </a>
                        
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?= $userData['name']; ?>
                </div>
            </nav>
        </div>