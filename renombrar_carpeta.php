<?php
if (isset($_POST['folder_id']) && isset($_POST['new_folder_name'])) {
    // Establece la conexión a la base de datos
    include '../eventos/funtion/conexion.php';

    // Obtiene los datos del formulario
    $folderId = $_POST['folder_id'];
    $newFolderName = $_POST['new_folder_name'];

    // Verifica que el nombre de la carpeta no esté vacío
    if (empty($newFolderName)) {
        echo "<script>alert('El nuevo nombre de la carpeta no puede estar vacío.');</script>";
        exit();
    }

    // Actualiza el nombre de la carpeta en la base de datos
    $sql = "UPDATE folders SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newFolderName, $folderId);

    if ($stmt->execute()) {
        // Redirige a index2.php después de modificar la carpeta
        echo "<script>
                alert('Modificado correctamente');
                window.location.href = 'https://www.croccancun.com/eventos/index2.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Error al actualizar el nombre de la carpeta: <?php echo $conn->error; ?>');</script>";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    echo "<script>alert('El formulario no se ha enviado correctamente.');</script>";
}
?>
