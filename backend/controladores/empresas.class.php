<?php
require_once __DIR__ . '/sistema.class.php';

class Empresa extends Sistema
{
    function getAll()
    {
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_empresa, nombre, RFC, telefono FROM empresa;");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $datos = $stmt->fetchAll();
        $this->setCount(count($datos));
        return $datos;
    }

    function getOne($id_empresa)
    {
        $this->connect();
        $stmt = $this->conn->prepare("SELECT id_empresa, nombre, RFC, telefono FROM empresa WHERE id_empresa = :id_empresa");
        $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
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
        try {
            // Log de los datos recibidos
            error_log("Datos recibidos para insertar: " . json_encode($datos));
            
            // Verificar que los datos no estén nulos
            if (empty($datos['nombre']) || empty($datos['RFC']) || empty($datos['telefono'])) {
                throw new Exception("Los campos 'nombre', 'RFC' y 'telefono' son obligatorios.");
            }

            // Preparamos la sentencia de inserción
            $stmt = $this->conn->prepare("INSERT INTO empresa (nombre, RFC, telefono) VALUES (:nombre, :RFC, :telefono);");
            
            // Bind de los parámetros
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(':RFC', $datos['RFC'], PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $datos['telefono'], PDO::PARAM_STR);
            
            // Ejecutamos la sentencia
            $stmt->execute();
            
            // Retornamos el número de filas afectadas
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // Si hay algún error, lanzamos una excepción con el mensaje de error
            throw new Exception("Error al insertar en la base de datos: " . $e->getMessage());
        }
    }

    function delete($id_empresa)
    {
        $this->connect();
        $stmt = $this->conn->prepare("DELETE FROM empresa WHERE id_empresa = :id_empresa;");
        $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function update($id_empresa, $datos)
    {
        $this->connect();
        try {
            // Log de los datos recibidos
            error_log("Datos recibidos para actualizar: " . json_encode($datos));

            // Verificar que los datos no estén nulos
            if (empty($datos['nombre']) || empty($datos['RFC']) || empty($datos['telefono'])) {
                throw new Exception("Los campos 'nombre', 'RFC' y 'telefono' son obligatorios.");
            }

            // Preparamos la sentencia de actualización
            $stmt = $this->conn->prepare("UPDATE empresa SET nombre = :nombre, RFC = :RFC, telefono = :telefono WHERE id_empresa = :id_empresa");
            
            // Bind de los parámetros
            $stmt->bindParam(':nombre', $datos['nombre'], PDO::PARAM_STR);
            $stmt->bindParam(":RFC", $datos["RFC"], PDO::PARAM_STR);
            $stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
            
            // Ejecutamos la sentencia
            $stmt->execute();
            
            // Retornamos el número de filas afectadas
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // Si hay algún error, lanzamos una excepción con el mensaje de error
            throw new Exception("Error al actualizar en la base de datos: " . $e->getMessage());
        }
    }
}
