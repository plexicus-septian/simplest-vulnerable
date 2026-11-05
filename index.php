<?php
// Conexión a la base de datos (modifica con tus propios parámetros de conexión)
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "tu_base_de_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Vulnerabilidad de SQL Injection
// El siguiente código es vulnerable a SQL Injection ya que el input del usuario se concatena directamente en la consulta SQL sin validación o sanitización.
if(isset($_GET['id'])) {
    $id = $_GET['id']; // Input del usuario tomado directamente desde la URL
    $sql = "SELECT * FROM usuarios WHERE id = $id"; // Vulnerable a SQL Injection
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Nombre: " . $row["nombre"]. "<br>";
        }
    } else {
        echo "0 resultados";
    }
}

// Protección contra Cross-Site Scripting (XSS)
// El input del usuario se codifica antes de imprimirlo en el HTML para evitar que se interprete como marcado o script ejecutable.
if(isset($_GET['mensaje'])) {
    // El input del usuario se codifica con htmlspecialchars para prevenir XSS
    // (ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' escapan comillas, evitan cadenas inválidas y respetan la codificación de la página).
    $mensaje = htmlspecialchars(is_string($_GET['mensaje']) ? $_GET['mensaje'] : '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    echo "<div>$mensaje</div>";
}

// Cerrar conexión
$conn->close();
?>
