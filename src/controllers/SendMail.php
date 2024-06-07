<?php
$to_email = "maxconm190@gmail.com";
$subject = "Prueba de correo electrónico";
$body = "Este es un correo de prueba enviado desde PHP.";
$headers = "From: hernandezfloreshugo.dev@gmail.com";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Correo electrónico enviado correctamente a $to_email";
} else {
    echo "Error al enviar el correo electrónico.";
}
?>
