<?php
require 'db.php';

$id       = $conn->real_escape_string($_POST['id_persona']);
$nombre   = $conn->real_escape_string($_POST['nombre']);
$ape1     = $conn->real_escape_string($_POST['apellido1']);
$ape2     = $conn->real_escape_string($_POST['apellido2']);
$correo   = $conn->real_escape_string($_POST['correo']);
$estado   = $conn->real_escape_string($_POST['estado_cuenta']);
$permisos = $conn->real_escape_string($_POST['permisos_especiales']);

$conn->begin_transaction();
try {
    $sql1 = "INSERT INTO Persona (ID_persona, Nombre, Apellido1, Apellido2, correo, estado_cuenta)
             VALUES ('$id', '$nombre', '$ape1', '$ape2', '$correo', '$estado')";
    if (!$conn->query($sql1)) throw new Exception($conn->error);

    $sql2 = "INSERT INTO Administrador (ID_administrador, Permisos_especiales)
             VALUES ('$id', '$permisos')";
    if (!$conn->query($sql2)) throw new Exception($conn->error);

    $conn->commit();
    header("Location: index.php?status=success&tipo=administrador");
} catch (Exception $e) {
    $conn->rollback();
    echo "Error crítico: " . $e->getMessage();
}
$conn->close();