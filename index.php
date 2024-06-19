<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guardar texto en un archivo</title>
</head>
<body>
    <?php
    $archivo = 'youtubeLinks.db';

    // Verificar si el archivo existe
    if (file_exists($archivo)) {
        // Leer el contenido del archivo en un array
        $contenido = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Eliminar duplicados
        $contenido = array_unique($contenido);

        // Guardar el contenido sin duplicados en el archivo
        file_put_contents($archivo, implode(PHP_EOL, $contenido) . PHP_EOL);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se ha enviado algún texto
        if (isset($_POST['texto'])) {
            // Sanitizar y validar el texto
            $texto = filter_var(trim($_POST['texto']), FILTER_SANITIZE_STRING);

            // Verificar si el texto está vacío después de sanitizar
            if (empty($texto)) {
                echo "<p>El texto ingresado no es válido.</p>";
            } else {
                // Leer el contenido del archivo nuevamente para comprobar duplicados
                $contenido = file_exists($archivo) ? file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

                // Comprobar si el texto ya existe en el archivo
                if (in_array($texto, $contenido)) {
                    echo "<p>El texto ya existe en el archivo. No se ha guardado el texto duplicado.</p>";
                } else {
                    // Guardar el texto en el archivo en modo apéndice
                    if (file_put_contents($archivo, $texto . PHP_EOL, FILE_APPEND)) {
                        echo "<p>Texto guardado exitosamente en $archivo</p>";
                    } else {
                        echo "<p>Error al guardar el texto</p>";
                    }
                }
            }
        } else {
            echo "<p>No se ha recibido ningún texto</p>";
        }
    }
    ?>

    <form action="" method="post">
        <label for="texto">Escribe algo:</label>
        <textarea name="texto" id="texto" rows="10" cols="30"></textarea><br><br>
        <input type="submit" value="Guardar">
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
</body>
</html>
