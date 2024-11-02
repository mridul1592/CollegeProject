<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_POST['smtSave']) || isset($_POST['smtSaveAddNew'])) {
    $title = trim(addslashes($_POST['txtTitle']));
    //print_r($_POST['catid']);		
    $query = "select * from tbljobopening where jobTitle='$title'";
    $result = mysql_query($query);
    $repeat = mysql_num_rows($result);
    if (!$repeat) {
        $desig = trim(addslashes($_POST['txtDesignation']));
        $description = trim(addslashes($_POST['txtDescription']));
        $qualification = trim(addslashes($_POST['txtQualification']));
        $technology = trim(addslashes($_POST['txtTechnology']));
        $position = trim(addslashes($_POST['txtPosition']));
        $rules = trim(addslashes($_POST['txtRules']));
        $jobcat = trim(addslashes($_POST['ddlJobCategory']));
        $jobsubcat = $_POST['catid'];
        $status = trim(addslashes($_POST['rbtnStatus']));
        //print_r($jobsubcat);
        $query = "insert into tbljobopening set
				jobTitle='$title',
				jobDesignation='$desig',
				jobDesc='$description',
				jobQualification='$qualification',
				jobTechnology='$technology',
				jobPositionCount=$position,
				jobStatus='$status',
				jobTestRules='$rules'
				";
        $result = mysql_query($query) or die(mysql_error());
        if ($result) {
            $query = "select MAX(jobId) from tbljobopening";
            $result = mysql_query($query);
            $jobId = mysql_result($result, 0, 0);
            $count = count($jobsubcat);
            --$count;
            $query = "insert into tbljobcategory (jobId,catId) values ($jobId,$jobcat)";
            for ($i = 0; $i <= $count; $i++) {
                //	echo $i;
                //	echo $count;

                if ($i <= $count) {
                    echo $query .=" ,($jobId," . $jobsubcat[$i] . ")";
                }
            }
            echo $query;
            $result = mysql_query($query) or die(mysql_error());
            if ($result) {
                header('location:' . URL . 'admin/jobs/manageJobs.php?msg=added');
            }
        }
    }
}
?>
<script>

    $(document).ready(function() {
        $(document).submit(function() {
            var title;
            var desig;
            var description;
            var qualification;
            var technology;
            var position;
            var rules;
            var jobcat;
            var jobsubcat;
            var flag = 0;

            title = $("#txtTitle").val();
            desig = $("#txtDesignation").val();
            description = $("#txtDescription").val();
            qualification = $("#txtQualification").val();
            technology = $("#txtTechnology").val();
            position = $("#txtPosition").val();
            rules = $("#txtRules").val();
            jobcat = $("#ddlJobCategory").val();
            jobsubcat = $("#chkSubCategory").val();
            if (title == "")
            {
                flag = 1;
                $("#txtTitleErr").html("Required!");
            }
            if (desig == "")
            {
                flag = 1;
                $("#txtDesignationErr").html("Required!");
            }
            if (description == "")
            {
                flag = 1;
                $("#txtDescriptionErr").html("Required!");
            }
            if (qualification == "")
            {
                flag = 1;
                $("#txtQualificationErr").html("Required!");
            }
            if (technology == "")
            {
                flag = 1;
                $("#txtTechnologyErr").html("Required!");
            }

            if (position == "")
            {
                flag = 1;
                $("#txtPositionErr").html("Required!");
            }
            if (rules == "")
            {
                flag = 1;
                $("#txtRulesErr").html("Required!");
            }
            if (jobcat == -1)
            {
                flag = 1;
                $("#ddlJobCategoryErr").html("Required!");
            }
            return parseInt(flag) == 1 ? false : true;
        });
    });/**/
    function subcategories(cat)
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        }
        else
        {
            xmlhttp = new ActiveXObject(Microsoft.XMLHTTP);
        }


        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("spnSubCategory").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "getSubCagtegory.php?cat=" + cat, true);
        xmlhttp.send();
    }/**/
    function checkAll()
    {
        var ctrlbxValue = document.getElementById("chkCheckAll").checked;
        var arrSubCategories = document.getElementsByName("catid[]");
        var len = arrSubCategories.length;
        var i;
        if (ctrlbxValue)
        {
            for (i = 0; i < len; i++)
            {
                arrSubCategories[i].checked = true;
            }
        }
        else
        {
            for (i = 0; i < len; i++)
            {
                arrSubCategories[i].checked = false;
            }
        }
        return true;
    } /**/
</script>
<div class="content">
    <h3 class="pageHeader">Add Job</h3>
    <div class="big_form">
        <fieldset>
            <form method="post">
                <table>
                    <tr>
                        <td>Job Title<span class="red">*</span></td>
                        <td><input type="text" name="txtTitle" id="txtTitle">
                            <span id="txtTitleErr" class="red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Designation<span class="red">*</span></td>
                        <td><input type="text" name="txtDesignation" id="txtDesignation">
                            <span id="txtDesignationErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Description<span class="red">*</span></td>
                        <td><textarea name="txtDescription" id="txtDescription"></textarea>
                            <span id="txtDescriptionErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Qualification<span class="red">*</span></td>
                        <td><textarea name="txtQualification" id="txtQualification"></textarea>
                            <span id="txtQualificationErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Technology<span class="red">*</span></td>
                        <td><textarea name="txtTechnology" id="txtTechnology"></textarea>
                            <span id="txtTechnologyErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Position(Count)<span class="red">*</span></td>
                        <td><input type="text" name="txtPosition" id="txtPosition">
                            <span id="txtPositionErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Test Rules<span class="red">*</span></td>
                        <td><textarea name="txtRules" id="txtRules"></textarea>
                            <span id="txtRulesErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Job Category<span class="red">*</span></td>
                        <td>
                            <select name="ddlJobCategory" onchange="return subcategories(this.value)">
                                <option value="-1">--select--</option>
                                <?php
                                $query = "select * from tblcategory where catParentId is NULL and catStatus=1";
                                $result = mysql_query($query);
                                while ($row = mysql_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span id="ddlJobCategoryErr" class="red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sub-Category</td>
                        <td><br>
                            <span id="spnSubCategory"><input type="checkbox" name="chkCheckAll" />All </span><br />
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><input type="radio" name="rbtnStatus" value="1" checked="checked" />Open <input type="radio" name="rbtnStatus" value="0" />Close</td>
                    </tr>
                    <tr>
                        <td colspan="2" align='center'><br>
                            <input type="submit" name="smtSave" value="Save">
                            <input type="submit" name="smtSaveAddNew" value="SaveAndAddNew">
                            <input type="reset">
                            <input type="button" value="Cancel" onclick="window.location = '<?php echo URL ?>admin/jobs/manageJobs.php'"
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>