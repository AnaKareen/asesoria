<?php
require_once __DIR__ . '/sistema.class.php';
class cita extends Sistema
{
  function getAll()
  {
    $this->connect();
    $stmt = $this->conn->prepare("SELECT c.id_cita,c.fecha_cita,c.hora_cita,c.estado,concat(p.nombre,' ',p.apellidop) as nombre_paciente ,p.id_paciente from cita c join paciente p on p.id_paciente = c.id_paciente ;");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $datos = $stmt->fetchAll();
    $this->setCount(count($datos));
    return $datos;
  }
  function getPaciente(){
    $this->connect(); // Agrega esta línea para inicializar la conexión
    $stmt = $this->conn->prepare("SELECT id_paciente, concat(nombre,' ',apellidop) as paciente from paciente ;");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $datos = $stmt->fetchAll();
    $this->setCount(count($datos));
    return $datos;
}

  function getOne($id_cita)
  {
    $this->connect();
    $stmt = $this->conn->prepare("SELECT c.id_cita,c.fecha_cita,c.hora_cita,c.estado,concat(p.nombre,' ',p.apellidop) as nombre_paciente ,p.id_paciente from cita c join paciente p on p.id_paciente = c.id_paciente WHERE id_cita = :id_cita");
    $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
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
          // Verificar que 'telefono' esté presente y no sea nulo
          if (empty($datos['telefono'])) {
              throw new Exception("El campo 'telefono' es obligatorio.");
          }
  
          try {
              $stmt = $this->conn->prepare("INSERT INTO cita(id_paciente, fecha_cita, hora_cita, estado) VALUES
               (:id_paciente, :fecha_cita, :hora_cita, :estado);");
              $stmt->bindParam(':id_paciente', $datos['id_paciente'], PDO::PARAM_INT);
              $stmt->bindParam(':fecha_cita', $datos['fecha_cita'], PDO::PARAM_STR);
              $stmt->bindParam(':hora_cita', $datos['hora_cita'], PDO::PARAM_STR);
              $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
              $stmt->execute();
              return $stmt->rowCount(); // Devuelve el número de filas afectadas
          } catch (PDOException $e) {
              // Captura la excepción y maneja el error adecuadamente
              echo 'Error: ' . $e->getMessage();
              return 0;
          }
      }
      return 0; // Devuelve 0 si la validación falla
  }
  
  function delete($id_cita)
  {
      $this->connect();
      $stmt = $this->conn->prepare("DELETE FROM cita WHERE id_cita = :id_cita;");
      $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->rowCount();
      return $result;
  }
  
  function update($id_cita, $datos)
  {
      $this->connect();
      // Verificar si la cita existe
      $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM cita WHERE id_cita = :id_cita");
      $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $cita_exists = $result['count'] > 0;
      
      if ($cita_exists) {
          // Actualizar datos de la cita
          $stmt = $this->conn->prepare("UPDATE cita SET id_paciente = :id_paciente, fecha_cita = :fecha_cita, hora_cita = :hora_cita, estado = :estado WHERE id_cita = :id_cita");
          $stmt->bindParam(':id_paciente', $datos['id_paciente'], PDO::PARAM_INT);
          $stmt->bindParam(':fecha_cita', $datos['fecha_cita'], PDO::PARAM_STR);
          $stmt->bindParam(':hora_cita', $datos['hora_cita'], PDO::PARAM_STR);
          $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
          $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->rowCount();
      } else {
          return 0;
      }
  }
  

  function validatePaciente($datos)
  {
    if (empty($datos["nombre"])) {
      return false;
    }
    return true;
  }
}
