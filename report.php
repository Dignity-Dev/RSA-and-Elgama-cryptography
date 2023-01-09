<?php
include "header.php";
session_start();
?>




<div class="container">
    <div class="card shadow" style="border-top: 3px solid blue; margin-bottom: 30px;">
        <div class="card-body text-justify">
            <div style="padding:20px;">
                <div class="row">
                    <h3>All Report</h3>
                    <hr>
                    <div class="table-responsive">
                        <table class="table dispplay" id="example">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Algorithm</th>
                                    <th>File Type</th>
                                    <th>Encrytion Time</th>
                                    <th>Encrypt Key</th>
                                    <th>Cipher Key</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM `algo_now`";
                                $query = mysqli_query($con, $sql);
                                $count = 1;
                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php
                                            $algo = substr($row['algo_type'], -3);
                                            if ($algo == 'RSA') {
                                                echo "Rivest–Shamir–Adleman (RSA) Algorithm";
                                            } else {
                                                echo "Elgama Algorithm";
                                            }
                                            ?></td>
                                        <td><?php
                                            $type = substr($row['algo_file'], -3);
                                            if ($type == 'jpeg' || $type == 'jpg' || $type == 'png') {
                                                echo "Image";
                                            } elseif ($type == 'mp3') {
                                                echo "Audio";
                                            } elseif ($type == 'mp4') {
                                                echo "Video";
                                            } else {
                                                echo "Unknown";
                                            }
                                            ?></td>
                                        <td><?php echo "in " . number_format($row['encrypt_time'], 4) . "Seconds"; ?></td>
                                        <td><?php echo $row['algo_key']; ?></td>
                                        <td><?php echo $row['encrypt_text']; ?></td>
                                        <td>
                                            <a href="delete.php?id=<?php echo $row['algo_id'];?>" class="btn btn-danger"> <i class="fa fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php
    include "footer.php";
    ?>