<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>assets/images/logo.png" type="image/x-icon">

    <!--plugins-->
    <link href="<?php echo BASE_URL; ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="<?php echo BASE_URL; ?>assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?php echo BASE_URL; ?>assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/app.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>assets/css/login.css" rel="stylesheet">

    <link href="<?php echo BASE_URL; ?>assets/css/icons.css" rel="stylesheet">
    <title><?php echo TITLE . ' - ' . $data['title']; ?></title>
</head>

<body class="bg-login">


    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Periodo de prueba terminado</p>
        </div>
    </div>

    <!-- Resto de tu contenido -->

    <!-- Agrega tus scripts JavaScript aquí -->
    <script>
        // Obtén referencias a los elementos del modal
        const modal = document.getElementById("myModal");
        const closeButton = document.getElementsByClassName("close")[0];

        // Función para mostrar el modal
        function mostrarModal() {
            modal.style.display = "block";
        }

        // Función para cerrar el modal
        function cerrarModal() {
            modal.style.display = "none";
        }

        // Evento para cerrar el modal al hacer clic en el botón de cierre
        closeButton.addEventListener("click", cerrarModal);

        // Mostrar el modal después de 1 día (86400 segundos)
        setTimeout(mostrarModal, 8 * 1); // 1 día en milisegundos
    </script>

    <!-- Code new -->
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <form method="POST" autocomplete="off" id="formulario" class="sign-in-form">
                        <div class="logo">
                            <div>
                                <img  src="<?php echo BASE_URL; ?>assets/images/logo.png" class="logo-icon" alt="logo icon">
                            </div>
                            <div>
                                <h5 style="color:black; font-size: 23px; line-height: 21px;" class="logo-text">Sistema de <br> <strong> Ventas </strong></h5>
                            </div>
                        </div>

                        <div class="heading">
                            <h2 style="line-height: 29px;">Bienvenid@ de nuevo.</h2>

                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input name="correo" id="correo" type="email" minlength="4" class="input-field" autocomplete="off" required />
                                <label for="correo">Correo electrocico</label>
                                <span id="errorCorreo" class="text-danger"></span>
                            </div>

                            <div class="input-wrap">
                                <input id="clave" name="clave" type="password" minlength="4" class="input-field" autocomplete="off" required />
                                <label for="clave">Password</label>
                                <span id="errorClave" class="text-danger"></span>
                            </div>

                            <input type="submit" class="sign-btn" />

                            <p class="text">
                                Forgotten your password or you login datails?
                                <a href="<?php echo BASE_URL . 'principal/forgot'; ?>">Get help</a> signing in
                            </p>
                        </div>
                    </form>


                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="#" class="image img-1 show" alt="" />
                        <img src="#" class="image img-2" alt="" />
                        <img src="#" class="image img-3" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>¡Gestiona tu negocio!</h2>
                                <h2>¡Vende en linea!</h2>
                                <h2>¡Toma el control!</h2>
                            </div>
                        </div>

                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Code new -->


    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/loginnew.js"></script>

    <!--plugins-->
    <script src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->

    <script src="<?php echo BASE_URL; ?>assets/js/app.js"></script>
    <script src="<?php echo BASE_URL; ?>assets/js/sweetalert2.all.min.js"></script>
    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
    <script src="<?php echo BASE_URL; ?>assets/js/modulos/login.js"></script>
</body>

</html>