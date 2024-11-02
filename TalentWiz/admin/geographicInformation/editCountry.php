<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_GET['cid']) && !empty($_GET['cid'])) {
    $query = "select * from tblgicountry where countryId=" . $_GET['cid'];
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    if ($row['countryStatus'] == true)
        $active = 'checked="checked"';
    else
        $inactive = 'checked="checked"';
}
if (isset($_POST['smtEditCountry'])) {
    if (isset($_GET['cid'])) {
        $queryRepeat = "select countryName from tblgicountry where countryId = " . $_GET['cid'];
        $result = mysql_query($queryRepeat);
        $cname = mysql_result($result, 0, 0);
        if ($cname == $_POST['txtCountry']) {
            $update = "update tblgicountry set
				countryStatus=" . $_POST['status'] . " where countryId=" . $_GET['cid'] . "
				";
            $result = mysql_query($update);
            //echo mysql_error();
            if ($result) {
                header('location:' . URL . 'admin/geographicInformation/manageCountries.php?msg=edited');
            }
        } else {
            $query = "select count(*) from tblgicountry where countryName = '" . $_POST['txtCountry'] . "'";
            $result = mysql_query($query);
            $counter = mysql_result($result, 0, 0);
            if (!$counter) {
                $query = "update tblgicountry set
			countryName='" . $_POST['txtCountry'] . "',
			countryStatus=" . $_POST['status'] . " where countryId=" . $_GET['cid'] . "
			";
                $result = mysql_query($query);
                if ($result) {
                    header('location:' . URL . 'admin/geographicInformation/manageCountries.php?msg=edited');
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
            var country = $("#txtCountry").val();
            if (country == "")
            {
                flag = 0;
                $("#spnCountryErr").html("*Required!");
            }
            return parseInt(flag) == 1 ? true : false;
        });
    });
	function clearValidation()
	{
		$("#spnError").html("");
		$("#spnCountryErr").html("");
	}
</script>

<div class="content" style="height:370px">
    <h4 class="pageHeader">Edit Country</h4><span id="spnError" class="red_error"><?php if (isset($msg)) echo $msg ?></span>
    <div id="manage_country" class="small_form">
        <fieldset>
            <form method="post">
                <p>
                    <label class="field">Country</label>
                    <input value="<?php echo isset($_POST['txtCountry']) ? $_POST['txtCountry'] : $row['countryName']; ?>" id="txtCountry" type="text" name="txtCountry" /><span class="red_error" id="spnCountryErr"></span>
                </p>
                <p>
                    <label class="field">Status:</label>
                    <input type="radio" name="status" value="1" <?php echo isset($active) ? $active : "" ?> />
                    Active
                    <input type="radio" name="status" value="0" <?php echo isset($inactive) ? $inactive : "" ?> />
                    Inactive</p>
                <input type="submit" name="smtEditCountry" value="Update" />
                <input type="reset"  onclick="return clearValidation()"/>
                <input type="button" value="Cancel" onclick="window.location = 'manageCountries.php'">
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>
