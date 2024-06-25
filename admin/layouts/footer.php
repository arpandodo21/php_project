<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2023</div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
<script src="<?php echo $object->baseUrl; ?>assets/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
<script src="<?php echo $object->baseUrl; ?>assets/js/datatables-simple-demo.js"></script>
<script>
    $(document).ready(function () {

        // Handle form submission
        $('#rolePrivilegesForm').submit(function (e) {
            e.preventDefault();
            updateRolePrivileges();
        });
    });
    const logout = () => {
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Logout"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo $object->baseUrl; ?>admin/logout.php",
                    data: { logout: 1 },
                    type: 'POST',
                    beforeSend: function () {
                        $('body').LoadingOverlay('show');
                    },
                    success: function (res) {
                        $('body').LoadingOverlay('hide');
                        let data = JSON.parse(res);
                        if (data.status == 'success') {
                            Swal.fire({
                                title: data.message,
                                icon: "success",
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                window.location.href = "<?= $object->baseUrl ?>admin/login.php"
                            }, 2000);
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }
                });
            }
        });

    }

    //for fetching roles
    // const fetchRole = (e) => {
    //     if (e.value == '') {
    //         $('.role-checkbox').show()
    //     } else {
    //         $('.role-checkbox').hide()
    //         $.ajax({
    //             url: "<?= $object->baseUrl . '/admin/update-role.php' ?>",
    //             data: { id: e.value,priviledges: },
    //             type: 'POST',
    //             beforeSend: function () {
    //                 $('body').LoadingOverlay('show');
    //             },
    //             success: function (res) {
    //                 $('body').LoadingOverlay('hide');
    //                 console.log(res);
    //             },
    //             error: function (err) {
    //                 console.log(err);
    //             }
    //         })
    //     }

    // }

    function loadRolePrivileges(elem) {
        
        if (elem.value!="") {
            let roleId = elem.value;
            $.ajax({
                url: '<?= $object->baseUrl . '/common.php' ?>',
                method: 'POST',
                data: { role_id: roleId },
                beforeSend: function () {
                    $('body').LoadingOverlay('show');
                },
                success: function (data) {
                    // let rolePrivileges = JSON.parse(data);
                    console.log(data);
                    // $('#privilegesContainer input[type="checkbox"]').each(function () {
                    //     $(this).prop('checked', rolePrivileges.includes($(this).val()));
                    // });
                    $('body').LoadingOverlay('hide');
                },
                error:function(err){
                    console.log(err);
                }
            });
        } else {
            $('#privilegesContainer input[type="checkbox"]').prop('checked', false);
        }
    }

    function updateRolePrivileges() {
        var formData = $('#rolePrivilegesForm').serialize();
        console.log(formData)
        // $.ajax({
        //     url: 'update_role_privileges.php',
        //     method: 'POST',
        //     data: formData,
        //     success: function (response) {
        //         alert(response);
        //     }
        // });
    }


</script>
</body>

</html>