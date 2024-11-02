<?php
include_once '../../include/header.php';

if (isset($_GET['catid'])) {
    $query = "select * from tblcategory where catId=" . $_GET['catid'];
    $result = mysql_query($query);
    $rowfetch = mysql_fetch_assoc($result);

    if (isset($_POST['smtUpdate'])) {
        if (isset($_POST['ddlRootCategory']) && !empty($_POST['ddlRootCategory']))
            $rootcategory = $_POST['ddlRootCategory'];
        $catname = trim(addslashes($_POST['txtCategoryName']));
        $query = "update tblcategory set 
				catTitle='$catname',
				catStatus=" . $_POST['rbtnStatus'];
        if (isset($rootcategory)) {
            $query .= ",catParentId=" . $rootcategory;
        } else {
            $query .= ",catParentId=NULL";
        }
        $query .=" where catId=" . $_GET['catid'];
//	die($query);
        $result = mysql_query($query);
        if ($result) {
            header('location:manageCategory.php?msg=edited');
        } else {
            die(mysql_error());
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
        <h3 class="pageHeader">Edit Category</h3>
        <form method="post" class="small_form">
            <fieldset>
                <table>
                    <tr>
                        <td>Category Level</td>
                        <td><select <?php echo $rowfetch['catParentId'] == NULL ? "disabled='disabled'" : "" ?> name="ddlCategoryType" onchange='return subcat(this.value)'>
                                <option value="root" <?php echo $rowfetch['catParentId'] == NULL ? "selected='selected'" : "" ?>>Root Category</option>
                                <option value="subcat" <?php echo $rowfetch['catParentId'] != NULL ? "selected='selected'" : "" ?>>Sub-Category</option>
                            </select></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span id="spnCategory">
                                <?php
                                if ($rowfetch['catParentId'] != NULL) {
                                    ?>
                                    <table>
                                        <tr>
                                            <td width="42%">Root Category</td>
                                            <td><select name="ddlRootCategory">
                                                    <?php
                                                    $query = "select * from tblcategory where catParentId is NULL";
                                                    $result = mysql_query($query);
                                                    while ($row = mysql_fetch_assoc($result)) {
                                                        ?>
                                                        <option value="<?php echo $row['catId'] ?>" <?php echo $row['catId'] == $rowfetch['catParentId'] ? "selected='selected'" : "" ?>><?php echo $row['catTitle'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select></td>
                                        </tr>
                                    </table>
                                <?php }
                                ?>
                            </span></td>
                    </tr>
                    <tr>
                        <td>Cateogry Name<span class="red">*</span></td>
                        <td><input type="text" id="txtCategoryName" name="txtCategoryName" value="<?php echo $rowfetch['catTitle'] ?>" />
                            <span class="red" id="txtCategoryNameErr"></span></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><input type="radio" name="rbtnStatus" value="1" <?php echo $rowfetch['catStatus'] == true ? "checked='checked'" : "" ?> />
                            Active
                            <input type="radio" name="rbtnStatus" value="0" <?php echo $rowfetch['catStatus'] == false ? "checked='checked'" : "" ?> />
                            Inactive</td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center"><input type="submit" value="Edit Category" name="smtUpdate" />
                            <input type="button" value="Cancel" onclick="window.location = '<?php echo URL ?>admin/questions/manageCategory.php'" /></td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
    <?php
}
include_once '../../include/footer.php';
?>
