<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '\..\controladores\cita.php';

$cita = new Cita();
$pacientes = $cita->getPaciente();

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
                <li><a href="../admin/index.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../cita/mostrar.php">Listado de las citas</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nueva cita</a></li>
            </ul>

            <!-- multistep form -->
            <form
                action="cita.php?action=<?php echo ($action == 'UPDATE') ? 'EDIT&id_cita=' . $datos['id_cita'] : 'SAVE'; ?>"
                method="post" enctype="multipart/form-data">
                <div class="containerss">
                    <h1>Nueva cita</h1>
                    <hr>
                    <br>
                    <label for="fecha_cita"><b>Fecha de la cita</b></label><span class="badge-warning">*</span>
                    <input required type="date" id="fecha_cita" name="fecha_cita"
                        value="<?php echo (isset($datos['fecha_cita'])) ? $datos['fecha_cita'] : '' ?>">
                    <br><br>
                    <label for="hora_cita"><b>Hora de la cita</b></label><span class="badge-warning">*</span>
                    <input type="time" id="hora_cita" name="hora_cita"
                        value="<?php echo (isset($datos['hora_cita'])) ? $datos['hora_cita'] : '' ?>">
                    <br><br>
                    <label for="id_paciente"><b>Paciente</b></label><span class="badge-warning">*</span>
                    <select id="id_paciente" name="id_paciente">
                        <?php foreach ($pacientes as $paciente): ?>
                            <option value="<?php echo $paciente['id_paciente']; ?>"><?php echo $paciente['paciente']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <br><br>
                    <label for="estado"><b>Estado de la cita</b></label><span class="badge-warning">*</span>
                    <select id="estado" name="estado">
                        <option value="Pagado">Pagado</option>
                        <option value="Pendiente">Pendiente</option>
                    </select>
                    <br><br>
                    <input type="submit" value="Guardar" class="button" name="SAVE">
                </div>
            </form>
        </main>
        <!-- MAIN -->
    </section>
    <script src="../../backend/js/jquery.min.js"></script>
    <!-- NAVBAR -->
    <script src="../../backend/js/script.js"></script>
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/vpat.js"></script>
    <script src="../../backend/js/patiens.js"></script>
    <script src="../../backend/js/doctor.js"></script>
    <script src="../../backend/js/laboratory.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
</body>

</html>