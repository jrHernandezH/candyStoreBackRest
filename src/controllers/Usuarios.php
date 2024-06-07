<?php
//Todo: Este es el controlador de Usuarios
require_once 'Cors.php';
require_once '../models/Usuarios.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':
        userSignIn();
    break;
    case 'POST':
        userRegister();
    break;
    case 'PUT':
        userUpdate();
    break;
    case 'DELETE':
        userDelete();
    break;
}

//? Funcion Funcionando (FF)
function userSignIn(){
    try {
        $cuenta = $_GET['cuenta'];
        $password = $_GET['password'];

        if (!$cuenta || !$password) {
            echo json_encode(array('msg' => 'Faltan datos'));
            throw new InvalidArgumentException('Faltan datos requeridos');
        }
        $usuario = new Usuario();

        $usuario->setCuenta($cuenta);
        $usuario->setPassword($password);
        $resultado = $usuario->signIn();

        if($resultado){
            echo json_encode(array('msg'=> 'Usuario encontrado', 'usuario' => $resultado));
        } else {
            echo json_encode(array('msg' => 'Usuario no encontrado'));
        }
    } catch (\Throwable $th) {
        error_log("Error en userSignIn: " . $th->getMessage());
        echo json_encode(array('error'=> 'Error en userSignIn'));
    }
}

//? Funcion Funcionando (FF)
function userRegister(){
    try {
        $dataUser = json_decode(file_get_contents("php://input"), true);

        $usuario = new Usuario();
        $usuario->setCuenta($dataUser['cuenta']);
        $usuario->setPassword($dataUser['password']);
        $usuario->setNombre($dataUser['nombre']);
        $usuario->setApellidos($dataUser['apellidos']);
        $usuario->setRfc($dataUser['rfc']);
        $usuario->setDireccion($dataUser['direccion']);
        $usuario->setCalle($dataUser['calle']);
        $usuario->setColonia($dataUser['colonia']);
        $usuario->setCodigoPostal($dataUser['codigo_postal']);
        $usuario->setCiudad($dataUser['ciudad']);
        $usuario->setEstado($dataUser['estado']);
        $usuario->setTelefono($dataUser['telefono']);
        $usuario->setAvatar($dataUser['avatar']);
        $usuario->setActivo($dataUser['activo']);
        $usuario->setRol($dataUser['rol']);
        
        $resultado = $usuario->register();

        if ($resultado) {
            $resultadoSignIn = $usuario->signIn();
            echo json_encode(['msg' => 'Usuario registrado', 'usuario' => $resultadoSignIn]);
        } else {
            echo json_encode(['msg' => 'Registro no completado']);
        }
    }  catch (\Throwable $th) {
        error_log("Error en userRegister: " . $th->getMessage());
        echo json_encode(['error' => 'Error en userRegister']);
    }
}

//? Funcion Funcionando (FF)
function userUpdate(){
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $usuario = new Usuario();
        $usuario->setCuenta($data['cuenta']);
        $usuario->setActivo($data['activo']);

        $resultado = $usuario->updateState();

        if ($resultado) {
            echo json_encode(['msg' => 'Estado de usuario actualizado correctamente']);
        } else {
            echo json_encode(['msg' => 'Error al actualizar el estado de usuario']);
        }
    } catch (\Throwable $th) {
        error_log("Error en userUpdate: " . $th->getMessage());
        echo json_encode(['error' => 'Error en userUpdate']);
    }
}

//? Funcion
function userDelete(){
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        $usuario = new Usuario();
        $usuario->setCuenta($data['cuenta']);

        $resultado = $usuario->deleteAccount();

        if ($resultado) {
            echo json_encode(['msg' => 'Usuario eliminado correctamente']);
        } else {
            echo json_encode(['msg' => 'Error al eliminar el usuario']);
        }
    } catch (\Throwable $th) {
        error_log("Error en userDelete: " . $th->getMessage());
        echo json_encode(['error' => 'Error en userDelete']);
    }
}


?>