<?php
//select * from tbljobcategory a left outer join (select c.catId,c.catTitle,d.catId as parentId,d.catTitle as parentName from tblcategory c join tblcategory d on c.catParentId=d.catId) b on a.catId=b.catId where jobId=13
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_POST['ddlFilter'])) {
    $filter = $_POST['ddlFilter'];
}

$pageIndex = 0;
$pageSize = 6;

//print_r($_POST);
if (isset($_GET['pageIndex']) && !empty($_GET['pageIndex'])) {
    $pageIndex = $_GET['pageIndex'];
}
if (isset($_POST['smtRight'])) {
    $pageIndex += (1 * $pageSize);
    header('location:?jobid=' . $_GET['jobid'] . '&pageIndex=' . $pageIndex);
} else if (isset($_POST['smtLeft'])) {
    $pageIndex -= (1 * $pageSize);
    header('location:?jobid=' . $_GET['jobid'] . '&pageIndex=' . $pageIndex);
}
if ($pageIndex < 0)
    $pageIndex = 0;
$countQuery = "select * from tbljobtest a join (select c.*,d.clgShortName from tblcandidate c join tblcollege d on c.cndCollege=d.clgId) b on a.cndId=b.cndId where a.jobId=" . $_GET['jobid'];
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);
$totalCount;

if (isset($_POST['txtSearch']) && !empty($_POST['txtSearch'])) {
    $search = $_POST['txtSearch'];
    header('location:?jobid=' . $_GET['jobid'] . '&pageIndex=0&action=search&text=' . $search);
}
if (isset($_GET['action']) && $_GET['action'] == "search") {
    $search = $_GET['text'];
} else {
    $search = "";
}
$left = "";
$right = "";

$query = "select * from tbljobtest a join (select c.*,d.clgShortName from tblcandidate c join tblcollege d on c.cndCollege=d.clgId) b on a.cndId=b.cndId where concat(cndFirstName,' ',cndLastName) like '%" . $search . "%' and a.jobId=" . $_GET['jobid'];
if (isset($filter) && $filter != -1) {
    $filter != 2 ? ($query .= " and a.jobIsSelected=$filter") : ($query .= " and a.jobIsSelected is NULL");
}
$query .= " limit " . $pageIndex . "," . $pageSize;
$result = mysql_query($query);
$countMessage = "";
if ($result) {
    //echo $totalCount;
    if ($totalCount == 0 || $pageSize >= $totalCount) {
        $left = 'disabled="disabled"';
        $right = 'disabled="disabled"';
    } else if ($pageIndex == 0) {
        $left = 'disabled="disabled"';
    } else if (($pageIndex + $pageSize) >= $totalCount) {
        $left = "";
        $right = 'disabled="disabled"';
        //echo $pageIndex;
    } else {
        $left = "";
        $right = "";
    }
}
if (isset($_GET['opt']) && isset($_GET['jobtestid']) && !empty($_GET['jobtestid'])) {
    echo $query = "update tbljobtest set jobIsSelected=if(jobIsSelected=1,0,1) where jobTestId=" . $_GET['jobtestid'];
    $resultStatus = mysql_query($query);
    header('location:' . URL . 'admin/jobs/jobInfo.php?jobid=' . $_GET['jobid']);
}
?>
<script>
    function frmManageJobs_submit()
    {
        document.search_jobs.submit();
    }
</script>
<div  style="height:370px">
    <h4 class="pageHeader">Job Information</h4>
    <div id="manage_jobs">
        <div class="big_form">
            <?php
            $query = "select * from tbljobopening where jobId=" . $_GET['jobid'];
            $resultJobDetail = mysql_query($query);
            $rowJobDetail = mysql_fetch_assoc($resultJobDetail);

            $query = "select a.*,b.catTitle,b.catParentId from tbljobcategory a left outer join tblcategory b on a.catId=b.catId where jobId=" . $_GET['jobid'];
            $resultJobCategory = mysql_query($query);
            $rowJobCategory = mysql_fetch_assoc($resultJobCategory);
            ?>
            <fieldset>
                <table>
                    <tr>
                        <td class="bold">Job Title</td>
                        <td><?php echo $rowJobDetail['jobTitle'] ?></td>
                        <td class="bold">Positions(Count)</td>
                        <td><?php echo $rowJobDetail['jobPositionCount'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Designation</td>
                        <td><?php echo $rowJobDetail['jobDesignation'] ?></td>
                        <td class="bold">Qualification</td>
                        <td><?php echo $rowJobDetail['jobQualification'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Description</td>
                        <td colspan="2"><?php echo $rowJobDetail['jobDesc'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Technology</td>
                        <td colspan="2"><?php echo $rowJobDetail['jobTechnology'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Job Status</td>
                        <td colspan="2"><?php echo $rowJobDetail['jobStatus'] == true ? "open" : "closed"; ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Job Category</td>
                        <td colspan="2"><?php echo $rowJobCategory['catParentId'] == NULL ? $rowJobCategory['catTitle'] : "" ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Job SubCategory</td>
                        <td colspan="2"><br><?php
                            $qry = "select a.*,b.catTitle,b.catParentId from tbljobcategory a left outer join tblcategory b on a.catId=b.catId where jobId=" . $_GET['jobid'];
                            $resultJobSubCategory = mysql_query($query);
                            while ($rowJobSubCategory = mysql_fetch_assoc($resultJobSubCategory)) {
                                if ($rowJobSubCategory['catParentId'] != NULL)
                                    echo $rowJobSubCategory['catTitle'] . "<br />";
                            }
                            ?></td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <fieldset>
            <form method="post" name="filter">

                <ul class="search">
                    <li>
                        <select name="ddlFilter" onchange="javascript:document.filter.submit()">
                            <option value="-1">--selected--</option>
                            <option <?php echo isset($filter) ? ($filter == 2 ? "selected='selected'" : "") : "" ?> value="2">Pending</option>
                            <option <?php echo isset($filter) ? ($filter == 1 ? "selected='selected'" : "") : "" ?> value="1">Selected</option>
                            <option <?php echo isset($filter) ? ($filter == 0 ? "selected='selected'" : "") : "" ?>  value="0">Not Selected</option>
                        </select>
                    </li>
                </ul>
            </form>
            <form name="search_jobs" method="post">
                <ul class="search">
                    <li>&nbsp <input type="text" name="txtSearch" placeholder="search.." /></li>
                    <li><a onclick="return frmManageJobs_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
                </ul>
            </form>
            <div style="clear:both">
                <?php
                if (isset($_GET['msg'])) {
                    if ($_GET['msg'] == "added") {
                        echo '<span class="spnGreen">Record Inserted</span>';
                    }
                    if ($_GET['msg'] == "edited") {
                        echo '<span class="spnGreen">Record Edited</span>';
                    }
                }
                ?>
                <form name="manage_jobs" method="post">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Candidate Name</th>
                            <th>DOB</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>College</th>
                            <th>Batch</th>
                            <th>Regulation/<br />Discipline</th>
                            <th>Test Date</th>
                            <th>Result</th>
                            <th>Send Email</th>
                        </tr>
                        <?php
                        $class = "odd";

                        if (isset($_GET['pageIndex'])) {
                            $rownum = $_GET['pageIndex'];
                        } else {
                            $rownum = 0;
                        }

                        while ($row = mysql_fetch_assoc($result)) {
                            //print_r($row);
                            ++$rownum;
                            if ($class == "even")
                                $class = "odd";
                            else
                                $class = "even";

                            $testDate = explode(" ", $row['jobTestOn']);
                            /* if($row['jobStatus']==1) $status="enabled.png";
                              else $status="disabled.png";
                              /* */
                            ?>
                            <tr class="<?php echo $class ?>">
                                <td><?php echo $rownum ?></td>
                                <td><?php echo $row['cndFirstName'] . " " . $row['cndLastName'] ?></td>
                                <td><?php echo $row['cndDOB'] ?></td>
                                <td><?php echo $row['cndEmailOfficial'] ?></td>
                                <td><?php echo $row['cndMobilePrimary'] ?></td>
                                <td><?php echo $row['clgShortName'] ?></td>
                                <td><?php echo $row['cndBatch'] ?></td>
                                <td><?php echo $row['cndRegDisId'] ?></td>
                                <td><?php echo $testDate[0] ?></td>
                                <td><a href="?jobid=<?php echo $_GET['jobid'] ?>&jobtestid=<?php echo $row['jobTestId']; ?>&opt=status"><?php echo $row['jobIsSelected'] == NULL ? "Pending" : ($row['jobIsSelected'] == 1 ? "Selected" : "Not Selected") ?></a></td>
                                <td><a onclick="window.open('sendEmail.php?jobTestId=<?php echo $row['jobTestId'] ?>','','width=600,height=500');">Send</a></td>
                            </tr>
                        <?php }
						$count=mysql_num_rows($result);
					if($count==0)
					{?>
					<tr>
						<td class="odd" align="center" colspan="11">No Record found</td>
					</tr>	
				<?php	}
                        ?>
                    </table>

                    <ul class="bottom_options">
                        <li><input type="submit" value="&lt&lt" name="smtLeft" <?php if (isset($left)) echo $left ?> />
                            <input type="submit" value="&gt&gt" name="smtRight" <?php if (isset($right)) echo $right ?> /></li>
                        <li><br><input type='button' name='btnBack' value='Back' onclick='window.location = "<?php echo URL ?>admin/jobs/manageJobs.php"'>
                    </ul>
                </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>