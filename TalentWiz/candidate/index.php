<?php include_once '../include/header.php'; ?>
<?php include_once "checksession.php"; ?>

<div class="content">
    <?php
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        switch ($msg) {
            case "finishedTest": {
                    echo "<span class='spnGreen'>Your Test has been submitted.The results will be out soon.</span>";
                    break;
                }
            case "feedbackSent": {
                    echo "<span class='spnGreen'>Your Feedback has been recorded.</span>";
                    break;
                }
            case "requestSent": {
                    echo "<span class='spnGreen'>Your Request has been recorded.</span>";
                    break;
                }
            case "passwordUpdated": {
                    echo "<span class='spnGreen'>Your password has been updated.</span>";
                    break;
                }
            case "profileUpdated": {
                    echo "<span class='spnGreen'>Your profile has been updated.</span>";
                    break;
                }
        }
    }
    ?>

</div>

<?php include_once '../include/footer.php'; ?>