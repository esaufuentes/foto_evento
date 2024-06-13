<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descarga</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <style>
        /* Estilos para el contenedor de la galería de imágenes */
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px; /* Espacio entre las imágenes */
        }

        /* Estilos para el contenedor de cada imagen */
        .image-container {
            position: relative;
        }

        /* Estilos para las imágenes en la galería */
        .image-gallery img {
            max-width: 200px; /* Ancho máximo de las imágenes */
            max-height: 200px; /* Altura máxima de las imágenes */
            border: 2px solid #ccc; /* Borde alrededor de las imágenes */
            border-radius: 5px; /* Borde redondeado */
            transition: transform 0.2s ease; /* Efecto de transición al pasar el ratón */
        }

        /* Estilos para cuando se pasa el ratón sobre las imágenes */
        .image-gallery img:hover {
            transform: scale(1.1); /* Aumentar el tamaño de la imagen al pasar el ratón */
        }

        /* Estilos para el contenedor de superposición */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0; /* Inicialmente oculto */
            transition: opacity 0.2s ease;
        }

        /* Estilos para el botón de descarga */
        .download-btn {
            padding: 10px 20px;
            background-color: #101010;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        /* Estilos para el ícono de visualización */
        .view-icon {
            font-size: 30px;
            color: white;
            cursor: pointer;
        }

        /* Estilos para cuando se pasa el ratón sobre la superposición */
        .overlay:hover {
            opacity: 1; /* Mostrar la superposición al pasar el ratón */
        }

        /* Estilo del modal (fondo) */
        .modal {
          display: none; /* Oculto por defecto */
          position: fixed; /* Fijo en toda la pantalla */
          z-index: 1; /* Situado encima de todo */
          padding-top: 100px; /* Ubicación del modal */
          left: 0;
          top: 0;
          width: 100%; /* Ancho completo */
          height: 100%; /* Altura completa */
          overflow: auto; /* Habilita el scroll si es necesario */
          background-color: rgba(0, 0, 0, 0.8); /* Negro con opacidad */
        }

        /* Estilo del contenido del modal */
        .modal-content {
          margin: auto;
          display: block;
          width: 80%;
          max-width: 700px;
          background-color: #fefefe;
          padding: 20px;
          border-radius: 8px;
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        #modalImage {
    max-width: 100%;
    height: auto;
    display: block;
    margin: auto;
}
.close {
    position: absolute;
    top: 10px;
    right: 10px;
    color: #aaa;
    font-size: 28px;
}



    


.delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            color: red;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            border-radius: 50%; /* Hacer el botón redondo */
            width: 30px; /* Establecer el ancho */
            height: 30px; /* Establecer la altura */
            display: flex; /* Para centrar el contenido */
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
        }

        .delete-btn:hover {
            background-color: #ffcccc; /* Cambiar el color de fondo al pasar el ratón */
        }
        /* Estilos para los botones de confirmar y cancelar */
        #confirmDelete,
        #cancelDelete {
            padding: 10px 20px;
            background-color: black; /* Color de fondo negro */
            color: white; /* Color del texto blanco */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px; /* Margen derecho para separar los botones */
        }

        #confirmDelete:hover,
        #cancelDelete:hover {
            background-color: #333; /* Cambio de color al pasar el ratón */
        }
    </style>
</head>
<body>
    <h1>Catálogo de Imágenes</h1>

    <?php
    // Verificar si se ha recibido un ID de carpeta válido
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id_carpeta = $_GET['id'];
       
        // Realizar la consulta para obtener los nombres de las imágenes de la carpeta seleccionada
        include '../eventos/funtion/conexion.php';

        $query = "SELECT id, name FROM images WHERE folder_id = $id_carpeta";
        $result = $conn->query($query);


        // Mostrar las imágenes
        if ($result->num_rows > 0) {
            echo "<div class='image-gallery'>";
            while($row = $result->fetch_assoc()) {
                $imagePath = '../eventos/uploads/' . $row['name']; // Construir la ruta de la imagen
                if (file_exists($imagePath)) { // Verificar si la imagen existe
                    echo "<div class='image-container'>";
                    echo "<img src='$imagePath' alt='Imagen'>";
                    echo "<div class='overlay'>";
                    echo "<button onclick='confirmDelete(".$row['id'].")' class='delete-btn'>X</button>"; // Botón de eliminación
                    echo "<a href='$imagePath' download><button class='download-btn'>Descargar</button></a>"; // Botón de descarga
                    echo "<span class='view-icon' onclick='viewImage(\"$imagePath\")'>👁️</span>"; // Ícono de visualización
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "La imagen '$imagePath' no existe.";
                }
            }
            echo "</div>";
        } else {
            echo "No se encontraron imágenes en esta carpeta.";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    } else {
        echo "ID de carpeta no válido.";
    }
    ?>
    
    <!-- Modal para la visualización de la imagen -->
    <div id="myModal" class="modal">
      <!-- Contenido del modal -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <img id="modalImage" src="" alt="Imagen en modal">
      </div>
    </div>

    <!-- Modal de Confirmación -->
    <div id="deleteModal" class="modal">
      <div class="modal-content">
        <h2>Eliminar Imagen</h2>
        <p>¿Está seguro que desea eliminar esta imagen?</p>
        <button id="confirmDelete">Eliminar</button>
        <button id="cancelDelete">Cancelar</button>
      </div>
    </div>

    <script>
    // Obtén el modal
    var modal = document.getElementById("myModal");

    // Obtén la imagen y la inserta dentro del modal - usa su atributo "alt" como título
    function viewImage(src) {
        var modalImg = document.getElementById("modalImage");
        modal.style.display = "block";
        modalImg.src = src;
    }

    // Obtén el elemento <span> que cierra el modal
    var span = document.getElementsByClassName("close")[0];

    // Cuando el usuario hace clic en <span> (x), cierra el modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Función para confirmar la eliminación de una imagen
    function confirmDelete(imageId) {
        var confirmationModal = document.getElementById("deleteModal");
        confirmationModal.style.display = "block";

        // Botón de confirmar eliminación
        document.getElementById("confirmDelete").onclick = function() {
            deleteImage(imageId);
            confirmationModal.style.display = "none";
        };

        // Botón de cancelar eliminación
        document.getElementById("cancelDelete").onclick = function() {
            confirmationModal.style.display = "none";
        };
    }

    // Función para eliminar la imagen
    function deleteImage(imageId) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar_imagen.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status == 200) {
                alert(xhr.responseText); // Mostrar respuesta del servidor
                location.reload(); // Recargar la página para reflejar la eliminación
            }
        };
        xhr.send("id=" + imageId);
    }
    </script>
</body>
</html>
