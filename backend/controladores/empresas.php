<?php
include __DIR__ . '\\empresas.class.php';
$app = new empresa();
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_empresa = (isset($_GET['id_empresa'])) ? $_GET['id_empresa'] : null;
$datos = array();
$alert = array();
switch ($action) {
    case "DELETE":
        if ($app->delete($id_empresa)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> psicologo eliminado correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo eliminar el psicologo';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';
        include dirname(__DIR__). '\empresas\mostrarE.php';
        break;
    case "UPDATE":
        $datos = $app->getOne($id_empresa);
        if (isset($datos['id_empresa'])) {
            include dirname(__DIR__). '\empresas\nuevoE.php';
        } else {
            print_r($datos);
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se ha encontrado la psicologo especificado';
            $datos = $app->getAll();
            include dirname(__DIR__). '..\h&f\alert.php';
            include dirname(__DIR__). '\empresas\mostrarE.php';

        }
        break;
    case "CREATE":
        include 'D:\\xampp\\htdocs\\proyectofinal\\backend\\empresas\\nuevoE.php';
        break;
    case "SAVE":
        $datos = $_POST;
        print_r($datos);
        if ($app->insert($datos) && isset($datos['id_empresa'])) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> psicologo registgrado correctamente';
        } else {
            
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo registrar la psicologo';
        }
        $datos = $app->getAll();
        include __DIR__ . '/..\h&f\alert.php';
        include __DIR__.'\\..\\empresas\\mostrarE.php';


        break;
    case "EDIT":
        $datos = $_POST;
        if ($app->update($id_empresa, $datos)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> psicologo actualizada correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo actualizar la psicologo';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';

        include dirname(__DIR__). '\empresas\mostrarE.php';


        break;        
    default:
        $datos = $app->getAll();



        break;
}

