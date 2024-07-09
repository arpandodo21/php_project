<?php
require_once './layouts/header.php';

?>
<div id="layoutSidenav">
    <?php require_once './layouts/sidebar.php'; ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4"><?= $pageName; ?></h1>
                <button type="button" class="btn btn-primary" id="add-provider">Add Provider</button>
                <table class="table provider-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Provider</th>
                            <th scope="col">Type</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

        <script src="https://cdn.datatables.net/r/dt/dt-1.10.9/datatables.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                var dataTable = $('.provider-table').DataTable({
                    "responsive": true,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        url: "ajax/providerOperations.php", // json datasource
                        data: { action: 'getEMP' },
                        type: 'post',  // method  , by default get

                    },
                    error: function () {  // error handling
                        $(".employee-grid-error").html("");
                        $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#employee-grid_processing").css("display", "none");

                    }

                });
            })
                ;
        </script>
        <?php require_once './layouts/footer.php' ?>