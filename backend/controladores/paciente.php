<?php
include __DIR__ . '\\paciente.class.php';
$app = new Paciente();
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_paciente = (isset($_GET['id_paciente'])) ? $_GET['id_paciente'] : null;
$datos = array();
$alert = array();
switch ($action) {
    case "DELETE":
        if ($app->delete($id_paciente)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> paciente eliminado correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo eliminar el paciente';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';
        include dirname(__DIR__). '\pacientes\mostrar.php';

        break;
    case "UPDATE":
        $datos = $app->getOne($id_paciente);
        if (isset($datos['id_paciente'])) {
            include dirname(__DIR__). '\pacientes\nuevo.php';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se ha encontrado la paciente especificado';
            $datos = $app->getAll();
            include dirname(__DIR__). '..\h&f\alert.php';
            include dirname(__DIR__). '\pacientes\mostrar.php';

        }
        break;
    case "CREATE":
        include dirname(__DIR__). '\pacientes\nuevo.php';
        break;
    case "SAVE":
        $datos = $_POST;
        if ($app->insert($datos) && isset($datos['id_paciente'])) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> paciente registgrado correctamente';
        } else {
            
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo registrar la paciente';
        }
        $datos = $app->getAll();
        include __DIR__ . '/..\h&f\alert.php';
        include __DIR__.'/..\\pacientes\\mostrar.php';


        break;
    case "EDIT":
        $datos = $_POST;
        if ($app->update($id_paciente, $datos)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> paciente actualizada correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo actualizar la paciente';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';
        include dirname(__DIR__). '\pacientes\mostrar.php';
        break;        
    default:
        $datos = $app->getAll();



        break;
}

