<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpetas</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    text-align: center;
}

/* Estilos para los iconos de carpeta */
.folder-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* Mostrar en 3 columnas */
    grid-gap: 10px; /* Ajusta este valor para controlar el espaciado entre carpetas */
}

.folder-container {
    text-align: center;
    margin-bottom: 20px; /* Ajusta este valor si deseas más o menos espacio entre filas de carpetas */
}

.folder-icon {
    width: 100px;
    height: 100px;
    background-image: url('folder_icon.png');
    background-size: cover;
    cursor: pointer;
    margin: 0 auto 10px; /* Asegura que el icono esté centrado en el contenedor y añade espacio antes del texto */
    display: block; /* Asegura que se trate como bloque para respetar el margen auto */
}

.folder-name {
    text-align: center;
    display: block; /* Asegura que se trate como un bloque y permita la alineación del texto */
    width: 100%; /* Ocupa el ancho completo del contenedor para centrar el texto */
    background: linear-gradient(#e6b479, rgb(234 227 205 / 45%));
}


      

/* Estilos para dispositivos móviles */
@media (max-width: 600px) {
    .folder-grid {
        grid-template-columns: repeat(1, 1fr); /* Cambiar a una columna en dispositivos móviles */
    }

    .folder-icon {
        width: 75px; /* Reducir el tamaño del icono en dispositivos móviles */
        height: 75px;
    }
}

@media (max-width: 400px) {
    .folder-icon {
        width: 50px; /* Reducir aún más el tamaño del icono en pantallas muy pequeñas */
        height: 50px;
    }
}


        .folder-name {
            font-size: 14px;
            text-align: center;
        }

        .folder-icon.selected {
            border: 2px solid blue;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f09121;
            border: 1px solid #ccc;
            margin-right: 5px;
            text-decoration: none;
            color: #333;
        }

        .pagination a.active {
            background-color: #f09121;
            color: #fff;
        
        }

        .pagination a:hover {
    background-color: yellow;
}


.preview-image {
    width: 100px; /* Tamaño de las imágenes de vista previa */
    height: auto; /* Mantener la proporción */
    margin: 5px;
    border: 1px solid #ddd; /* Borde opcional para mejor visualización */
    box-shadow: 2px 2px 5px rgba(0,0,0,0.1); /* Sombra opcional para mejor visualización */
}

.image-container {
    display: inline-block; /* Permitir múltiples imágenes por línea */
    position: relative;
}

.delete-button {
    position: absolute;
    top: -5px; /* Ajusta la posición del botón para que esté más cerca de la esquina */
    right: -5px; /* Ajusta la posición del botón para que esté más cerca de la esquina */
    width: 20px; /* Define el ancho del botón */
    height: 20px; /* Define la altura del botón */
    font-size: 12px; /* Ajusta el tamaño de la fuente del botón */
    padding: 0; /* Elimina el padding del botón */
    border: none;
    background-color: red;
    color: white;
    border-radius: 50%;
    cursor: pointer;
}


@media (max-width: 600px) {
    .preview-image {
        width: 80px; /* Tamaños más pequeños para dispositivos móviles */
    }
}

@media (max-width: 400px) {
    .preview-image {
        width: 60px; /* Tamaños aún más pequeños para pantallas muy pequeñas */
    }
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Descarga Tu foto</h1>

        <!-- Formulario para crear una nueva carpeta -->


        <!-- Iconos de carpetas -->
        <div id="folder-icons" class="folder-grid">
            <!-- Aquí se agregarán los iconos de las carpetas dinámicamente -->
            <?php
            // Conexión a la base de datos
            include '../funtion/conexion.php';

            // Paginación
            $items_por_pagina = 3;
            $pagina_actual = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($pagina_actual - 1) * $items_por_pagina;

            // Consulta para obtener las carpetas existentes con paginación y ordenadas de forma ascendente por el nombre
            $query = "SELECT id, name FROM folders ORDER BY id DESC LIMIT $items_por_pagina OFFSET $offset";
            $result = $conn->query($query);

            // Genera los iconos de las carpetas
            while ($row = $result->fetch_assoc()) {
                echo "<div class='folder-container'>";
                echo "<div class='folder-icon' data-folder-id='" . $row['id'] . "'></div>";
                echo "<div class='folder-name'>" . $row['name'] . "</div>";
                echo "</div>";
            }

            // Consulta para obtener el número total de carpetas
            $total_carpetas_query = "SELECT COUNT(id) AS total FROM folders";
            $total_carpetas_result = $conn->query($total_carpetas_query);
            $total_carpetas_row = $total_carpetas_result->fetch_assoc();
            $total_carpetas = $total_carpetas_row['total'];

            // Cerrar la conexión a la base de datos
            $conn->close();
            ?>
        </div>

        <!-- Paginación -->
        <div class="pagination">
    <?php
    // Mostrar enlaces de paginación
    $total_paginas = ceil($total_carpetas / $items_por_pagina);

    // Número máximo de páginas antes de mostrar "..."
    $max_paginas_mostradas = 3;

    // Calcular la página inicial y final a mostrar
    $pagina_inicio = max(1, $pagina_actual - floor($max_paginas_mostradas / 2));
    $pagina_fin = min($pagina_inicio + $max_paginas_mostradas - 1, $total_paginas);

    // Ajustar la página inicial si la página final se encuentra al final
    $pagina_inicio = max(1, $pagina_fin - $max_paginas_mostradas + 1);

    // Mostrar "inicio" si la página actual es mayor que 1
    if ($pagina_actual > 1) {
        echo "<a href='?page=1'>Inicio</a>";
    }

    // Mostrar puntos suspensivos si hay más de 10 páginas y la página inicial no es 1
    if ($pagina_inicio > 1) {
        echo "<span>...</span>";
    }

    // Mostrar enlaces de las páginas
    for ($i = $pagina_inicio; $i <= $pagina_fin; $i++) {
        $active_class = ($i == $pagina_actual) ? 'active' : '';
        echo "<a href='?page=$i' class='$active_class'>$i</a>";
    }

    // Mostrar puntos suspensivos si hay más de 10 páginas y la página final no es la última
    if ($pagina_fin < $total_paginas) {
        echo "<span>...</span>";
    }

    // Mostrar "fin" si la página actual no es la última
    if ($pagina_actual < $total_paginas) {
        echo "<a href='?page=$total_paginas'>Fin</a>";
    }
    ?>
</div>


    


<div id="image-preview-container"></div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Script para manejar la selección de carpetas
    const folderIcons = document.querySelectorAll('.folder-icon');
    
    folderIcons.forEach(function(folderIcon) {
        folderIcon.addEventListener('click', function() {
            folderIcons.forEach(function(icon) {
                icon.classList.remove('selected');
            });

            folderIcon.classList.add('selected');
            document.getElementById('selected_folder').value = folderIcon.dataset.folderId;
        });
    });

    folderIcons.forEach(function(folderIcon) {
        folderIcon.addEventListener('dblclick', function() {
            window.location.href = 'catalogo.php?id=' + folderIcon.dataset.folderId;
        });
    });

    // Script para manejar la carga de imágenes
    const fileInput = document.getElementById('image');
    const imagePreviewContainer = document.getElementById('image-preview-container');

    fileInput.addEventListener('change', function() {
        const files = fileInput.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const image = new Image();
                image.src = e.target.result;
                image.classList.add('preview-image');

                const deleteButton = document.createElement('button');
                deleteButton.innerText = 'x';
                deleteButton.classList.add('delete-button');
                deleteButton.addEventListener('click', function() {
                    imageContainer.removeChild(image);
                    imageContainer.removeChild(deleteButton);
                    if (imagePreviewContainer.childElementCount === 0) {
                        resetFileInput(); // Restablecer el valor del input de archivo solo si no hay imágenes en la vista previa
                    }
                });

                const imageContainer = document.createElement('div');
                imageContainer.classList.add('image-container');
                imageContainer.appendChild(image);
                imageContainer.appendChild(deleteButton);

                imagePreviewContainer.appendChild(imageContainer);
            };

            reader.readAsDataURL(file);
        }
    });

    // Restablecer el valor del input de archivo al eliminar una imagen
    function resetFileInput() {
        fileInput.value = ''; // Restablecer el valor
    }
});


</script>
</body>

</html>
