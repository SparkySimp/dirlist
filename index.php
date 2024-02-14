<?php
$path = $_SERVER['REQUEST_URI'];
$isFile = is_file($path);
$isDir = is_dir($path);

function readFileContent($path) {
    $content = file_get_contents($path);
    echo "<pre>$content</pre>";
}
function listDirectory($path) {
    $files = scandir($path);
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            $fullPath = $path . '/' . $file;
            $size = filesize($fullPath);
            $lastModified = date("F d Y H:i:s.", filemtime($fullPath));
            // provide these three fields in three bootstrap columns
            echo "<div class=\"col-4\">";
            echo "<p><a href=\"$fullPath\">$file</a></p>";
            echo "</div>";
            echo "<div class=\"col-4\">";
            echo "<p>$size bytes</p>";
            echo "</div>";
            echo "<div class=\"col-4\">";
            echo "<p>Last modified: $lastModified</p>";
            echo "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directory Listing</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        // if the user uses light mode, adjust the body accordingly,
        // and vice versa. Check the `prefers-color-scheme` media
        // query for that purpose
        document.addEventListener('DOMContentLoaded', (event) => {
            if (window.matchMedia('(prefers-color-scheme: light)').matches) {
                document.documentElement.setAttribute("data-bs-theme", "light");
            } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute("data-bs-theme", "dark");
            }
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Directory Listing</h1>
        <?php
        if ($isFile) {
            readFileContent($path);
        } else if ($isDir) {
            echo "<div class=\"row\">";
            listDirectory($path);
            echo "</div>";
        } else {
            http_response_code(404);
            echo "<p>Invalid path</p>";
        }
        ?>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>