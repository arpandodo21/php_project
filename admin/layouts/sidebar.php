<?php
if (!empty($userData)) {
    $permissions = $object->getRolePermission($userData['user_id']);
}
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php
                $current_page = basename($_SERVER['SCRIPT_NAME']);
                $pageName = '';

                // Group permissions by categories for collapsible sections
                $categories = [];
                foreach ($permissions as $permission) {
                    $categories[$permission['permission_name']][] = $permission;
                }

                foreach ($categories as $category => $links) {
                    // Handle collapsible sections dynamically
                    $isActive = array_reduce($links, function ($carry, $link) use ($current_page) {
                        return $carry || ($current_page === basename($link['link']));
                    }, false);

                    $collapseExpanded = $isActive ? 'show' : '';
                    $collapseActive = $isActive ? 'true' : 'false';

                    echo "
                    <a class='nav-link collapsed' href='#' data-bs-toggle='collapse' data-bs-target='#collapse$category'
                        aria-expanded='$collapseActive' aria-controls='collapse$category'>
                        <div class='sb-nav-link-icon'><i class='fas fa-folder'></i></div>
                        $category
                        <div class='sb-sidenav-collapse-arrow'><i class='fas fa-angle-down'></i></div>
                    </a>
                    <div class='collapse $collapseExpanded' id='collapse$category' aria-labelledby='heading$category'
                        data-bs-parent='#sidenavAccordion'>
                        <nav class='sb-sidenav-menu-nested nav'>";

                    foreach ($links as $link) {
                        $active = ($current_page === basename($link['link'])) ? 'active' : '';
                        echo "
                        <a class='nav-link $active' href='{$link['link']}'>
                            <div class='sb-nav-link-icon'><i class='{$link['icon']}'></i></div>
                            {$link['display_name']}
                        </a>";
                    }

                    echo "</nav></div>";
                }
                ?>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= htmlspecialchars($userData['name']); ?>
        </div>
    </nav>
</div>