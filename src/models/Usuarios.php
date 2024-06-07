<?php
//TODO: Este modelo es para la tabla de Usuarios que comprende
require_once 'DB.php';


class Usuario {
    //! Variable privada de conexion
    private $connection;

    //*Variables de la base de datos
    private string $cuenta;
    private string $password;
    private string $passwordPlano;
    private string $nombre;
    private string $apellidos;
    private string $rfc;
    private string $direccion;
    private string $calle;
    private string $colonia;
    private string $codigo_postal;
    private string $ciudad;
    private string $estado;
    private string $telefono;
    private string $avatar;
    private string $activo;
    private string $rol;

    //? Constructor 
    public function __construct() {
        $this->connection = DB::getConnection();
    }
    //? METODOS SET AND GET CON VALIDACIONES

    public function setCuenta(string $cuenta){
        if(filter_var($cuenta, FILTER_VALIDATE_EMAIL)){
            $this->cuenta=$cuenta;
        } else {
            throw new InvalidArgumentException("Cuenta no valida");
        }
    }

    public function getCuenta():string {
        return $this->cuenta;
    }   

    public function setPassword(string $password){
        //! Contraseña con hash
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->password = $hashedPassword;
        $this->passwordPlano = $password;
    }

    public function getPassword():string{
        return $this->password;
    }

    //! Metodo para verificar la contraseña por hash
    public function verificarPassword($hash):bool{
        return password_verify($this->passwordPlano, $hash);
    }

    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }

    public function getNombre():string{    
        return $this->nombre;    
    }   

    public function setApellidos(string $apellidos){
        $this->apellidos = $apellidos;
    }

    public function getApellidos():string{
        return $this->apellidos;
    }

    public function setRfc(string $rfc){
        $this->rfc = $rfc;
    }
    
    public function getRfc():string{
        return $this->rfc;
    }

    public function setDireccion(string $direccion){
        $this->direccion = $direccion;
    }

    public function getDireccion():string{
        return $this->direccion;
    }

    public function setCalle(string $calle){
        $this->calle = $calle;
    }

    public function getCalle():string{
        return $this->calle;
    }

    public function setColonia(string $colonia){
        $this->colonia = $colonia;
    }

    public function getColonia():string{
        return $this->colonia;
    }

    public function setCodigoPostal(string $codigo_postal){
        $this->codigo_postal = $codigo_postal;
    }

    public function getCodigoPostal():string{
        return $this->codigo_postal;
    }

    public function setCiudad(string $ciudad){
        $this->ciudad = $ciudad;
    }

    public function getCiudad():string{
        return $this->ciudad;
    }

    public function setEstado(string $estado){
        $this->estado = $estado;
    }

    public function getEstado():string{
        return $this->estado;
    }

    public function setTelefono(string $telefono){
        $this->telefono = $telefono;
    }

    public function getTelefono():string{
        return $this->telefono;
    }

    public function setAvatar(string $avatar){
        $this->avatar = $avatar;
    }

    public function getAvatar():string{
        return $this->avatar;
    }

    public function setActivo(string $activo){
        $this->activo = $activo;
    }

    public function getActivo():string{
        return $this->activo;
    }

    public function setRol(string $rol){
        $this->rol = $rol;
    }
    
    public function getRol():string{
        return $this->rol;
    }

    //! Metodos importantes para la API REST
 
    //? Metodo para iniciar sesion
    public function signIn(){
        try {
            $sql = "SELECT * FROM usuario WHERE cuenta = :cuenta";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":cuenta", $this->cuenta);
            $stmt->execute();
    
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($usuario) {
                if ($this->verificarPassword($usuario['password'])) {
                    return $usuario;
                } else {
                    throw new Exception("Contraseña incorrecta");
                }
            } else {
                throw new Exception("Usuario no encontrado");
            }
        } catch (\Throwable $th) {
            error_log("Error en el modelo SignIn: " . $th->getMessage());
            throw new Exception("Error en el modelo SignIn: " . $th->getMessage());
        }
    }
    //? Metodo para registrarse
    public function register(){
        try {
            $sql = "INSERT INTO usuario (cuenta, password, nombre, apellidos, rfc, direccion, calle, colonia, codigo_postal, ciudad, estado, telefono, avatar, activo, rol) 
                    VALUES (:cuenta, :password, :nombre, :apellidos, :rfc, :direccion, :calle, :colonia, :codigo_postal, :ciudad, :estado, :telefono, :avatar, :activo, :rol)";
    
            $stmt = $this->connection->prepare($sql);
            
            $stmt->bindParam(":cuenta", $this->cuenta);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":apellidos", $this->apellidos);
            $stmt->bindParam(":rfc", $this->rfc);
            $stmt->bindParam(":direccion", $this->direccion);
            $stmt->bindParam(":calle", $this->calle);
            $stmt->bindParam(":colonia", $this->colonia);
            $stmt->bindParam(":codigo_postal", $this->codigo_postal);
            $stmt->bindParam(":ciudad", $this->ciudad);
            $stmt->bindParam(":estado", $this->estado);
            $stmt->bindParam(":telefono", $this->telefono);
            $stmt->bindParam(":avatar", $this->avatar);
            $stmt->bindParam(":activo", $this->activo);
            $stmt->bindParam(":rol", $this->rol);
    
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
        } catch (\Throwable $th) {
            error_log("Error en el modelo Register: " . $th->getMessage());
            throw new Exception("Error en el modelo Register: " . $th->getMessage());
        }
    }
    //? Metodo para eliminar Usuario
    public function deleteAccount(){
        try {
            $sql = "DELETE FROM usuario WHERE cuenta = :cuenta";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":cuenta", $this->cuenta);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\Throwable $th) {
            error_log("Error en el modelo deleteAccount: " . $th->getMessage());
            throw new Exception("Error en el modelo deleteAccount: " . $th->getMessage());
        }
    }
    //? Metodo para activar o desabilitar la cuenta
    public function updateState(){
        try {
            $sql = "UPDATE usuario SET activo = :activo WHERE cuenta = :cuenta";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(":activo", $this->activo);
            $stmt->bindParam(":cuenta", $this->cuenta);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (\Throwable $th) {
            error_log("Error en el modelo updateState: " . $th->getMessage());
            throw new Exception("Error en el modelo updateState: " . $th->getMessage());
        }
    }
    
}
?>
