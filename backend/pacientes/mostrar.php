<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '\..\controladores\paciente.php';

?>
<!DOCTYPE html>
<html lang="es">

<?php include_once __DIR__.'\\..\\h&f\\head.php'?>
<title>PI ASESESORIA | Listado de pacientes</title>
<body>
    <!-- SIDEBAR -->
    <?php include __DIR__ . '\\..\\h&f\\menu.php'; ?>
    <!-- SIDEBAR -->

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
                <li><a href="#" class="active">Listado de los pacientes</a></li>
            </ul>

            <a href="../controladores/paciente.php?action=CREATE" class="button">Nuevo</a>
            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Pacientes</h3>
                    </div>
                    <div class="table-responsive" style="overflow-x:auto;">
                        <table id="example" class="responsive-table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">NOMBRE</th>
                                    <th scope="col">TELEFONO</th>
                                    <th scope="col">FECHA DE NACIMIENTO</th>
                                    <th scope="col">PRIMERA VISITA</th>
                                    <th scope="col">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datos as $dato): ?>
                                    <tr>
                                        <th scope="row"><?php echo $dato['id_paciente']; ?></th>
                                        <td><?php echo $dato['nombre']; ?></td>
                                        <td><?php echo $dato['telefono']; ?></td>
                                        <td><?php echo $dato['fecha_nacimiento']; ?></td>
                                        <td><?php echo $dato['primera_visita']; ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="../controladores/paciente.php?action=UPDATE&id_paciente=<?php echo $dato['id_paciente']; ?>"
                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Actualizar</a>
                                                <a href="../controladores/paciente.php?action=DELETE&id_paciente=<?php echo $dato['id_paciente']; ?>"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>

    <!-- Inclusión de scripts y demás -->
    <script src="../../backend/js/jquery.min.js"></script>
    <script src="../../backend/js/script.js"></script>
    <!-- Data Tables -->
    <script type="text/javascript" src="../../backend/js/datatable.js"></script>
    <script type="text/javascript" src="../../backend/js/datatablebuttons.js"></script>
    <script type="text/javascript" src="../../backend/js/jszip.js"></script>
    <script type="text/javascript" src="../../backend/js/pdfmake.js"></script>
    <script type="text/javascript" src="../../backend/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonshtml5.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonsprint.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                    },
                    {
                        extend: 'excel',
                        className: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                    },
                    {
                        extend: 'pdf',
                        className: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                    },
                    {
                        extend: 'print',
                        className: 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded',
                    }
                ]
            });
        });
    </script>
</body>

</html>