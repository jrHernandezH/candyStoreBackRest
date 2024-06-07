<?php
require_once 'Cors.php';

$target_dir = "../assets/avatar/";

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['image'])) {
            $file_name = uniqid() . "_" . $_FILES['image']['name']; // Nombre único para evitar colisiones
            $target_file = $target_dir . $file_name;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Verificar si el archivo es una imagen real
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check === false) {
                throw new Exception("El archivo no es una imagen válida.");
            }

            // Limitar el tamaño del archivo (5MB máximo)
            if ($_FILES['image']['size'] > 5000000) {
                throw new Exception("El tamaño del archivo es demasiado grande.");
            }

            // Permitir solo formatos de imagen JPEG y PNG
            if ($imageFileType != 'jpg' && $imageFileType != 'png') {
                throw new Exception("Solo se permiten archivos JPG y PNG.");
            }

            // Subir el archivo
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Optimizar la imagen para reducir el tamaño de archivo
                optimizarImagen($target_file, $imageFileType);
                
                // Construir la URL de la imagen
                $url = "http://localhost/candyStoreRest/src/assets/avatar/" . $file_name;

                echo json_encode(array("msg" => "Imagen subida exitosamente.", "path" => $target_file, "nombre" => $file_name, "url" => $url));
            } else {
                throw new Exception("Error al subir el archivo.");
            }
        } else {
            throw new Exception("No se ha subido ningún archivo.");
        }
    } else {
        throw new Exception("Método no permitido.");
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(array("error" => $e->getMessage()));
}

function optimizarImagen($file, $fileType) {
    try {
        switch ($fileType) {
            case 'jpg':
                $image = imagecreatefromjpeg($file);
                break;
            case 'png':
                $image = imagecreatefrompng($file);
                break;
        }

        // Redimensionar la imagen a un tamaño máximo de 1200x1200 píxeles
        $width = imagesx($image);
        $height = imagesy($image);
        $new_width = $width;
        $new_height = $height;

        if ($width > 1200 || $height > 1200) {
            $aspect_ratio = $width / $height;

            if ($width > $height) {
                $new_width = 1200;
                $new_height = 1200 / $aspect_ratio;
            } else {
                $new_height = 1200;
                $new_width = 1200 * $aspect_ratio;
            }

            $resized_image = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($resized_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($resized_image, $file, 85); // Calidad de compresión del 85%
        }

        // Liberar memoria
        imagedestroy($image);
    } catch (Exception $e) {
        error_log("Error al optimizar la imagen: " . $e->getMessage());
        throw $e;
    }
}

?>
