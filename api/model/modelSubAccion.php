<?php
require_once '../class/conection.php';

class modelSubAccion
{

    private $_BD;

    public function __construct()
    {
        $this->_BD = new Conection();
    }

    public function subacciones($data)
    {
        try {

            $proceso = $data['proceso'];
            $accion  = $data['accion'];

            $stmt = $this->_BD->prepare("SELECT DISTINCT SUBACCION
                                                FROM procesos
                                                where proceso = :proceso
                                                  and accion = :accion
                                                  and subaccion <> ''
                                                ORDER BY SUBACCION");

            $stmt->execute([':accion' => $accion, ':proceso' => $proceso]);

            if ($stmt->rowCount()) {
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response  = [$resultado, 201];
            } else {
                $response = [
                    'status' => 400,
                    'msg'    => 'Sin datos para listar',
                ];

            } // If no records "No Content" status
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        $this->_BD = null;
        echo json_encode($response);
    }
}
