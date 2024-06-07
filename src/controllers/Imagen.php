<?php
//TODO: Este es el controlador para imagenes
require_once 'Cors.php';
require_once '../models/Imagen.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        getImages();
        break;
    case 'POST':
        setImages();
        break; 
}

//? Función para obtener las imágenes de un producto
function getImages() {
    try {
        if (!isset($_GET['id_producto'])) {
            echo json_encode(array("msg"=>"Falta el parámetro id_producto"));
        }

        $id_producto = intval($_GET['id_producto']);
        $db = new DB();
        $conn = $db->getConnection();
        $imagen = new ImagenProducto();

        $imagen->setProductoId($id_producto);
        $resultado = $imagen->obtenerImagenesProducto();

        if($resultado) {
            echo json_encode(['imagenes' => $resultado]);
        } else {
            echo json_encode(['msg' => 'No se encontraron imágenes']);
        }
    } catch (\Throwable $th) {
        error_log("Error en getImages: " . $th->getMessage());
        echo json_encode(['error' => 'Error en getImages']);
    }
}

//? Función para registrar una nueva imagen
function setImages() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['producto_id']) || !isset($data['imagen_url'])) {
            throw new Exception("Falta uno o más parámetros requeridos");
        }

        $producto_id = intval($data['producto_id']);
        $imagen_url = $data['imagen_url'];

        $db = new DB();
        $conn = $db->getConnection();
        $imagen = new ImagenProducto();

        $imagen->setProductoId($producto_id);
        $imagen->setImagenUrl($imagen_url);

        $resultado = $imagen->registrarImagen();

        if($resultado) {
            echo json_encode(['msg' => 'Imagen registrada correctamente']);
        } else {
            echo json_encode(['msg' => 'Error al registrar la imagen']);
        }
    } catch (\Throwable $th) {
        error_log("Error en setImages: " . $th->getMessage());
        echo json_encode(['error' => 'Error en setImages']);
    }
}
?>
