<?php
$host = "10.116.25.92";
$user = "secretaria1";
$pass = "1234567890ab";
$db   = "gestion_escolar";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Conexión fallida: " . $conn->connect_error); }

// Recoger datos
$id       = $_POST['id_persona'];
$nombre   = $_POST['nombre'];
$ape1     = $_POST['apellido1'];
$ape2     = $_POST['apellido2'];
$correo   = $_POST['correo'];
$estado   = $_POST['estado_cuenta'];
$titulo   = $_POST['titulo_academico'];

// Iniciar transacción para asegurar que se graben ambas tablas o ninguna
$conn->begin_transaction();
try {
    // 1. Insertar en la tabla Persona
    $sql1 = "INSERT INTO Persona (ID_persona, Nombre, Apellido1, Apellido2, correo, estado_cuenta)
             VALUES ('$id', '$nombre', '$ape1', '$ape2', '$correo', '$estado')";
    $conn->query($sql1);

    // 2. Insertar en la tabla Profesor
    $sql2 = "INSERT INTO Profesor (ID_profesor, titulo_academico)
             VALUES ('$id', '$titulo')";
    $conn->query($sql2);

    // Si todo va bien, confirmar cambios
    $conn->commit();
    header("Location: index.php?status=success");
} catch (Exception $e) {
    // Si algo falla, deshacer todo
    $conn->rollback();
    echo "Error crítico: " . $e->getMessage();
}

$conn->close();
?>
