<?php
require_once __DIR__ . '/sistema.class.php';
class Paciente extends Sistema
{
  function getAll()
  {
    $this->connect();
    $stmt = $this->conn->prepare("select id_paciente, concat(nombre,' ',apellidop,' ',apellidom)as nombre, telefono, fecha_nacimiento,primera_visita FROM paciente;");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $datos = $stmt->fetchAll();
    $this->setCount(count($datos));
    return $datos;
  }
  function getOne($id_paciente)
  {
    $this->connect();
    $stmt = $this->conn->prepare("select id_paciente,nombre,apellidop,apellidom, telefono, fecha_nacimiento,primera_visita FROM paciente WHERE id_paciente = :id_paciente");
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
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
      $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM paciente WHERE id_paciente = :id_paciente");
      $stmt->bindParam(':id_paciente', $datos['id_paciente'], PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $paciente_exists = $result['count'] > 0;

      if (!$paciente_exists) { // Cambio aquí para asegurarnos que el paciente no exista antes de insertar
        $stmt = $this->conn->prepare("INSERT INTO paciente(nombre, apellidop, apellidom, telefono, fecha_nacimiento, primera_visita) VALUES (:nombre, :apellidop, :apellidom, :telefono, :fecha_nacimiento, :primera_visita);");
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
        $stmt->bindParam(':apellidop', $datos['apellidop'], PDO::PARAM_STR);
        $stmt->bindParam(':apellidom', $datos['apellidom'], PDO::PARAM_STR); // Cambio de tipo de dato aquí
        $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);
        $stmt->bindParam(':fecha_nacimiento', $datos['fecha_nacimiento'], PDO::PARAM_STR); // Corregido typo
        $stmt->bindParam(':primera_visita', $datos['primera_visita'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
      }
    }
    return 0; // Devuelve 0 si la validación falla o el
  }

  function delete($id_paciente)
  {
    $this->connect();
    $stmt = $this->conn->prepare("DELETE FROM paciente WHERE id_paciente = :id_paciente;");
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    return $result;
  }

  function update($id_paciente, $datos)
  {
      $this->connect();
      // Verificar si el paciente existe
      $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM paciente WHERE id_paciente = :id_paciente");
      $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $paciente_exists = $result['count'] > 0;
      
      if ($paciente_exists) {
          // Actualizar datos del paciente
          $stmt = $this->conn->prepare("UPDATE paciente SET nombre = :nombre, apellidop = :apellidop, apellidom = :apellidom, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento, primera_visita = :primera_visita WHERE id_paciente = :id_paciente");
          
          $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
          $stmt->bindParam(":apellidop", $datos["apellidop"], PDO::PARAM_STR);
          $stmt->bindParam(":apellidom", $datos["apellidom"], PDO::PARAM_STR);
          $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
          $stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
          $stmt->bindParam(":primera_visita", $datos["primera_visita"], PDO::PARAM_STR);
          $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
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
