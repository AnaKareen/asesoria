<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '\..\controladores\psicologos.php';
?>
<!DOCTYPE html>
<html lang="es">

<?php include_once __DIR__.'\\..\\h&f\\head.php'?>
<title>PI ASESESORIA | Listado de psicologos</title>
<body>

    <!-- SIDEBAR -->
    <?php include __DIR__ . '\\..\\h&f\\menu.php'; ?>

    <!-- NAVBAR -->
    <section id="content">
        <!-- NAVBAR -->
        <?php include __DIR__ . '\\..\\h&f\\nav.php'; ?>

        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="../admin/escritorio.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Listado de los médicos</a></li>
            </ul>
            <a href="../controladores/psicologos.php?action=CREATE" class="button">Nuevo</a>
            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Psicologos</h3>
                    </div>
                    <div class="table-responsive" style="overflow-x:auto;">

                        <?php if (count($datos) > 0): ?>
                            <table id="example" class="responsive-table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">MATRICULA</th>
                                        <th scope="col">NOMBRE</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datos as $dato): ?>
                                        <tr>
                                            <th scope="row"><?php echo $dato['id_psicologo']; ?></th>
                                            <td><?php echo $dato['matricula']; ?></td>
                                            <td><?php echo $dato['nombre']; ?></td>
                                            <td>
                                            <div class="btn-group" role="group">
                                                <a href="../controladores/psicologos.php?action=UPDATE&id_psicologo=<?php echo $dato['id_psicologo']; ?>"
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Actualizar</a>
                                                <a href="../controladores/psicologos.php?action=DELETE&id_psicologo=<?php echo $dato['id_psicologo']; ?>"
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
    </section>
    <?php include_once '../../backend/php/delete_doctor.php' ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
