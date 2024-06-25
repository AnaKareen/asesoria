<?php
include __DIR__ . '\\cita.class.php';
$app = new Cita();
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_cita = (isset($_GET['id_cita'])) ? $_GET['id_cita'] : null;
$datos = array();
$alert = array();
switch ($action) {
    case "DELETE":
        if ($app->delete($id_cita)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> cita eliminado correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo eliminar el cita';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';
        include dirname(__DIR__). '\cita\mostrar.php';

        break;
    case "UPDATE":
        $datos = $app->getOne($id_cita);
        if (isset($datos['id_cita'])) {
            include dirname(__DIR__). '\cita\nuevo.php';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se ha encontrado la cita especificado';
            $datos = $app->getAll();
            include dirname(__DIR__). '..\h&f\alert.php';
            include dirname(__DIR__). '\cita\mostrar.php';

        }
        break;
        
        case "CREATE":
            include dirname(__DIR__). '\cita\nuevo.php';
            break;
        case "SAVE":
            $datos = $_POST;
            print_r($_POST);
            if ($app->insert($datos) && isset($datos['id_paciente'])) {
                $alert['type'] = 'success';
                $alert['message'] = '<i class="fa-solid fa-circle-check"></i> paciente registgrado correctamente';
                
            } else {
                
                $alert['type'] = 'danger';
                $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo registrar la paciente';
            }
            $datos = $app->getAll();
            include __DIR__ . '/..\h&f\alert.php';
            include __DIR__.'/..\\cita\\mostrar.php';
    
    
            break;
        
    case "EDIT":
        $datos = $_POST;
        if ($app->update($id_cita, $datos)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> cita actualizada correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo actualizar la cita';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';

        include dirname(__DIR__). '\cita\mostrar.php';


        break;        
    default:
        $datos = $app->getAll();



        break;
}

