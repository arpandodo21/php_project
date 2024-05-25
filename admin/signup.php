<?php
require_once '../db.php';
$object = new database('php_project');
$baseUrl = $object->baseUrl;
if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
    $object->redirect($baseUrl . 'admin/dashboard.php');
    // print_r($_SESSION['user']);
} else {
    unset($_SESSION['user']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($object->createUser($_POST)) {
            echo json_encode(array('status' => 'success'));
            exit;
        } else {
            echo json_encode(array('status' => 'error'));
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/php_project/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Sign Up</title>
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Sign Up</h2>
                                <p class="text-white-50 mb-5">Create Your Account</p>
                                <form id="signup-form">
                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label" for="typeNameX">Your Full Name</label>
                                        <input type="text" id="typeNameX" class="form-control form-control-lg"
                                            name="name" />
                                    </div>
                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label" for="typeEmailX">Email</label>
                                        <input type="email" id="typeEmailX" class="form-control form-control-lg"
                                            name="email" />
                                    </div>

                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <label class="form-label" for="typePasswordX">Password</label>
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg"
                                            name="password" />
                                    </div>

                                    <!-- <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a>
                                </p> -->
                                    <button data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-light btn-lg px-5" type="submit">Sign Up</button>
                                </form>
                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>

                            </div>

                            <div>
                                <p class="mb-0">Already have an Account? <a href="<?= $baseUrl ?>"
                                        class="text-white-50 fw-bold">Login</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <div class="loader">

    </div> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $("#signup-form").validate({
                rules: {
                    // compound rule
                    name:{
                        required: true,
                        digits: false
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    name:{
                        required: "Please enter your name",
                        digits: "Please dont enter any number"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Your email address must be in the format of name@domain.com"
                    },
                    password: {
                        required: "Please enter your password"
                    }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: '<?php echo $baseUrl . 'admin/signup.php' ?>',
                        type: 'POST',
                        data: $(form).serialize(),
                        beforeSend: function () {
                            $('body').LoadingOverlay('show');
                        },
                        success: function (data) {
                            $('body').LoadingOverlay('hide');
                            let res = JSON.parse(data);
                            if (res.status == 'success') {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "success",
                                    title: "Login Successful",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            setTimeout(function () {
                                window.location.href = '<?= $baseUrl . "admin/login.php" ?>';
                            }, 2000);
                            } else {
                                Swal.fire({
                                    position: "top-end",
                                    icon: "error",
                                    title: "Login Unsuccessful",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }

                        }, error: function (err) {
                            console.log(err);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>