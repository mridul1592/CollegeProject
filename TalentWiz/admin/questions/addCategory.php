<?php
include_once '../../include/header.php';

if (isset($_POST['smtSave'])) {
    $catname = trim(addslashes($_POST['txtCategoryName']));

    $query = "select * from tblcategory where catTitle='" . $catname . "'";
    $result = mysql_query($query);
    $repeat = mysql_num_rows($result);
    if (!$repeat) {
        if (isset($_POST['ddlRootCategory']) && !empty($_POST['ddlRootCategory']))
            $rootcategory = $_POST['ddlRootCategory'];
        echo $query = "insert into tblcategory set 
				catTitle='$catname',
				catStatus=" . $_POST['rbtnStatus'];
        if (isset($rootcategory)) {
            $query .= ",catParentId=" . $rootcategory;
        }
        $result = mysql_query($query);
        if ($result) {
            header('location:manageCategory.php?msg=added');
        } else {
            die(mysql_error());
        }
    } else {
        $msg = "Name already exists!";
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {
            var catname = String.trim($("#txtCategoryName").val());
            flag = 1;
            if (catname == "")
            {
                flag = 0;
                $("#txtCategoryNameErr").html("Required!");
            }
            return parseInt(flag) == 0 ? false : true;
        });
    });

    function subcat(qcat)
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        }
        else
        {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("spnCategory").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "getCategory.php?qcat=" + qcat, true);
        xmlhttp.send();
    }
</script>
<div class="content">
    <h3 class="pageHeader">Add Category</h3>
    <span class="red"><?php echo isset($msg) ? $msg : "" ?></span>
    <form method="post" class="small_form">
        <fieldset>
            <table>
                <tr>
                    <td>Category Level</td>
                    <td>
                        <select name="ddlCategoryType" onchange='return subcat(this.value)'>
                            <option <?php echo isset($_POST['ddlCategoryType']) ? (($_POST['ddlCategoryType'] == "root") ? "selected='selected'" : "") : "" ?> value="root">Root Category</option>
                            <option <?php echo isset($_POST['ddlCategoryType']) ? (($_POST['ddlCategoryType'] == "subcat") ? "selected='selected'" : "") : "" ?> value="subcat" >Sub-Category</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span id="spnCategory">
                            <?php
                            if (isset($_POST['ddlCategoryType']) && $_POST['ddlCategoryType'] == "subcat") {
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
                                                    <option <?php echo isset($_POST['ddlRootCategory']) ? (($_POST['ddlRootCategory'] == $row['catId']) ? "selected='selected'" : "") : "" ?> value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select></td>
                                    </tr>
                                </table>
                                <?php
                            }
                            ?>
                        </span></td>
                </tr>
                <tr>
                    <td>Cateogry Name<span class="red">*</span></td>
                    <td><input type="text" id="txtCategoryName" name="txtCategoryName" value="<?php echo isset($_POST['txtCategoryName']) ? $_POST['txtCategoryName'] : "" ?>" /><span class="red" id="txtCategoryNameErr"></span></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><input type="radio" name="rbtnStatus" value="1" <?php echo isset($_POST['rbtnStatus']) ? (($_POST['rbtnStatus'] == 1) ? "checked='checked'" : "") : "checked='checked'" ?> />Active <input type="radio" name="rbtnStatus" <?php echo isset($_POST['rbtnStatus']) ? (($_POST['rbtnStatus'] == 0) ? "checked='checked'" : "") : "" ?> value="0" />Inactive</td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <input type="submit" value="Add Category" name="smtSave" />
                        <input type="button" value="Cancel" onclick="window.location = '<?php echo URL ?>admin/questions/manageCategory.php'" />
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>

<?php
include_once '../../include/footer.php';
?>