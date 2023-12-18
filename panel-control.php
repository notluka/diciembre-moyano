<?php
session_start();

// Incluir la función conectar()
include('conexion.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["correo"])) {
    header("Location: login.php");
    exit();
}

// Obtener los datos de la base de datos (puedes personalizar esta consulta según tus necesidades)
$conn = conectar();

// Obtener las categorías para el filtro
$consultaCategorias = "SELECT * FROM categorias";
$resultadoCategorias = $conn->query($consultaCategorias);

// Construir la consulta de denuncias con filtro por categoría
$condicionCategoria = "";
if (isset($_GET["categoria"]) && $_GET["categoria"] !== "") {
    $condicionCategoria = " WHERE denuncias.categoria_id = " . $_GET["categoria"];
}

$consultaDenuncias = "SELECT denuncias.*, categorias.nombre as nombre_categoria FROM denuncias 
                     INNER JOIN categorias ON denuncias.categoria_id = categorias.id" . $condicionCategoria;
$resultadoDenuncias = $conn->query($consultaDenuncias);

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control</title>
    <link rel="stylesheet" type="text/css" href="panel-control.css">
</head>
<body>
    <header>
        <div class="profile-info">
            <!-- Mensaje de bienvenida -->
            <p>Bienvenido, <?php echo $_SESSION["correo"]; ?>.</p>

            <!-- Imagen de perfil -->
            <img src="./public/perfil.png" alt="Icono de perfil" />
        </div>
        
        <!-- Enlace para cerrar sesión -->
        <a href="./cerrar-sesion.php" class="logout-link">Cerrar Sesión</a>
    </header>

    <div class="main-content">
        <h2>Panel de Control</h2>
        <h3>Bienvenido, <?php echo $_SESSION["correo"]; ?>.</h3>

        <!-- Agrega el formulario para el filtro de categorías en la sección HTML -->
        <form action="" method="get">
            <label for="categoria">Filtrar por Categoría:</label>
            <select name="categoria" id="categoria">
                <option value="">Todas las categorías</option>
                <?php
                // Mostrar las opciones de categorías
                while ($rowCategoria = $resultadoCategorias->fetch_assoc()) {
                    $selected = (isset($_GET["categoria"]) && $_GET["categoria"] == $rowCategoria["id"]) ? "selected" : "";
                    echo "<option value='" . $rowCategoria["id"] . "' $selected>" . $rowCategoria["nombre"] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Filtrar">
        </form>

        <!-- Mostrar las denuncias en forma de "cards" -->
        <div class="card-container">
            <?php
            // Mostrar las denuncias en forma de "cards"
            while ($rowDenuncia = $resultadoDenuncias->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<h4>" . $rowDenuncia["titulo"] . "</h4>";
                echo "<p><strong>Categoría:</strong> " . $rowDenuncia["nombre_categoria"] . "</p>";
                echo "<p><strong>Descripción:</strong> " . $rowDenuncia["descripcion"] . "</p>";
                // Agrega más detalles según sea necesario
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
