<?php
include_once '../../include/header.php';
include_once '../checksession.php';

//			exit;
if (isset($_POST['smtSaveCity']) || isset($_POST['smtSaveAddNew'])) {

    $cityname = trim(addslashes($_POST['txtCity']));
    if (isset($_GET['sid']) && !empty($_GET['sid'])) {
        $queryRepeat = "select * from tblgicity where cityName = '" . $cityname . "' and stateId=" . $_GET['sid'];
        $result = mysql_query($queryRepeat);
        $repeat = mysql_num_rows($result);
        if ($repeat) {
            $msg = "Name already exists!";
        } else {
            $query = "insert into tblgicity set
			cityName='" . $cityname . "',
			stateId=" . $_GET['sid'] . ",
			cityStatus=" . $_POST['status'] . ";
			";
            $result = mysql_query($query);
            if ($result) {
                if (isset($_POST['smtSaveCity'])) {
                    //echo $_GET['cid'];
                    header('location:' . URL . 'admin/geographicInformation/manageCity.php?msg=added&sid=' . $_GET['sid'] . '&cid=' . $_GET['cid']);
                } else if (isset($_POST['smtSaveAddNew'])) {
                    header('location:' . URL . 'admin/geographicInformation/addCity.php?sid=' . $_GET['sid'] . '&cid=' . $_GET['cid'] . '&msg=added');
                }
            }
        }
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {
            var f = 0;
            var city = $("#txtCity").val();
            if (city == "")
            {
                f = 1;
                $("#txtCityErr").html("*required!");
            }
            return parseInt(f) == 1 ? false : true;

        });
    });
	function clearValidation()
	{
		$("#spnError").html("");
		$("#txtCityErr").html("");
	}
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Add City</h4>
	<span id="spnError" class="red_error"><?php if (isset($msg)) echo $msg ?></span>
    <?php
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == "added") {
            echo '<span class="green_success">Record Added</span>';
        }
    }
    ?>
    <div id="" class="small_form">
        <fieldset>

            <?php
            if (isset($_GET['cid']) && isset($_GET['sid'])) {
                $infoquery = "select countryName from tblgicountry where countryId=" . $_GET['cid'];
                $result = mysql_query($infoquery);
                $country = mysql_result($result, 0, 0);
                $infoquery = "select stateName from tblgistate where stateId=" . $_GET['sid'] . " and countryId=" . $_GET['cid'];
                $result = mysql_query($infoquery);
                $state = mysql_result($result, 0, 0);
            }
            ?>
            <b>Country: <?php echo $country ?><br /></b>
            <b>State: <?php echo $state ?></b>
            <form method="post">
                <p><label class="field">City:</label><input type="text" id="txtCity" name="txtCity"><span class="red_error" id="txtCityErr"></span></p>
                <p><label class="field">Status:</label><input type="radio" name="status" value="1" checked="checked"/>Active<input type="radio" name="status" value="0" />Inactive</p>
                <ul class="bottom_options">
                    <li><input type="submit" name="smtSaveCity" value="Add city"/>
                        <input type="submit" name="smtSaveAddNew" value="SaveAndAddNew" />
                        <input type="reset"  onclick="return clearValidation()"/>
                        <input type="button" value="Cancel" onclick="window.location = 'manageCity.php?sid=<?php echo $_GET['sid'] ?>&cid=<?php echo $_GET['cid'] ?>'"></li>
                </ul>
            </form>
        </fieldset>
    </div>
</div>

<?php include_once '../../include/footer.php'; ?>