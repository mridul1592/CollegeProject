<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_GET['fid'])) {
    $fid = $_GET['fid'];
    $qryRet = "select * from tblfaq where faqId=" . $fid;
    $exeRet = mysql_query($qryRet);
    $rowRet = mysql_fetch_assoc($exeRet);

    if (isset($_POST['smtUpdateFaq'])) {
        $faq = trim(addslashes($_POST['txtFaq']));
        $answer = trim(addslashes($_POST['txtAnswer']));
		$qryRepeat="select * from tblfaq where faq='$faq' and faq not in (select faq from tblfaq where faqId=$fid)";
		$resultRepeat=mysql_query($qryRepeat);
		$repeat=mysql_num_rows($resultRepeat);
		if($repeat==0)
        {
		 {
                echo $query = "update tblfaq set
				faq='" . $faq . "',
				faqAns='" . $answer . "',
				faqPostOn=now(),
				faqStatus=" . $_POST['rbtnStatus'] . "
				where faqId=" . $fid . "
				;";

                $result = mysql_query($query);
                if ($result) 
				{
                    if (isset($_POST['smtUpdateFaq'])) 
					{
                        header('location:' . URL . 'admin/faq/manageFaq.php?msg=updated');
                    }
                }
            }
        }
		else
		{
			$msg="Faq already exists!";	
		}
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {
            var flag = 1;
            var faq = $("#txtFaq").val().trim();
            var ans = $("#txtAnswer").val().trim();
            if (faq == "")
            {
                flag = 0;
                $("#spnFaqErr").html("*Required!");
            }
            if (ans == "")
            {
                flag = 0;
                $("#spnAnswerErr").html("*Required!");
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
        <h3 class="pageHeader">Edit FAQ</h3>
		<?php
	echo isset($msg)?("<span class='red_error'>".$msg."</span>"):"";
    ?>
        <br />
        <form method="post">
            <fieldset>
                <table>
                    <tr>
                        <td><label class="field">FAQ:</label></td>
                        <td><input id="txtFaq" type="text" name="txtFaq" value="<?php echo $rowRet['faq'] ?>" /></td>
                        <td><span class="red_error" id="spnFaqErr"></span></td>
                    </tr>
                    <tr>
                        <td><label class="field">Answer:</label></td>
                        <td><textarea id="txtAnswer" name="txtAnswer" rows="2"> <?php echo $rowRet['faqAns'] ?></textarea></td>
                        <td><span class="red_error" id="spnAnswerErr"></span></td>
                    </tr>
                    <tr>
                        <td><label class="field">Status:</label></td>
                        <td><input type="radio" name="rbtnStatus" value="1" <?php echo ($rowRet['faqStatus'] == true ? 'checked="checked"' : "") ?> />Active
                            &nbsp;<input type="radio" name="rbtnStatus" value="0" <?php echo ($rowRet['faqStatus'] == false ? 'checked="checked"' : "") ?> />Inactive</td>                        
                    </tr>
                    <tr>
                        <td colspan="3">
                            <input type="submit" name="smtUpdateFaq" value="Update" />
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