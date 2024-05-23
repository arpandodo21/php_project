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
                        error:function(err){
                            console.log(err)
                        }
                    });
                }
            });

        }
</script>
</body>

</html>