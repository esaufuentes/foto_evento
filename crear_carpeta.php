<?php
// Verifica si se ha enviado el formulario para crear la carpeta
if (isset($_POST['crear_carpeta'])) {
    // Recupera el nombre de la carpeta del formulario
    $nombreCarpeta = $_POST['nombre_carpeta'];

    // Verifica si el nombre de la carpeta no está vacío
    if (!empty($nombreCarpeta)) {
        // Conexión a la base de datos
        include '../eventos/funtion/conexion.php';

        // Escapa caracteres especiales para prevenir inyección SQL
        $nombreCarpeta = $conn->real_escape_string($nombreCarpeta);

        // Verifica si ya existe una carpeta con el mismo nombre
        $query = "SELECT id FROM folders WHERE name = '$nombreCarpeta'";
        $result = $conn->query($query);

        if ($result->num_rows == 0) {
            // No hay una carpeta con el mismo nombre, se puede crear
            $query = "INSERT INTO folders (name) VALUES ('$nombreCarpeta')";
            if ($conn->query($query) === TRUE) {
                // Redirige a carpeta.php
                header("Location: index2.php");
                exit; // Detiene la ejecución del script actual después de la redirección
            } else {
                echo "Error al crear la carpeta: " . $conn->error;
            }
        } else {
            // Ya existe una carpeta con el mismo nombre, muestra un mensaje de error en una ventana popup y redirige
            echo "<script>alert('Ya existe una carpeta con el nombre \"$nombreCarpeta\".'); window.location.href = 'https://www.croccancun.com/eventos/index2.php';</script>";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    } else {
        // El nombre de la carpeta está vacío, muestra un mensaje de error en una ventana popup y redirige
        echo "<script>alert('Error: El nombre de la carpeta está vacío.'); window.location.href = 'https://www.croccancun.com/eventos/index2.php';</script>";
    }
} else {
    // Si no se envió el formulario correctamente, redirecciona o muestra un mensaje de error
    echo "Error: El formulario no se ha enviado correctamente.";
}
?>
