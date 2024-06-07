<?php
require_once 'Cors.php';
require_once '../models/Detalles.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        getDetalle();
        break;
    case 'POST':
        setDetalle();
        break; 
    case 'DELETE':
        deleteDetalle();
        break;
    case 'PUT':
        updateDetalle();
        break;
}

//? Funcion para obtener los detalles del pedido
function getDetalle(){
    try {
        $pedido_id = $_GET['pedido_id'];

        if (!isset($pedido_id)) {
            echo json_encode(array("error" => "ID no proporcionado"));
            return;
        }
        $detalle = new Detalle();
        $detalle->setPedidoId($pedido_id);
        $resultado = $detalle->obtenerDetalles();

        if($resultado){
            echo json_encode(array('msg'=>"Detalles encontrado", 'Detalles'=> $resultado));
        }else{
            echo json_encode(array('msg'=>"Detalles no encontrados"));
        }

    } catch (\Throwable $th) {
        error_log("Error en el controlador getDetalle: " . $th->getMessage());
            throw new Exception("Error en el controlador getDetalle:" . $th->getMessage());
    }
}

//? Funcion para  registrar los detalles del pedido
function setDetalle(){
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['pedido_id']) || !isset($data['producto_id']) || !isset($data['cantidad']) || !isset($data['precio_unitario']) || !isset($data['subtotal'])) {
            echo json_encode(array('error' => 'Faltan datos necesarios'));
            return;
        }

        $detallePedido = new Detalle();
        $detallePedido->setPedidoId($data['pedido_id']);
        $detallePedido->setProductoId($data['producto_id']);
        $detallePedido->setCantidad($data['cantidad']);
        $detallePedido->setPrecioUnitario($data['precio_unitario']);
        $detallePedido->setSubtotal($data['subtotal']);

        $resultado = $detallePedido->registrarDetallePedido();

        if ($resultado) {
            echo json_encode(array('msg' => 'Detalle del pedido registrado con éxito'));
        } else {
            echo json_encode(array('error' => 'Error al registrar el detalle del pedido'));
        }
    } catch (\Throwable $th) {
        error_log("Error en el controlador setDetallePedido: " . $th->getMessage());
        echo json_encode(array('error' => 'Error en el controlador setDetallePedido: ' . $th->getMessage()));
    }
}

//? Function para actualizar los detalles del pedido
function updateDetalle(){
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id']) || !isset($data['subtotal'])) {
            echo json_encode(array('error' => 'Faltan datos necesarios'));
            return;
        }

        $detallePedido = new Detalle();
        $detallePedido->setId($data['id']);
        $detallePedido->setSubtotal($data['subtotal']);

        $resultado = $detallePedido->actualizarSubtotalDetallePedido();

        if ($resultado) {
            echo json_encode(array('msg' => 'Subtotal del detalle del pedido actualizado con éxito'));
        } else {
            echo json_encode(array('error' => 'Error al actualizar el subtotal del detalle del pedido'));
        }
    } catch (\Throwable $th) {
        error_log("Error en el controlador updateSubtotalDetallePedido: " . $th->getMessage());
        echo json_encode(array('error' => 'Error en el controlador updateSubtotalDetallePedido: ' . $th->getMessage()));
    }
}

//? Funcion para eliminar el detalle del pedido
function deleteDetalle(){
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            echo json_encode(array('error' => 'Faltan datos necesarios'));
            return;
        }

        $detallePedido = new Detalle();
        $detallePedido->setId($data['id']);

        $resultado = $detallePedido->eliminarDetallePedido();

        if ($resultado) {
            echo json_encode(array('msg' => 'Detalle del pedido eliminado con éxito'));
        } else {
            echo json_encode(array('error' => 'Error al eliminar el detalle del pedido'));
        }
    } catch (\Throwable $th) {
        error_log("Error en el controlador deleteDetallePedido: " . $th->getMessage());
        echo json_encode(array('error' => 'Error en el controlador deleteDetallePedido: ' . $th->getMessage()));
    }
}
?>