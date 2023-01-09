<?php
include "header.php";
session_start();
?>




<div class="container">
    <div class="card shadow" style="border-top: 3px solid blue; margin-bottom: 30px;">
        <div class="card-body text-justify">
            <div style="padding:20px;">
                <div class="row">
                    <div class="col-md-7">
                        <h3>Encryption Mode</h3>
                        <hr>
                        <?php
                        function str_to_array($str)
                        {
                            return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
                        }

                        $_key = $mytype = $encryption_key = $encryption = '';
                        if (isset($_POST['enc'])) {
                            $mytype = $_POST['mytype'];
                            $_key = $_POST['key'];
                            usleep(mt_rand(100, 10000));
                            $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
                            $mem1 = memory_get_usage();
                            $check = "Multimedia";
                            if ($mytype == 'RSA') {
                                //Rivest–Shamir–Adleman (RSA) Algorithm
                                $encryption_key = $_key;
                                $ciphering = "AES-128-CTR";
                                $iv_length = openssl_cipher_iv_length($ciphering);
                                $options   = 0;
                                $encryption_iv = random_bytes($iv_length);
                                $encryption = openssl_encrypt($check, $ciphering, $encryption_key, $options, $encryption_iv);
                                // code to store multimedia file
                                $fileInfo = PATHINFO($_FILES["anyfile"]["name"]);
                                    if ($fileInfo['extension'] == "png" or $fileInfo['extension'] == "jpg" or $fileInfo['extension'] == "jpeg" or $fileInfo['extension'] == "mp3" or $fileInfo['extension'] == "mp4") {
                                        $filename = $_FILES["anyfile"]["name"];
                                        $tempname = $_FILES["anyfile"]["tmp_name"];
                                        $newFileName = $fileInfo['filename'] . "-" . time() . "." . $fileInfo['extension'];
                                        $folder = "upload/" . $newFileName;
                                        // Now let's move the uploaded file into the folder: ebook    
                                        move_uploaded_file($tempname, $folder);
                                        // Get all the submitted data from the form
                                        $sql = "INSERT INTO `algo_now`(`algo_type`, `algo_file`, `algo_key`, `encrypt_text`, `encrypt_time`, `encrypt_size`) VALUES ('$mytype','$newFileName','$_key','$encryption','$time','$mem1')";

                                        // Execute query
                                        $save = mysqli_query($con, $sql);
                                    } else{
                                        echo "<script>window.alert('This file is not a multimedia or not an accepted file extension')</script>";
                                        }
                            } 
                            elseif ($mytype == 'Elgama') {
                                $encryption_key = $_key;
                                $ciphering = "BF-CBC";
                                $iv_length = openssl_cipher_iv_length($ciphering);
                                $options   = 0;
                                $encryption_iv = rand();
                                $encryption = openssl_encrypt($check, $ciphering, $encryption_key, $options, $encryption_iv);
                                // code to store multimedia file
                                $fileInfo = PATHINFO($_FILES["anyfile"]["name"]);
                                if ($fileInfo['extension'] == "png" or $fileInfo['extension'] == "jpg" or $fileInfo['extension'] == "jpeg" or $fileInfo['extension'] == "mp3" or $fileInfo['extension'] == "mp4") {
                                    $filename = $_FILES["anyfile"]["name"];
                                    $tempname = $_FILES["anyfile"]["tmp_name"];
                                    $newFileName = $fileInfo['filename'] . "-" . time() . "." . $fileInfo['extension'];
                                    $folder = "upload/" . $newFileName;
                                    // Now let's move the uploaded file into the folder: ebook    
                                    move_uploaded_file($tempname, $folder);
                                    // Get all the submitted data from the form
                                    $sql = "INSERT INTO `algo_now`(`algo_type`, `algo_file`, `algo_key`, `encrypt_text`, `encrypt_time`, `encrypt_size`) VALUES ('$mytype','$newFileName','$_key','$encryption','$time','$mem1')";

                                    // Execute query
                                    $save = mysqli_query($con, $sql);
                                } else {
                                    echo "<script>window.alert('This file is not a multimedia or not an accepted file extension')</script>";
                                }
                                
                            } else {
                                echo "<script>window.alert('please select Encrytion Type');</script>";
                            }
                        }
                        ?>
                        <form class="form-group" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Encryption Algorithm</label>
                                    <?php if ($mytype == 'RSA') {
                                    ?>
                                        <input type="text" value="Rivest–Shamir–Adleman (RSA) Algorithm" class="form-control" disabled required>
                                    <?php } elseif ($mytype == 'Elgama') { ?>
                                        <input type="text" value="Elgamal Algorithm" class="form-control" disabled required>

                                    <?php
                                    } else { ?>
                                        <select class="form-control" name='mytype' required>
                                            <option value="--">:::- ENCRYPTION ALGORITHM -:::</option>
                                            <option value="RSA">Rivest–Shamir–Adleman (RSA) Algorithm</option>
                                            <option value="Elgama">Elgamal Algorithm</option>

                                        </select>
                                    <?php } ?>

                                </div>  
                                <div class="col-md-6">
                                    <label>Encryption Key</label>
                                    <?php
                                    if ($encryption_key) {
                                    ?>
                                        <input type="text" name="key" disabled value="<?php if ($encryption_key) {
                                                                                            echo $encryption_key;
                                                                                        } ?>" class="form-control" required>
                                    <?php } else { ?>
                                        <input type="text" name="key" value="<?php if ($encryption_key) {
                                                                                    echo $encryption_key;
                                                                                } ?>" class="form-control" required>
                                    <?php } ?>
                                </div>
                            </div>
                            <label>Choose Multimedia File</label>
                            <input type="file" name="anyfile" class="form-control" required>

                            <br>
                            <input type="submit" name="enc" class="btn btn-primary col-md-6" value="Encrypt Now">
                        </form>
                    </div>
                    <div class="col-md-5">
                        <h3>Output</h3>
                        <hr>
                        <label>Encrypted Text</label>
                        <textarea class="form-control" name="arabic_text" rows='5' id='myInput'><?php echo $encryption; ?></textarea>
                        <br>

                        <?php
                        if ($encryption) {
                        ?>
                            &nbsp;&nbsp;&nbsp;<button onclick="myFunction()" class="btn btn-info">Copy text</button>
                            &nbsp;&nbsp;&nbsp; <a href="decry.php" class="btn btn-success ">Goto Decryption Page</a>
                        <?php
                            // Do stuff
                            usleep(mt_rand(100, 10000));

                            // At the end of your script
                            $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
                            echo '<h3>Execution Time</h3>';
                            echo "<b>Results Timeout:</b> in $time Seconds\n";

                            $mem1 = memory_get_usage();
                            $a = $encryption;
                            echo "<br/><b>Cipher Size: </b>" . ((strlen($a) * 8) / 4) . "Bytes";
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>