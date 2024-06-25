<?php
require_once __DIR__ . '/sistema.class.php';
class psicologo extends Sistema
{
  function getAll()
  {
    $this->connect();
    $stmt = $this->conn->prepare("select id_psicologo,matricula,nombre,apellidos FROM psicologo;");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $datos = $stmt->fetchAll();
    $this->setCount(count($datos));
    return $datos;
  }
  function getOne($id_psicologo)
  {
    $this->connect();
    $stmt = $this->conn->prepare("select id_psicologo,matricula,nombre,apellidos FROM psicologo WHERE id_psicologo = :id_psicologo");
    $stmt->bindParam(':id_psicologo', $id_psicologo, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $datos = $stmt->fetchAll();
    if (!empty($datos)) {
      $this->setCount(count($datos)); // Asegúrate de que setCount esté definido o elimina esta línea si no es necesario
      return $datos[0];
    }
    return [];
  }


  function insert($datos)
  {
    $this->connect();
    if ($this->validatePaciente($datos)) {
      $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM psicologo WHERE id_psicologo = :id_psicologo");
      $stmt->bindParam(':id_psicologo', $datos['id_psicologo'], PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $paciente_exists = $result['count'] > 0;

      if (!$paciente_exists) { // Cambio aquí para asegurarnos que el psicologo no exista antes de insertar
        $stmt = $this->conn->prepare("INSERT INTO psicologo(matricula,nombre, apellidos) VALUES (:matricula,:nombre, :apellidos);");
        $stmt->bindParam(':matricula', $datos['matricula'], PDO::PARAM_STR);
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $datos['apellidos'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
      }
    }
    return 0; // Devuelve 0 si la validación falla o el
  }

  function delete($id_psicologo)
  {
    $this->connect();
    $stmt = $this->conn->prepare("DELETE FROM psicologo WHERE id_psicologo = :id_psicologo;");
    $stmt->bindParam(':id_psicologo', $id_psicologo, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    return $result;
  }

  function update($id_psicologo, $datos)
  {
      $this->connect();
      // Verificar si el psicologo existe
      $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM psicologo WHERE id_psicologo = :id_psicologo");
      $stmt->bindParam(':id_psicologo', $id_psicologo, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $paciente_exists = $result['count'] > 0;
      
      if ($paciente_exists) {
          // Actualizar datos del psicologo
          $stmt = $this->conn->prepare("UPDATE psicologo SET matricula = :matricula,nombre = :nombre, apellidos = :apellidos WHERE id_psicologo = :id_psicologo");
          $stmt->bindParam(':matricula',$datos["matricula"],PDO::PARAM_STR);
          $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
          $stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
          
          $stmt->bindParam(':id_psicologo', $id_psicologo, PDO::PARAM_INT);
          $stmt->execute();
      } else {
          return 0;
      }
      return $stmt->rowCount();
  }
  

  function validatePaciente($datos)
  {
    if (empty($datos["nombre"])) {
      return false;
    }
    return true;
  }
}
