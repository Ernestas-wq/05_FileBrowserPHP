<?php
# Back button
function displayBackButton($path)
{
    echo '
<li> <form action="index.php" method="POST">
<input type="hidden" name="file" value="' . $path . '">
<button class="back" type="submit">
<img class="back_img" src="assets/img/box-arrow-left.svg" alt="">
Go back </button>
</form></li>
';
}
# User UI [Logout, etc..]
function displayUserUI($username)
{
    echo '<div class="userUI">
                    <h4 class="userUI__name">Welcome, ' . $username . '!</h4>
                    <a class="userUI__link" href="login.php?action=logout">Logout</a>
                    </div>';
}

# Upload modal

function displayUploadModal($path)
{
    echo ' <div class="modal_overlay modal_overlay--active" id="uploadModal">

    <form action="upload.php" method="POST" id="uploadForm" class="modal"
    enctype="multipart/form-data">
    <button id="closeUploadModal">Close</button>

    <h3>Select file to upload: <br><br>
     <span>(file will be saved at current directory)</span></h3>
    <input type="hidden" name="file" value="' . $path . '">
    <input class="custom-file-input" type="file" name="fileToUpload" id="fileToUpload">
    <button class="upload" type="submit" value="upload" name="confirmUpload">
    Submit upload</button>
    </form>
    ';
}
# New directory
function displayAddNewDir($path)
{
    echo '<li>
                <form action="" method="POST" id="new_dir_form">
                <input type="hidden" name="file" value="' . $path . '">
               <div class="input-container new_dir">
                    <input type="text" id="new_dir" name="new_dir" autocomplete="off" required>
                    <label for="new_dir" class="label-name">
                        <span class="content-name">Add new directory
                        <span class="new_dir__prefix"> (Press enter to confirm)</span>
                        </span>
                    </label>
                </div>
                </form>
                </li>';
}
# Search display
function displaySearch()
{
    echo '<li>
    <div class="input-container search">
    <input type="text" id="search" required autocomplete="off">
    <label for="search" class="label-name">
    <span class="content-name">Search files and directories</span>
    </label>
    </div></li>';
};
function displayOpenUpload($path)
{
    echo '<li>
                <form action="" method="POST">
                <input type="hidden" name="file" value="' . $path . '">
                <input type="hidden" name="uploadModal" value="openUploadModal">
                <button class="back" type="submit">Upload file
                <img class="back_img" src="assets/img/cloud-arrow-up.svg" alt="">
                </button>
                </form>
                </li> ';
};
