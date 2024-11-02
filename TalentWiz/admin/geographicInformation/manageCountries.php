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
if (isset($_POST['txtSearch']) && !empty($_POST['txtSearch'])) {
    $search = $_POST['txtSearch'];
    header('location:?pageIndex=0&action=search&text=' . $search);
}
if (isset($_GET['action']) && $_GET['action'] == "search") {
    $search = $_GET['text'];
} else {
    $search = "";
}
$countQuery = "select * from tblgicountry where countryName like '%" . $search. "%'";
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);
$totalCount;


$left = "";
$right = "";

$query = "select * from tblgicountry where countryName like '%" . $search . "%' limit " . $pageIndex . "," . $pageSize;
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
        $left = "";
        $right = 'disabled="disabled"';
        //echo $pageIndex;
    } else {
        $left = "";
        $right = "";
    }
}
if (isset($_GET['opt']) && isset($_GET['cid'])) {
    $opt = $_GET['opt'];
    if ($opt == "status") {
        $queryStatus = "update tblgicountry set countryStatus=if(countryStatus=1,0,1) where countryId=" . $_GET['cid'];
        //die($queryStatus);
        $status = mysql_query($queryStatus);
        header('location:manageCountries.php?pageIndex=' . $_GET['pageIndex']);
    }
}
?>
<script>
    function frmManageCountries_submit()
    {
        document.search_countries.submit();
    }
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Manage Countries</h4>
    <div class="big_form">
        <fieldset>
            <form name="search_countries" method="post">
                <ul class="search">
                    <li><input type="button" name="btnAddNew" value="Add New" onclick="window.location = 'addCountry.php'" /></li>
                    <li>&nbsp <input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManageCountries_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
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
                <form name="manage_countries" method="post">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Country</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>States</th>
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

                            if ($row['countryStatus'] == 1)
                                $status = "enabled.png";
                            else
                                $status = "disabled.png";
                            ?>
                            <tr class="<?php echo $class ?>">
                                <td><?php echo $rownum ?></td>
                                <td><?php echo $row['countryName'] ?></td>
                                <td><a href="?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 0 ?>&opt=status&cid=<?php echo $row['countryId'] ?>"><img class="button" src="<?php echo URL; ?>images/<?php echo $status ?>"></a></td>
                                <td><a href="<?php echo URL ?>admin/geographicInformation/editCountry.php?cid=<?php echo $row['countryId'] ?>"><img class="button" src="<?php echo URL; ?>images/edit.png" /></a></td>
                                <td><a href="<?php echo URL ?>admin/geographicInformation/manageStates.php?cid=<?php echo $row['countryId'] ?>">States</a></td>
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