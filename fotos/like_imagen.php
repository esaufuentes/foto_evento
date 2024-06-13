<?php
// Verifica si se ha recibido un ID de imagen válido
if(isset($_POST['id']) && is_numeric($_POST['id'])) {
    $imageId = $_POST['id'];

    // Conecta a la base de datos
    include '../funtion/conexion.php';


    // Incrementa el contador de "Me gusta" en la base de datos para la imagen dada
    $updateQuery = "UPDATE images SET likes = likes + 1 WHERE id = $imageId";
    if ($conn->query($updateQuery) === TRUE) {
        echo "¡Gracias por tu Me gusta!";
    } else {
        echo "Error al dar Me gusta: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    echo "ID de imagen no válido.";
}
?>
