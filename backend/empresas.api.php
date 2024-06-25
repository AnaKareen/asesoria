<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

$file_path = __DIR__ . '\\controladores\\empresas.class.php';

if (file_exists($file_path)) {
    include $file_path;
} else {
    echo json_encode(['error' => 'File empresa.class.php not found at ' . $file_path]);
    exit;
}

$action = (isset($_GET['action'])) ? $_GET['action'] : null;

class Api extends Empresa
{
    public function read()
    {
        $datos = $this->getAll();
        echo json_encode($datos);
    }

    public function readOne($id_empresa)
    {
        if (!is_numeric($id_empresa)) {
            echo json_encode(['mensaje' => "ID de empresa no válido"]);
            return;
        }
        $datos = $this->getOne($id_empresa);
        if ($datos) {
            echo json_encode($datos);
        } else {
            echo json_encode(['mensaje' => "No se ha encontrado la empresa especificada"]);
        }
    }

    public function deleteOne($id_empresa)
    {
        if (!is_numeric($id_empresa)) {
            echo json_encode(['mensaje' => "ID de empresa no válido"]);
            return;
        }
        $filas = $this->delete($id_empresa);
        if ($filas) {
            echo json_encode(['mensaje' => "La empresa se ha eliminado"]);
        } else {
            echo json_encode(['mensaje' => "No se pudo eliminar la empresa"]);
        }
    }

    public function create($datos)
    {
        $requiredFields = ['id_empresa', 'nombre', 'RFC', 'telefono'];
        $missingFields = [];

        foreach ($requiredFields as $field) {
            if (!isset($datos[$field])) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            echo json_encode(['mensaje' => "Datos insuficientes para crear la empresa. Faltan: " . implode(', ', $missingFields)]);
            return;
        }

        try {
            $filas = $this->insert($datos);
            if ($filas) {
                echo json_encode(['mensaje' => "La empresa se ha añadido correctamente"]);
            } else {
                echo json_encode(['mensaje' => "No se pudo añadir la empresa"]);
            }
        } catch (Exception $e) {
            echo json_encode(['mensaje' => "Error: " . $e->getMessage()]);
        }
    }

    public function update($id_empresa, $datos)
    {
        if (!is_numeric($id_empresa)) {
            echo json_encode(['mensaje' => "ID de empresa no válido"]);
            return;
        }
        try {
            $filas = $this->update($id_empresa, $datos);
            if ($filas) {
                echo json_encode(['mensaje' => "La empresa se ha actualizado correctamente"]);
            } else {
                echo json_encode(['mensaje' => "No se pudo actualizar la empresa"]);
            }
        } catch (Exception $e) {
            echo json_encode(['mensaje' => "Error: " . $e->getMessage()]);
        }
    }
}

$app = new Api();
$input = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit; // Manejo de solicitudes preflight (CORS)
}

switch ($action) {
    case 'save':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $app->create($input);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            if (isset($input['id_empresa'])) {
                $app->update($input['id_empresa'], $input);
            } else {
                echo json_encode(['mensaje' => "ID de empresa no especificado para la actualización"]);
            }
        }
        break;
    case 'delete':
        if (isset($_GET['id_empresa'])) {
            $app->deleteOne($_GET['id_empresa']);
        } else {
            echo json_encode(['mensaje' => "ID de empresa no especificado para la eliminación"]);
        }
        break;
    case 'get':
    default:
        if (isset($_GET['id_empresa'])) {
            $app->readOne($_GET['id_empresa']);
        } else {
            $app->read();
        }
        break;
}
?>
