<?php
require_once __DIR__ . '/sistema.class.php';
class departamento extends Sistema
{
  function getAll()
  {
    $this->connect();
    $stmt = $this->conn->prepare("SELECT d.id_departamento,d.nombre,e.id_empresa,e.nombre as empresa from departamento d join empresa e on e.id_empresa = d.id_departamento;");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $datos = $stmt->fetchAll();
    $this->setCount(count($datos));
    return $datos;
  }
  function getOne($id_departamento)
  {
    $this->connect();
    $stmt = $this->conn->prepare("SELECT d.id_departamento,d.nombre,e.id_empresa,e.nombre as empresa from departamento d join empresa e on e.id_empresa = d.id_departamento WHERE id_departamento = :id_departamento");
    $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $datos = $stmt->fetchAll();
    if (!empty($datos)) {
      $this->setCount(count($datos)); 
      return $datos[0];
    }
    return [];
  }


  function insert($datos)
  {
      $this->connect();
      if ($this->validateCita($datos)) {
          $stmt = $this->conn->prepare("INSERT INTO departamento(id,empresa, nombre) VALUES (:id_departamento, :nombre);");
          $stmt->bindParam(':id_departamento', $datos['id_departamento'], PDO::PARAM_INT);
          $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
          $stmt->execute();
          return $stmt->rowCount(); // Devuelve el número de filas afectadas
      }
      return 0; // Devuelve 0 si la validación falla
  }
  

  
  
  function delete($id_departamento)
  {
    $this->connect();
    $stmt = $this->conn->prepare("DELETE FROM cita WHERE id_departamento = :id_departamento;");
    $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    return $result;
  }

  function update($id_departamento, $datos)
  {
      $this->connect();
      // Verificar si la cita existe
      $stmt = $this->conn->prepare("SELECT COUNT(*) AS count FROM cita WHERE id_departamento = :id_departamento");
      $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $cita_exists = $result['count'] > 0;
  
      if ($cita_exists) {
          // Actualizar datos de la cita
          $stmt = $this->conn->prepare("UPDATE departamento SET nombre = :nombre, id_empresa = :id_empresa WHERE id_departamento = :id_departamento");
        $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_INT);
        $stmt->bindParam(':id_empresa', $datos['id_empresa'], PDO::PARAM_STR);
        $stmt->bindParam(':hora_cita', $datos['hora_cita'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $datos['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':id_departamento', $id_departamento, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount(); // Devuelve el número de filas afectadas
    } else {
        return 0; // Devuelve 0 si el id del paciente no es válido
    }
  }
  
  

  function validateCita($datos)
  {
    if (empty($datos["id_departamenrto"])) {
      return false;
    }
    return true;
  }
}
