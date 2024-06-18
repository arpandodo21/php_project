<?php
require_once './layouts/header.php';

// Fetch roles
$sql = "SELECT * FROM roles";
$result = $object->conn->query($sql);
$roles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

// Fetch privileges
$sql = "SELECT * FROM privileges";
$result = $object->conn->query($sql);
$privileges = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $privileges[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roleName = $_POST['role_name'];
    $privileges = isset($_POST['privileges']) ? $_POST['privileges'] : [];

    // Insert role
    $sql = "INSERT INTO roles (name) VALUES ('$roleName')";
    if ($conn->query($sql) === TRUE) {
        $roleId = $conn->insert_id;

        // Insert role privileges
        foreach ($privileges as $privilegeId) {
            $sql = "INSERT INTO role_privileges (role_id, privilege_id) VALUES ('$roleId', '$privilegeId')";
            $conn->query($sql);
        }
    }
}

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
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="roleName" class="form-label">Role Name</label>
                                        <input type="text" class="form-control" id="roleName" name="role_name"
                                            value="<?= $role['name'] ?? '' ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Privileges</label><br>
                                        <?php foreach ($privileges as $privilege): ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                    id="privilege<?= $privilege['id'] ?>" name="privileges[]"
                                                    value="<?= $privilege['id'] ?>" <?= in_array($privilege['id'], $rolePrivileges) ? 'checked' : '' ?>>
                                                <label class="form-check-label"
                                                    for="privilege<?= $privilege['id'] ?>"><?= $privilege['name'] ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" name="role_id" value="<?= $role['id'] ?? '' ?>">
                                    <button type="submit" class="btn btn-primary"><?= $submitButton ?></button>
                                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <?php require_once './layouts/footer.php' ?>