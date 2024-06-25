<?php
ob_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');
    $id = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html lang="es">

<?php include __DIR__ . '\\..\\h&f\\head.php'; ?>


<body>

    <!-- SIDEBAR -->
    <?php include __DIR__ . '\\..\\h&f\\menu.php'; ?>

    <!-- SIDEBAR -->
    <!-- NAVBAR -->
    <section id="content">

        <!-- NAVBAR -->
        <?php include __DIR__ . '\\..\\h&f\\nav.php'; ?>
        <!-- NAVBAR -->

        <!-- MAIN -->

        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../pacientes/mostrar.php">Listado de los pacientes</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nuevos pacientes</a></li>
            </ul>

            <!-- multistep form -->


            <form action="paciente.php?action=<?php echo ($action == 'UPDATE') ? 'EDIT&id_paciente=' . $datos['id_paciente'] : 'SAVE'; ?>" method="post" enctype="multipart/form-data">
                <div class="containerss">
                    <h1><?php echo ($action == 'UPDATE') ? 'Actualizar información de la paciente' : 'Agregar nueva paciente'; ?></h1>
                    <div class="alert-danger">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>Importante!</strong> Es importante rellenar los campos con &nbsp;<span
                            class="badge-warning">*</span>
                    </div>
                    <hr>

                    <label for="psw"><b>Nombre del paciente</b></label><span class="badge-warning">*</span>
                    <input type="text" class="form-control" id="nombre" placeholder="ejm: Juan Raul" name="nombre" value="<?php echo (isset($datos['nombre'])) ? $datos['nombre'] : '' ?>">

                    <label for="psw"><b>Apellido paterno del paciente</b></label><span class="badge-warning">*</span>
                    <input type="text" class="form-control" id="apellidop" placeholder="ejm: Ramirez " name="apellidop" value="<?php echo (isset($datos['apellidop'])) ? $datos['apellidop'] : '' ?>">

                    <label for="psw"><b>Apellido materno del paciente</b></label><span class="badge-warning">*</span>
                    <input type="text" class="form-control" id="apellidom" placeholder="ejm: Gonzalez" name="apellidom" value="<?php echo (isset($datos['apellidom'])) ? $datos['apellidom'] : '' ?>">


                    <label for="psw"><b>Teléfono</b></label><span class="badge-warning">*</span>
                    <input type="text" class="form-control" id="telefono" placeholder="ejm: 4613132029" name="telefono" value="<?php echo (isset($datos['telefono'])) ? $datos['telefono'] : '' ?>">

                    <label for="psw"><b>Fecha de nacimiento</b></label><span class="badge-warning">*</span>
                    <input type="date" class="form-control" id="fecha_nacimiento" placeholder="ejm: 25/03/1988" name="fecha_nacimiento" value="<?php echo (isset($datos['fecha_nacimiento'])) ? $datos['fecha_nacimiento'] : '' ?>">

                    <label for="psw"><b>Primera Visita</b></label><span class="badge-warning">*</span>
                    <input type="date" class="form-control" id="primera_visita" placeholder="ejm: 31-05-2023" name="primera_visita" value="<?php echo (isset($datos['primera_visita'])) ? $datos['primera_visita'] : '' ?>">

                    

                    <hr>

                    <input  type="submit" value="Guardar" class="button" name="SAVE">
                </div>

            </form>

        </main>
        <!-- MAIN -->
    </section>
    <script src="../../backend/js/jquery.min.js"></script>
    <?php include_once '../controladores/paciente.class.php' ?>

    <!-- NAVBAR -->

    <script src="../../backend/js/script.js"></script>
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/vpat.js"></script>


    <script type="text/javascript">
        let popUp = document.getElementById("cookiePopup");
        //When user clicks the accept button
        document.getElementById("acceptCookie").addEventListener("click", () => {
            //Create date object
            let d = new Date();
            //Increment the current time by 1 minute (cookie will expire after 1 minute)
            d.setMinutes(2 + d.getMinutes());
            //Create Cookie withname = myCookieName, value = thisIsMyCookie and expiry time=1 minute
            document.cookie = "myCookieName=thisIsMyCookie; expires = " + d + ";";
            //Hide the popup
            popUp.classList.add("hide");
            popUp.classList.remove("shows");
        });
        //Check if cookie is already present
        const checkCookie = () => {
            //Read the cookie and split on "="
            let input = document.cookie.split("=");
            //Check for our cookie
            if (input[0] == "myCookieName") {
                //Hide the popup
                popUp.classList.add("hide");
                popUp.classList.remove("shows");
            } else {
                //Show the popup
                popUp.classList.add("shows");
                popUp.classList.remove("hide");
            }
        };
        //Check if cookie exists when page loads
        window.onload = () => {
            setTimeout(() => {
                checkCookie();
            }, 2000);
        };
    </script>

</body>

</html>