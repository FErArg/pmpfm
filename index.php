<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso con clave para guardar texto en archivo</title>
</head>
<body>
    <?php
    $archivo = 'youtubeLinks.db';
    $clave_correcta = 'tu_clave_secreta'; // Clave secreta para acceso (reemplaza por la clave que desees)

    $mostrar_formulario = false; // Variable para controlar si se muestra el formulario de ingreso de texto

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se ha enviado la clave
        if (isset($_POST['clave'])) {
            $clave_ingresada = $_POST['clave'];

            // Verificar si la clave ingresada es correcta
            if ($clave_ingresada === $clave_correcta) {
                $mostrar_formulario = true;
            } else {
                echo "<p>Clave incorrecta. Acceso denegado.</p>";
            }
        } else {
            echo "<p>No se ha recibido la clave.</p>";
        }
    }
    ?>

    <?php if (!$mostrar_formulario) : ?>
        <!-- Formulario para ingresar la clave -->
        <form action="" method="post">
            <label for="clave">Ingrese la clave de acceso:</label>
            <input type="password" name="clave" id="clave" required>
            <input type="submit" value="Acceder">
        </form>
    <?php else : ?>
        <!-- Formulario para ingresar texto y mostrar contenido del archivo -->
        <form action="" method="post">
            <label for="texto">Escribe algo:</label>
            <textarea name="texto" id="texto" rows="10" cols="30"></textarea><br><br>
            <input type="submit" value="Guardar">
            <input type="hidden" name="clave" value="<?php echo htmlspecialchars($clave_correcta); ?>">
        </form>

        <?php
        // Mostrar el contenido del archivo en una lista
        if (file_exists($archivo)) {
            $contenido = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            echo "<h2>Contenido del archivo:</h2>";
            echo "<ul>";
            foreach ($contenido as $linea) {
                echo "<li>" . htmlspecialchars($linea) . "</li>";
            }
            echo "</ul>";
        }
        ?>
    <?php endif; ?>
</body>
</html>
