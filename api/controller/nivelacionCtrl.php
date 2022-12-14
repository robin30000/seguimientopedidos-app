<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$data = json_decode(file_get_contents("php://input"));

if (isset($data->method)) {
    switch ($data->method) {
        case 'saveTicket':
            require_once '../class/nivelacion.php';
            $user = new nivelacion();
            $user->saveTicket($data->data);
            break;
        case 'searchIdTecnic':
            require_once '../class/nivelacion.php';
            $user = new nivelacion();
            $user->searchIdTecnic($data->data);
            break;
        case 'saveNivelation':
            require_once '../class/nivelacion.php';
            $user = new nivelacion();
            $user->saveNivelation($data->data);
            break;
        case 'en_genstion_nivelacion':
            require_once '../class/nivelacion.php';
            $user = new nivelacion();
            $user->en_genstion_nivelacion();
            break;
        case 'buscarhistoricoNivelacion':
            require_once '../class/nivelacion.php';
            $user = new nivelacion();
            $user->buscarhistoricoNivelacion($data->data);
            break;
        case 'gestionarNivelacion':
            require_once '../class/nivelacion.php';
            $user = new nivelacion();
            $user->gestionarNivelacion();
            break;
        case 'guardaNivelacion':
            require_once '../class/nivelacion.php';
            $user = new nivelacion();
            $user->guardaNivelacion($data->data);
            break;

        default:
            echo 'ninguna opción valida.';
            break;
    }
} else {
    echo 'ninguna opción valida.';
}
