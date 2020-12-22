<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/dist/css/main.min.css">
    <title>File browser</title>
</head>

<body>
    <div class="background-container">
        <div class="container">
            <h1>Your file browser</h1>

            <img src="assets/img/moon.png" alt="">
            <div class="stars"></div>
            <div class="twinkling"></div>
            <div class="clouds"></div>
            <h3 class="error" id="new_dir_error"></h3>


            <?php
            if (isset($_REQUEST["file"])) {
                # Get File path
                $file_path = urldecode($_REQUEST["file"]); // Decode URL-encoded string


                // Process download
                if (file_exists($file_path)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file_path));
                    flush(); // Flush system output buffer
                    readfile($file_path);
                    die();
                } else {
                    http_response_code(404);
                    die();
                }
            } else {
                die("Invalid file name!");
            }
            ?>
        </div>
    </div>
</body>

</html>