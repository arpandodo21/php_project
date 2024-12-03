<?php
    if(!empty($userData)){
        $object->getRolePermission($userData['user_id']);
    }
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php
                $current_page = basename($_SERVER['SCRIPT_NAME']);
                $pageName = '';
                // Determine which collapsible section (if any) should be expanded
                $collapseProductsExpanded = in_array($current_page, ['products.php', 'add-product.php']) ? 'show' : '';
                $collapseProductsActive = in_array($current_page, ['products.php', 'add-product.php']) ? 'true' :
                    'false';

                $collapseRolesExpanded = in_array($current_page, ['roles.php', 'update-role.php']) ? 'show' : '';
                $collapseRolesActive = in_array($current_page, ['roles.php', 'update-role.php']) ? 'true' : 'false';

                // Loop through the links and generate the navigation items
                foreach ($object->pages['links'] as $file => $title) {
                    // Determine if the link is active
                    $active = ($current_page === $file) ? 'active' : '';
                    if($current_page === $file) $pageName = $title;
                    // Determine the icon
                    $icon = $object->pages['icons'][$file];
                    // Determine the icon class
                    $iconClass = ($file === 'products.php') ? 'fa-brands' : 'fas';

                    // Check if the link is for "Products" or "Roles"
                    if ($file === 'products.php' || $file === 'add-product.php') {
                        continue; // Skip the regular product link, handled in the collapsible section
                    } elseif ($file === 'roles.php' || $file === 'update-role.php') {
                        continue; // Skip the regular roles link, handled in the collapsible section
                    } else {
                        echo "
                <a class='nav-link $active' href='{$object->baseUrl}admin/$file'>
                    <div class='sb-nav-link-icon'><i class='$iconClass $icon'></i></div>
                    $title
                </a>
                ";
                    }
                }

                // Add the collapsible section for "Products"
                echo "
                <a class='nav-link collapsed' href='#' data-bs-toggle='collapse' data-bs-target='#collapseProducts'
                    aria-expanded='$collapseProductsActive' aria-controls='collapseProducts'>
                    <div class='sb-nav-link-icon'><i class='fa-brands fa-product-hunt'></i></div>
                    Products
                    <div class='sb-sidenav-collapse-arrow'><i class='fas fa-angle-down'></i></div>
                </a>
                <div class='collapse $collapseProductsExpanded' id='collapseProducts' aria-labelledby='headingProducts'
                    data-bs-parent='#sidenavAccordion'>
                    <nav class='sb-sidenav-menu-nested nav'>
                        <a class='nav-link' href='{$object->baseUrl}admin/products.php'>View Products</a>
                        <a class='nav-link' href='{$object->baseUrl}admin/add-product.php'>Add Product</a>
                    </nav>
                </div>
                ";

                // Add the collapsible section for "Roles"
                echo "
                <a class='nav-link collapsed' href='#' data-bs-toggle='collapse' data-bs-target='#collapseRoles'
                    aria-expanded='$collapseRolesActive' aria-controls='collapseRoles'>
                    <div class='sb-nav-link-icon'><i class='fas fa-user-shield'></i></div>
                    User Role
                    <div class='sb-sidenav-collapse-arrow'><i class='fas fa-angle-down'></i></div>
                </a>
                <div class='collapse $collapseRolesExpanded' id='collapseRoles' aria-labelledby='headingRoles'
                    data-bs-parent='#sidenavAccordion'>
                    <nav class='sb-sidenav-menu-nested nav'>
                        <a class='nav-link' href='{$object->baseUrl}admin/roles.php'>View Roles</a>
                        <a class='nav-link' href='{$object->baseUrl}admin/update-role.php'>Update Role</a>
                    </nav>
                </div>
                ";
                ?>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= $userData['name']; ?>
        </div>
    </nav>
</div>