<?php
include_once '../../include/header.php';

$rownum = 0;
if (isset($_POST['smtSearch'])) {
    //print_r($_POST);
    if (isset($_POST['txtTitle']) && !empty($_POST['txtTitle'])) {
        $title = $_POST['txtTitle'];
    }
    if (isset($_POST['txtDesignation']) && !empty($_POST['txtDesignation'])) {
        $desig = $_POST['txtDesignation'];
    }
    if (isset($_POST['txtQualification']) && !empty($_POST['txtQualification'])) {
        $qualification = $_POST['txtQualification'];
    }
    if (isset($_POST['txtTechnology']) && !empty($_POST['txtTechnology'])) {
        $technology = $_POST['txtTechnology'];
    }
    if (isset($_POST['ddlCategory']) && !empty($_POST['ddlCategory'])) {
        $category = $_POST['ddlCategory'];
    }
    if (isset($_POST['ddlCategory']) && $_POST['ddlCategory'] != -1) {
        $category = $_POST['ddlCategory'];
        if (isset($_POST['catid']) && !empty($_POST['catid'])) {
            $subcat = $_POST['catid'];
        }
    }
}
$query = "select * from tbljobopening where jobStatus=1";
isset($title) ? $query.=" and jobTitle like '%" . $title . "%'" : "";
isset($desig) ? $query.=" and jobDesignation like '%" . $desig . "%'" : "";
isset($qualification) ? $query.=" and jobQualification like '%" . $qualification . "%'" : "";
isset($technology) ? $query.=" and jobTechnology like '%" . $technology . "%'" : "";
//isset($title)?$query.=" and jobTitle like '%".$title."%'":"";
if (isset($category) && $category != -1) {
    //////////select all jobs according to categories////////////////
    $queryCat = "select * from tbljobcategory where catId in ($category";
    if (isset($subcat)) {
        for ($i = 0; $i < count($subcat); $i++) {
            $queryCat .= "," . $subcat[$i];
        }
    }
    $queryCat .= " ) group by jobId";
    $resultCat = mysql_query($queryCat);

    $query .= " and jobId in (0";
    while ($rowCat = mysql_fetch_assoc($resultCat)) {
        $query .= "," . $rowCat['jobId'];
    }
    $query .= " )";
}
//echo $query;
$result = mysql_query($query);
?>
<script>
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
    }

    function checkAll()
    {
        var chkboxValue = document.getElementById("chkCheckAll").checked;
        var arrSubCategories = document.getElementsByName("catid[]");
        var len = arrSubCategories.length;
        if (chkboxValue == true)
        {
            for (var i = 0; i < len; i++)
            {
                arrSubCategories[i].checked = true;
            }
        }
        else
        {
            for (var i = 0; i < len; i++)
            {
                arrSubCategories[i].checked = false;
            }
        }
    }
function clearValidation()
{
	$("#txtTitle").html("");
	$("#txtDesignation").html("");
	$("#txtQualification").html("");
	$("#txtTechnology").html("");
}
</script>
<div class="content">
    <h3 class="pageHeader">Search Jobs</h3>

    <div class="small_form">
        <fieldset>
            <form name="frmSendFeedback" method="post">
                <table>
                    <tr>
                        <td>
                            <label>Job Title</label>
                        </td>
                        <td>
                            <input type="text" name="txtTitle" id="txtTitle" value='<?php echo isset($title) ? $title : "" ?>' />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Designation</label>
                        </td>
                        <td>
                            <textarea name="txtDesignation" id="txtDesignation"><?php echo isset($desig) ? $desig : "" ?></textarea>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <label>Qualification</label>
                        </td>
                        <td>
                            <textarea name="txtQualification" id="txtQualification"><?php echo isset($qualification) ? $qualification : "" ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Technology</label>
                        </td>
                        <td>
                            <textarea name="txtTechnology" id="txtTechnology"><?php echo isset($technology) ? $technology : "" ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Category</label>
                        </td>
                        <td>
                            <select id= name="ddlCategory" onchange="return subcategories(this.value)">
                                <option value="-1">--select--</option>
                                <?php
                                $qryCat = "select * from tblcategory where catParentId is NULL and catStatus=1";
                                $resultCat = mysql_query($qryCat);
                                while ($rowCat = mysql_fetch_assoc($resultCat)) {
                                    ?>
                                    <option value="<?php echo $rowCat['catId'] ?>"><?php echo $rowCat['catTitle'] ?></option>
                                <?php }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>SubCategory</label>
                        </td>
                        <td>
                            <span id="spnSubCategory"><input type="checkbox" name="chkCheckAll" onclick="return checkAll()" />All <br /></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" name="smtSearch" id="smtSearch" value="Search" />
                            <input type="reset" onclick="return clearValidation()"/>
                            <input type="button" value="Cancel" onclick="window.location = '<?php echo URL ?>candidate/'" />
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <div id="searchJobs">
        <fieldset>
            <table class="candidateTable" width="100%">
                <tr>
                    <th>#</th>
                    <th>Job Title</th>
                    <th>Designation</th>
                    <th>Qualification</th>
                    <th>Technology</th>
                    <th>Positions</th>
                    <th> </th>
                </tr>
                <?php
                $class = "odd";
                while ($row = mysql_fetch_assoc($result)) {
                    ++$rownum;
                    if ($class == "even")
                        $class = "odd";
                    else
                        $class = "even";
                    ?>
                    <tr class="<?php echo $class ?>">
                        <td><?php echo $rownum ?></td>
                        <td><?php echo $row['jobTitle'] ?></td>
                        <td><?php echo $row['jobDesignation'] ?></td>
                        <td><?php echo $row['jobQualification'] ?></td>
                        <td><?php echo $row['jobTechnology'] ?></td>
                        <td><?php echo $row['jobPositionCount'] ?></td>
                        <td><a href="<?php echo URL ?>candidate/jobs/viewJob.php?jobid=<?php echo $row['jobId'] ?>"> View | Apply </a></td>
                    </tr>	
                <?php }
				$count=mysql_num_rows($result);
				if($count==0)
				{
					?>
					<tr>
					<td class="odd" align="center" class="red" colspan="7">No Result Found</td>
					</tr>
				<?php }
                ?>
            </table>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>