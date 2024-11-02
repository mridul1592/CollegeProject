<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_POST['smtSaveState']) || isset($_POST['smtSaveAddNew'])) {
    $statename = trim(addslashes($_POST['txtState']));
    if (isset($_GET['cid']) && !empty($_GET['cid'])) {
        $queryRepeat = "select * from tblgistate where stateName = '" . $statename . "' and countryId = " . $_GET['cid'];
        $result = mysql_query($queryRepeat);
        $repeat = mysql_num_rows($result);
        if ($repeat) {
            $msg = "Name already in use!";
        } else {
            $query = "insert into tblgistate set
			stateName='" . $statename . "',
			countryId=" . $_GET['cid'] . ",
			stateStatus=" . $_POST['status'] . ";
			";
            $result = mysql_query($query);
            if ($result) {
                if (isset($_POST['smtSaveState'])) {
                    header('location:' . URL . 'admin/geographicInformation/manageStates.php?msg=added&cid=' . $_GET['cid']);
                } else if (isset($_POST['smtSaveAddNew'])) {
                    header('location:' . URL . 'admin/geographicInformation/addState.php?msg=added&cid=' . $_GET['cid']);
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
            var state = $("#txtState").val();
            if (state == "")
            {
                flag = 0;
                $("#txtStateErr").html("*Required!");
            }
            return parseInt(flag) == 1 ? true : false;
        });
    });
	function clearValidation()
	{
		$("#spnError").html("");
		$("#txtStateErr").html("");
	}
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Add State</h4>
	<span id="spnError" class="red_error"><?php if (isset($msg)) echo $msg ?></span>
    <?php
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == "added") {
            echo '<span class="green_success">Record Added</span>';
        }
    }
    ?>
    <div class="small_form">
        <fieldset>
            <?php
            if (isset($_GET['cid'])) {
                $countryQry = "select countryName from tblgicountry where countryId=" . $_GET['cid'];
                $exe = mysql_query($countryQry);
                $country = mysql_result($exe, 0, 0);
            }
            ?>
            <b>Country:<?php echo isset($country) ? $country : "" ?></b>
            <form name="" action="" method="post">
                <p><label class="field">State:</label><input id="txtState" type="text" name="txtState" /><span class="red_error" id="txtStateErr"></span></p>
                <p><label class="field">Status:</label><input type="radio" name="status" value="1" checked="checked"/>Active<input type="radio" name="status" value="0" />Inactive</p>
                <input type="submit" name="smtSaveState" value="Add State" />
                <input type="submit" name="smtSaveAddNew" value="SaveAndAddNew" />
                <input type="reset"  onclick="return clearValidation()"/>
                <input type="button" name="btnCancel" value="Cancel" onclick="window.location = 'manageStates.php?cid=<?php if (isset($_GET['cid'])) echo $_GET['cid'] ?>'">
            </form>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>