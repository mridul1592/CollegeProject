<?php
include_once '../include/settings.php';
//echo "asdfasdf";
if (isset($_GET) && $_GET['sid'] != -1) {
    $query = "select * from tblgicity where stateId=" . $_GET['sid'] . " and cityStatus=1;";
    $result = mysql_query($query);
    //print_r($_GET);exit;
    ?>
    <p><label class="field">City:</label><select id="ddlCity" name="ddlCity">
            <option value="-1">--select city--</option>
            <?php
            while ($row = mysql_fetch_assoc($result)) {
                ?>
                <option value="<?php echo $row['cityId'] ?>"><?php echo $row['cityName'] ?></option>
            <?php }
            ?>
        </select><span class="red_error" id="ddlCityErr"></span>
    </p>
    <?php
}
?>