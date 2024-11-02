<?php
include_once '../../include/header.php';
//print_r($_SESSION);

$pageIndex = 0;
$pageSize = 6;

//print_r($_POST);
if (isset($_GET['pageIndex']) && !empty($_GET['pageIndex'])) {
    $pageIndex = $_REQUEST['pageIndex'];
} else {
    $pageIndex = 0;
}
if (isset($_POST['smtRight'])) {
    $pageIndex += (1 * $pageSize);
    header('location:?option=' . $_GET['option'] . '&applied&jobid=' . $_GET['jobid'] . '&pageIndex=' . $pageIndex);
} else if (isset($_POST['smtLeft'])) {
    $pageIndex -= (1 * $pageSize);
    header('location:?option=' . $_GET['option'] . '&jobid=' . $_GET['jobid'] . '&pageIndex=' . $pageIndex);
}
if ($pageIndex < 0)
    $pageIndex = 0;
$countQuery = "select *,(select clgShortName from tblcollege where clgId=cndCollege) as cndCollegeTitle from tbluser a inner join ( select c.*,d.jobTestId,d.jobTestOn,d.jobIsSelected,d.jobTestCorrectAns,d.jobTestTotalQuestions from tblcandidate c join tbljobtest d on c.cndId=d.cndId where d.jobId=" . $_GET['jobid'] . ") b on a.usrId=b.cndId";
if ($_GET['option'] == "selected") {
    $countQuery .= " where b.jobIsSelected=1";
}
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);

if (isset($_POST['txtSearch']) && !empty($_POST['txtSearch'])) {
    $search = addslashes($_POST['txtSearch']);
    header('location:?option=applied&jobid=' . $_GET['jobid'] . '&pageIndex=0&action=search&text=' . $search);
}
if (isset($_GET['action']) && $_GET['action'] == "search") {
    $search = addslashes($_GET['text']);
} else {
    $search = "";
}
$left = "";
$right = "";

$query = "select *,(select clgShortName from tblcollege where clgId=cndCollege) as cndCollegeTitle from tbluser a inner join ( select c.*,d.jobTestId,d.jobTestOn,d.jobIsSelected,d.jobTestCorrectAns,d.jobTestTotalQuestions from tblcandidate c join tbljobtest d on c.cndId=d.cndId where d.jobId=" . $_GET['jobid'] . ") b on a.usrId=b.cndId where concat(cndFirstName,' ',cndLastName) like '%" . $search . "%'";
if ($_GET['option'] == "selected") {
    $query .= " and b.jobIsSelected=1 ";
    $pageHeader = "Selected Candidates";
} else {
    $pageHeader = "Applied Candidates";
}
$query .= " and a.usrType!='admin' limit " . $pageIndex . "," . $pageSize;
$result = mysql_query($query) or die(mysql_error());

if ($result) {
    //echo $pageSize;
    //echo $totalCount;
    if ($totalCount == 0 || $pageSize >= $totalCount) {
        $left = 'disabled="disabled"';
        $right = 'disabled="disabled"';
    } else if ($pageIndex == 0) {
        $left = 'disabled="disabled"';
    } else if (($pageIndex + 1) * $pageSize >= $totalCount) {
        $left = "";
        $right = 'disabled="disabled"';
    } else {
        $left = "";
        $right = "";
    }
    if (isset($_GET['opt']) && isset($_GET['jobtestid'])) {
        $opt = $_GET['opt'];
        if ($opt == "isSelected") {
            $queryStatus = "update tbljobtest set jobIsSelected=if(jobIsSelected=1,0,1) where jobTestId='" . $_GET['jobtestid'] . "'";
            $status = mysql_query($queryStatus);
            header('location:jobCandidates.php?option=' . $_GET['option'] . '&jobid=' . $_GET['jobid'] . '&pageIndex=' . $_GET['pageIndex']);
        }
    }
}
?>
<script type="text/javascript">
    function frmManageCandidates_submit()
    {
        document.frmSearchCandidates.submit();
    }

</script>
<div style="height:370px">
    <h4 class="pageHeader"><?php echo $pageHeader ?></h4>

    <div id="manage_candidates" class="list_content">
        <fieldset>
            <form method="post" name="frmSearchCandidates">
                <ul class="search">
                    <li><input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManageCandidates_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
                </ul>
            </form>
            <div style="clear:both"></div>
            <form name="frmManageCandidates" method="post">
                <table>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>Mobile</th>
                        <th>Email Id</th>
                        <th>College</th>
                        <th>Batch</th>
                        <th>Regulation<br>/Discipline</th>
                        <th>Test Date</th>
                        <th>Result</th>
                        <th>Selected</th>
                    </tr>
<?php
$class = "odd";
if (isset($_GET['pageIndex']))
    $rownum = $_GET['pageIndex'];
else
    $rownum = 0;
//print_r($result);
while ($row = mysql_fetch_assoc($result)) {
    //echo $row['jobId'];
    ++$rownum;
    if ($class == "even")
        $class = "odd";
    else
        $class = "even";

    if ($row['usrStatus'] == "active")
        $status = "enabled.png";
    else
        $status = "disabled.png";

    $jobTestDate = explode(" ", $row['jobTestOn']);
    ?>
                        <tr class="<?php echo $class ?>">
                            <td><?php echo $rownum ?></td>
                            <td><?php echo $row['cndFirstName'] . " " . $row['cndLastName'] ?></td>
                            <td><?php echo $row['cndDOB'] ?></td>
                            <td><?php echo $row['cndMobilePrimary'] ?></td>
                            <td><?php echo $row['cndEmailOfficial'] ?></td>
                            <td><?php echo $row['cndCollegeTitle'] ?></td>
                            <td><?php echo $row['cndBatch'] ?></td>
                            <td><?php echo $row['cndRegDisId'] ?></td>
                            <td><?php echo $jobTestDate[0] ?></td>
                            <td><?php echo $row['jobTestCorrectAns'] . "/" . $row['jobTestTotalQuestions']; ?></td>
                            <td><a href="?option=<?php echo $_GET['option'] ?>&jobid=<?php echo $_GET['jobid'] ?>&pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : "" ?>&opt=isSelected&jobtestid=<?php echo $row['jobTestId'] ?>"><?php echo $row['jobIsSelected'] == NULL ? "Pending" : ($row['jobIsSelected'] == 1 ? "Selected" : "Not Selected") ?></a></td>
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
                    <li><br><input type="button" value="Back" name="btnBack" onclick="window.location = '<?php echo URL ?>admin/jobs/manageJobs.php'"></li>
                </ul>

            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>