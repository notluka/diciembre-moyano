<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Denuncia</title>
    <link rel="stylesheet" type="text/css" href="procesar-denuncia.css">
    </head>
<body>
    <header class="App-header">
        <div class="logo-container">
            <!--  imagen logo -->
            <img src="./public/logo.jpeg" alt="Logo de la plataforma" />
        </div>
        <div class="project-info">
            <h1>Plataforma de Denuncias Ciudadanas</h1>
            <div class="shortcuts">
                <a href="./Novedades.html">Novedades</a>
                <a href="./Denuncia.html">Haz una Denuncia</a>
                <a href="./index.html">Home</a>
            </div>
        </div>
    </header>
    
    <div class="message-container">
        <?php
        include('./conexion.php'); // Incluye el archivo de conexión
        
        // Recibir datos del formulario
        $categoria_id = $_POST['categoria'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $numDocumento = $_POST['numDocumento'];
        $numDomicilio = $_POST['numDomicilio'];
        $numTelefono = $_POST['numTelefono'];
        $correoElectronico = $_POST['correoElectronico'];
        
        // Conectar a la base de datos
        $conn = conectar();
        
        // Verificar la unicidad del número de denuncia
        do {
            $numDenuncia = rand(100000, 999999); // Número aleatorio de 6 dígitos
        
            // Consulta para verificar la existencia del número de denuncia
            $verificarExistencia = "SELECT COUNT(*) as count FROM denuncias WHERE numero_denuncia = '$numDenuncia'";
            $result = $conn->query($verificarExistencia);
        
            if ($result !== false && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $count = $row['count'];
        
                // Si count es 0, el número de denuncia no existe en la base de datos y se puede utilizar
            } else {
                echo "Error al verificar la existencia del número de denuncia.";
                break;
            }
        } while ($count > 0);
        
        // Preparar la consulta SQL
        $sql = "INSERT INTO denuncias (categoria_id, titulo, descripcion, numero_denuncia, num_documento, num_domicilio , num_telefono, correo_electronico) 
                VALUES ('$categoria_id', '$titulo', '$descripcion', '$numDenuncia', '$numDocumento', '$numDomicilio', '$numTelefono', '$correoElectronico')";
        
        if ($conn->query($sql) === TRUE) {
            // Si la denuncia se registró correctamente
            echo '<p class="success-message">Denuncia registrada correctamente. ¡Gracias por tu participación!</p>';
            echo '<img src="./public/participacion.jpeg" alt="Colaboración" class="colaboracion-image">';
        } else {
            // Si hay un error al registrar la denuncia
            echo '<p class="error-message">Error al registrar la denuncia. Por favor, inténtalo nuevamente o contáctanos.</p>';
            echo '<img src="./public/error.jpeg" alt="Error" class="colaboracion-image">';
        }
        
        // Cerrar la conexión
        $conn->close();
        ?>
    
    </div>
    
    <footer>
        <p>Contacto: contacto@plataformadenuncias.com</p>
        <p>&copy; 2023 Plataforma de Denuncias Ciudadanas. Todos los derechos reservados.</p>
    </footer>