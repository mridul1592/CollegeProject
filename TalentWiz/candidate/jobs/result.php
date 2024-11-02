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
$countQuery = "select * from tbljobtest a left outer join tbljobopening b on a.jobId=b.jobId where a.cndId='" . $_SESSION['userid'] . "'";
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);
$totalCount;

if (isset($_POST['txtSearch']) && !empty($_POST['txtSearch'])) {
    $search = trim(addslashes($_POST['txtSearch']));
    header('location:?pageIndex=0&action=search&text=' . $search);
}
if (isset($_GET['action']) && $_GET['action'] == "search") {
    $search = trim(addslashes($_GET['text']));
} else {
    $search = "";
}
$left = "";
$right = "";

$query = "select * from tbljobtest a left outer join tbljobopening b on a.jobId=b.jobId where a.cndId='" . $_SESSION['userid'] . "' and b.jobTitle like '%" . $search . "%' limit " . $pageIndex . "," . $pageSize;
$result = mysql_query($query);
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
?>
<script>
    function frmManagejobtest_submit()
    {
        document.search_jobtest.submit();
    }
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Test Results</h4>
    <div id="manage_jobtest">
        <fieldset>
            <form name="search_jobtest" method="post">
                <ul class="search">
                    <li>&nbsp <input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManagejobtest_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
                </ul>
            </form>
            <div style="clear:both">

                <form name="manage_jobtest" method="post">
                    <table width="100%">
                        <tr class="odd">
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Designation</th>
                            <th>Position Count</th>
                            <th>Job Status</th>
                            <th>Test Date</th>
                            <th>Result</th>
                            <th>Print</th>
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

                            $jobtestdate = explode(" ", $row['jobTestOn']);
                            ?>
                            <tr class="<?php echo $class ?>">
                                <td><?php echo $rownum ?></td>
                                <td><?php echo $row['jobTitle'] ?></td>

                                <td><?php echo $row['jobDesignation'] ?></td>
                                <td><?php echo $row['jobPositionCount'] ?></td>
                                <td><?php echo $row['jobStatus'] == true ? "open" : "closed" ?></td>
                                <td><?php echo $jobtestdate[0] ?></td>
                                <td><?php echo $row['jobIsSelected'] == NULL ? "Pending" : ($row['jobIsSelected'] == true ? "Selected" : "Not selected") ?></td>
                                <td><a onclick="window.open('printResult.php?jobtestid=<?php echo $row['jobTestId'] ?>','','width=600,height=500');">Print</a></td>
                            </tr>
                        <?php }
						$count=mysql_num_rows($result);
					if($count==0)
					{?>
					<tr>
						<td class="odd" align="center" colspan="8">No Record found</td>
					</tr>	
				<?php	}
                        ?>
                    </table>

                    <ul class="bottom_options">
                        <p><li><input type="submit" value="&lt&lt" name="smtLeft" <?php if (isset($left)) echo $left ?> />
                            <input type="submit" value="&gt&gt" name="smtRight" <?php if (isset($right)) echo $right ?> /></li></p>
                    </ul>
                </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>