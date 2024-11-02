<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_GET['city']) && !empty($_GET['city'])) {//for status
    $query = "select * from tblgicity where cityId=" . $_GET['city'];
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    if ($row['cityStatus'] == true)
        $active = 'checked="checked"';
    else
        $inactive = 'checked="checked"';
}
if (isset($_POST['smtEditCity'])) {
    if (isset($_GET['sid']) && isset($_GET['cid']) && isset($_GET['city'])) {
        $queryRepeat = "select cityName from tblgicity where cityId = " . $_GET['city'] . " and stateId=" . $_GET['sid'];
        $result = mysql_query($queryRepeat);
        $cname = mysql_result($result, 0, 0);
        if ($cname == $_POST['txtCity']) {
            $update = "update tblgicity set
				cityStatus=" . $_POST['status'] . " where cityId=" . $_GET['city'] . " and stateId=" . $_GET['sid'] . "
				";
            $result = mysql_query($update);
            //echo mysql_error();
            if ($result) {
                header('location:' . URL . 'admin/geographicInformation/manageCity.php?cid=' . $_GET['cid'] . '&sid=' . $_GET['sid'] . '&msg=edited');
            }
        } else {
            $query = "select count(*) from tblgicity where cityName = '" . addslashes($_POST['txtCity']) . "' and stateId=" . $_GET['sid'];
            $result = mysql_query($query);
            $counter = mysql_result($result, 0, 0);
            if (!$counter) {
                echo $query = "update tblgicity set
			cityName='" . addslashes($_POST['txtCity']) . "',
			cityStatus=" . $_POST['status'] . " where cityId=" . $_GET['city'] . " and stateId=" . $_GET['sid'] . "
			";
                $result = mysql_query($query);
                if ($result) {
                    header('location:' . URL . 'admin/geographicInformation/manageCity.php?cid=' . $_GET['cid'] . '&sid=' . $_GET['sid'] . '&msg=edited');
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
            var country = $("#txtCity").val();
            if (country == "")
            {
                flag = 0;
                $("#spnCityErr").html("*Required!");
            }
            return parseInt(flag) == 1 ? true : false;
        });
    });
</script>

<div class="content" style="height:370px">
    <h4 class="pageHeader">Edit City</h4><span class="red_error"><?php if (isset($msg)) echo $msg ?></span>
    <div id="manage_city" class="small_form">
        <fieldset>
            <form method="post">
                <p>
                    <label class="field">City</label>
                    <input value="<?php echo isset($_POST['txtCity']) ? $_POST['txtCity'] : $row['cityName']; ?>" id="txtCity" type="text" name="txtCity" /><span class="red_error" id="spnCityErr"></span>
                </p>
                <p>
                    <label class="field">Status:</label>
                    <input type="radio" name="status" value="1" <?php echo isset($active) ? $active : "" ?> />
                    Active
                    <input type="radio" name="status" value="0" <?php echo isset($inactive) ? $inactive : "" ?> />
                    Inactive</p>
                <input type="submit" name="smtEditCity" value="Update" />
                <input type="reset" />
                <input type="button" value="Cancel" onclick="window.location = 'manageCity.php?cid=<?php echo $_GET['cid'] ?>&sid=<?php echo $_GET['sid'] ?>'">
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once  '../../include/footer.php';
?>