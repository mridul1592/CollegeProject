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
$countQuery = "select * from tblpostdiscussion ";
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

$query = "select * from tblpostdiscussion where  postTopic like '%" . $search . "%' limit " . $pageIndex . "," . $pageSize;
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
        $queryStatus = "update tblpostdiscussion set postStatus=if(postStatus=1,0,1) where postId=" . $_GET['cid'];
        //die($queryStatus);
        $status = mysql_query($queryStatus);
        header('location:manageDiscussion.php?pageIndex=' . $_GET['pageIndex']);
    }
    else if ($opt == "delete") {
        $queryStatus = "delete from tblpostdiscussion where postId=" . $_GET['cid'];
        //die($queryStatus);
        $status = mysql_query($queryStatus);
        header('location:manageDiscussion.php?msg=deleted&pageIndex=' . $_GET['pageIndex']);
    }
}
?>
<script>
    function frmManageDiscussion_submit()
    {
        document.search_Discussion.submit();
    }
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Manage Discussion</h4>
    <div id="manage_Discussion">
        <fieldset>
            <form name="search_Discussion" method="post">
                <ul class="search">
                    <li><input type="button" name="btnAddNew" value="Add New Topic" onclick="window.location = 'addDiscussion.php'" /></li>
                    <li>&nbsp <input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManageDiscussion_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
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
                    if ($_GET['msg'] == "deleted") {
                        echo '<span class="spnGreen">Record Deleted</span>';
                    }
                }
                ?>
                <form name="manage_Discussion" method="post">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Topic</th>
                            <th>Date</th>
                            <th>Created by</th>
                            <th>Response</th>
                            <th>Status</th>
                            <th>Delete</th>
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

                            if ($row['postStatus'] == 1)
                                $status = "enabled.png";
                            else
                                $status = "disabled.png";


                            $qryResponse = "select * from tblreplydiscussion where postId=" . $row['postId'];
                            $resultResponse = mysql_query($qryResponse);
                            $response = mysql_num_rows($resultResponse);
                            ?>
                            <tr class="<?php echo $class ?>">
                                <td><?php echo $rownum ?></td>
                                <td><a href="<?php echo URL ?>admin/discussion/participateDiscussion.php?disc=<?php echo $row['postId'] ?>"><?php echo $row['postTopic'] ?></a></td>
                                <td><?php echo $row['postDate'] ?></td>
                                <td><?php echo $row['postBy'] ?></td>
                                <td><?php echo $response; ?></td>
                                <td><a href="?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 0 ?>&opt=status&cid=<?php echo $row['postId'] ?>"><img class="button" src="<?php echo URL; ?>images/<?php echo $status ?>"></a></td>
                                <td><a href="<?php echo URL ?>admin/discussion/manageDiscussion.php?cid=<?php echo $row['postId'] ?>&opt=delete" onclick="return confirm('Are you sure?')"><img class="button" src="<?php echo URL; ?>images/delete.png" /></a></td>
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