<?php
include ('../../config.php');

$nombres = $_POST['nombres'];
$email = $_POST['email'];
$rol = $_POST['rol'];
$password_user = $_POST['password_user'];
$password_repeat = $_POST['password_repeat'];

// Verificar que ninguno de los campos esté vacío
if (empty($nombres) || empty($email) || empty($rol) || empty($password_user) || empty($password_repeat)) {
    session_start();
    $_SESSION['mensaje'] = "Por favor, complete todos los campos.";
    header('Location: '.$URL.'/usuarios/create.php');
    exit(); // Detiene la ejecución del script
}

// Comprobar si las contraseñas coinciden
if ($password_user != $password_repeat) {
    session_start();
    $_SESSION['invalid'] = "Error, las contraseñas no son iguales.";
    header('Location: '.$URL.'/usuarios/create.php');
    exit(); // Detiene la ejecución del script
}

// Verificar si el correo electrónico ya está en uso
$sentencia = $pdo->prepare("SELECT email FROM tb_usuarios WHERE email = :email");
$sentencia->bindParam(':email', $email);
$sentencia->execute();
$resultado = $sentencia->fetch();

if ($resultado) {
    session_start();
    $_SESSION['mensaje'] = "Error, el correo electrónico ya está en uso.";
    header('Location: '.$URL.'/usuarios/create.php');
    exit(); // Detiene la ejecución del script
}

// Si llegamos aquí, significa que todos los campos están completos, la contraseña cumple con los requisitos
// y el correo electrónico no está en uso
$password_user = password_hash($password_user, PASSWORD_DEFAULT);
$sentencia = $pdo->prepare("INSERT INTO tb_usuarios (nombres, email, id_rol, password_user, fyh_creacion) 
VALUES (:nombres,:email,:id_rol,:password_user,:fyh_creacion)");

$sentencia->bindParam(':nombres', $nombres);
$sentencia->bindParam(':email', $email);
$sentencia->bindParam(':id_rol', $rol);
$sentencia->bindParam(':password_user', $password_user);
$sentencia->bindParam(':fyh_creacion', $fechaHora);
$sentencia->execute();

session_start();
$_SESSION['mensaje'] = "Se registró al usuario de manera correcta.";
header('Location: '.$URL.'/usuarios/');





