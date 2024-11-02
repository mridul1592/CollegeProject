<?php
include_once '../../include/settings.php';
if (isset($_GET['cat']) && $_GET['cat'] != -1) {
    ?>
    <div id="subCategory">
        <input type="checkbox" id="chkCheckAll" name="chkCheckAll" onclick="return checkAll()" >All<br>
        <?php
        $query = "select * from tblcategory where catStatus=1 and catParentId=" . $_GET['cat'];
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            ?>
            <input type="checkbox" name="catid[]" value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?><br>
            <?php
        }
        ?>
    </div>
    <?php
} elseif ($_GET['cat'] == -1) {
    ?>
    <input type="checkbox" name="chkCheckAll" />All <br />
    <?php
}
?>