<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_GET['cid']) && isset($_GET['sid'])) {
    $pageIndex = 0;
    $pageSize = 4;

//print_r($_POST);
    if (isset($_GET['pageIndex'])) {
        $pageIndex = $_REQUEST['pageIndex'];
    }
    if (isset($_POST['smtRight'])) {
        $pageIndex += (1 * $pageSize);
        if (!isset($_GET['sid']) && empty($_GET['sid']))
            header('location:?pageIndex=' . $pageIndex);
        else if (isset($_GET['sid']) && isset($_GET['cid']))
            header('location:?pageIndex=' . $pageIndex . '&cid=' . $_GET['cid'] . '&sid=' . $_GET['sid']);
    }
    else if (isset($_POST['smtLeft'])) {
        $pageIndex -= (1 * $pageSize);
        if (!isset($_GET['sid']) && empty($_GET['sid']))
            header('location:?pageIndex=' . $pageIndex);
        else if (isset($_GET['sid']) && isset($_GET['cid']))
            header('location:?pageIndex=' . $pageIndex . '&cid=' . $_GET['cid'] . '&sid=' . $_GET['sid']);
    }
    if ($pageIndex < 0)
        $pageIndex = 0;

 if (isset($_POST['txtSearch']) && !empty($_POST['txtSearch'])) {
        $search = addslashes($_POST['txtSearch']);
        header('location:?cid=' . $_GET['cid'] . '&sid=' . $_GET['sid'] . '&pageIndex=0&action=search&text=' . $search);
    }
    if (isset($_GET['action']) && $_GET['action'] == "search") {
        $search = $_GET['text'];
    } else {
        $search = "";
    }
    $countQuery = "select * from tblgicity where cityName like '%" . $search . "%'";
    if (isset($_GET['sid']) && !empty($_GET['sid'])) {
        $countQuery .= " and stateId=" . $_GET['sid'];
    }

    $countResult = mysql_query($countQuery);
    $totalCount = mysql_num_rows($countResult);

   
    $left = "";
    $right = "";

    $query = "select * from tblgicity where cityName like '%" . $search . "%'";
    if (isset($_GET['sid']) && !empty($_GET['sid'])) {
        $query .= " and stateId=" . $_GET['sid'];
    }
    $query .=" limit " . $pageIndex . "," . $pageSize;
    $result = mysql_query($query);
    $countMessage = "";
    if ($result) {
        $countMessage = "page" . ($pageIndex + 1) . "shows" . mysql_num_rows($result) . "record(s) out of " . $totalCount;
        if ($totalCount == 0 || $pageSize >= $totalCount) {
            $left = 'disabled="disabled"';
            $right = 'disabled="disabled"';
        } else if ($pageIndex == 0) {
            $left = 'disabled="disabled"';
        } else if ($pageIndex + $pageSize >= $totalCount) {
            $left = "";
            $right = 'disabled="disabled"';
        } else {
            $left = "";
            $right = "";
        }
        //echo $pageIndex;
        //echo $totalCount;
        if (isset($_GET['opt']) && isset($_GET['cid']) && isset($_GET['sid'])) {
            $opt = $_GET['opt'];
            if ($opt == "status") {
                $queryStatus = "update tblgicity set cityStatus=if(cityStatus=1,0,1) where cityId=" . $_GET['city'];
                //die($queryStatus);
                $status = mysql_query($queryStatus);
                //header('location:manage_city.php?pageIndex='.$_GET['pageIndex']).'&cid='.$_GET['cid'].'&sid='.$_GET['sid'];
            }
        }
    }
    ?>
<script>
    function frmManageCities_submit()
    {
        document.search_cities.submit();
    }
    </script>

<div class="content"  style="height:370px">
	<h4 class="pageHeader">Manage Cities</h4>
	<div class="big_form">
		<fieldset>
			<?php
                if (isset($_GET['cid']) && isset($_GET['sid'])) {
                    $infoquery = "select countryName from tblgicountry where countryId=" . $_GET['cid'];
                    $result = mysql_query($infoquery);
                    $country = mysql_result($result, 0, 0);
                    $infoquery = "select stateName from tblgistate where stateId=" . $_GET['sid'] . " and countryId=" . $_GET['cid'];
                    $result = mysql_query($infoquery);
                    $state = mysql_result($result, 0, 0);
                }
                ?>
			<b>Country: <?php echo $country ?><br />
			</b> <b>State: <?php echo $state ?></b>
			<form name="search_cities" method="post">
				<ul class="search">
					<li>
						<input type="button" name="btnAddNew" value="Add New" onclick="window.location = 'addCity.php?sid=<?php echo $_GET['sid'] ?>&cid=<?php echo $_GET['cid'] ?>'" />
					</li>
					<li>&nbsp;
						<input type="text" name="txtSearch" value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" placeholder="search.." />
					</li>
					<li><a onclick="return frmManageCities_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
				</ul>
			</form>
			<div style="clear:both"></div>
			<?php
                if (isset($_GET['msg'])) {
                    switch ($_GET['msg']) {
                        case "added":
                            echo '<span class="spnGreen">Record Inserted</span>';
                            break;
                        case "edited":
                            echo '<span class="spnGreen">Record Edited</span>';
                            break;
                    }
                }
                ?>
			<form name="manage_cities" method="post">
				<table>
					<tr>
						<th>#</th>
						<th>City</th>
						<th>Status</th>
						<th>Edit/View</th>
					</tr>
					<?php
                        $class = "odd";
                        $result = mysql_query($query);

                        if (isset($_GET['pageIndex']))
                            $rownum = $_GET['pageIndex'];
                        else
                            $rownum = 0;


                        while ($row = mysql_fetch_assoc($result)) {
                            ++$rownum;
                            if ($class == "odd")
                                $class = "even";
                            else
                                $class = "odd";

                            if ($row['cityStatus'] == 1)
                                $status = "enabled.png";
                            else
                                $status = "disabled.png";
                            ?>
					<tr class="<?php echo $class; ?>">
						<td><?php echo $rownum; ?></td>
						<td><?php echo $row['cityName'] ?></td>
						<td><a href="?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 0 ?>&opt=status&cid=<?php echo $_GET['cid'] ?>&sid=<?php echo $row['stateId'] ?>&city=<?php echo $row['cityId'] ?>"><img src="<?php echo URL; ?>images/<?php echo $status ?>" /></a></td>
						<td><a href="<?php echo URL ?>admin/geographicInformation/editCity.php?cid=<?php echo $_GET['cid'] ?>&sid=<?php echo $_GET['sid'] ?>&city=<?php echo $row['cityId'] ?>"><img class="button" src="<?php echo URL; ?>images/edit.png"></a></td>
					</tr>
					<?php }
					$count=mysql_num_rows($result);
					if($count==0)
					{?>
					<tr>
						<td class="odd" align="center" colspan="4">No Record found</td>
					</tr>	
				<?php	}
                        ?>
				</table>
				<ul class="bottom_options">
					<li>
						<input type="submit" value="&lt&lt" name="smtLeft" <?php if (isset($left)) echo $left ?> />
						<input type="submit" value="&gt&gt" name="smtRight" <?php if (isset($right)) echo $right ?> />
					</li>
					<li><br>
						<input type="button" value="Back" name="btnBack" onclick="window.location = '<?php echo URL ?>admin/geographicInformation/manageStates.php?cid=<?php echo $_GET['cid'] ?>'">
					</li>
				</ul>
			</form>
		</fieldset>
	</div>
</div>
<?php
}
include_once '../../include/footer.php';
?>
