<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->method)) {

    switch ($data->method) {

        case 'DepartamentosContratos':
            require_once '../class/otrosServicios.php';
            $user = new otrosServicios();
            $user->DepartamentosContratos($data->data);
            break;
        case 'insertData':
            require_once '../class/otrosServicios.php';
            $user = new otrosServicios();
            $user->insertData($data->data);
        default:
            echo 'ninguna opción valida.';
            break;

    }
} else {
    echo 'ninguna opción valida.';
}