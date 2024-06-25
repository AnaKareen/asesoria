<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '\..\controladores\departamento.php';

$departamento = new departamento();
$empresas = $departamento->getAll();

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
        <?php include __DIR__.'\\..\\h&f\\nav.php'; ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/index.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="../emoresas/mostrarD.php">Listado de las departamentos</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Nueva cita</a></li>
            </ul>

            <!-- multistep form -->
            <form action="departamento.php?action=<?php echo ($action == 'UPDATE') ? 'EDIT&id_departamento=' . $datos['id_departamento'] : 'SAVE'; ?>" method="post" enctype="multipart/form-data">
                <div class="containerss">
                    <h1>Nueva departamento</h1>
                    <hr>
                    <br>
                    <label for="nombre"><b>Fecha de la cita</b></label><span class="badge-warning">*</span>
                    <input required type="text" id="nombre" name="nombre" value="<?php echo (isset($datos['nombre'])) ? $datos['nombre'] : '' ?>">
                    <br><br>
                    <label for="id_empresa"><b>Empresa</b></label><span class="badge-warning">*</span>
                    <select id="id_empresa" name="id_empresa">
                        <?php foreach ($empresas as $empresa) : ?>
                            <option value="<?php echo $empresa['id_empresa']; ?>"><?php echo $empresa['empresa']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br><br>
                    
                    <input  type="submit" value="Guardar" class="button" name="SAVE">
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
