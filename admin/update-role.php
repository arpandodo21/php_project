<?php

require_once './layouts/header.php';
// Fetch roles
$roles = $object->get_all_records('roles');
// Fetch privileges
$privileges = $object->get_all_records('privileges');
$rolePrivileges = $object->get_all_records('privileges', ['id']);

// $userWiseRoles = $object->getRoleWisePriviledges($roleId);


?>
<div id="layoutSidenav">
    <?php require_once './layouts/sidebar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update Role Priviledges</h1>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Update Role Priviledges
                            </div>
                            <div class="card-body">
                                <form method="POST" id="rolePrivilegesForm">
                                    <div class="mb-3">
                                        <label for="role_id" class="form-label">Role Name</label>
                                        <select name="role_id" class="form-control" onchange="loadRolePrivileges(this)">
                                            <option value="">Select Role</option>
                                            <?php foreach ($roles as $role) { ?>

                                                <option value="<?= $role['id'] ?>"><?= ucfirst($role['NAME']) ?></option>

                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 role-checkbox" id="privilegesContainer">
                                        <label class="form-label">Privileges</label><br>
                                        <?php foreach ($privileges as $privilege): ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    id="privilege<?= $privilege['id'] ?>" name="privileges[]"
                                                    value="<?= $privilege['id'] ?>" <?= in_array($privilege['id'], $rolePrivileges) ? 'checked' : '' ?>>
                                                <label class="form-check-label"
                                                    for="privilege<?= $privilege['id'] ?>"><?= $privilege['NAME'] ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" name="role_id" value="<?= $role['id'] ?? '' ?>">
                                    <button type="submit" class="btn btn-primary role-submit">Update</button>
                                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <?php require_once './layouts/footer.php' ?>