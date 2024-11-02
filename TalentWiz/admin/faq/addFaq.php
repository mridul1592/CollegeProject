<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_POST['smtSaveFaq']) || isset($_POST['smtSaveAddNew'])) {
    $faq = trim(addslashes($_POST['txtFaq']));
    $answer = trim(addslashes($_POST['txtAnswer']));
    {
        $queryRepeat = "select * from tblfaq where faq = '" . $faq . "'";
        $result = mysql_query($queryRepeat);
        $repeat = mysql_num_rows($result);

        if ($repeat) {
            $msg = "FAQ already in use!";
        } else {
            $query = "insert into tblfaq set
			faq='" . $faq . "',
			faqAns='" . $answer . "',
			faqPostOn=now(),
			faqStatus=" . $_POST['rbtnStatus'] . "
			;";
            //mysql_error();
            $result = mysql_query($query);
            if ($result) {
                if (isset($_POST['smtSaveFaq'])) {
                    header('location:' . URL . 'admin/faq/manageFaq.php?msg=added');
                } else if (isset($_POST['smtSaveAddNew'])) {
                    header('location:' . URL . 'admin/faq/addFaq.php?msg=added');
                }
            }
        }
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {
            var flag = 1;
            var country = $("#txtFaq").val();
            if (country == "")
            {
                flag = 0;
                $("#spnFaqErr").html("*Required!");
            }
            return parseInt(flag) == 1 ? true : false;
        });
    });
</script>

<div class="content" style="height:370px">
    <?php
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == "added") {
            echo '<span class="green_success">Record Added</span>';
        }
    }
    ?>
    <div id="divAddFaq" class="add_form">
        <h3 class="pageHeader">Add FAQ</h3>
        <br />
        <form method="post">
            <fieldset>
                <table>
                    <tr>
                        <td><label class="field">FAQ:</label></td>
                        <td><input id="txtFaq" type="text" name="txtFaq" /></td>
                        <td><span class="red_error" id="spnFaqErr"><?php if (isset($msg)) echo $msg ?></span></td>
                    </tr>
                    <tr>
                        <td><label class="field">Answer:</label></td>
                        <td><textarea id="txtAnswer" name="txtAnswer" rows="2"></textarea></td>
                    </tr>
                    <tr>
                        <td><label class="field">Status:</label></td>
                        <td><input type="radio" name="rbtnStatus" checked="checked" value="1" />Active
                            &nbsp;<input type="radio" name="rbtnStatus" value="0" />Inactive</td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" name="smtSaveFaq" value="Save" />
                            <input type="submit" name="smtSaveAddNew" value="Save&AddNew" />
                            <input type="reset" />
                            <input type="button" value="Cancel" onclick="window.location = 'manageFaq.php'" /></td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>

</div>
<?php
include_once '../../include/footer.php';
?>
