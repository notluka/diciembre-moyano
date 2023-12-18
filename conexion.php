<?php
function conectar()
{
    $host = "localhost";
    $username = "id20664148_datitos";
    $password = "1!aAbbbb";
    $database = "id20664148_database1";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    return $conn;
}
?>