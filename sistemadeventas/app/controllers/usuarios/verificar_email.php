<?php
include ('../../config.php');

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Consulta para verificar si el correo electrónico existe en la base de datos
    $sql = "SELECT email FROM tb_usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Crear una respuesta JSON
    $response = array('emailExists' => ($result['count'] > 0));

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // No se proporcionó el parámetro 'email'
    // Puedes manejar esto de acuerdo a tus necesidades
    echo "Parámetro 'email' no proporcionado.";
}
