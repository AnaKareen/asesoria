<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '\..\controladores\cita.php';
?>
<!DOCTYPE html>
<html lang="es">

<?php include __DIR__ . '\\..\\h&f\\head.php'; ?>
<title>PI ASESORIA | Listado de citas</title>

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
                <li><a href="#" class="active">Listado de las citas</a></li>
            </ul>
            <a href="../controladores/cita.php?action=CREATE" class="button">Nuevo</a>
            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Citas</h3>
                    </div>
                    <div class="table-responsive" style="overflow-x:auto;">

                        <?php if (count($datos) > 0): ?>
                            <table id="example" class="responsive-table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Paciente</th>
                                        <th scope="col">Fecha Cita</th>
                                        <th scope="col">Hora Cita</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datos as $dato): ?>
                                        <tr>
                                            <th scope="row"><?php echo $dato['id_cita']; ?></th>
                                            <td><?php echo $dato['nombre_paciente']; ?></td>
                                            <td><?php echo $dato['fecha_cita']; ?></td>
                                            <td><?php echo $dato['hora_cita'];?></td>
                                            <td><?php echo $dato['estado'];?></td>
                                            <td>
                                            <div class="btn-group" role="group">
                                                <a href="../controladores/cita.php?action=UPDATE&id_cita=<?php echo $dato['id_cita']; ?>"
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Actualizar</a>
                                                <a href="../controladores/cita.php?action=DELETE&id_cita=<?php echo $dato['id_cita']; ?>"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</a>
                                            </div>
                                        </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert">
                                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                <strong>Danger!</strong> No hay datos.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </main>
        <!-- MAIN -->
    </section>

    <!-- NAVBAR -->
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</body>

</html>