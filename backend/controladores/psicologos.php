<?php
include __DIR__ . '\\psicologos.class.php';
$app = new Psicologo();
$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_psicologo = (isset($_GET['id_psicologo'])) ? $_GET['id_psicologo'] : null;
$datos = array();
$alert = array();
switch ($action) {
    case "DELETE":
        if ($app->delete($id_psicologo)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> psicologo eliminado correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo eliminar el psicologo';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';
        include dirname(__DIR__). '\psicologos\mostrar.php';

        break;
    case "UPDATE":
        $datos = $app->getOne($id_psicologo);
        if (isset($datos['id_psicologo'])) {
            include dirname(__DIR__). '\psicologos\nuevo.php';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se ha encontrado la psicologo especificado';
            $datos = $app->getAll();
            include dirname(__DIR__). '..\h&f\alert.php';
            include dirname(__DIR__). '\psicologos\mostrar.php';

        }
        break;
    case "CREATE":
        include 'D:\\xampp\\htdocs\\proyectofinal\\backend\\psicologos\\nuevo.php';
        break;
    case "SAVE":
        $datos = $_POST;
        if ($app->insert($datos) && isset($datos['id_psicologo'])) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> psicologo registgrado correctamente';
        } else {
            
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo registrar la psicologo';
        }
        $datos = $app->getAll();
        include __DIR__ . '/..\h&f\alert.php';
        include __DIR__.'/..\\psicologos\\mostrar.php';


        break;
    case "EDIT":
        $datos = $_POST;
        if ($app->update($id_psicologo, $datos)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> psicologo actualizada correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo actualizar la psicologo';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';

        include dirname(__DIR__). '\psicologos\mostrar.php';


        break;        
    default:
        $datos = $app->getAll();



        break;
}

