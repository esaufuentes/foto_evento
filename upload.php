<?php
if (isset($_FILES['image']) && isset($_POST['selected_folder'])) {
    // Establece la conexión a la base de datos (cambia los valores según tu configuración)
    include '../eventos/funtion/conexion.php';

    // Verifica si el directorio de destino existe, si no, intenta crearlo
    $uploadDirectory = "../eventos/uploads/";
    if (!file_exists($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0777, true)) {
            die('Error: No se pudo crear el directorio de destino.');
        }
    }

    // Obtiene la carpeta seleccionada
    $folderId = $_POST['selected_folder'];

    // Verifica si se seleccionaron imágenes
    if (!empty($_FILES['image']['name'][0])) {
        $totalFiles = count($_FILES['image']['name']);
        $successCount = 0;

        // Itera sobre cada imagen para procesarla
        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $_FILES['image']['name'][$i];
            $fileTmpName = $_FILES['image']['tmp_name'][$i];
            $fileSize = $_FILES['image']['size'][$i];
            $fileError = $_FILES['image']['error'][$i];
            $fileType = $_FILES['image']['type'][$i];

            // Genera una ruta única para guardar el archivo
            $fileDestination = $uploadDirectory . basename($fileName);

            // Mueve el archivo al directorio de destino
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Inserta la información del archivo en la base de datos
                $sql = "INSERT INTO images (folder_id, name, path) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $folderId, $fileName, $fileDestination);
                if ($stmt->execute()) {
                    $successCount++;
                } else {
                    
                  

                    echo "<script>alert('Error al registrar el archivo {$fileName} en la base de datos.<br> Porfavor Seleccione una carpeta'); window.location.href = 'https://www.croccancun.com/eventos/index2.php';</script>";
                }
            } else {
                echo "Hubo un error subiendo el archivo {$fileName}.<br>";
            }
        }

        // Cierra la conexión a la base de datos
        $conn->close();

        // Si todas las imágenes se cargaron con éxito, redirige a index2.php
        if ($successCount === $totalFiles) {
            echo "<script>alert('Cargado con Exito.'); window.location.href = 'https://www.croccancun.com/eventos/index2.php';</script>";
        }
    } else {
        echo "<script>alert('Porfavor Seleccione Carpeta.'); window.location.href = 'https://www.croccancun.com/eventos/index2.php';</script>";
    }
} else {
    

    echo "<script>alert('Porfavor Seleccione una O Varias Imagenes.'); window.location.href = 'https://www.croccancun.com/eventos/index2.php';</script>";
}
?>
