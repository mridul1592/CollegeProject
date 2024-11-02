<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_GET['sid']) && !empty($_GET['sid'])) {
    $query = "select * from tblgistate where stateId=" . $_GET['sid'];
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    if ($row['stateStatus'] == true)
        $active = 'checked="checked"';
    else
        $inactive = 'checked="checked"';
}
if (isset($_POST['smtEditState'])) {
    if (isset($_GET['sid']) && isset($_GET['cid'])) {
        $queryRepeat = "select stateName from tblgistate where stateId = " . $_GET['sid'] . " and countryId=" . $_GET['cid'];
        $result = mysql_query($queryRepeat);
        $cname = mysql_result($result, 0, 0);
        if ($cname == $_POST['txtState']) {
            $update = "update tblgistate set
				stateStatus=" . $_POST['status'] . " where stateId=" . $_GET['cid'] . "
				";
            $result = mysql_query($update);
            //echo mysql_error();
            if ($result) {
                header('location:' . URL . 'admin/geographicInformation/manageStates.php?msg=edited&cid=' . $_GET['cid']);
            }
        } else {
            $query = "select count(*) from tblgistate where stateName = '" . $_POST['txtState'] . "' and countryId=" . $_GET['cid'];
            $result = mysql_query($query);
            $counter = mysql_result($result, 0, 0);
            if (!$counter) {
                echo $query = "update tblgistate set
			stateName='" . addslashes($_POST['txtState']) . "',
			stateStatus=" . $_POST['status'] . " where stateId=" . $_GET['sid'] . "
			";
                $result = mysql_query($query);
                if ($result) {
                    header('location:' . URL . 'admin/geographicInformation/manageStates.php?msg=edited&cid=' . $_GET['cid']);
                }
            } else {
                $msg = "Name already in use!";
            }
        }
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {
            var flag = 1;
            var country = $("#txtState").val();
            if (country == "")
            {
                flag = 0;
                $("#spnStateErr").html("*Required!");
            }
            return parseInt(flag) == 1 ? true : false;
        });
    });
	function clearValidation()
	{
		$("#spnError").html("");
		$("#spnStateErr").html("");
	}
</script>

<div class="content" style="height:370px">
    <h4 class="pageHeader">Edit States</h4><span id="spnError" class="red_error"><?php if (isset($msg)) echo $msg ?></span>
    <div id="manage_country" class="small_form">
        <fieldset>
            <form method="post">
                <p>
                    <label class="field">State</label>
                    <input value="<?php echo isset($_POST['txtState']) ? $_POST['txtState'] : $row['stateName']; ?>" id="txtState" type="text" name="txtState" /><span class="red_error" id="spnStateErr"></span>
                </p>
                <p>
                    <label class="field">Status:</label>
                    <input type="radio" name="status" value="1" <?php echo isset($active) ? $active : "" ?> />
                    Active
                    <input type="radio" name="status" value="0" <?php echo isset($inactive) ? $inactive : "" ?> />
                    Inactive</p>
                <input type="submit" name="smtEditState" value="Update" />
                <input type="reset" onclick="return clearValidation()"/>
                <input type="button" value="Cancel" onclick="window.location = 'manageStates.php?cid=<?php echo $row['countryId'] ?>'">
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>
