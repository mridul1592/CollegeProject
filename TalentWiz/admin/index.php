<?php include_once '../include/header.php'; ?>
<?php include_once "checksession.php"; ?>

<div class="content">
    <?php
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        switch ($msg) {
            case "mailSent": {
                    echo "<span class='spnGreen'>The mail has been sent!</span>
                        <script language=Javascript>
                            setTimeout('window.close()',3000);
                        </script>";
                    break;
                }
            case "userAdded": {
                    echo "<span class='spnGreen'>New User Added</span>";
                    break;
                }
            case "passwordUpdated": {
                    echo "<span class='spnGreen'>Password Updated</span>";
                    break;
                }
            case "profileUpdated": {
                    echo "<span class='spnGreen'>Profile Updated</span>";
                    break;
                }
        }
    }
    ?>
    </div>
</div>
<?php //Content Area End ?>

<?php include_once '../include/footer.php'; ?>