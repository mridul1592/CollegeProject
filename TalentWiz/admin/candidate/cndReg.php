<?php
include_once '../../include/header.php';
?>
<div class="content">
    <h4 class="pageHeader">Add Candidate</h4>
    <form method="post">
        <?php
        if (isset($_GET['pageView']) && $_GET['pageView'] == 1) {
            include_once 'cndReg1.php';
        } else if (isset($_GET['pageView']) && $_GET['pageView'] == 2) {
            include_once 'cndReg2.php';
        } else if (isset($_GET['pageView']) && $_GET['pageView'] == 3) {
            include_once 'cndReg3.php';
        } else if (isset($_GET['pageView']) && $_GET['pageView'] == 4) {
            include_once 'cndReg4.php';
        }
        ?>
    </form>
</div>
<?php
include_once '../../include/footer.php';
?>