<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CROC ADMIN V1.0 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src='progess/nprogress.js'></script>
    <link rel='stylesheet' href='progess/nprogress.css' />

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
            grid-template-columns: repeat(3, 1fr);
            /* Mostrar en 3 columnas */
            grid-gap: 10px;
            /* Ajusta este valor para controlar el espaciado entre carpetas */
        }

        .folder-container {
            text-align: center;
            margin-bottom: 20px;
            /* Ajusta este valor si deseas más o menos espacio entre filas de carpetas */
        }

        .folder-icon {
            width: 100px;
            height: 100px;
            background-image: url('folder_icon.png');
            background-size: cover;
            cursor: pointer;
            margin: 0 auto 10px;
            /* Asegura que el icono esté centrado en el contenedor y añade espacio antes del texto */
            display: block;
            /* Asegura que se trate como bloque para respetar el margen auto */
        }

        .folder-name {
            text-align: center;
            display: block;
            /* Asegura que se trate como un bloque y permita la alineación del texto */
            width: 100%;
            /* Ocupa el ancho completo del contenedor para centrar el texto */
            background: linear-gradient(#c68e2a1c, rgb(234 227 205 / 45%));
        }

        /* Estilos para dispositivos móviles */
        @media (max-width: 600px) {
            .folder-grid {
                grid-template-columns: repeat(1, 1fr);
                /* Cambiar a una columna en dispositivos móviles */
            }

            .folder-icon {
                width: 75px;
                /* Reducir el tamaño del icono en dispositivos móviles */
                height: 75px;
            }
        }

        @media (max-width: 400px) {
            .folder-icon {
                width: 50px;
                /* Reducir aún más el tamaño del icono en pantallas muy pequeñas */
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

        .delete-icon {


            background: red;

            border-radius: 50%;


            font-size: 18px;


            left: 171px;
            top: -139px;
            color: #fff;

            border: none;

            cursor: pointer;

            width: 30px;
            height: 30px;



        }

        .pagination {
            margin-top: 20px;
            text-align: center;
            /* Alinear el paginador al centro */
            width: 100%;
            /* Establecer un ancho completo */
            display: flex;
            /* Usar flexbox para centrar el contenido */
            justify-content: center;
            /* Centrar horizontalmente */
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f09121;
            border: 1px solid #ccc;
            margin-right: 5px;
            text-decoration: none;
            color: #333;
            border-radius: 12%;
        }

        .pagination a.active {
            background-color: #f09121;
            color: #fff;
        }

        .pagination a:hover {
            background-color: yellow;
        }


        .preview-image {
            width: 100px;
            /* Tamaño de las imágenes de vista previa */
            height: auto;
            /* Mantener la proporción */
            margin: 5px;
            border: 1px solid #ddd;
            /* Borde opcional para mejor visualización */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            /* Sombra opcional para mejor visualización */
        }

        .image-container {
            display: inline-block;
            /* Permitir múltiples imágenes por línea */
            position: relative;
        }

        .delete-button {
            position: absolute;
            top: -5px;
            /* Ajusta la posición del botón para que esté más cerca de la esquina */
            right: -5px;
            /* Ajusta la posición del botón para que esté más cerca de la esquina */
            width: 20px;
            /* Define el ancho del botón */
            height: 20px;
            /* Define la altura del botón */
            font-size: 12px;
            /* Ajusta el tamaño de la fuente del botón */
            padding: 0;
            /* Elimina el padding del botón */
            border: none;
            background-color: red;
            color: white;
            border-radius: 50%;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            .preview-image {
                width: 80px;
                /* Tamaños más pequeños para dispositivos móviles */
            }
        }

        @media (max-width: 400px) {
            .preview-image {
                width: 60px;
                /* Tamaños aún más pequeños para pantallas muy pequeñas */
            }
        }

        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: left;
            font-size: 15px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Estilos para el modal de eliminación */
        .delete-modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .delete-modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .delete-close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .delete-close:hover,
        .delete-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #confirmDelete,
        #cancelDelete {
            padding: 10px 20px;
            background-color: black;
            /* Color de fondo negro */
            color: white;
            /* Color del texto blanco */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 5px 10px 0;
            /* Margen para separar los botones */
        }

        #confirmDelete:hover,
        #cancelDelete:hover {
            background-color: #333;
            /* Cambio de color al pasar el ratón */
        }

        .small-icon {
            width: 120px;
            /* Puedes ajustar el tamaño según sea necesario */
            height: auto;
            /* Mantiene la proporción de la imagen */
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="https://www.croccancun.com/eventos/index2.php">
                <div class="sidebar-brand-icon rotate-n-0">
                    <img src='../eventos/fotos/LOGOCROC.png' class='like-img small-icon' alt='CROC'>
                </div>

                <div class="sidebar-brand-text mx-3">CROC ADMIN <sup>V.1.0</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="https://www.croccancun.com/eventos/index2.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Carpetas
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span>Vista</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Usuario</h6>
                        <a class="collapse-item" href="buttons.html">Editar Perfil</a>
                        <a class="collapse-item" href="buttons.html">Cambiar Contraseña</a>
                        <a class="collapse-item" href="buttons.html">Calendario de Eventos</a>
                        <a class="collapse-item" href="buttons.html">Alta Noticias Croc</a>
                        <a class="collapse-item" href="buttons.html">Alta Videos Croc</a>
                        <a class="collapse-item" href="buttons.html">Estatus de Radio</a>

                    </div>
                </div>
            </li>

            <!-- Divider -->
           

            <!-- Heading -->


            <!-- Nav Item - Charts -->


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->


                        <!-- Dropdown - Alerts -->


                        <!-- Nav Item - Messages -->


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">User</span>
                                <img class="img-profile rounded-circle" src="https://i1.wp.com/lopezdoriga.com/wp-content/uploads/2018/05/croc.png?fit=1920%2C1080&ssl=1">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Configuración
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Actividad
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cerrar Sesión
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                        <h1 class="h3 mb-4 text-gray-800">COMUNICACIÓN SOCIAL Y RELACIONES PÚBLICAS</h1>

                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Carpetas Totales</div>
                                            <?php
                                            include '../eventos/funtion/conexion.php';

                                            try {
                                                // Consulta para obtener el total de registros en la tabla
                                                $sql = "SELECT COUNT(*) as carpeta FROM folders;";
                                                $result = $conn->query($sql);

                                                if ($result) {
                                                    $row = $result->fetch_assoc();
                                                    $totalRegistros = $row['carpeta'];

                                                    echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>" . $totalRegistros . "</div>";

                                                    // Resto del código que desees ejecutar si la consulta fue exitosa
                                                } else {
                                                    echo "Error al ejecutar la consulta.";
                                                }
                                            } catch (PDOException $e) {
                                                echo "Error al ejecutar la consulta: " . $e->getMessage();
                                            }

                                            ?>


                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->


                        <!-- Earnings (Monthly) Card Example -->

                    </div>

                    <!-- Pending Requests Card Example -->


                    <!-- Content Row -->


                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->


                        <!-- Content Row -->
                        <div class="row">

                            <!-- Area Chart -->
                            <div class="col-xl-12 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Alta de Carpetas</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <form id="form" method="POST" action="crear_carpeta.php" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <div class="form-group">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="nombre_carpeta" class="form-label">Nombre de la Carpeta:</label>
                                                            <input type="text" name="nombre_carpeta" class="form-control" id="nombre_carpeta">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <br>
                                                            <button type="submit" name="crear_carpeta">Crear Carpeta</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>



                                        </form>


                                        <div id="folder-icons" class="folder-grid">
                                            <!-- Aquí se agregarán los iconos de las carpetas dinámicamente -->
                                            <?php
                                            // Conexión a la base de datos
                                            include '../eventos/funtion/conexion.php';

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
                                                echo "<div class='folder-name' data-folder-id='" . $row['id'] . "'>" . $row['name'] . "</div>";
                                                echo "<div class='delete-icon' data-folder-id='" . $row['id'] . "'>&times;</div>";
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
                                            $max_paginas_mostradas = 5;

                                            // Establecer página inicial y final para mostrar
                                            $pagina_inicial = max(1, $pagina_actual - floor($max_paginas_mostradas / 2));
                                            $pagina_final = min($total_paginas, $pagina_inicial + $max_paginas_mostradas - 1);

                                            // Ajustar la página inicial si la página final se ha movido demasiado
                                            $pagina_inicial = max(1, $pagina_final - $max_paginas_mostradas + 1);

                                            // Botón de inicio
                                            if ($pagina_actual > 1) {
                                                echo "<a href='?page=1'>&lt;&lt;</a>";
                                            }

                                            // Puntos suspensivos antes de la primera página
                                            if ($pagina_inicial > 1) {
                                                echo "<span>&hellip;</span>";
                                            }

                                            // Mostrar enlaces de paginación
                                            for ($i = $pagina_inicial; $i <= $pagina_final; $i++) {
                                                $active_class = ($i == $pagina_actual) ? 'active' : '';
                                                echo "<a href='?page=$i' class='$active_class'>$i</a>";
                                            }

                                            // Puntos suspensivos después de la última página
                                            if ($pagina_final < $total_paginas) {
                                                echo "<span>&hellip;</span>";
                                            }

                                            // Botón de fin
                                            if ($pagina_actual < $total_paginas) {
                                                echo "<a href='?page=$total_paginas'>&gt;&gt;</a>";
                                            }
                                            ?>


                                        </div>



                                        <!-- Formulario para subir imágenes -->
                                        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                                            <input type="file" name="image[]" id="image" multiple>
                                            <!-- Campo oculto para almacenar la carpeta seleccionada -->
                                            <input type="hidden" name="selected_folder" id="selected_folder" value="">
                                            <button type="submit" name="submit">Subir Imagen</button>
                                        </form>
                                    </div>

                                    <!-- Modal para cambiar el nombre de la carpeta -->
                                    <div id="renameModal" class="modal">
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <form id="renameForm" action="renombrar_carpeta.php" method="post">
                                                <input type="hidden" name="folder_id" id="modalFolderId">




                                                <div class="modal-header">
                                                    <h5 class="modal-title" for="new_folder_name">Ingrese Nuevo Nombre</h5>
                                                </div>

                                                <textarea class="form-control" name="new_folder_name" id="newFolderName"></textarea>

                                                <br>
                                                <button type="submit">Cambiar Nombre</button>



                                            </form>
                                        </div>
                                    </div>

                                    <!-- Modal para eliminar carpeta -->
                                    <div id="deleteModal" class="modal">
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <p>¿Está seguro de que desea eliminar esta carpeta y su contenido?</p>
                                            <button id="confirmDelete">Sí, eliminar</button>
                                            <button id="cancelDelete">Cancelar</button>
                                        </div>
                                    </div>




                                    <!-- Contenedor de vista previa de imágenes -->
                                    <div id="image-preview-container"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center">
                        <span>Todos los Derechos Reservados CROC 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo para irte?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Cerrar sesión" a continuación si estás listo para finalizar tu sesión actual.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="login.html">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const folderIcons = document.querySelectorAll('.folder-icon');
            const folderNames = document.querySelectorAll('.folder-name');
            const renameModal = document.getElementById('renameModal');
            const closeModal = document.querySelector('.close');
            const modalFolderId = document.getElementById('modalFolderId');
            const newFolderName = document.getElementById('newFolderName');
            const renameForm = document.getElementById('renameForm');
            const deleteIcons = document.querySelectorAll('.delete-icon');
            const deleteModal = document.getElementById('deleteModal');
            const deleteClose = deleteModal.querySelector('.close');
            const confirmDelete = document.getElementById('confirmDelete');
            const cancelDelete = document.getElementById('cancelDelete');
            let folderIdToDelete = null;


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

            // Manejar la barra de progreso en la subida de imagen
            const uploadForm = document.getElementById('uploadForm');
            uploadForm.addEventListener('submit', function() {
                NProgress.start();

            });

            // Manejar redireccionamiento a catálogo con doble clic
            folderIcons.forEach(function(folderIcon) {
                folderIcon.addEventListener('dblclick', function() {
                    // Redireccionar al usuario a catalogo.php, pasando el ID de la carpeta como parámetro
                    window.location.href = 'catalogo.php?id=' + folderIcon.dataset.folderId;
                });
            });

            // Abrir el modal al hacer doble clic en el nombre de la carpeta
            folderNames.forEach(function(folderName) {
                folderName.addEventListener('dblclick', function() {
                    modalFolderId.value = folderName.dataset.folderId;
                    newFolderName.value = folderName.textContent;
                    renameModal.style.display = 'block';
                });
            });

            // Cerrar el modal al hacer clic en la 'x'
            closeModal.addEventListener('click', function() {
                renameModal.style.display = 'none';
            });

            // Cerrar el modal al hacer clic fuera del contenido del modal
            window.addEventListener('click', function(event) {
                if (event.target == renameModal) {
                    renameModal.style.display = 'none';
                }
            });


            // Manejar clic en el ícono de eliminación
            deleteIcons.forEach(function(deleteIcon) {
                deleteIcon.addEventListener('click', function() {
                    folderIdToDelete = deleteIcon.dataset.folderId;
                    deleteModal.style.display = 'block';
                });
            });

            // Cerrar el modal de eliminación al hacer clic en la 'x'
            deleteClose.addEventListener('click', function() {
                deleteModal.style.display = 'none';
            });

            // Cerrar el modal de eliminación al hacer clic en cancelar
            cancelDelete.addEventListener('click', function() {
                deleteModal.style.display = 'none';
            });

            // Manejar la confirmación de eliminación
            confirmDelete.addEventListener('click', function() {
                if (folderIdToDelete) {
                    window.location.href = 'eliminar_carpeta.php?id=' + folderIdToDelete;
                }
            });

            // Cerrar el modal de eliminación al hacer clic fuera del contenido del modal
            window.addEventListener('click', function(event) {
                if (event.target == deleteModal) {
                    deleteModal.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>