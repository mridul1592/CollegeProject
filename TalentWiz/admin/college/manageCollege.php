<?php
include_once '../../include/header.php';
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
$countQuery = "select * from tblcollege";
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

$query = "select * from tblcollege where clgName like '%" . $search . "%' limit " . $pageIndex . "," . $pageSize;
$result = mysql_query($query);
$countMessage = "";
if ($result) {
    //echo $pageSize;
    //echo $totalCount;
    $countMessage = "page" . ($pageIndex + 1) . "shows" . mysql_num_rows($result) . "record(s) out of " . $totalCount;
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
            $queryStatus = "update tblcollege set clgStatus=if(clgStatus='active','inactive','active') where clgId='" . $_GET['clg'] . "'";
            $status = mysql_query($queryStatus);
            header('location:manageCollege.php?pageIndex=' . $_GET['pageIndex']);
        }
    }
}
?>
<script type="text/javascript">
    function frmSearchCollege_submit()
    {
        document.frmSearchCollege.submit();
    }
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Manage Colleges</h4>

    <div id="manage_college" class="list_content">
        <fieldset>
            <form method="post" name="frmSearchCollege">
                <ul class="search">
                    <li><input type="button" onclick="window.location = 'addCollege.php'" value="Add New" /></li>
                    <li> &nbsp;<input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmSearchCollege_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
                </ul>
            </form>
            <div style="clear:both"></div>
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == "added") {
                    echo '<span class="spnGreen">Record Inserted</span>';
                }
                if ($_GET['msg'] == "updated") {
                    echo '<span class="spnGreen">Record Updated</span>';
                }
            }
            ?>
            <form name="frmManageCollege" method="post">
                <table>
                    <tr>
                        <th>#</th>
                        <th>College Name</th>
                        <th>HR allotted</th>
                        <th>HR Phone</th>
                        <th>HR Email</th>
                        <th>Edit</th>
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
                        ?>
                        <tr class="<?php echo $class ?>">
                            <td><?php echo $rownum ?></td>
                            <td><?php echo $row['clgName'] ?></td>
                            <td><?php echo $row['clgHRName'] ?></td>
                            <td><?php echo $row['clgHRPhoneNos'] ?></td>
                            <td><?php echo $row['clgHREmail'] ?></td>
                            <td><a href="editCollege.php?clg=<?php echo $row['clgId'] ?>"><img class="button" src="<?php echo URL; ?>images/edit.png" /></a></td>

                        </tr>
                    <?php }
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