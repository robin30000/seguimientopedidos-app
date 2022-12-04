<?php
require_once '../class/conection.php';

class modelUser
{
    private $_DB;

    public function __construct()
    {
        $this->_DB = new Conection();
    }

    public function editarUsuario($data)
    {

        try {

            $login          = $data->datosEdicion;
            $id             = $login['ID'];
            $usuarioid      = $login['LOGIN'];
            $nombre         = $login['NOMBRE'];
            $identificacion = $login['IDENTIFICACION'];
            $perfil         = $login['perfil'];
            $password       = $login['PASSWORD'];

            $stmt = $this->_DB->prepare("update usuarios
                                                set nombre         = :nombre,
                                                    identificacion = :dentificacion,
                                                    login          = :usuarioid,
                                                    password       = :password,
                                                    perfil         = :perfil
                                                where id = :id");
            $stmt->execute([
                ':nombre'         => $nombre,
                ':identificacion' => $identificacion,
                ':login'          => $usuarioid,
                ':password'       => $password,
                ':perfil'         => $perfil,
            ]);

            if ($stmt->rowCount() == 1) {
                $response = ['Usuario actualizado', 201];
            } else {
                $response = ['Ah ocurrido un error intentalo de nuevo', 400];
            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

        echo json_encode($response);
    }

    public function editarRegistro($data)
    {
        try {

            $user           = $_SESSION['login'];
            $datos          = $data->datosEdicion;
            $accion         = $datos['accion'];
            $tipo_pendiente = $datos['tipo_pendiente'];
            $observaciones  = $datos['observaciones'];
            $id             = $datos['id'];

            $stmt = $this->_DB->prepare("update registros
                                                set asesor         = :user,
                                                    accion         = :accion,
                                                    tipo_pendiente = :tipo_pendiente,
                                                    observaciones  = :observaciones
                                                where id = :id");
            $stmt->execute([
                ':user'           => $user,
                ':accion'         => $accion,
                ':tipo_pendiente' => $tipo_pendiente,
                ':observaciones'  => $observaciones,
                ':id'             => $id,
            ]);

            if ($stmt->rowCount() == 1) {
                $response = ['Pedido actualizado', 201];
            } else {
                $response = ['Ah ocurrido un error intentalo de nuevo', 400];
            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

        $this->_DB = null;
        echo json_encode($response);
    }

    public function CrearpedidoComercial($data)
    {

        try {

            $user          = $_SESSION['login'];
            $crearpedido   = $data['datospedidoComercial'];
            $ciudad        = $crearpedido['CIUDAD'];
            $estado        = $crearpedido['ESTADO'];
            $gestion       = $crearpedido['GESTION'];
            $observaciones = $crearpedido['OBSERVACIONES'];
            $pedido_actual = $crearpedido['PEDIDO_ACTUAL'];
            $pedido_nuevo  = $crearpedido['PEDIDO_NUEVO'];
            $clasificacion = $crearpedido['CLASIFICACION'];

            $stmt = $this->_DB->prepare("INSERT INTO registros_comercial (LOGIN_ASESOR,
                                                 PEDIDO_ACTUAL,
                                                 PEDIDO_NUEVO,
                                                 CIUDAD,
                                                 GESTION, CLASIFICACION, ESTADO, OBSERVACIONES)
                                                values (:user,
                                                        :pedido_actual,
                                                        :pedido_nuevo,
                                                        :ciudad,
                                                        :gestion, :clasificacion, :estado, :observaciones)");

            $stmt->execute([
                ':user'          => $user,
                ':pedido_actual' => $pedido_actual,
                ':pedido_nuevo'  => $pedido_nuevo,
                ':ciudad'        => $ciudad,
                ':gestion'       => $gestion,
                ':clasificacion' => $clasificacion,
                ':estado'        => $estado,
                ':observaciones' => $observaciones,
            ]);

            if ($stmt->rowCount() == 1) {
                $response = ['Usuario creado', 201];
            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        $this->_DB = null;
        echo json_encode($response);

    }

    public function guardarPlan($data)
    {

        try {
            $login       = $_SESSION['login'];
            $user        = $login['LOGIN'];
            $planNPS     = $data->datosPlan;
            $responsable = $planNPS['responsable'];
            $regional    = $planNPS['regional'];
            $plan        = $planNPS['plan'];

            $stmt = $this->_DB->prepare("INSERT INTO npsPlanTrabajo (responsable,
                                                regional,
                                                observaciones, usuario_carga)
                                                values (:responsable,
                                                        :regional,
                                                        :plan,
                                                        :user)");
            $stmt->execute([
                ':responsable' => $responsable,
                ':regional'    => $regional,
                ':plan'        => $plan,
                ':user'        => $user,
            ]);

            if ($stmt->rowCount() == 1) {
                $response = ['Usuario creado', 201];
            } else {
                $response = ['Ah ocurrido un error intentalo de nuevo'];
            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

        $this->_DB = null;
        echo json_encode($response);

    }

    public function CrearpedidoOffline($data)
    {
        try {

            $user          = $_SESSION['login'];
            $crearpedido   = $data['datospedidoOffline'];
            $login_asesor  = $crearpedido['LOGIN_ASESOR'];
            $pedido        = $crearpedido['PEDIDO'];
            $proceso       = $crearpedido['PROCESO'];
            $producto      = $crearpedido['PRODUCTO'];
            $accion        = $crearpedido['ACCION'];
            $actividad     = $crearpedido['ACTIVIDAD'];
            $actividad2    = $crearpedido['ACTIVIDAD2'];
            $observaciones = $crearpedido['OBSERVACIONES'];
            $observaciones = str_replace("\n", "/", $observaciones);

            $stmt = $this->_DB->prepare("INSERT INTO registros_offline (LOGIN_ASESOR_OFF,
                                                   LOGIN_ASESOR,
                                                   PEDIDO,
                                                   PROCESO,
                                                   PRODUCTO, ACCION, ACTIVIDAD, ACTIVIDAD2, OBSERVACIONES)
                                                values (:user,
                                                        :login_asesor,
                                                        :pedido,
                                                        :proceso,
                                                        :producto, :accion, :actividad, :actividad2, :observaciones)");
            $stmt->execute([
                ':user'          => $user,
                ':login_asesor'  => $login_asesor,
                ':pedido'        => $pedido,
                ':proceso'       => $proceso,
                ':producto'      => $producto,
                ':accion'        => $accion,
                ':actividad'     => $actividad,
                ':actividad2'    => $actividad2,
                ':observaciones' => $observaciones,
            ]);

            if ($stmt->rowCount() == 1) {
                $response = ['Usuario creado', 201];
            } else {
                $response = ['Ah ocurrido un error intentalo nuevamente', 400];
            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        $this->_DB = null;
        echo json_encode($response);
    }

    public function ingresarPedidoAsesor($params)
    {
        try {

            $idcambioequipo   = $params['idcambioequipo'];
            $duracion_llamada = $params['duracion_llamada'];
            $crearpedido      = $params['datospedido'];
            $user             = $_SESSION['login'];
            /* $plantilla = $params['plantilla'];
            $datosClick = $params['datosClick'];
            $id_llamada = $crearpedido['id_llamada'];
            $proceso = $crearpedido['proceso'];
            $accion = $crearpedido['accion'];
            $subaccion = $crearpedido['subAccion'];
            $observaciones = $crearpedido['observaciones'];
            $cod_familiar = $crearpedido['cod_familiar'];
            $prueba_integra = $crearpedido['prueba_integra'];
            $telefonia_tdm = $crearpedido['telefonia_tdm'];
            $telev_hfc = $crearpedido['telev_hfc'];
            $iptv = $crearpedido['iptv'];
            $internet = $crearpedido['internet'];
            $toip = $crearpedido['toip'];
            $smartPlay = $crearpedido['smartPlay'];
            $observaciones = $crearpedido['observaciones'];
            $observaciones = str_replace("\n", "/", $observaciones);
            $observaciones = str_replace("'", " ", $observaciones);
            $pruebaSMNET = $crearpedido['pruebaSMNET'];
            $UNESourceSystem = $crearpedido['UNESourceSystem'];
            $codigo = $crearpedido['pendiente'];
            $tipointeraccion = $crearpedido['interaccion'];
            $diagnostico = $crearpedido['diagnostico']; */

            $plantilla       = (isset($params['plantilla'])) ? $params['plantilla'] : '';
            $datosClick      = (isset($params['datosClick'])) ? $params['datosClick'] : '';
            $id_llamada      = (isset($crearpedido['id_llamada'])) ? $crearpedido['id_llamada'] : '';
            $proceso         = (isset($crearpedido['proceso'])) ? $crearpedido['proceso'] : '';
            $accion          = (isset($crearpedido['accion'])) ? $crearpedido['accion'] : '';
            $subaccion       = (isset($crearpedido['subAccion'])) ? $crearpedido['subAccion'] : '';
            $observaciones   = (isset($crearpedido['observaciones'])) ? $crearpedido['observaciones'] : '';
            $cod_familiar    = (isset($crearpedido['cod_familiar'])) ? $crearpedido['cod_familiar'] : '';
            $prueba_integra  = (isset($crearpedido['prueba_integra'])) ? $crearpedido['prueba_integra'] : '';
            $telefonia_tdm   = (isset($crearpedido['telefonia_tdm'])) ? $crearpedido['telefonia_tdm'] : '';
            $telev_hfc       = (isset($crearpedido['telev_hfc'])) ? $crearpedido['telev_hfc'] : '';
            $iptv            = (isset($crearpedido['iptv'])) ? $crearpedido['iptv'] : '';
            $internet        = (isset($crearpedido['internet'])) ? $crearpedido['internet'] : '';
            $toip            = (isset($crearpedido['toip'])) ? $crearpedido['toip'] : '';
            $smartPlay       = (isset($crearpedido['smartPlay'])) ? $crearpedido['smartPlay'] : '';
            $observaciones   = (isset($crearpedido['observaciones'])) ? $crearpedido['observaciones'] : '';
            $observaciones   = str_replace("\n", "/", $observaciones);
            $observaciones   = str_replace("'", " ", $observaciones);
            $pruebaSMNET     = (isset($crearpedido['pruebaSMNET'])) ? $crearpedido['pruebaSMNET'] : '';
            $UNESourceSystem = (isset($crearpedido['UNESourceSystem'])) ? $crearpedido['UNESourceSystem'] : '';
            $codigo          = (isset($crearpedido['pendiente'])) ? $crearpedido['pendiente'] : '';
            $tipointeraccion = (isset($crearpedido['interaccion'])) ? $crearpedido['interaccion'] : '';
            $diagnostico     = (isset($crearpedido['diagnostico'])) ? $crearpedido['diagnostico'] : '';

            $clienteContestaLlamada = (isset($crearpedido['clienteContestaLlamada'])) ? $crearpedido['clienteContestaLlamada'] : '';
            $razonNoInstalacion     = (isset($crearpedido['razonNoInstalacion'])) ? $crearpedido['razonNoInstalacion'] : '';
            $tecnicoVivienda        = (isset($crearpedido['tecnicoVivienda'])) ? $crearpedido['tecnicoVivienda'] : '';
            $conocimientoAgenda     = (isset($crearpedido['conocimientoAgenda'])) ? $crearpedido['conocimientoAgenda'] : '';

            if ($clienteContestaLlamada != '') {
                $observaciones = '¿Técnico esta en la vivienda?: ' . $tecnicoVivienda . '||¿Tenia conocimiento de la agenda?: ' . $conocimientoAgenda . '||¿cliente contesta la llamada?: ' . $clienteContestaLlamada . '||¿Nos podría indicar por que no se puede instalar los servicios?: ' . $razonNoInstalacion . '||' . $observaciones;
            }

            if ($tipointeraccion != 'llamada') {
                $id_llamada = '';
            }

            if ($datosClick['pEDIDO_UNE'] == "" || $datosClick['pEDIDO_UNE'] == "TIMEOUT") {

                $tecnico              = $crearpedido['tecnico'];
                $despacho             = $crearpedido['CIUDAD'];
                $producto             = $crearpedido['producto'];
                $pedido               = $params['pedido'];
                $nombre_de_la_empresa = $params['empresa'];

            } else {
                if ($datosClick['uNEProvisioner'] == "EMT") {
                    $nombre_de_la_empresa = "EMTELCO";
                } elseif ($datosClick['uNEProvisioner'] == "RYE") {
                    $nombre_de_la_empresa = "REDES Y EDIFICACIONES";
                } elseif ($datosClick['uNEProvisioner'] == "EIA") {
                    $nombre_de_la_empresa = "ENERGIA INTEGRAL ANDINA";
                } else {
                    $nombre_de_la_empresa = $datosClick['uNEProvisioner'];
                }
                $producto = $datosClick['uNETecnologias'];
                $tecnico  = $datosClick['engineerID'];
                $despacho = $datosClick['uNEMunicipio'];
                $pedido   = $datosClick['pEDIDO_UNE'];
            }

            if (
                ($proceso == 'Reparaciones' && $accion == 'Cambio Equipo') ||
                ($proceso == 'Instalaciones' && $accion == 'Aprovisionar') ||
                ($proceso == 'Instalaciones' && $accion == 'Contingencia') ||
                ($proceso == 'Reparaciones' && $accion == 'Aprovisionar') ||
                ($proceso == 'Reparaciones' && $accion == 'Contingencia')
            ) {
                $patron        = [",", ", "];
                $patronreplace = ["|", "|"];
                $macEntra      = str_replace($patron, $patronreplace, trim(strtoupper($crearpedido['macEntra'])));
                $macSale       = str_replace($patron, $patronreplace, trim(strtoupper($crearpedido['macSale'])));

                $stmt = $this->_DB->prepare("INSERT INTO cambio_equipos (pedido, hfc_equipo_sale, hfc_equipo_entra)
                                                    VALUES (:pedido, :macSale, :macEntra)");
                $stmt->execute([
                    ':pedido'   => $pedido,
                    ':macSale'  => $macSale,
                    ':macEntra' => $macEntra,
                ]);
                if (!$stmt->rowCount()) {
                    echo 'No ingreso';
                }
            }

            if ($proceso == 'Reparaciones') {

                $stmt = $this->_DB->prepare("INSERT INTO registros (pedido, id_tecnico, empresa, asesor, observaciones,
                       accion, tipo_pendiente, proceso, producto, duracion, llamada_id, prueba_integrada, codigo_familiar,
                       smartplay, toip, inter, iptv, telev, totdm, plantilla, despacho, id_cambio_equipo, pruebaSmnet,
                       UNESourceSystem, pendiente, diagnostico)
                        VALUES (:pedido, :tecnico, :nombre_de_la_empresa,
                                upper(:user), :observaciones, :accion, :subaccion, :proceso, :producto,
                                :duracion_llamada, :id_llamada, :prueba_integra, :cod_familiar, :smartPlay, :toip, :internet,
                                :iptv, :telev_hfc, :telefonia_tdm, :plantilla, :despacho, :idcambioequipo, :pruebaSMNET,
                                :UNESourceSystem, :codigo, :diagnostico)");

                $stmt->execute([
                    ':pedido'               => $pedido,
                    ':tecnico'              => $tecnico,
                    ':nombre_de_la_empresa' => $nombre_de_la_empresa,
                    ':user'                 => $user,
                    ':observaciones'        => $observaciones,
                    ':accion'               => $accion,
                    ':subaccion'            => $subaccion,
                    ':proceso'              => $proceso,
                    ':producto'             => $producto,
                    ':duracion_llamada'     => $duracion_llamada,
                    ':id_llamada'           => $id_llamada,
                    ':prueba_integra'       => $prueba_integra,
                    ':cod_familiar'         => $cod_familiar,
                    ':smartPlay'            => $smartPlay,
                    ':toip'                 => $toip,
                    ':internet'             => $internet,
                    ':iptv'                 => $iptv,
                    ':telev_hfc'            => $telev_hfc,
                    ':telefonia_tdm'        => $telefonia_tdm,
                    ':plantilla'            => $plantilla,
                    ':despacho'             => $despacho,
                    ':idcambioequipo'       => $idcambioequipo,
                    ':pruebaSMNET'          => $pruebaSMNET,
                    ':UNESourceSystem'      => $UNESourceSystem,
                    ':codigo'               => $codigo,
                    ':diagnostico'          => $diagnostico,
                ]);
                if ($stmt->rowCount() == 1) {
                    $response = ['Registro ingresado', 201];
                } else {
                    $response = ['Ah ocurrido un error intentalo de nuevo'];
                }

            } else {

                $stmt = $this->_DB->prepare("INSERT INTO registros (pedido, id_tecnico, empresa, asesor, observaciones, accion, tipo_pendiente, proceso, producto,
                       duracion, llamada_id, plantilla, despacho, pruebaSmnet,
                       UNESourceSystem, pendiente, diagnostico)
                        VALUES (:pedido, :tecnico, :nombre_de_la_empresa, upper(:user), :observaciones, :accion, :subaccion, :proceso, :producto,
                                :duracion_llamada, :id_llamada, :plantilla, :despacho, :pruebaSMNET,
                                :UNESourceSystem, :codigo, :diagnostico)");

                $stmt->execute([
                    ':$pedido'               => $pedido,
                    ':$tecnico'              => $tecnico,
                    ':$nombre_de_la_empresa' => $nombre_de_la_empresa,
                    ':$user'                 => $user,
                    ':$observaciones'        => $observaciones,
                    ':$accion'               => $accion,
                    ':$subaccion'            => $subaccion,
                    ':$proceso'              => $proceso,
                    ':$producto'             => $producto,
                    ':$duracion_llamada'     => $duracion_llamada,
                    ':$id_llamada'           => $id_llamada,
                    ':$plantilla'            => $plantilla,
                    ':$despacho'             => $despacho,
                    ':$pruebaSMNET'          => $pruebaSMNET,
                    ':$UNESourceSystem'      => $UNESourceSystem,
                    ':$codigo'               => $codigo,
                    ':$diagnostico'          => $diagnostico,
                ]);

                if ($stmt->rowCount() == 1) {
                    $response = ['Registro ingresado', 201];
                } else {
                    $response = ['Ah ocurrido un error intentalo de nuevo'];
                }

            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        $this->_DB = null;
        echo json_encode($response);
    }

    public function creaUsuario($data)
    {
        try {

            $login          = $data['datosCrearUsuario'];
            $identificacion = $login['IDENTIFICACION'];
            $nombre         = $login['NOMBRE'];
            $loginUser      = $login['LOGIN'];
            $perfil         = $login['PERFIL'];
            $password       = $login['PASSWORD'];

            $stmt = $this->_DB->prepare("insert into usuarios (login, nombre, password, identificacion, perfil, gestion)
                                                values (:loginUser, :nombre, :password, :identificacion, :perfil, :gestion)");
            $stmt->execute([
                ':loginUser'      => $loginUser,
                ':nombre'         => $nombre,
                ':password'       => $password,
                ':identificacion' => $identificacion,
                ':perfil'         => $perfil,
                ':gestion'        => '',

            ]);

            if ($stmt->rowCount() == 1) {
                $response = ['Usuario creado', 201];
            } else {
                $response = ['Ah ocurrido un error intentalo nuevamente'];
            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        $this->_DB = null;
        echo json_encode($response);
    }

    public function creaTecnico($data)
    {
        try {

            $login            = $data->datosCrearTecnico;
            $identificacion   = $login['IDENTIFICACION'];
            $nombre           = $login['NOMBRE'];
            $ciudad           = $login['CIUDAD'];
            $celular          = $login['CELULAR'];
            $empresa          = $login['empresa'];
            $id_tecnico_forma = $data->id_tecnico;

            if ($identificacion == "") {
                $identificacion = $id_tecnico_forma;
            }

            $stmt = $this->_DB->prepare("INSERT INTO tecnicos (identificacion, nombre, ciudad, celular, empresa)
                                            values (:identificacion, :nombre, :ciudad, :celular, :empresa)");

            $stmt->execute([
                ':identificacion' => $identificacion,
                ':nombre'         => $nombre,
                ':ciudad'         => $ciudad,
                ':celular'        => $celular,
                ':empresa'        => $empresa,
            ]);

            if ($stmt->rowCount() == 1) {
                $response = ['Usuario creado', 201];
            } else {
                $response = ['Ah ocurrido un error intentalo nuevamente', 400];
            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        $this->_DB = null;
        echo json_encode($response);
    }

    public function listadoUsuarios($data)
    {
        try {
            $pagina    = $data->page;
            $concepto  = $data->concepto;
            $usuario   = $data->usuario;
            $parametro = "";
            //echo "selección".$buscar;
            //echo "dato".$usuario;

            //$today = date("Y-m-d");

            if ($pagina == "undefined") {
                $pagina = "0";
            } else {
                $pagina = $pagina - 1;
            }

            $pagina = $pagina * 100;

            if ($concepto == 'nombre') {
                $parametro = " a.nombre LIKE '%$usuario%'";

            } elseif ($concepto == 'login') {
                $parametro = "  a.login LIKE '%$usuario%'";
            };

            $stmt = $this->_DB->prepare("SELECT a.id,
                                                       a.nombre,
                                                       a.identificacion,
                                                       a.login,
                                                       a.perfil,
                                                       (select b.nombre from perfiles b where b.perfil = a.perfil) as PERFIL,
                                                       a.password
                                                FROM usuarios a
                                                where 1 = 1
                                                    AND ?
                                                order by a.nombre ASC
                                                limit 100 offset ?");
            $stmt->bindParam(1, $parametro);
            $stmt->bindParam(2, $pagina, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $result   = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $response = [$result, $stmt->rowCount(), 201];
            } else {
                $response = ['No se encontraron registros', 400];
            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

        $this->_DB = null;
        echo json_encode($response);
    }

    public function borrarUsuario($data)
    {
        try {
            $stmt = $this->_DB->prepare("delete from usuarios where id = :id");
            $stmt->execute([':id' => $data]);

            if ($stmt->rowCount() == 1) {
                $response = ['Usuario eliminado', 201];
            } else {
                $response = ['Ah ocurrido un erro intentalo nuevamente'];
            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }

        $this->_DB = null;
        echo json_encode($response);
    }

    public function borrarTecnico($data)
    {
        try {
            $stmt = $this->_DB->prepare("DELETE FROM  tecnicos WHERE id = :id");
            $stmt->execute([':id' => $data]);

            if ($stmt->rowCount()) {
                $response = ['Usuario eliminado', 201];
            } else {
                $response = ['Ah ocurrido un error intentalo nuevamente', 400];
            }

        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        $this->_DB = null;
        echo json_encode($response);
    }

    public function editarTecnico($data)
    {
        try {
            $login          = $data;
            $identificacion = $login['IDENTIFICACION'];
            $nombre         = $login['NOMBRE'];
            $ciudad         = $login['CIUDAD'];
            $celular        = $login['CELULAR'];
            $empresa        = $login['empresa'];
            $id             = $login['ID'];

            $stmt = $this->_DB->prepare("update tecnicos
                                                set nombre         = :nombre,
                                                    identificacion = :identificacion,
                                                    ciudad         = :ciudad,
                                                    celular        = :celular,
                                                    empresa        = :empresa
                                                where id = :id");
            $stmt->execute([
                ':nombre'         => $nombre,
                ':identificacion' => $identificacion,
                ':ciudad'         => $ciudad,
                ':celular'        => $celular,
                ':empresa'        => $empresa,
            ]);

            if ($stmt->rowCount() == 1) {
                $response = ['Usuario actualizado', 201];
            } else {
                $response = ['Ah ocurrido un error intentalo nuevamente', 400];
            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        $this->_DB = null;
        echo json_encode($response);
    }
}
