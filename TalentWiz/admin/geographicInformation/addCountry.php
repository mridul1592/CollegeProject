<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_POST['smtSaveCountry']) || isset($_POST['smtSaveAddNew'])) {
    $countryname = trim(addslashes($_POST['txtCountry'])); {
        $queryRepeat = "select * from tblgicountry where countryName = '" . $countryname . "'";
        $result = mysql_query($queryRepeat);
        $repeat = mysql_num_rows($result);

        if ($repeat) {
            $msg = "Name already in use!";
        } else {
            $query = "insert into tblgicountry set
			countryName='" . $countryname . "',
			countryStatus=" . $_POST['status'] . ";
			";
            $result = mysql_query($query);
            if ($result) {
                if (isset($_POST['smtSaveCountry'])) {
                    header('location:' . URL . 'admin/geographicInformation/manageCountries.php?msg=added');
                } else if (isset($_POST['smtSaveAddNew'])) {
                    header('location:' . URL . 'admin/geographicInformation/addCountry.php?msg=added');
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
    <h4 class="pageHeader">Add Country</h4><span id="spnError" class="red_error"><?php if (isset($msg)) echo $msg ?></span>
    <?php
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == "added") {
            echo '<span class="green_success">Record Added</span>';
        }
    }
    ?>
    <div id="manage_country" class="small_form">
        <fieldset>
            <form name="" action="" method="post">
                <p>
                    <label class="field">Country</label>
                    <input id="txtCountry" type="text" name="txtCountry" />
                    <span class="red_error" id="spnCountryErr"></span> </p>
                <p>
                    <label class="field">Status:</label>
                    <input type="radio" name="status" value="1" checked="checked"/>
                    Active
                    <input type="radio" name="status" value="0" />
                    Inactive</p>
                <input type="submit" name="smtSaveCountry" value="Save" />
                <input type="submit" name="smtSaveAddNew" value="SaveAndAddNew" />
                <input type="reset" onclick="return clearValidation()"/>
                <input type="button" value="Cancel" onclick="window.location = 'manageCountries.php'">
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>
