<?php
include_once '../../include/header.php';
include_once '../checksession.php';

$pageIndex = 0;
$pageSize = 4;

//print_r($_POST);
if (isset($_GET['pageIndex'])) {
    $pageIndex = $_GET['pageIndex'];
}
if (isset($_POST['smtRight'])) {
    $pageIndex += (1 * $pageSize);
    if (!isset($_GET['cid']) && empty($_GET['cid']))
        header('location:?pageIndex=' . $pageIndex);
    else if (isset($_GET['cid']) && !empty($_GET['cid']))
        header('location:?pageIndex=' . $pageIndex . '&cid=' . $_GET['cid']);
}
else if (isset($_POST['smtLeft'])) {
    $pageIndex -= (1 * $pageSize);
    if (!isset($_GET['cid']) && empty($_GET['cid']))
        header('location:?pageIndex=' . $pageIndex);
    else if (isset($_GET['cid']) && !empty($_GET['cid']))
        header('location:?pageIndex=' . $pageIndex . '&cid=' . $_GET['cid']);
}
if ($pageIndex < 0)
    $pageIndex = 0;
if (isset($_REQUEST['txtSearch'])) {
    $search = $_POST['txtSearch'];
    header('location:?cid=' . $_GET['cid'] . '&pageIndex=0&action=search&text=' . $search);
}
if (isset($_GET['action']) && $_GET['action'] == "search") {
    $search = $_GET['text'];
} else {
    $search = "";
}

$countQuery = "select * from tblgistate where stateName like '%" . $search . "%' ";
if (isset($_GET['cid']) && !empty($_GET['cid'])) {
    $countQuery .= " and countryId=" . $_GET['cid'];
}
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);


$left = "";
$right = "";

$query = "select * from tblgistate where stateName like '%" . $search . "%' ";
if (isset($_GET['cid']) && !empty($_GET['cid'])) {
    $query .=" and countryId=" . $_GET['cid'];
}
$query.= " limit " . $pageIndex . "," . $pageSize;
$result = mysql_query($query);
$countMessage = "";
if ($result) {
    $countMessage = "page" . ($pageIndex + 1) . "shows" . mysql_num_rows($result) . "record(s) out of " . $totalCount;
    if ($totalCount == 0 || $pageSize >= $totalCount) {
        $left = 'disabled="disabled"';
        $right = 'disabled="disabled"';
    } else if ($pageIndex == 0) {
        $left = 'disabled="disabled"';
    } else if (($pageIndex + $pageSize) >= $totalCount) {
//		echo $pageIndex;
        $left = "";
        $right = 'disabled="disabled"';
    } else {
        $left = "";
        $right = "";
    }
    if (isset($_GET['opt']) && isset($_GET['cid']) && isset($_GET['sid'])) {
        $opt = $_GET['opt'];
        if ($opt == "status") {
            $queryStatus = "update tblgistate set stateStatus=if(stateStatus=1,0,1) where stateId=" . $_GET['sid'];
            //die($queryStatus);
            $status = mysql_query($queryStatus);
            header('location:manageStates.php?pageIndex=' . $_GET['pageIndex'] . '&cid=' . $_GET['cid']);
        }
    }
}
?>
<script>
    function frmManageStates_submit()
    {
        document.search_states.submit();
    }
</script>
<div class="content" style="height:370px">
    <H4 class="pageHeader">Manage States</H4>
    <div class="big_form">
        <fieldset>
            <?php
            if (isset($_GET['cid'])) {
                $countryQry = "select countryName from tblgicountry where countryId=" . $_GET['cid'];
                $exe = mysql_query($countryQry);
                $country = mysql_result($exe, 0, 0);
            }
            ?>
            <b>Country:<?php echo isset($country) ? $country : "" ?></b>
            <form name="search_states" method="post">
                <ul class="search">
                    <li><input type="button" name="btnAddNew" value="Add New" onclick="window.location = 'addState.php?cid=<?php echo isset($_GET['cid']) ? $_GET['cid'] : "" ?>'" /></li>
                    <li>&nbsp; <input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManageStates_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
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
                <form name="manage_states" method="post">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>State</th>
                            <th>Status</th>
                            <th>Edit/View</th>
                            <th>City</th>
                        </tr>
                        <?php
                        $class = "odd";


                        if (isset($_GET['pageIndex']))
                            $rownum = $_GET['pageIndex'];
                        else
                            $rownum = 0;

                        //$result=mysql_query($query);
                        while ($row = mysql_fetch_assoc($result)) {
                            $rownum++;

                            if ($class == "even")
                                $class = "odd";
                            else
                                $class = "even";

                            if ($row['stateStatus'] == 1)
                                $status = "enabled.png";
                            else
                                $status = "disabled.png";
                            //print_r($row);}exit;{
                            ?>
                            <tr class="<?php echo $class ?>">
                                <td><?php echo $rownum ?></td>
                                <td><?php echo $row['stateName'] ?></td>
                                <td><a href="?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 0 ?>&opt=status&cid=<?php echo isset($_GET['cid']) ? $_GET['cid'] : "" ?>&sid=<?php echo $row['stateId'] ?>"><img class="button" src="<?php echo URL; ?>images/<?php echo $status ?>"></a></td>
                                <td><a href="<?php echo URL ?>admin/geographicInformation/editState.php?cid=<?php echo $row['countryId'] ?>&sid=<?php echo $row['stateId'] ?>"><img class="button" src="<?php echo URL; ?>images/edit.png" /></a></td>
                                <td><a href="<?php echo URL ?>admin/geographicInformation/manageCity.php?cid=<?php echo $row['countryId'] ?>&sid=<?php echo $row['stateId'] ?>">City</a></td>
                            </tr>
                        <?php }
						$count=mysql_num_rows($result);
					if($count==0)
					{?>
					<tr>
						<td class="odd" align="center" colspan="5">No Record found</td>
					</tr>	
				<?php	}
                        ?>
                    </table>
                    <ul class="bottom_options">
                        <li><input type="submit" value="&lt&lt" name="smtLeft" <?php if (isset($left)) echo $left ?> />
                            <input type="submit" value="&gt&gt" name="smtRight" <?php if (isset($right)) echo $right ?> /></li>
                        <li><br><input type="button" value="Back" name="btnBack" onclick="window.location = '<?php echo URL ?>admin/geographicInformation/manageCountries.php'"></li>
                    </ul>
                </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>