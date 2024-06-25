<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
}
?>
<?php
require_once('../bd/conexion.php');
$req = $connect->prepare("SELECT id_cita, CONCAT(p.nombre, ' - ', c.hora_cita) AS title, fecha_cita AS start, fecha_cita AS end FROM cita c INNER JOIN paciente p ON c.id_paciente = p.id_paciente");
$req->execute();
$events = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../backend/css/admin.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../../backend/img/ico.svg">

    <!-- FullCalendar -->
    <link href='../css/fullcalendar.css' rel='stylesheet' />
    <style type="text/css">
        #calendar {
            max-width: 800px;
        }

        .col-centered {
            float: none;
            margin: 0 auto;
        }
    </style>

    <title>Clínica Salud | Calendario de las citas</title>
</head>

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
                <li><a href="#" class="active">Calendario de las citas</a></li>
            </ul>

            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Calendario</h3>

                    </div>
                    <div id="calendar" class="col-centered">

                    </div>
                </div>
            </div>

        </main>
        <!-- MAIN -->
    </section>

    <!-- NAVBAR -->
    <script src="../js/jquery.min.js"></script>

    <script src="../js/script.js"></script>

    <!-- Data Tables -->
    <!-- FullCalendar -->
    <script src='../js/moment.min.js'></script>
    <script src='../js/fullcalendar/fullcalendar.min.js'></script>
    <script src='../js/fullcalendar/fullcalendar.js'></script>
    <script src='../js/fullcalendar/locale/es.js'></script>

    <script>
        $(document).ready(function() {

            $('#calendar').fullCalendar({
                header: {
                    language: 'es',
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay',

                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                select: function(start, end) {

                    $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd').modal('show');
                },
                eventRender: function(event, element) {
                    element.bind('dblclick', function() {
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #title').val(event.title);
                        $('#ModalEdit #color').val(event.color);
                        $('#ModalEdit').modal('show');
                    });
                },
                eventDrop: function(event, delta, revertFunc) { // si changement de position

                    edit(event);

                },
                eventResize: function(event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                    edit(event);

                },
                events: <?php echo json_encode($events); ?>
            });

        });
    </script>

</body>

</html>
