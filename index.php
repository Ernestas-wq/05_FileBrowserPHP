<?php
require('helpers/displays.php');
require('helpers/helperFoos.php');
session_start();
# Defining main globals for path managing
$sep = DIRECTORY_SEPARATOR;
# Change levels if you want to browse on higher level
$base_dir = defineBaseDir(getcwd(), 1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

            if ($_SERVER["REQUEST_METHOD"] === "POST") {

                if ($_SESSION['logged_in'] === true) {

                    $rel = $_POST['file'];
                    // if we are atleast 1 level deep updating base directory
                    $base_dir = $rel ? $base_dir . $rel : $base_dir;
                    #Display current browsing dir..
                    echo '<div class="utility utility__topLeft"><h3 class=utility__message">
                     ' . $base_dir .  '  </h3> </div>';
                    # Confirm delete
                    if ($_POST['confirmDelete']) {
                        $path_to_item = $_POST['confirmDelete'];
                        unlink($path_to_item);
                    }
                    echo "<ul>";
                    # Upload
                    displayOpenUpload($rel);

                    # New directory & Search
                    displayAddNewDir($rel);
                    displaySearch();

                    if ($_POST['new_dir']) {
                        $new_dir = $_POST['new_dir'];
                        mkdir($base_dir . $sep . $new_dir);
                    }
                    if ($rel) {
                        # Generating a back button with a back path if atleast 1 level deep
                        # Back path is basically the path - last element after /
                        $back_path = explode($sep, $rel);
                        $back_path = array_filter($back_path);
                        array_pop($back_path);
                        $back_path = implode($sep, $back_path);
                        if ($back_path) {
                            $back_path = $sep . $back_path;
                        }
                        echo "<br>";
                        displayBackButton($back_path);
                    }
                    // Getting content from new directory
                    // Printing all directories
                    $content = scandir($base_dir);
                    for ($i = 2; $i < count($content); $i++) {
                        # Define new current directory
                        $curr_dir = $base_dir . $sep . $content[$i];
                        if (is_dir($curr_dir)) {
                            #If it's a directory making a form with new path..
                            echo '
                        <li data-search="' . $content[$i] . '">
                        <form action="index.php"  method="POST" >
            <input type="hidden" name="file" value="' .
                                $rel . $sep . $content[$i] . '"/>
            <img class="browser_img" alt="folder" src="assets/img/folder.png">
            <button type="submit" class="folder">
            ' . $content[$i] . ' </button></form></li>';
                        }
                    }
                    #printing all files
                    for ($i = 2; $i < count($content); $i++) {

                        if (is_file($base_dir . $sep . $content[$i])) {
                            $curr_dir = $base_dir . $sep . $content[$i];
                            # Getting file extension to show correct image
                            $split = explode('.', $content[$i]);
                            $ext = $split[count($split) - 1];
                            # Getting the relative path and putting it on href
                            $path = $rel ? $rel . $sep . $content[$i] : $content[$i];
                            # Need to trim the first slash so it refers to root directory
                            $path = ltrim($path, $sep);
                            # File with all its options (Delete, download..)..
                            echo '<li data-search="' . $content[$i] . '"><div class="file">
                            <img class="file_img" alt="file" src="assets/img/' . $ext . '.png">
                            <a target="_blank" rel="noopener noreferrer" class="openFile"
                             href="/' . $path  . ' "> ' . $content[$i] . ' </a>
                            <form action="" method="POST">
                            <a class="download"
                            href="download.php?file=' . $base_dir . $sep . $content[$i] . '">
                            <img class="download__img"
                            src="assets/img/cloud-arrow-down.svg" alt="trash">Download </a>
                            <input type="hidden" name="file" value="' . $rel . '">
                            <input type="hidden" name="delete" value="' . $curr_dir . '">
                            <button class="delete" type="submit">Delete
                            <img class="delete__bin" src="assets/img/trash.svg" alt="trash">
                            </button>
                            </form>
                </div></li>';
                        }
                    }


                    #Delete
                    if ($_POST['delete']) {
                        $delete_path = $_POST['delete'];
                        $temp = explode($sep, $delete_path);
                        $fileName = $temp[count($temp) - 1];

                        echo '<div class="modal_overlay modal_overlay--active" id="confirmDeleteModal">
                    <form action="" method="POST" id="confirmDelete" class="modal">
                    <h3>Are you sure you want to delete <span>' . $fileName . '</span> ? </h3>
                    <input type="hidden" name="file" value="' . $rel . '">
                    <input type="hidden" name="confirmDelete" value="' . $delete_path . '">
                    <button class="yes" type="submit">Yes</button>
                    <button class="no">No</button>


                    </form>
                </div>
                    ';
                    }
                    #Upload
                    if ($_POST['uploadModal']) {
                        displayUploadModal($base_dir);
                    }
                    echo "</ul>";
                    # User UI corner
                    displayUserUI($_SESSION['username']);
                } else {
                    echo '<h3 class="utility__message utility__message--red"> Sorry, username
                     or password was not correct.</h3>
                    <div class="utility">
                    <a class="utility__link" href="index.html">Back to main</a>
                    </div>
                    ';
                }
            } else {
                echo '<h3 class="utility__message">Failed to request data</h3>
                <div class="utility">
            <a class="utility__link" href="index.html">Back to main</a>
            </div>';
            }
            ?>
        </div>

    </div>
    <script src="js/browser.js"></script>
</body>

</html>