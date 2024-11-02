<?php

include_once '../../include/header.php';

if (isset($_POST['smtPost'])) {
    $topic = trim(addslashes($_POST['txtTopic']));
    $desc = trim(addslashes($_POST['txtDescription']));

    $query = "insert into tblpostdiscussion set
			postTopic='$topic',
			postDesc='$desc',
			postDate=now(),
			postBy='" . $_SESSION['userid'] . "',
			postStatus=1
			";
    $result = mysql_query($query);
    if ($result) {
        header('location:' . URL . 'candidate/discussion/viewDiscussion.php?msg=added');
    }
}
?>
<script>
    $(document).ready(function(e) {
        $(document).submit(function() {
            var title = String.trim($("#txtTopic").val());
            var desc = String.trim($("#txtDescription").val());
            var flag = 0;
            if (title == "")
            {
                flag = 1;
                $("#txtTopicErr").html("Required!");
            }
            if (desc == "")
            {
                flag = 1;
                $("#txtDescriptionErr").html("Required!");
            }
            return parseInt(flag) == 1 ? false : true;
        });
    });
</script>
<div class="content">
    <h3 class="pageHeader">Add Discussion Topic</h3>
    <div id="divAddDiscussion" class="small_form">
        <fieldset>
            <form method="post">
                <table>
                    <tr>
                        <td><label>Discussion Topic</label>
                            <span class="red">*</span></td>
                        <td><input type="text" name="txtTopic" id="txtTopic" /><span id="txtTopicErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Description<span class="red">*</span></td>
                        <td><textarea name="txtDescription" id="txtDescription"></textarea><span id="txtDescriptionErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><input type="submit" name="smtPost" id="smtPost" value="Post" />
                            <input type="button" name="btnCancel" onclick="window.location = 'viewDiscussion.php'" value="Cancel" /></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>