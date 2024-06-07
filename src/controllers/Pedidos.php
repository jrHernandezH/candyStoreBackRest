<?php
//TODO: Este es el controlador para pedidos
require_once 'Cors.php';
require_once '../models/Pedidos.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        getPedidos();
        break;
    case 'POST':
        setPedidos();
        break; 
    case 'DELETE':
        deletePedidos();
        break;
    case 'PUT':
        updatePedidos();
        break;
}

//? Función Funcionando (FF)
function getPedidos() {
    try {
        $usuario_id = $_GET['usuario_id'];
        $pedidos = new Pedido();

        if (isset($usuario_id)) {
            $pedidos->setUsuarioId($usuario_id);
            $resultado = $pedidos->getAllOrderCustomer();

            if ($resultado) {
                echo json_encode(array("msg" => "Pedidos encontrados", "pedidos" => $resultado));
            } else {
                echo json_encode(array("msg" => "Sin pedidos encontrados"));
            }
        } else {
            $resultado = $pedidos->getAllOrders();
            if ($resultado) {
                echo json_encode(array("msg" => "Pedidos encontrados", "pedidos" => $resultado));
            } else {
                echo json_encode(array("msg" => "Sin pedidos encontrados"));
            }
        }
    } catch (\Throwable $th) {
        error_log("Error en el controlador Pedidos: " . $th->getMessage());
        echo json_encode(array('error' => 'Error en el controlador Pedidos'));
    }
}

//? Funcion Funcionando (FF)
function setPedidos() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($data['usuario_id']) || !isset($data['direccion_envio']) || !isset($data['metodo_pago']) || !isset($data['estado'])) {
            echo json_encode(array('error' => 'Faltan datos necesarios'));
            return;
        }

        $pedido = new Pedido();
        $pedido->setUsuarioId($data['usuario_id']);
        $pedido->setDireccionEnvio($data['direccion_envio']);
        $pedido->setMetodoPago($data['metodo_pago']);
        $pedido->setEstado($data['estado']);
        
        $resultado = $pedido->registerOrder();

        if ($resultado) {
            echo json_encode(array('msg' => 'Pedido registrado con éxito'));
        } else {
            echo json_encode(array('error' => 'Error al registrar el pedido'));
        }
    } catch (\Throwable $th) {
        error_log("Error en el controlador setPedidos: " . $th->getMessage());
        echo json_encode(array('error' => 'Error en el controlador setPedidos'));
    }
}

//? Funcion Funcionando (FF)
function deletePedidos(){
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $pedido = new Pedido();

        $pedido->setId($data['id_pedido']);
        $resultado = $pedido->deleteOrder();

        if($resultado){
            echo json_encode(array("msg"=>"Producto eliminado correctamente"));
        }else{
            echo json_encode(array("msg"=>"Error al eliminar el producto"));
        }
    } catch (\Throwable $th) {
        error_log("Error en el controlador Pedidos: " . $th->getMessage());
        echo json_encode(array('error' => 'Error en el controlador Pedidos'));
    }
}

//? Función Funcionando
function updatePedidos() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            echo json_encode(array('error' => 'Faltan datos necesarios'));
            return;
        }

        $pedido = new Pedido();
        $pedido->setId($data['id']);

        $updated = false;

        if (isset($data['estado'])) {
            $pedido->setEstado($data['estado']);
            if ($pedido->updateStateOrder()) {
                $updated = true;
            }
        }

        if (isset($data['direccion_envio'])) {
            $pedido->setDireccionEnvio($data['direccion_envio']);
            if ($pedido->updateDirectionOrder()) {
                $updated = true;
            }
        }

        if ($updated) {
            echo json_encode(array('msg' => 'Pedido actualizado con éxito'));
        } else {
            echo json_encode(array('error' => 'Error al actualizar el pedido'));
        }
    } catch (\Throwable $th) {
        error_log("Error en el controlador updateOrder: " . $th->getMessage());
        echo json_encode(array('error' => 'Error en el controlador updateOrder'));
    }
}

?>