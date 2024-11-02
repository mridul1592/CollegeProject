<?php
include_once '../../include/header.php';

if (isset($_POST['smtSend'])) {
    $title = trim(addslashes($_POST['txtTitle']));
    $desc = trim(addslashes($_POST['txtDescription']));

    $query = "insert into tblfeedback set
			feedbackTitle='$title',
			feedbackDesc='$desc',
			feedbackDate=now(),
			feedbackSendBy='" . $_SESSION['userid'] . "',
			feedbackStatus='active'
			";
    //$result=mysql_query($query);
    //if($result)
    {
        header('location:' . URL . 'candidate/index.php?msg=feedbackSent');
    }
}
?>
<script>
    $(document).ready(function(e) {
        $(document).submit(function() {
            var title = $("#txtTitle").val().trim();
            var desc = $("#txtDescription").val().trim();
            var flag = 0;
            if (title == "")
            {
                flag = 1;
                $("#txtTitleErr").html("Required!");
            }
            if (desc == "")
            {
                flag = 1;
                $("#txtDescriptionErr").html("Required!");
            }
            return parseInt(flag) == 1 ? false : true;
        });
    });
	function clearValidation()
        {
            $("#txtDescriptionErr").html("");
            $("#txtTitleErr").html("");
        }
</script>
<div id="divSendFeedback" class="content">
    <h3 class="pageHeader">Send Feedback</h3>

    <div class="small_form">
        <fieldset>
            <form name="frmSendFeedback" method="post">
                <table>
                    <tr>
                        <td>
                            <label>Feedback Title</label><span class="red">*</span>
                        </td>
                        <td>
                            <input type="text" name="txtTitle" id="txtTitle" />
                        </td>
                        <td>
                            <span id="txtTitleErr" class="red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Description</label><span class="red">*</span>
                        </td>
                        <td>
                            <textarea name="txtDescription" id="txtDescription" rows="10" cols="30"></textarea>
                        </td>
                        <td>
                            <span id="txtDescriptionErr" class="red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <input type="submit" name="smtSend" id="smtSend" value="Send" />
                            <input type="reset" onclick='return clearValidation()'/>
                            <input type="button" value="Cancel" onclick="window.location = '<?php echo URL ?>candidate/index.php'" /></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>