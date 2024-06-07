<?php
//TODO: Este modelo es para la tabla de Imagenes de Productos
require_once 'DB.php';

class ImagenProducto {
    //! Variable privada de conexión
    private $connection;

    //* Variables de la base de datos
    private int $id;
    private int $producto_id;
    private string $imagen_url;

    //? Constructor
    public function __construct() {
        $this->connection = DB::getConnection();
    }

    //? Metodos Setters y Getters
    public function setId(int $id) {
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setProductoId(int $producto_id) {
        $this->producto_id = $producto_id;
    }

    public function getProductoId(): int {
        return $this->producto_id;
    }

    public function setImagenUrl(string $imagen_url) {
        $this->imagen_url = $imagen_url;
    }

    public function getImagenUrl(): string {
        return $this->imagen_url;
    }
    
    //! Metodos importantes para la API REST
 
    //? Metodo para registrar Imagenes
    public function registrarImagen() {
        try {
            $sql = "INSERT INTO imagen_producto (producto_id, imagen_url) VALUES (:producto_id, :imagen_url)";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':producto_id', $this->producto_id, PDO::PARAM_INT);
            $stmt->bindParam(':imagen_url', $this->imagen_url, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\Throwable $th) {
            error_log("Error en el modelo registrarImagen: " . $th->getMessage());
            throw new Exception("Error en el modelo registrarImagen: " . $th->getMessage());
        }
    }

    //? Metodo para obtener las imagenes
    public function obtenerImagenesProducto() {
        try {
            $sql = "SELECT * FROM imagen_producto WHERE producto_id = :producto_id";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':producto_id', $this->producto_id, PDO::PARAM_INT);
            $stmt->execute();

            $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $imagenes;
        } catch (\Throwable $th) {
            error_log("Error en el modelo obtenerImagenesProducto: " . $th->getMessage());
            throw new Exception("Error en el modelo obtenerImagenesProducto: " . $th->getMessage());
        }
    }
    
}
?>
