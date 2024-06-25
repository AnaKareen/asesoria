<?php
include __DIR__ . '\\departamento.class.php';
$app = new departamento(); // Renombra la instancia de acuerdo a tu lógica

$action = (isset($_GET['action'])) ? $_GET['action'] : null;
$id_empresa = (isset($_GET['id_empresa'])) ? $_GET['id_empresa'] : null;
$datos = array();
$alert = array();

switch ($action) {
    case "DELETE":
        if ($app->delete($id_empresa)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> Empresa eliminada correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo eliminar la empresa';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';
        include dirname(__DIR__). '\empresas\mostrarD.php';
        break;

    case "UPDATE":
        $datos = $app->getOne($id_empresa);
        if (!empty($datos)) {
            include dirname(__DIR__). '\empresas\nuevoE.php';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se ha encontrado la empresa especificada';
            $datos = $app->getAll();
            include dirname(__DIR__). '..\h&f\alert.php';
            include dirname(__DIR__). '\empresas\mostrarD.php';
        }
        break;

    case "CREATE":
        include 'D:\\xampp\\htdocs\\proyectofinal\\backend\\empresas\\nuevoD.php'; // Ajusta la ruta según tu estructura de archivos
        break;

    case "SAVE":
        $datos = $_POST;
        if ($app->insert($datos)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> Empresa registrada correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo registrar la empresa';
        }
        $datos = $app->getAll();
        include __DIR__ . '/..\h&f\alert.php';
        include __DIR__ . '\..\empresas\mostrarD.php';
        break;

    case "EDIT":
        $datos = $_POST;
        if ($app->update($id_empresa, $datos)) {
            $alert['type'] = 'success';
            $alert['message'] = '<i class="fa-solid fa-circle-check"></i> Empresa actualizada correctamente';
        } else {
            $alert['type'] = 'danger';
            $alert['message'] = '<i class="fa-solid fa-circle-xmark"></i> No se pudo actualizar la empresa';
        }
        $datos = $app->getAll();
        include dirname(__DIR__). '..\h&f\alert.php';
        include dirname(__DIR__). '\empresas\mostrarD.php';
        break;

    default:
        $datos = $app->getAll();
        // Incluir aquí cualquier otra lógica que necesites para la página de inicio
        break;
}
