<?php
include "header.php";
session_start();
function str_to_array($str)
{
    return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
}

$_key = $mytype = $encryption_key = $check = '';
?>




<div class="container">
    <div class="card shadow" style="border-top: 3px solid blue; margin-bottom: 30px;">
        <div class="card-body text-justify">
            <div style="padding:20px;">
                <div class="row">
                    <div class="col-md-7">
                        <h3>Decryption Mode</h3>
                        <hr>
                        <form class="form-group" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Decryption Algorithm</label>
                                    <select class="form-control" name='mytype' required>
                                        <option value="--">:::- Decryption ALGORITHM -:::</option>
                                        <option value="RSA">Rivest–Shamir–Adleman (RSA) Algorithm</option>
                                        <option value="Elgama">Elgamal Algorithm</option>

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Description Key</label>

                                    <input type="text" name="key" class="form-control" required>
                                </div>
                            </div>
                            <label>Enter Encryption Text</label>

                            <textarea class="form-control" name="check" rows="5" required></textarea>

                            <br>
                            <input type="submit" name="dec" class="btn btn-primary col-md-6" value="Decrypt Now">
                        </form>
                    </div>
                    <?php

                    if (isset($_POST['dec'])) {
                        $mytype = $_POST['mytype'];
                        $_key = $_POST['key'];
                        $check = $_POST['check'];

                        usleep(mt_rand(100, 10000));
                        $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
                        $mem1 = memory_get_usage();


                        $sql = "SELECT * FROM `algo_now` WHERE `algo_type`='$mytype' AND `algo_key`='$_key' AND `encrypt_text`='$check' ";

                        $now = mysqli_query($con, $sql);
                        $f = mysqli_fetch_array($now);
                        if ($f) {
                    ?>
                            <div class="col-md-5">
                                <h3>Output</h3>
                                <hr>
                                <p>Encrypted File inforation</p>
                                <hr>
                                <p><b>File Type:</b>
                                    <?php
                                    $type = substr($f['algo_file'], -3);
                                    if ($type == 'jpeg' || $type == 'jpg' || $type == 'png') {
                                        echo "Image Files" . " (." . $type . ")";
                                    }
                                    if ($type == 'mp3') {
                                        echo "Audio Files" . " (." . $type . ")";
                                    }
                                    if ($type == 'mp4') {
                                        echo "Video Files" . " (." . $type . ")";
                                    }
                                    ?>

                                </p>
                                <p><b>Algorithm: </b>
                                    <?php
                                    $algo = substr($f['algo_type'], -3);
                                    if ($algo == 'RSA') {
                                        echo "Rivest–Shamir–Adleman (RSA) Algorithm";
                                    } else {
                                        echo "Elgama Algorithm";
                                    }
                                    ?></p>
                                <div>
                                    <?php
                                    $type = substr($f['algo_file'], -3);
                                    if ($type == 'jpeg' || $type == 'jpg' || $type == 'png') {
                                    ?>
                                        <img src="<?php echo 'upload/' . $f['algo_file']; ?>" alt="" style="width:auto; height:200px;">
                                    <?php }

                                    if ($type == 'mp3') {
                                    ?>
                                        <audio controls>
                                            <source src="horse.ogg" type="audio/ogg">
                                            <source src="<?php echo 'upload/' . $f['algo_file']; ?>" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    <?php }
                                    if ($type == 'mp4') {
                                    ?>
                                        <video width="auto" height="240" controls>
                                            <source src="<?php echo 'upload/' . $f['algo_file']; ?>" type="video/mp4">
                                            <source src="movie.ogg" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php }

                                    ?>
                                </div>


                                <br>



                            </div>
                    <?php
                        } else {
                            ?>
                            <div class="col-md-5">
                                <h3>Output</h3>
                                <hr>
                                <div class="bg-danger p-5 mt-3 text-center text-white">
                                    <i class="fa fa-info-circle text-white fa-3x"></i>
                                    <h3>Algorithm Key Error</h3>
                                    <p>Cannot decrypt any information, kindly check your input and try again.</p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>