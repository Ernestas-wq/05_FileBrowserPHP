<?php
session_start();

if (
    isset($_POST['login'])
    && !empty($_POST['username'])
    && !empty($_POST['password'])
) {
    if (
        $_POST['username'] == 'ern' &&
        $_POST['password'] == 'zefyras'
    ) {
        $_SESSION['logged_in'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = 'ern';
    }
}

?>

<?php
# Defining main globals for path managing
$root_dir = getcwd();
$sep = DIRECTORY_SEPARATOR;
$tmp = explode($sep, $root_dir);
#Making base directory one level up
$dir = array_splice($tmp, count($tmp) - 1);
$base_dir = implode($sep, $tmp);


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
            if (isset($_GET['action']) and $_GET['action'] == 'logout') {
                session_start();
                unset($_SESSION['username']);
                unset($_SESSION['password']);
                unset($_SESSION['logged_in']);
                echo '<h3 class="utility__message">You have logged out</h3>';
                echo '<div class="utility">
                <a class="utility__link" href="index.html">Back to main</a>
                </div>"
                ';
            }
            ?>




            <?php

            if ($_SERVER["REQUEST_METHOD"] === "POST") {


                if ($_SESSION['logged_in'] === true) {
                    $rel = $_POST['file'];
                    // if we are atleast 1 level deep updating base directory
                    $base_dir = $rel ? $base_dir . $rel : $base_dir;

                    # Confirm delete
                    if ($_POST['confirmDelete']) {
                        $path_to_item = $_POST['confirmDelete'];
                        print_r($path_to_item);
                        unlink($path_to_item);
                    }

                    echo "<ul>";



                    echo '<li>
                <form action="" method="POST">
                <input type="hidden" name="file" value="' . $rel . '">
                <input type="hidden" name="uploadModal" value="openUploadModal">
                <button class="back" type="submit">Upload file
                <img class="back_img" src="assets/img/cloud-arrow-up.svg" alt="">
                </button>
                </form>
                </li> ';



                    # New directory
                    echo '<li>
                <form action="" method="POST" id="new_dir_form">
                <input type="hidden" name="file" value="' . $rel . '">
               <div class="input-container new_dir">
                    <input type="text" id="new_dir" name="new_dir" autocomplete="off" required>
                    <label for="new_dir" class="label-name">
                        <span class="content-name">Add new directory
                        <span class="new_dir__prefix"> (Press enter to confirm)</span>
                        </span>
                    </label>
                </div>
                </form>
                </li>
                <li>
                <div class="input-container search">
                <input type="text" id="search" required autocomplete="off">
                <label for="search" class="label-name">
                <span class="content-name">Search files and directories</span>
                </label>
                </div></li>
                ';

                    if ($_POST['new_dir']) {
                        $new_dir = $_POST['new_dir'];
                        mkdir($base_dir . $sep . $new_dir);
                    }
                    if ($rel) {
                        # Generating a back button with a back path if atleast 1 level deep
                        # Back path is basically the path - last elementy after /
                        $back_path = explode($sep, $rel);
                        $back_path = array_filter($back_path);
                        array_pop($back_path);
                        $back_path = implode($sep, $back_path);
                        if ($back_path) {
                            $back_path = $sep . $back_path;
                        }
                        echo "<br>";
                        echo '
                    <li> <form action="index.php" method="POST">
            <input type="hidden" name="file" value="' . $back_path . '">
            <button class="back" type="submit">
            <img class="back_img" src="assets/img/box-arrow-left.svg" alt="">
            Go back </button>
            </form></li>
            ';
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
                        <li data-search="' . $content[$i] . '"><form action="index.php"  method="POST" >
            <input type="hidden" name="file" value="' .
                                $rel . $sep . $content[$i] .
                                '"/>
            <img class="browser_img" alt="folder" src="assets/img/folder.png">
            <button type="submit" class="folder">
            ' . $content[$i] . ' </button>
            </form></li>
            ';
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
                            <a class="openFile" href="/' . $path  . ' "> ' . $content[$i] . '  </a>
                            <form action="" method="POST">
                            <a class="download" href="download.php?file=' . $base_dir . $sep . $content[$i] . '">
                            <img class="download__img" src="assets/img/cloud-arrow-down.svg" alt="trash">
                            Download </a>
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
                        echo ' <div class="modal_overlay modal_overlay--active" id="uploadModal">

                    <form action="upload.php" method="POST" id="uploadForm" class="modal" enctype="multipart/form-data">
                    <button id="closeUploadModal">Close</button>

                    <h3>Select file to upload: <br><br>
                     <span>(file will be saved at project\uploads...)</span></h3>
                    <input type="hidden" name="file" value="' . $rel . '">
                    <input class="custom-file-input" type="file" name="fileToUpload" id="fileToUpload">
                    <button class="upload" type="submit" value="upload" name="confirmUpload">
                    Submit upload</button>
                    </form>
                    ';
                    }
                    echo "</ul>";
                    # User UI corner

                    echo '<div class="userUI">
                    <h4 class="userUI__name">Welcome, ' . $_SESSION['username'] . '!</h4>
                    <a class="userUI__link" href="index.php?action=logout">Logout</a>
                    </div>';
                } else {
                    echo '<h3 class="utility__message utility__message--red"> Sorry, something went wrong.</h3>
                    <div class="utility">
                    <a class="utility__link" href="index.html">Back to main</a>
                    </div>
                    ';
                }
            }
            ?>
        </div>

    </div>
    <script src="js/browser.js"></script>
</body>

</html>