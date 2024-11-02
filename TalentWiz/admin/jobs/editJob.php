<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_GET['jobid']) && !empty($_GET['jobid'])) {
    $query = "select * from tbljobopening where jobId=" . $_GET['jobid'];
    $result = mysql_query($query) or die(mysql_error());
    $details = mysql_fetch_assoc($result);

    $query = "select * from tbljobcategory a left outer join (select c.catId,c.catTitle,d.catId as parentId,d.catTitle as parentName from tblcategory c join tblcategory d on c.catParentId=d.catId) b on a.catId=b.catId where jobId=" . $_GET['jobid'];
    $resultCat = mysql_query($query) or die(mysql_error());
    if (isset($_POST['smtUpdate'])) {
        $title = trim(addslashes($_POST['txtTitle']));
        //print_r($_POST['catid']);		

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
        echo $query = "update tbljobopening set
				jobTitle='$title',
				jobDesignation='$desig',
				jobDesc='$description',
				jobQualification='$qualification',
				jobTechnology='$technology',
				jobPositionCount=$position,
				jobStatus='$status',
				jobTestRules='$rules'
				where jobId=" . $_GET['jobid'] . "
				";
        $result = mysql_query($query) or die(mysql_error());
        if ($result) {
            $delete = "delete from tbljobcategory where jobId=" . $_GET['jobid'];
            $resultDelete = mysql_query($delete) or die(mysql_error());

            $jobId = $_GET['jobid'];
            $count = count($jobsubcat);
            --$count;
            $query = "insert into tbljobcategory (jobId,catId) values ($jobId,$jobcat)";
            for ($i = 0; $i <= $count; $i++) {
                $query .=" ,($jobId," . $jobsubcat[$i] . ")";
            }
            //echo $query.=" where jobId=" . $_GET['jobid'];
            $result = mysql_query($query) or die(mysql_error());
            if ($result) {
                header('location:' . URL . 'admin/jobs/manageJobs.php?msg=edited');
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
        <h3 class="pageHeader">Edit Job</h3>
        <div class="big_form">
            <fieldset>
                <form method="post">
                    <table>
                        <tr>
                            <td>Job Title<span class="red">*</span></td>
                            <td><input type="text" name="txtTitle" id="txtTitle" value="<?php echo $details['jobTitle'] ?>">
                                <span id="txtTitleErr" class="red"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Designation<span class="red">*</span></td>
                            <td><input type="text" name="txtDesignation" id="txtDesignation" value="<?php echo $details['jobDesignation'] ?>">
                                <span id="txtDesignationErr" class="red"></span></td>
                        </tr>
                        <tr>
                            <td>Description<span class="red">*</span></td>
                            <td><textarea name="txtDescription" id="txtDescription"> <?php echo $details['jobDesc'] ?></textarea>
                                <span id="txtDescriptionErr" class="red"></span></td>
                        </tr>
                        <tr>
                            <td>Qualification<span class="red">*</span></td>
                            <td><textarea name="txtQualification" id="txtQualification"><?php echo $details['jobQualification'] ?></textarea>
                                <span id="txtQualificationErr" class="red"></span></td>
                        </tr>
                        <tr>
                            <td>Technology<span class="red">*</span></td>
                            <td><textarea name="txtTechnology" id="txtTechnology"><?php echo $details['jobTechnology'] ?></textarea>
                                <span id="txtTechnologyErr" class="red"></span></td>
                        </tr>
                        <tr>
                            <td>Position(Count)<span class="red">*</span></td>
                            <td><input type="text" name="txtPosition" id="txtPosition" value="<?php echo $details['jobPositionCount'] ?>">
                                <span id="txtPositionErr" class="red"></span></td>
                        </tr>
                        <tr>
                            <td>Test Rules<span class="red">*</span></td>
                            <td><textarea name="txtRules" id="txtRules"><?php echo $details['jobTestRules'] ?></textarea>
                                <span id="txtRulesErr" class="red"></span></td>
                        </tr>
                        <tr>
                            <td>Job Category<span class="red">*</span></td>
                            <td>
                                <select name="ddlJobCategory" onchange="return subcategories(this.value)">
                                    <option value="-1">--select--</option>
                                    <?php
                                    echo $qryRootcat = "select a.*,b.catParentId from tbljobcategory a join tblcategory b on a.catId=b.catId where a.jobId=" . $_GET['jobid'] . " and b.catParentId is NULL";
                                    $result = mysql_query($qryRootcat);
                                    $rowCat = mysql_fetch_assoc($result);

                                    $query = "select * from tblcategory where catParentId is NULL and catStatus=1";
                                    $result = mysql_query($query);
                                    while ($row = mysql_fetch_assoc($result)) {
                                        ?>
                                        <option <?php echo $rowCat['catId'] == $row['catId'] ? "selected='selected'" : "" ?> value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?></option>
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
                                <span id="spnSubCategory"><input type="checkbox" id="chkCheckAll" name="chkCheckAll" onclick="return checkAll()" />All <br />
                                    <?php
                                    //while($detailCat=mysql_fetch_assoc($resultCat)){print_r($detailCat);}
                                    //print_r($detailCat);
                                    /* echo $qryRootcat = "select a.*,b.catParentId from tbljobcategory a join tblcategory b on a.catId=b.catId where a.jobId=" . $_GET['jobid'] . " and b.catParentId is NOT NULL";
                                      $result = mysql_query($qryRootcat);
                                      $rowSubCat = mysql_fetch_assoc($result);
                                      print_r($rowSubCat); */
                                    $query = "select * from tblcategory where catStatus=1 and catParentId=" . $rowCat['catId'];
                                    $result = mysql_query($query);
                                    //$flag=0;
                                    while ($row = mysql_fetch_assoc($result)) {

                                        $qrySubCat = "select * from tbljobcategory where jobId=" . $_GET['jobid'] . " and catId=" . $row['catId'];
                                        $resultSubCat = mysql_query($qrySubCat);
                                        $rowSubCat = mysql_num_rows($resultSubCat);
                                        ?>
                                        <input type="checkbox" name="catid[]" <?php echo $rowSubCat > 0 ? "checked='checked'" : "" ?> value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?><br>
                                        <?php
                                    }
                                    ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><input type="radio" name="rbtnStatus" value="1" <?php echo $details['jobStatus'] == true ? "checked='checked'" : "" ?> />Open <input type="radio" name="rbtnStatus" value="0" <?php echo $details['jobStatus'] == false ? "checked='checked'" : "" ?> />Close</td>
                        </tr>
                        <tr>
                            <td colspan="2" align='center'><br>
                                <input type="hidden" name="option" value="com_talentwiz">
                                <input type="hidden" name="controller" value="admin">
                                <input type="hidden" name="task" value="editjob">

                                <input type="submit" name="smtUpdate" value="Update">
                                <input type="reset">
                                <input type="button" value="Cancel" onclick="window.location = '<?php echo URL ?>admin/jobs/manageJobs.php'">
                            </td>
                        </tr>
                    </table>
                </form>
            </fieldset>
        </div>
    </div>
<?php
}
include_once '../../include/footer.php';
?>