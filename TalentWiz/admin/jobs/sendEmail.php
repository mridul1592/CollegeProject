<?php
include_once '../../include/settings.php';

$query = "select *,(select cndFirstName from tblcandidate where cndId=jt.cndId) as cndName,(select cndEmailOfficial from tblcandidate where cndId=jt.cndId) as cndEmail from tbljobtest jt where jobTestId=" . $_GET['jobTestId'];
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
if ($row['jobIsSelected'] == true) {
    $subject = "Congratulations!!";
    $message = "Congratulations " . $row['cndName'] . "!! you have cleared the first round. Our HR will contact you soon.";
} else {
    $subject = "Test Results";
    $message = "We're sorry but you did not clear the exam!";
}
$headers = "admin@talentwiz.com";
if (isset($_POST['smtSend'])) {
    $to = $_POST['txtTo'];
    $headers = "From:" . $_POST['txtFrom'];
    $subject = $_POST['txtSubject'];
    $message = $_POST['txtMessage'];

    $mailSend = mail($to, $subject, $message, $headers);
    if ($mailSend) {
        header('location:' . URL . 'admin/index.php?msg=mailSent');        
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {
            var flag = 0;
            var to = $("#txtTo").val().trim();
            var subject = $("#txtSubject").val().trim();
            var from = $("#txtFrom").val().trim();
            var message = $("#txtMessage").val().trim();

            if (to == "")
            {
                flag = 1;
            }
            if (subject == "")
            {
                flag = 1;
            }
            if (from == "")
            {
                flag = 1;
            }
            if (message == "")
            {
                flag = 1;
            }
            if (flag == 1)
            {
                $("#spnError").html("* fields are required");
                return false;
            }
            return true;
        });
    });
</script>
<div class="content">
    <h2 class="pageHeader">Send Email</h2>
    <div class="small_form">
        <fieldset>
            <form method="post">
                <table>
                    <tr>
                        <td>To<span class="red">*</span></td>
                        <td><input id="txtTo" type="text" name="txtTo" value="<?php echo $row['cndEmail'] ?>"></td>
                    </tr>
                    <tr>
                        <td>Subject<span class="red">*</span></td>
                        <td><input id="txtSubject" type="text" name="txtSubject" value="<?php echo $subject ?>"></td>
                    </tr>
                    <tr>
                        <td>From<span class="red">*</span></td>
                        <td><input id="txtFrom" type="text" name="txtFrom" value="<?php echo $headers; ?>"></td>
                    </tr>
                    <tr>
                        <td>Message<span class="red">*</span></td>
                        <td><textarea id="txtMessage" cols="29" name="txtMessage"><?php echo $message ?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" name="smtSend" value="Send Mail">
                            <input type="button" value="Cancel" name="btnCancel" onclick="setTimeout('window.close()',10);"><br><br>
                            <span id="spnError" class="red"></span>
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>