<?php
include_once '../../include/settings.php';
//echo "asdfasdf";
if (isset($_GET) && $_GET['cid'] != -1) {
    $query = "select * from tblgistate where countryId=" . $_GET['cid'] . " and stateStatus=1;";
    $result = mysql_query($query);
    //print_r($_GET);exit;
    ?>
    <select id="ddlStateTemp" name="ddlStateTemp" onchange="GetAllCityByStateIdTemp(this.value)">
        <option value="-1">--select--</option>
        <?php
        while ($row = mysql_fetch_assoc($result)) {
            ?>
            <option value="<?php echo $row['stateId'] ?>"><?php echo $row['stateName'] ?></option>
        <?php }
        ?>
    </select>
    <span class="red_error" id="ddlStateErr"></span>
    <?php
} else {
    ?>
    <select id="ddlStateTemp" name="ddlStateTemp" onchange="GetAllCityByStateIdTemp(this.value)">
        <option value="-1">--select--</option>
    </select>
    <span class="red_error" id="ddlStateErr"></span>
    <?php
}
?>
