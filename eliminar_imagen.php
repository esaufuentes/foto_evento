<?php
include '../eventos/funtion/conexion.php'; // Asegúrate de ajustar la ruta de conexión a tu configuración

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Obtener la información de la imagen a eliminar
    $query = "SELECT name FROM images WHERE id = $id";
    $result = $conn->query($query);
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imageName = $row['name'];
        
        // Contar cuántas veces aparece el nombre de la imagen en la base de datos
        $query_count = "SELECT COUNT(*) AS count FROM images WHERE name = '$imageName'";
        $result_count = $conn->query($query_count);
        $count_row = $result_count->fetch_assoc();
        $imageCount = $count_row['count'];
        
        // Si hay más de una entrada con el mismo nombre de archivo, solo elimina la entrada de la base de datos
        if($imageCount > 1) {
            $query_delete = "DELETE FROM images WHERE id = $id";
            if($conn->query($query_delete)) {
                echo "Imagen eliminada con éxito de la base de datos.";
            } else {
                echo "Error al eliminar la imagen de la base de datos.";
            }
        } else {
            // Si solo hay una entrada con el mismo nombre de archivo, elimina el archivo físico también
            $imagePath = '../eventos/uploads/' . $imageName;
            if(file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            // Eliminar entrada de la base de datos
            $query_delete = "DELETE FROM images WHERE id = $id";
            if($conn->query($query_delete)) {
                echo "Imagen eliminada con éxito.";
            } else {
                echo "Error al eliminar la imagen de la base de datos.";
            }
        }
    } else {
        echo "La imagen no existe.";
    }
    
    $conn->close();
}
?>
