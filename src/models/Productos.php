<?php
//TODO: Este modelo es para la tabla de Productos que comprende
require_once 'DB.php';

class Producto {
    //! Variable privada de conexion
    private $connection;

    //*Variables de la base de datos
    private int $id_producto;
    private string $nombre;
    private string $descripcion;
    private float $precio;
    private int $stock;
    private string $marca;
    private string $categoria;
    private string $origen;
    private string $tipo;
    private string $proveedor;

    //? Constructor 
    public function __construct() {
        $this->connection = DB::getConnection();
    }

    //? Metodos SET'S and GET'S

    public function setIdProducto(int $id_producto) {
        $this->id_producto = $id_producto;
    }

    public function getIdProducto(): int {
        return $this->id_producto;
    }

    public function setNombre(string $nombre) {
        $this->nombre = $nombre;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setDescripcion(string $descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setPrecio(float $precio) {
        $this->precio = $precio;
    }

    public function getPrecio(): float {
        return $this->precio;
    }

    public function setStock(int $stock) {
        $this->stock = $stock;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function setMarca(string $marca) {
        $this->marca = $marca;
    }

    public function getMarca(): string {
        return $this->marca;
    }

    public function setCategoria(string $categoria){
        $this->categoria = $categoria;
    }

    public function getCategoria():string{
        return $this->categoria;
    }

    public function setOrigen(string $origen) {
        $this->origen = $origen;
    }

    public function getOrigen(): string {
        return $this->origen;
    }

    public function setTipo(string $tipo) {
        $this->tipo = $tipo;
    }

    public function getTipo(): string {
        return $this->tipo;
    }

    public function setProveedor(string $proveedor) {
        $this->proveedor = $proveedor;
    }

    public function getProveedor(): string {
        return $this->proveedor;
    }

    //! Metodos importantes para la API REST

    //? Metodo para obtener los productos
    public function getAllProducts() {
        try {
            $sql = "SELECT * FROM producto";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $productos;
        } catch (\Throwable $th) {
            error_log("Error en el modelo getAllProducts: " . $th->getMessage());
            throw new Exception("Error en el modelo getAllProducts: " . $th->getMessage());
        }
    }

    //? Metodo para registrar productos
    public function setProduct() {
        try {
            $sql = "INSERT INTO producto (nombre, descripcion, precio, stock, marca, categoria, origen, tipo, proveedor) 
                    VALUES (:nombre, :descripcion, :precio, :stock, :marca, :categoria, :origen, :tipo, :proveedor)";
            $stmt = $this->connection->prepare($sql);
    
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
            $stmt->bindParam(':precio', $this->precio, PDO::PARAM_STR);
            $stmt->bindParam(':stock', $this->stock, PDO::PARAM_INT);
            $stmt->bindParam(':marca', $this->marca, PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $this->categoria, PDO::PARAM_STR);
            $stmt->bindParam(':origen', $this->origen, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
            $stmt->bindParam(':proveedor', $this->proveedor, PDO::PARAM_STR);           
            $stmt->execute();
    
            $lastInsertedId = $this->connection->lastInsertId();

            if ($stmt->rowCount() > 0) {
                return $lastInsertedId; 
            } else {
                throw new Exception("No se encontró el producto con ID: $lastInsertedId");
            }
        } catch (\Throwable $th) {
            error_log("Error en el modelo setProduct: " . $th->getMessage());
            throw new Exception("Error en el modelo setProduct: " . $th->getMessage());
        }
    }
    

    //? Metodo para eliminar producto por ID
    public function deleteProduct() {
        try {
            $sql = "DELETE FROM producto WHERE id = :id_producto";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id_producto', $this->id_producto, PDO::PARAM_INT);
            
            $stmt->execute();

            // Verificar si alguna fila fue afectada
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se encontró el producto con ID: $id_producto");
            }
        } catch (\Throwable $th) {
            error_log("Error en el modelo deleteProduct: " . $th->getMessage());
            throw new Exception("Error en el modelo deleteProduct: " . $th->getMessage());
        }
    }

    //? Metodo para actualizar atributos del producto
    public function updateProduct(array $fields) {
        try {
            $setClause = [];
            $params = [];
            foreach ($fields as $key => $value) {
                $setClause[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $setClause = implode(', ', $setClause);

            $sql = "UPDATE producto SET $setClause WHERE id = :id_producto";
            $stmt = $this->connection->prepare($sql);
            $params[':id_producto'] = $this->id_producto;

            foreach ($params as $param => $value) {
                if (is_int($value)) {
                    $stmt->bindValue($param, $value, PDO::PARAM_INT);
                } elseif (is_float($value)) {
                    $stmt->bindValue($param, $value, PDO::PARAM_STR);
                } else {
                    $stmt->bindValue($param, $value, PDO::PARAM_STR);
                }
            }

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("No se encontró el producto con ID: $id_producto o no hubo cambios en los valores.");
            }
        } catch (\Throwable $th) {
            error_log("Error en el modelo updateProduct: " . $th->getMessage());
            throw new Exception("Error en el modelo updateProduct: " . $th->getMessage());
        }
    }
}
?>