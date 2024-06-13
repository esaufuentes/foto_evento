
<?php
if (isset($_GET['id'])) {
    $folder_id = $_GET['id'];

    // Conexión a la base de datos
    include '../eventos/funtion/conexion.php';
    
    // Eliminar imágenes asociadas con la carpeta
    $images_query = "SELECT path FROM images WHERE folder_id = $folder_id";
    $images_result = $conn->query($images_query);

    while ($row = $images_result->fetch_assoc()) {
        $file_path = $row['path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        } else {
            // Archivo no encontrado, puedes agregar un mensaje de registro o manejarlo según sea necesario
            echo "El archivo $file_path no existe.";
        }
    }

    // Eliminar registros de imágenes de la base de datos
    $delete_images_query = "DELETE FROM images WHERE folder_id = $folder_id";
    $conn->query($delete_images_query);

    // Eliminar la carpeta de la base de datos
    $delete_folder_query = "DELETE FROM folders WHERE id = $folder_id";
    $conn->query($delete_folder_query);

    // Cerrar la conexión a la base de datos
    $conn->close();

    // Redireccionar de vuelta a la página principal con un mensaje de éxito
    

    echo "<script>
    alert('Eliminado Correctamente');
    window.location.href = 'https://www.croccancun.com/eventos/index2.php';
  </script>";


    exit(); // Asegúrate de detener el script después de la redirección
}
?>
