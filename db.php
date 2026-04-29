<?php
$conn = new mysqli("10.116.25.92", "secretaria1", "1234567890ab", "gestion_escolar");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}