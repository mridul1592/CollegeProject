<?php
include_once '../../include/settings.php';
if (isset($_GET['qcat']) && $_GET['qcat'] == "subcat") {
    ?>

    <table>
        <tr>
            <td width="43%">Root Category</td>
            <td><select name="ddlRootCategory">
                    <?php
                    $query = "select * from tblcategory where catParentId is NULL";
                    $result = mysql_query($query);
                    while ($row = mysql_fetch_assoc($result)) {
                        ?>
                        <option value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?></option>
                        <?php
                    }
                    ?>
                </select></td>
        </tr>
    </table>
    <?php
}
?>
