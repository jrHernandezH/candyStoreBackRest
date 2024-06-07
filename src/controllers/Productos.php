<?php
//TODO: Este es el controlador de Productos
require_once 'Cors.php';
require_once '../models/Productos.php';
require_once '../models/Imagen.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        getProducts();
    break;
    case 'POST':
        setProducts();
    break;
    case 'PUT':
        updateProducts();
    break;
    case 'DELETE':
        deleteProducts();
    break;
}

//? Funcion Funcionando (FF)
function getProducts(){
    try {
        $producto = new Producto();
        $imagen = new ImagenProducto();
        $productos = $producto->getAllProducts();
        $productosConImagenes = array();

        foreach ($productos as $producto) {
            $productoId = $producto['id'];
            $imagen->setProductoId($producto['id']);
            $imagenes = $imagen->obtenerImagenesProducto();

            // Agregar las imágenes al producto
            $producto['imagenes'] = $imagenes;
            $productosConImagenes[] = $producto;
        }

        if ($productosConImagenes) {
            echo json_encode(['msg' => 'Productos obtenidos correctamente', 'productos' => $productosConImagenes]);
        } else {
            echo json_encode(['msg' => 'No se encontraron productos']);
        }
    } catch (\Throwable $th) {
        error_log("Error en getProducts: " . $th->getMessage());
        echo json_encode(['error' => 'Error en getProducts']);
    }
}


//? Funcion Funcionando (FF)
function setProducts(){
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $producto = new Producto();
        $producto->setNombre($data['nombre']);
        $producto->setDescripcion($data['descripcion']);
        $producto->setPrecio($data['precio']);
        $producto->setStock($data['stock']);
        $producto->setMarca($data['marca']);
        $producto->setCategoria($data['categoria']);
        $producto->setOrigen($data['origen']);
        $producto->setTipo($data['tipo']);
        $producto->setProveedor($data['proveedor']);

        $resultado = $producto->setProduct();

        if ($resultado) {
            echo json_encode(['msg' => 'Producto agregado correctamente', 'id'=>$resultado]);
        } else {
            echo json_encode(['msg' => 'Error al agregar el producto']);
        }
    } catch (\Throwable $th) {
        error_log("Error en setProducts: " . $th->getMessage());
        echo json_encode(['error' => 'Error en setProducts']);
    }
}

//? Funcion Funcionando (FF)
function deleteProducts(){
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $producto = new Producto();
        $producto->setIdProducto($data['id_producto']);
        $resultado = $producto->deleteProduct();

        if ($resultado) {
            echo json_encode(['msg' => 'Producto eliminado correctamente']);
        } else {
            echo json_encode(['msg' => 'Error al eliminar el producto']);
        }

    } catch (\Throwable $th) {
        error_log("Error en deleteProducts: " . $th->getMessage());
        echo json_encode(['error' => 'Error en deleteProducts']);
    }
}
//? Funcion Funcionando (FF)
function updateProducts() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $producto = new Producto();
        $producto->setIdProducto($data['id_producto']);

        $fields = [];
        if (isset($data['nombre'])) $fields['nombre'] = $data['nombre'];
        if (isset($data['descripcion'])) $fields['descripcion'] = $data['descripcion'];
        if (isset($data['precio'])) $fields['precio'] = $data['precio'];
        if (isset($data['stock'])) $fields['stock'] = $data['stock'];
        if (isset($data['marca'])) $fields['marca'] = $data['marca'];
        if (isset($data['categoria'])) $fields['categoria'] = $data['categoria'];
        if (isset($data['origen'])) $fields['origen'] = $data['origen'];
        if (isset($data['tipo'])) $fields['tipo'] = $data['tipo'];
        if (isset($data['proveedor'])) $fields['proveedor'] = $data['proveedor'];

        if (empty($fields)) {
            throw new Exception('No fields to update');
        }

        $resultado = $producto->updateProduct($fields);

        if ($resultado) {
            echo json_encode(['msg' => 'Producto actualizado correctamente']);
        } else {
            echo json_encode(['msg' => 'Error al actualizar el producto']);
        }
    } catch (\Throwable $th) {
        error_log("Error en updateProducts: " . $th->getMessage());
        echo json_encode(['error' => 'Error en updateProducts']);
    }
}

?>