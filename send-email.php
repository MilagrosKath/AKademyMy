<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    // Configura la dirección de tu correo electrónico aquí
    $to = 'milagros.one.2128@gmail.com';
    $subject = 'Nuevo mensaje de contacto';

    // Crear el contenido del correo
    $body = "Mensaje:\n$message\n";
    
    // Manejar el archivo adjunto
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['attachment']['tmp_name'];
        $name = $_FILES['attachment']['name'];
        $attachment = chunk_split(base64_encode(file_get_contents($tmp_name)));

        $boundary = md5(time());
        $headers = "From: no-reply@yourdomain.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

        $message_body = "--$boundary\r\n";
        $message_body .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
        $message_body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message_body .= "Mensaje:\n$message\n";
        $message_body .= "--$boundary\r\n";
        $message_body .= "Content-Type: image/jpeg; name=\"$name\"\r\n";
        $message_body .= "Content-Transfer-Encoding: base64\r\n";
        $message_body .= "Content-Disposition: attachment; filename=\"$name\"\r\n\r\n";
        $message_body .= $attachment . "\r\n";
        $message_body .= "--$boundary--";

        mail($to, $subject, $message_body, $headers);
    } else {
        $headers = "From: no-reply@yourdomain.com\r\n";
        $headers .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
        mail($to, $subject, $body, $headers);
    }

    echo "Mensaje enviado con éxito.";
}
?>
