<?php
// Definir las credenciales de la base de datos
$servername = "localhost";
$username = "croccanc_fotos";
$password = "t&cVNR!)4P4=";
$database = "croccanc_fotos";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
