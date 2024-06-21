<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso con clave para guardar texto en archivo</title>
</head>
<body>
    <?php
    $archivo = 'youtubeLinks.db';
    $clave_correcta = 'ClaveAcceso'; // Clave secreta para acceso (reemplaza por la clave que desees)
    $mostrar_formulario = false; // Variable para controlar si se muestra el formulario de ingreso de texto
    $apiKey = 'YOUTUBE_API_KEY'; // Your youtube api key

    /* ******************************************************************** */
    function checkYouTubeVideoExists($videoUrl, $apiKey) {
        // Extract the video ID from the URL
        $videoId = extractVideoId($videoUrl);
        if (!$videoId) {
            return false;
        }
    
        // YouTube Data API endpoint
        $apiUrl = "https://www.googleapis.com/youtube/v3/videos?id={$videoId}&key={$apiKey}&part=snippet";
    
        // Initialize cURL session
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the cURL request
        $response = curl_exec($ch);
        curl_close($ch);
    
        // Decode the JSON response
        $data = json_decode($response, true);
    
        // Check if the video exists
        if (isset($data['items']) && count($data['items']) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function extractVideoId($videoUrl) {
        $pattern = '/(?:v=|\/)([0-9A-Za-z_-]{11}).*/';
        preg_match($pattern, $videoUrl, $matches);
        return isset($matches[1]) ? $matches[1] : false;
    }

    /* ******************************************************************** */
    ?>

    <?php

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

    <?php  if (!$mostrar_formulario) :     ?>

        <!-- Formulario para ingresar la clave -->
        <form action="" method="post">
            <label for="clave">Ingrese la clave de acceso:</label>
            <input type="password" name="clave" id="clave" required>
            <input type="submit" value="Acceder">
        </form>
        <br>
        <?php else : ?>
        <!-- Formulario para ingresar texto y mostrar contenido del archivo -->
        <form action="" method="post">
            <label for="texto">Escribe algo:</label><br><br>
            <textarea name="texto" id="texto" rows="10" cols="70"></textarea><br><br>
            <input type="submit" value="Guardar">
            <input type="hidden" name="clave" value="<?php echo htmlspecialchars($clave_correcta); ?>">
        </form>
        <br>
    
    <?php    

    // Verificar si el archivo existe
    if (file_exists($archivo)) {
        // Leer el contenido del archivo en un array
        $contenido = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Eliminar duplicados
        $contenido = array_unique($contenido);

        // Guarda el contenido sin duplicados en el archivo
        file_put_contents($archivo, implode(PHP_EOL, $contenido) . PHP_EOL);
    }

    $videoUrl=$_POST['texto'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si se ha enviado algún texto
        if (isset($videoUrl)) {
            // Sanitizar y validar el texto
            // $texto = filter_var(trim($videoUrl), FILTER_SANITIZE_STRING);
            $texto = $videoUrl;

            if (checkYouTubeVideoExists($videoUrl, $apiKey)) {
                echo '<p style="background-color:green";>The YouTube video URL exists.';
                if (empty($texto)) {
                    echo '<p style="background-color:red";>El texto ingresado no es válido.</p>';
                } else {
                    // Leer el contenido del archivo nuevamente para comprobar duplicados
                    $contenido = file_exists($archivo) ? file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

                    // Comprobar si el texto ya existe en el archivo
                    if (in_array($texto, $contenido)) {
                        echo '<p style="background-color:red";>El texto ya existe en el archivo. No se ha guardado el texto duplicado.</p>';
                    } else {
                        // Guardar el texto en el archivo en modo apéndice
                        if (file_put_contents($archivo, $texto . PHP_EOL, FILE_APPEND)) {
                            echo '<p style="background-color:green";>Texto guardado exitosamente en '.$archivo.'</p>';
                        } else {
                            echo '<p style="background-color:red";>Error al guardar el texto</p>';
                        }
                    }
                }
            } else {
                echo '<p style="background-color:red";>The YouTube video URL does not exist or is invalid.</p>';
            }
        } else {
            echo '<p style="background-color:red";>No se ha recibido ningún texto</p>';
        }
    }

    echo "<hr>";
    echo "<h1><b>Links almacenados</b></h1>";

    // Mostrar el contenido del archivo en una lista
    
    if(file_exists($archivo)) {
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
