<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_GET['sq'])) {
    $sq = addslashes($_GET['sq']);
    $query = "select * from tblusersq where usrSQ='" . $sq . "'";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    if (isset($_POST['smtUpdateSQ'])) {
		$sq1 = trim(addslashes($_POST['txtSQ']));
		$qryRepeat="select * from tblusersq where usrSQ='$sq1' and usrSQ not in (select usrSQ from tbluserSQ where usrSQ='$sq')";
		$resultRepeat=mysql_query($qryRepeat);
		$repeat=mysql_num_rows($resultRepeat);
		if($repeat==0)
		{
			
			$qryUpdate = "update tblusersq set usrSQ='" . $sq1 . "' where usrSQ='" . $sq . "'";
			$resultUpdate = mysql_query($qryUpdate);
			if ($resultUpdate) {
				header('location:' . URL . 'admin/sq/manageSQ.php?msg=updated');
			}
		}
		else
		{
			$msg="Record already exists!";
		}
    }
}
?>
<br />
<br />
<script>
    function frmManagesq_submit()
    {
        document.search_sq.submit();
    }
    $(document).ready(function() {
        $(document).submit(function() {
            var sq = $("#txtSQ").val().trim();
            var flag = 0;
            if (sq == "")
            {
                $("#spnSQErr").html("*required!");
                flag = 1;
            }
            return parseInt(flag) == 1 ? false : true;
        });
    });
    /*function manage_sq_submit(sq)
     {
     
     document.manage_sq.submit();
     }/**/
</script>
<div class="content">
    <h3 class="pageHeader">Edit Security Question</h3>
	<?php
		echo isset($msg)?("<span class='red_error'>".$msg."</span>"):"";
	?>
	<div class="big_form">
    <fieldset>
        <form method="post">
            <table>
                <tr>
                    <td>Security Question</td>
                    <td><input type="text" name="txtSQ" value="<?php echo $row['usrSQ'] ?>" id="txtSQ"><span id="spnSQErr" class="red_error"></span></td>
                </tr>
                <tr>
                    <td><br /></td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input type="submit" name="smtUpdateSQ" value="Update" />
                        <input type="reset"  />
						<input type="button" value="Cancel" onclick="window.location='<?php echo URL?>admin/sq/manageSQ.php'">
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
	</div>
</div>
<?php
include_once '../../include/footer.php';
?>