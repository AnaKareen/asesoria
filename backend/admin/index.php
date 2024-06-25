<link rel=" stylesheet" href="../css/admin.css" />
<link rel=" stylesheet" href="../css/fullcalendar.css" />
<link rel=" stylesheet" href="../css/fullcalendar.min.css" />

<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
}
?>
<?php
require_once ('../../backend/bd/conexion.php');
$req = $connect->prepare("SELECT id_cita, fecha_cita, hora_cita, estado, id_paciente FROM cita");
$req->execute();
$events = $req->fetchAll();
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
    <?php include __DIR__ . '\\..\\h&f\\nav.php'; ?>


        <!-- MAIN -->
        <main>
            <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
            <ul class="breadcrumbs">
                <li><a href="index.php">Home</a></li>
                <li class="divider">/</li>
                <li><a href="#" class="active">Estadisticas</a></li>
            </ul>
            <div class="info-data">
                <div class="card">
                    <div class="head">
                        <div>

                            <?php
                            $sql = "SELECT COUNT(*) total FROM paciente";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <h2><?php echo $total; ?></h2>
                            <p>Pacientes</p>
                        </div>
                        <i class='bx bx-user icon'></i>
                    </div>

                </div>
                
                <div class="card">
                    <div class="head">
                        <div>
                            <?php
                            $sql = "SELECT COUNT(*) total FROM users";
                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                            $total = $result->fetchColumn();

                            ?>
                            <h2><?php echo $total; ?></h2>
                            <p>Usuarios</p>
                        </div>
                        <i class='bx bx-user-circle icon'></i>
                    </div>

                </div>

            </div>
            <div class="data">
                <div class="content-data">
                    <div class="table-responsive" style="overflow-x:auto;">
                        <?php

                        $sentencia = $connect->prepare("SELECT * FROM psicologo ORDER BY id_psicologo DESC LIMIT 10;");
                        $sentencia->execute();
                        $data = array();
                        if ($sentencia) {
                            while ($r = $sentencia->fetchObject()) {
                                $data[] = $r;
                            }
                        }
                        ?>
                        <?php if (count($data) > 0): ?>
                            <table id="example" class="responsive-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Psicologos</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $d): ?>
                                        <tr>

                                            <td data-title="Paciente"><?php echo $d->nombre ?>&nbsp;<?php echo $d->apellidos ?>
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

                <div class="content-data">

                    <div class="table-responsive" style="overflow-x:auto;">
                        <?php

                        $sentencia = $connect->prepare("SELECT * FROM paciente ORDER BY id_paciente DESC LIMIT 10;");
                        $sentencia->execute();
                        $data = array();
                        if ($sentencia) {
                            while ($r = $sentencia->fetchObject()) {
                                $data[] = $r;
                            }
                        }
                        ?>
                        <?php if (count($data) > 0): ?>
                            <table id="example" class="responsive-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nuevos pacientes</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $d): ?>
                                        <tr>

                                            <td data-title="Paciente">
                                                <?php echo $d->nombre ?>&nbsp;<?php echo $d->apellidop ?>&nbsp;<?php echo $d->apellidom ?>
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

            <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Calendario</h3>

                    </div>
                    <div id="calendar" class="col-centered fc fc-unthemed fc-ltr">
                        <div class="fc-toolbar fc-header-toolbar">
                            <div class="fc-left">
                                <div class="fc-button-group"><button type="button"
                                        class="fc-prev-button fc-button fc-state-default fc-corner-left"><span
                                            class="fc-icon fc-icon-left-single-arrow"></span></button><button
                                        type="button"
                                        class="fc-next-button fc-button fc-state-default fc-corner-right"><span
                                            class="fc-icon fc-icon-right-single-arrow"></span></button></div><button
                                    type="button"
                                    class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right fc-state-disabled"
                                    disabled="">Hoy</button>
                            </div>
                            <div class="fc-right">
                                <div class="fc-button-group"><button type="button"
                                        class="fc-month-button fc-button fc-state-default fc-corner-left fc-state-active">Mes</button><button
                                        type="button"
                                        class="fc-basicWeek-button fc-button fc-state-default">Semana</button><button
                                        type="button"
                                        class="fc-basicDay-button fc-button fc-state-default fc-corner-right">Día</button>
                                </div>
                            </div>
                            <div class="fc-center">
                                <h2>mayo 2024</h2>
                            </div>
                            <div class="fc-clear"></div>
                        </div>
                        <div class="fc-view-container" style="">
                            <div class="fc-view fc-month-view fc-basic-view" style="">
                                <table>
                                    <thead class="fc-head">
                                        <tr>
                                            <td class="fc-head-container fc-widget-header">
                                                <div class="fc-row fc-widget-header">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th class="fc-day-header fc-widget-header fc-mon">
                                                                    <span>lun.</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-tue">
                                                                    <span>mar.</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-wed">
                                                                    <span>mié.</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-thu">
                                                                    <span>jue.</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-fri">
                                                                    <span>vie.</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-sat">
                                                                    <span>sáb.</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-sun">
                                                                    <span>dom.</span>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody class="fc-body">
                                        <tr>
                                            <td class="fc-widget-content">
                                                <div class="fc-scroller fc-day-grid-container"
                                                    style="overflow: hidden; height: 568px;">
                                                    <div class="fc-day-grid fc-unselectable">
                                                        <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                            style="height: 94px;">
                                                            <div class="fc-bg">
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-other-month fc-past"
                                                                                data-date="2024-04-29"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-other-month fc-past"
                                                                                data-date="2024-04-30"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                data-date="2024-05-01"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                data-date="2024-05-02"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-past"
                                                                                data-date="2024-05-03"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-past"
                                                                                data-date="2024-05-04"></td>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-past"
                                                                                data-date="2024-05-05"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="fc-content-skeleton">
                                                                <table>
                                                                    <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-mon fc-other-month fc-past"
                                                                                data-date="2024-04-29"><span
                                                                                    class="fc-day-number">29</span></td>
                                                                            <td class="fc-day-top fc-tue fc-other-month fc-past"
                                                                                data-date="2024-04-30"><span
                                                                                    class="fc-day-number">30</span></td>
                                                                            <td class="fc-day-top fc-wed fc-past"
                                                                                data-date="2024-05-01"><span
                                                                                    class="fc-day-number">1</span></td>
                                                                            <td class="fc-day-top fc-thu fc-past"
                                                                                data-date="2024-05-02"><span
                                                                                    class="fc-day-number">2</span></td>
                                                                            <td class="fc-day-top fc-fri fc-past"
                                                                                data-date="2024-05-03"><span
                                                                                    class="fc-day-number">3</span></td>
                                                                            <td class="fc-day-top fc-sat fc-past"
                                                                                data-date="2024-05-04"><span
                                                                                    class="fc-day-number">4</span></td>
                                                                            <td class="fc-day-top fc-sun fc-past"
                                                                                data-date="2024-05-05"><span
                                                                                    class="fc-day-number">5</span></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                            style="height: 94px;">
                                                            <div class="fc-bg">
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                data-date="2024-05-06"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-past"
                                                                                data-date="2024-05-07"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                data-date="2024-05-08"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                data-date="2024-05-09"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-past"
                                                                                data-date="2024-05-10"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-past"
                                                                                data-date="2024-05-11"></td>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-past"
                                                                                data-date="2024-05-12"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="fc-content-skeleton">
                                                                <table>
                                                                    <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-mon fc-past"
                                                                                data-date="2024-05-06"><span
                                                                                    class="fc-day-number">6</span></td>
                                                                            <td class="fc-day-top fc-tue fc-past"
                                                                                data-date="2024-05-07"><span
                                                                                    class="fc-day-number">7</span></td>
                                                                            <td class="fc-day-top fc-wed fc-past"
                                                                                data-date="2024-05-08"><span
                                                                                    class="fc-day-number">8</span></td>
                                                                            <td class="fc-day-top fc-thu fc-past"
                                                                                data-date="2024-05-09"><span
                                                                                    class="fc-day-number">9</span></td>
                                                                            <td class="fc-day-top fc-fri fc-past"
                                                                                data-date="2024-05-10"><span
                                                                                    class="fc-day-number">10</span></td>
                                                                            <td class="fc-day-top fc-sat fc-past"
                                                                                data-date="2024-05-11"><span
                                                                                    class="fc-day-number">11</span></td>
                                                                            <td class="fc-day-top fc-sun fc-past"
                                                                                data-date="2024-05-12"><span
                                                                                    class="fc-day-number">12</span></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                            style="height: 94px;">
                                                            <div class="fc-bg">
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                data-date="2024-05-13"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-past"
                                                                                data-date="2024-05-14"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                data-date="2024-05-15"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                data-date="2024-05-16"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-past"
                                                                                data-date="2024-05-17"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-past"
                                                                                data-date="2024-05-18"></td>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-past"
                                                                                data-date="2024-05-19"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="fc-content-skeleton">
                                                                <table>
                                                                    <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-mon fc-past"
                                                                                data-date="2024-05-13"><span
                                                                                    class="fc-day-number">13</span></td>
                                                                            <td class="fc-day-top fc-tue fc-past"
                                                                                data-date="2024-05-14"><span
                                                                                    class="fc-day-number">14</span></td>
                                                                            <td class="fc-day-top fc-wed fc-past"
                                                                                data-date="2024-05-15"><span
                                                                                    class="fc-day-number">15</span></td>
                                                                            <td class="fc-day-top fc-thu fc-past"
                                                                                data-date="2024-05-16"><span
                                                                                    class="fc-day-number">16</span></td>
                                                                            <td class="fc-day-top fc-fri fc-past"
                                                                                data-date="2024-05-17"><span
                                                                                    class="fc-day-number">17</span></td>
                                                                            <td class="fc-day-top fc-sat fc-past"
                                                                                data-date="2024-05-18"><span
                                                                                    class="fc-day-number">18</span></td>
                                                                            <td class="fc-day-top fc-sun fc-past"
                                                                                data-date="2024-05-19"><span
                                                                                    class="fc-day-number">19</span></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                            style="height: 94px;">
                                                            <div class="fc-bg">
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                data-date="2024-05-20"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-past"
                                                                                data-date="2024-05-21"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                data-date="2024-05-22"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                data-date="2024-05-23"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-past"
                                                                                data-date="2024-05-24"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-past"
                                                                                data-date="2024-05-25"></td>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-past"
                                                                                data-date="2024-05-26"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="fc-content-skeleton">
                                                                <table>
                                                                    <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-mon fc-past"
                                                                                data-date="2024-05-20"><span
                                                                                    class="fc-day-number">20</span></td>
                                                                            <td class="fc-day-top fc-tue fc-past"
                                                                                data-date="2024-05-21"><span
                                                                                    class="fc-day-number">21</span></td>
                                                                            <td class="fc-day-top fc-wed fc-past"
                                                                                data-date="2024-05-22"><span
                                                                                    class="fc-day-number">22</span></td>
                                                                            <td class="fc-day-top fc-thu fc-past"
                                                                                data-date="2024-05-23"><span
                                                                                    class="fc-day-number">23</span></td>
                                                                            <td class="fc-day-top fc-fri fc-past"
                                                                                data-date="2024-05-24"><span
                                                                                    class="fc-day-number">24</span></td>
                                                                            <td class="fc-day-top fc-sat fc-past"
                                                                                data-date="2024-05-25"><span
                                                                                    class="fc-day-number">25</span></td>
                                                                            <td class="fc-day-top fc-sun fc-past"
                                                                                data-date="2024-05-26"><span
                                                                                    class="fc-day-number">26</span></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                            style="height: 94px;">
                                                            <div class="fc-bg">
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                data-date="2024-05-27"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-today fc-state-highlight"
                                                                                data-date="2024-05-28"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-future"
                                                                                data-date="2024-05-29"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-future"
                                                                                data-date="2024-05-30"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-future"
                                                                                data-date="2024-05-31"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-other-month fc-future"
                                                                                data-date="2024-06-01"></td>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-other-month fc-future"
                                                                                data-date="2024-06-02"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="fc-content-skeleton">
                                                                <table>
                                                                    <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-mon fc-past"
                                                                                data-date="2024-05-27"><span
                                                                                    class="fc-day-number">27</span></td>
                                                                            <td class="fc-day-top fc-tue fc-today fc-state-highlight"
                                                                                data-date="2024-05-28"><span
                                                                                    class="fc-day-number">28</span></td>
                                                                            <td class="fc-day-top fc-wed fc-future"
                                                                                data-date="2024-05-29"><span
                                                                                    class="fc-day-number">29</span></td>
                                                                            <td class="fc-day-top fc-thu fc-future"
                                                                                data-date="2024-05-30"><span
                                                                                    class="fc-day-number">30</span></td>
                                                                            <td class="fc-day-top fc-fri fc-future"
                                                                                data-date="2024-05-31"><span
                                                                                    class="fc-day-number">31</span></td>
                                                                            <td class="fc-day-top fc-sat fc-other-month fc-future"
                                                                                data-date="2024-06-01"><span
                                                                                    class="fc-day-number">1</span></td>
                                                                            <td class="fc-day-top fc-sun fc-other-month fc-future"
                                                                                data-date="2024-06-02"><span
                                                                                    class="fc-day-number">2</span></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                            style="height: 98px;">
                                                            <div class="fc-bg">
                                                                <table>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-other-month fc-future"
                                                                                data-date="2024-06-03"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-other-month fc-future"
                                                                                data-date="2024-06-04"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-other-month fc-future"
                                                                                data-date="2024-06-05"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-other-month fc-future"
                                                                                data-date="2024-06-06"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-other-month fc-future"
                                                                                data-date="2024-06-07"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-other-month fc-future"
                                                                                data-date="2024-06-08"></td>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-other-month fc-future"
                                                                                data-date="2024-06-09"></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="fc-content-skeleton">
                                                                <table>
                                                                    <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-mon fc-other-month fc-future"
                                                                                data-date="2024-06-03"><span
                                                                                    class="fc-day-number">3</span></td>
                                                                            <td class="fc-day-top fc-tue fc-other-month fc-future"
                                                                                data-date="2024-06-04"><span
                                                                                    class="fc-day-number">4</span></td>
                                                                            <td class="fc-day-top fc-wed fc-other-month fc-future"
                                                                                data-date="2024-06-05"><span
                                                                                    class="fc-day-number">5</span></td>
                                                                            <td class="fc-day-top fc-thu fc-other-month fc-future"
                                                                                data-date="2024-06-06"><span
                                                                                    class="fc-day-number">6</span></td>
                                                                            <td class="fc-day-top fc-fri fc-other-month fc-future"
                                                                                data-date="2024-06-07"><span
                                                                                    class="fc-day-number">7</span></td>
                                                                            <td class="fc-day-top fc-sat fc-other-month fc-future"
                                                                                data-date="2024-06-08"><span
                                                                                    class="fc-day-number">8</span></td>
                                                                            <td class="fc-day-top fc-sun fc-other-month fc-future"
                                                                                data-date="2024-06-09"><span
                                                                                    class="fc-day-number">9</span></td>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </main>


        <!-- MAIN -->
    </section>
    <!-- NAVBAR -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../js/script.js"></script>

    <!-- Data Tables -->
    <script src="../vendor/datatables/dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap.min.js"></script>


    <!-- Custom Data tables -->
    <script src="../vendor/datatables/custom/custom-datatables.js"></script>
    <script src="../vendor/datatables/custom/fixedHeader.js"></script>


    <!-- FullCalendar -->
    <script src='../js/moment.min.js'></script>
    <script src='../js/fullcalendar/fullcalendar.min.js'></script>
    <script src='../js/fullcalendar/fullcalendar.js'></script>
    <script src='../js/fullcalendar/locale/es.js'></script>

    <script>
        $(document).ready(function () {

            var date = new Date();
            var yyyy = date.getFullYear().toString();
            var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
            var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

            $('#calendar').fullCalendar({
                header: {
                    language: 'es',
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay',

                },
                defaultDate: yyyy + "-" + mm + "-" + dd,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                select: function (fecha_cita, hora_cita) {

                    $('#ModalAdd #fecha_cita').val(moment(fecha_cita).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd #hora_cita').val(moment(hora_cita).format('HH:mm:ss'));
                    $('#ModalAdd').modal('show');
                },
                eventRender: function (event, element) {
                    element.bind('dblclick', function () {
                        $('#ModalEdit #id_psicologo').val(event.id_psicologo);
                        $('#ModalEdit #estado').val(event.estado);
                        $('#ModalEdit #id_paciente').val(event.id_paciente);
                        $('#ModalEdit').modal('show');
                    });
                },
                eventDrop: function (event, delta, revertFunc) { // si changement de position

                    edit(event);

                },
                eventResize: function (event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

                    edit(event);

                },
                events: [
                    <?php foreach ($events as $event):

                        $fecha_cita = explode(" ", $event['fecha_cita']);
                        $hora_cita = explode(" ", $event['hora_cita']);
                        if ($fecha_cita[1] == '00:00:00') {
                            $fecha_cita = $fecha_cita[0];
                        } else {
                            $fecha_cita = $event['fecha_cita'];
                        }
                        if ($hora_cita[1] == '00:00:00') {
                            $hora_cita = $hora_cita[0];
                        } else {
                            $hora_cita = $event['hora_cita'];
                        }
                        ?>
                    <?php endforeach; ?>
                ]
            });



        });
    </script>
</body>

</html>