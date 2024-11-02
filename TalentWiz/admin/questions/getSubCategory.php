<?php
include_once '../../include/settings.php';
if (isset($_GET['cat']) && $_GET['cat'] != -1) {
    ?>
    <div id="subCategory">
        <select id="ddlSubCategory" name="ddlSubCategory">
            <option value="-1">--select--</option>
            <?php
            $query = "select * from tblcategory where catParentId=" . $_GET['cat'];
            $result = mysql_query($query);
            while ($row = mysql_fetch_assoc($result)) {
                ?>
                <option value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <?php
} elseif ($_GET['cat'] == -1) {
    ?>
    <select id="ddlSubCategory" name="ddlSubCategory"><option value="-1">--select--</option></select>
    <?php
}
?>