
            <?php
            if (isset($_REQUEST["file"])) {
                # Get File path
                $file_path = urldecode($_REQUEST["file"]); // Decode URL-encoded string
                print_r($file_path);

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
