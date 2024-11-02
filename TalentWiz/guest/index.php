<?php
include_once '../include/header.php';
echo isset($_SESSION['usertype']);
if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'candidate' || $_SESSION['usertype'] == 'admin')) {
    header('location:' . URL . 'candidate/index.php');
}
?>
<?php //Content Area Start ?>
<div class="content">
    <h1>Welcome to TalentWiz Online Examination Web Application</h1>
</div>
<?php //Content Area End ?>

<?php include_once '../include/footer.php'; ?>