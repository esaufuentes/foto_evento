<?php

if (isset($_POST['submit']) && isset($_FILES['image'])) {
    // Establece la conexión a la base de datos (cambia los valores según tu configuración)
    include '../eventos/funtion/conexion.php';

    // Verifica si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $uploadDirectory = "../eventos/uploads/"; // Ruta corregida del directorio de destino

    // Verificar si el directorio de destino existe, si no, intentar crearlo
    if (!file_exists($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0777, true)) {
            die('Error: No se pudo crear el directorio de destino.');
        }
    }

    $totalFiles = count($_FILES['image']['name']);

    for ($i = 0; $i < $totalFiles; $i++) {
        $fileName = $_FILES['image']['name'][$i];
        $fileTmpName = $_FILES['image']['tmp_name'][$i];
        $fileSize = $_FILES['image']['size'][$i];
        $fileError = $_FILES['image']['error'][$i];
        $fileType = $_FILES['image']['type'][$i];

        // Aquí puedes añadir validaciones para el tamaño del archivo o el tipo si es necesario

        if ($fileError === 0) {
            $fileDestination = $uploadDirectory . basename($fileName);
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Inserta la información del archivo en la base de datos
                $sql = "INSERT INTO images (folder_id, name, path) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $folderId, $fileName, $fileDestination);
                $folderId = $_POST['selected_folder'];
                if ($stmt->execute()) {
                    echo "El archivo {$fileName} se ha subido y registrado en la base de datos correctamente.<br>";
                } else {
                    echo "Error al registrar el archivo {$fileName} en la base de datos.<br>";
                }
            } else {
                echo "Hubo un error subiendo el archivo {$fileName}.<br>";
            }
        } else {
            echo "Hubo un error al subir el archivo {$fileName}. Código de error: {$fileError}<br>";
        }
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    echo "Error: El formulario no se ha enviado correctamente.";
}
?>
