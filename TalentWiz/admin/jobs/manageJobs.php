<?php
include_once '../../include/header.php';
include_once '../checksession.php';

$pageIndex = 0;
$pageSize = 6;
//print_r($_POST);
if (isset($_GET['pageIndex']) && !empty($_GET['pageIndex'])) {
    $pageIndex = $_GET['pageIndex'];
}
if (isset($_POST['smtRight'])) {
    $pageIndex += (1 * $pageSize);
    header('location:?pageIndex=' . $pageIndex);
} else if (isset($_POST['smtLeft'])) {
    $pageIndex -= (1 * $pageSize);
    header('location:?pageIndex=' . $pageIndex);
}
if ($pageIndex < 0)
    $pageIndex = 0;
$countQuery = "select * from tbljobopening where 1";
if (isset($_POST['ddlFilter'])) {
    $filter = $_POST['ddlFilter'];
    $countQuery .= " and jobStatus=" . $filter;
}
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);
$totalCount;

if (isset($_POST['txtSearch']) && !empty($_POST['txtSearch'])) {
    $search = $_POST['txtSearch'];
    header('location:?pageIndex=0&action=search&text=' . $search);
}
if (isset($_GET['action']) && $_GET['action'] == "search") {
    $search = $_GET['text'];
} else {
    $search = "";
}
$left = "";
$right = "";

$query = "select jo.*,count(jt.cndId) as appliedCandidates,(select count(cndId) from tbljobtest where jobId=jt.jobId and jobIsSelected=1 group by jobTitle,jobDesignation) as selectedCandidates from tbljobopening AS jo left outer join tbljobtest as jt on jo.jobId=jt.jobId where jobTitle like '%" . $search . "%'";
if (isset($filter) && $filter != -1) {
    empty($filter) ? $filter = 0 : "";
    $query .= " and jo.jobStatus=" . $filter;
}

$query .= " group by jobTitle,jobDesignation limit " . $pageIndex . "," . $pageSize;
$result = mysql_query($query);
$countMessage = "";
if ($result) {
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
if (isset($_GET['opt']) && isset($_GET['jobid'])) {
    $opt = $_GET['opt'];
    if ($opt == "status") {
        $queryStatus = "update tbljobopening set jobStatus=if(jobStatus=1,0,1) where jobId=" . $_GET['jobid'];
        //die($queryStatus);
        $status = mysql_query($queryStatus);
        header('location:manageJobs.php?pageIndex=' . $_GET['pageIndex']);
    } elseif ($opt == "delete") {
        $query = "delete from tbljobopening where jobId=" . $_GET['jobid'];
        //die($query);
        $delete = mysql_query($query) or die(mysql_error());
        $query = "delete from tbljobcategory where jobId=" . $_GET['jobid'];
        $delete2 = mysql_query($query) or die(mysql_error());
        header('location:manageJobs.php?msg=deleted&pageIndex=' . $_GET['pageIndex']);
    }
}
?>
<script type="text/javascript">
    function frmManageJobs_submit()
    {
        document.search_jobs.submit();
    }
    function confirmDelete()
    {
        var conf = confirm("Do you really want to delete the record?");
        if (conf)
            return true;
        return false;
    }
</script>
<div  style="height:370px">
    <h4 class="pageHeader">Manage Jobs</h4>
    <div id="manage_jobs">
        <fieldset>
            <form name="filter" method="post">

                <ul class="search">
                    <li>
                        <select name="ddlFilter" onchange="javascript:document.filter.submit()">
                            <option value="-1">--status--</option>
                            <option value="1" <?php echo isset($filter) ? ($filter == 1 ? "selected='selected'" : "") : "" ?>>Active</option>
                            <option value="0" <?php echo isset($filter) ? ($filter == 0 ? "selected='selected'" : "") : "" ?>>Inactive</option>
                        </select>
                    </li>
                </ul>
            </form>
            <form name="search_jobs" method="post">
                <ul class="search">
                    <li><input type="button" name="btnAddNew" value="Add New" onclick="window.location = 'addJob.php'" /></li>
                    <li>&nbsp <input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
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
                            <th>Job Title</th>
                            <th>Designation</th>
                            <th>Qualification</th>
                            <th>Technology</th>
                            <th>Positions</th>
                            <th>Candidate(s)<br>applied</th>
                            <th>Selected<br>Candidates</th>
                            <th>Delete</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                        <?php
                        $result = mysql_query($query);
                        $class = "odd";

                        if (isset($_GET['pageIndex'])) {
                            $rownum = $_GET['pageIndex'];
                        } else {
                            $rownum = 0;
                        }

                        while ($row = mysql_fetch_assoc($result)) {
                            ++$rownum;
                            if ($class == "even")
                                $class = "odd";
                            else
                                $class = "even";

                            if ($row['jobStatus'] == 1)
                                $status = "enabled.png";
                            else
                                $status = "disabled.png";
                            ?>
                            <tr class="<?php echo $class ?>">
                                <td><?php echo $rownum ?></td>
                                <td><a href="<?php echo URL ?>admin/jobs/jobInfo.php?jobid=<?php echo $row['jobId'] ?>"><?php echo $row['jobTitle'] ?></a></td>
                                <td><?php echo $row['jobDesignation'] ?></td>
                                <td><?php echo $row['jobQualification'] ?></td>
                                <td><?php echo $row['jobTechnology'] ?></td>
                                <td><?php echo $row['jobPositionCount'] ?></td>
                                <td><a href="<?php echo URL ?>admin/jobs/jobCandidates.php?option=applied&jobid=<?php echo $row['jobId'] ?>"><?php echo $row['appliedCandidates'] ?></a></td>
                                <td><a href="<?php echo URL ?>admin/jobs/jobCandidates.php?option=selected&jobid=<?php echo $row['jobId'] ?>"><?php echo $row['selectedCandidates'] == 0 ? "-" : $row['selectedCandidates']; ?></a></td>
                                <td><a onclick="return confirm('Are you sure?')" href="<?php echo URL ?>admin/jobs/manageJobs.php?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 0 ?>&opt=delete&jobid=<?php echo $row['jobId'] ?>"><img src="<?php echo URL; ?>images/delete.png"></a></td>
                                <td><a href="?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 0 ?>&opt=status&jobid=<?php echo $row['jobId'] ?>"><img class="button" src="<?php echo URL; ?>images/<?php echo $status ?>"></a></td>
                                <td><a href="<?php echo URL ?>admin/jobs/editJob.php?jobid=<?php echo $row['jobId'] ?>"><img src="<?php echo URL; ?>images/edit.png"></a></td>
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
                    </ul>
                </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>