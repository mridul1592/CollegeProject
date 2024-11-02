<?php
include_once '../include/header.php';
//print_r($_SESSION);

$pageIndex = 0;
$pageSize = 4;

//print_r($_POST);
if (isset($_GET['pageIndex']) && !empty($_GET['pageIndex'])) {
    $pageIndex = $_REQUEST['pageIndex'];
} else {
    $pageIndex = 0;
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
$countQuery = "select * from tbluser a inner join tbluserdetail b on a.usrId=b.usrId where a.usrType !='admin'";
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);

if (isset($_REQUEST['txtSearch']) && !empty($_POST['txtSearch'])) {
    $search = addslashes($_POST['txtSearch']);
    header('location:?pageIndex=0&action=search&text=' . $search);
}
if (isset($_GET['action']) && $_GET['action'] == "search") {
    $search = $_GET['text'];
} else {
    $search = "";
}
$left = "";
$right = "";

$query = "select * from tbluser a inner join tbluserdetail b on a.usrId=b.usrId where b.usrName like '%" . $search . "%' and a.usrType!='admin' limit " . $pageIndex . "," . $pageSize;
$result = mysql_query($query);
$countMessage = "";
if ($result) {
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
    if (isset($_GET['opt']) && isset($_GET['uid'])) {

        $opt = $_GET['opt'];
        if ($opt == "status") {
            $queryStatus = "update tbluser set usrStatus=if(usrStatus='active','inactive','active') where usrId='" . $_GET['uid'] . "'";
            $status = mysql_query($queryStatus);
            header('location:manageUsers.php?pageIndex=' . $_GET['pageIndex']);
        }
    }
}
?>
<script type="text/javascript">
    function frmManageUsers_submit()
    {
        document.frmSearchUsers.submit();
    }
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Manage Users</h4>

    <div id="manage_users" class="list_content">
        <fieldset>
            <form method="post" name="frmSearchUsers">
                <ul class="search">
                    <li><input type="button" name="btnAddNew" value="Add New" onclick="window.location = 'addUser.php'" /></li>
                    <li><input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManageUsers_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
                </ul>
            </form>
            <div style="clear:both"></div>
            <form name="frmManageUsers" method="post">
                <table>
                    <tr>
                        <th>#</th>
                        <th>UserId</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Mobile</th>
                        <th>Email Id</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $class = "odd";
                    if (isset($_GET['pageIndex']))
                        $rownum = $_GET['pageIndex'];
                    else
                        $rownum = 0;
//print_r($result);
                    while ($row = mysql_fetch_assoc($result)) {
                        ++$rownum;
                        if ($class == "even")
                            $class = "odd";
                        else
                            $class = "even";

                        if ($row['usrStatus'] == "active")
                            $status = "enabled.png";
                        else
                            $status = "disabled.png";
                        ?>
                        <tr class="<?php echo $class ?>">
                            <td><?php echo $rownum ?></td>
                            <td><?php echo $row['usrId'] ?></td>
                            <td><?php echo $row['usrName'] ?></td>
                            <td><?php echo $row['usrGender'] ?></td>
                            <td><?php echo $row['usrMobile'] ?></td>
                            <td><?php echo $row['usrEmail'] ?></td>
                            <td><a href="?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : "" ?>&opt=status&uid=<?php echo $row['usrId'] ?>"><img class="button" src="<?php echo URL; ?>images/<?php echo $status ?>" /></a></td>
                        </tr>
                    <?php }
					$count=mysql_num_rows($result);
					if($count==0)
					{?>
					<tr>
						<td class="odd" align="center" colspan="7">No Record found</td>
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
include_once '../include/footer.php';
?>