<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <?php
                // Get the current script name
                $current_page = basename($_SERVER['SCRIPT_NAME']);
                $pageName = '';
                // Loop through the links and generate the navigation items
                foreach ($object->pages['links'] as $file => $title) {
                    // Determine if the link is active
                    $active = ($current_page === $file) ? 'active' : '';
                    if($current_page === $file) $pageName = $title;
                    // Determine the icon
                    $icon = $object->pages['icons'][$file];
                    // Determine the icon class
                    $iconClass = ($file === 'products.php') ? 'fa-brands' : 'fas';
                    echo "
                        <a class='nav-link $active' href='{$object->baseUrl}admin/$file'>
                            <div class='sb-nav-link-icon'><i class='$iconClass $icon'></i></div>
                            $title
                        </a>
                    ";
                }
                ?>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= $userData['name']; ?>
        </div>
    </nav>
</div>