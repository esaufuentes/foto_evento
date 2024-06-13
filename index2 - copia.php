<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpetas</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .folder-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .folder-icon {
            width: 100px;
            height: 100px;
            background-image: url('folder_icon.png');
            /* Reemplaza 'folder_icon.png' con la ruta de tu icono de carpeta */
            background-size: cover;
            cursor: pointer;
            margin-right: 10px;
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
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            margin-right: 5px;
            text-decoration: none;
            color: #333;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Gestor de Carpetas y fotos</h1>

        <!-- Formulario para crear una nueva carpeta -->
        <form action="crear_carpeta.php" method="post">
            <label for="nombre_carpeta">Nombre de la carpeta:</label>
            <input type="text" name="nombre_carpeta" id="nombre_carpeta">
            <button type="submit" name="crear_carpeta">Crear Carpeta</button>
        </form>

        <!-- Iconos de carpetas -->
        <div id="folder-icons">
            <!-- Aquí se agregarán los iconos de las carpetas dinámicamente -->
            <?php
            // Conexión a la base de datos
            $conn = new mysqli("localhost", "root", "", "carpetas");

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

            for ($i = 1; $i <= $total_paginas; $i++) {
                $active_class = ($i == $pagina_actual) ? 'active' : '';
                echo "<a href='?page=$i' class='$active_class'>$i</a>";
            }
            ?>
        </div>

        <!-- Formulario para subir imágenes -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="image" id="image">
            <!-- Campo oculto para almacenar la carpeta seleccionada -->
            <input type="hidden" name="selected_folder" id="selected_folder" value="">
            <button type="submit" name="submit">Subir Imagen</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const folderIcons = document.querySelectorAll('.folder-icon');
            
            // Manejar selección de carpeta con clic
            folderIcons.forEach(function(folderIcon) {
                folderIcon.addEventListener('click', function() {
                    // Remover la clase 'selected' de todos los iconos de carpeta
                    folderIcons.forEach(function(icon) {
                        icon.classList.remove('selected');
                    });

                    // Agregar la clase 'selected' al icono de carpeta seleccionado
                    folderIcon.classList.add('selected');

                    // Actualizar el valor del campo oculto con el ID de la carpeta seleccionada
                    document.getElementById('selected_folder').value = folderIcon.dataset.folderId;
                });
            });

            // Manejar redireccionamiento a catálogo con doble clic
            folderIcons.forEach(function(folderIcon) {
                folderIcon.addEventListener('dblclick', function() {
                    // Redireccionar al usuario a catalogo.php, pasando el ID de la carpeta como parámetro
                    window.location.href = 'catalogo.php?id=' + folderIcon.dataset.folderId;
                });
            });
        });
    </script>
</body>

</html>
