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
$countQuery = "select * from tblquestion";
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);
$totalCount;

if (isset($_POST['txtSearch']) && !empty($_POST['txtSearch'])) {
    $search = trim(addslashes($_POST['txtSearch']));
    header('location:?pageIndex=0&action=search&text=' . $search);
}
if (isset($_GET['action']) && $_GET['action'] == "search") {
    $search = $_GET['text'];
} else {
    $search = "";
}
$left = "";
$right = "";

$query = "select a.*,d.catTitle,d.category from tblquestion a left outer join ( select b.*,c.catTitle as category from tblcategory b left outer join tblcategory c on b.catParentId=c.catId) d  on a.qusCategory=d.catId where qusTitle like '%" . $search . "%' limit " . $pageIndex . "," . $pageSize;
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
if (isset($_GET['opt']) && isset($_GET['qusid'])) {
    $opt = $_GET['opt'];
    if ($opt == "status") {
        $queryStatus = "update tblquestion set qusStatus=if(qusStatus=1,0,1) where qusId=" . $_GET['qusid'];
        //die($queryStatus);
        $status = mysql_query($queryStatus);
        header('location:manageQuestions.php?pageIndex=' . $_GET['pageIndex']);
    } else if ($opt == "delete") {
        echo $queryDelete = "delete from tblquestion where qusId=" . $_GET['qusid'];
        // die;
        $deleteResult = mysql_query($queryDelete);
        if ($deleteResult)
            header('location:manageQuestions.php?pageIndex=' . $_GET['pageIndex']);
    }
}
?>
<script>
    function frmManageQuestion_submit()
    {
        document.search_Question.submit();
    }
    function confirmDelete()
    {
        var conf = confirm("Delete this question?");
        if (conf)
            return true;
        else
            return false;
    }
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Manage Question</h4>
    <div id="manage_Question">
        <fieldset>
            <form name="search_Question" method="post">
                <ul class="search">
                    <li><input type="button" name="btnAddNew" value="Add New" onclick="window.location = 'addQuestion.php'" /></li>
                    <li>&nbsp <input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManageQuestion_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
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
            </div>
            <form name="manage_Question" method="post">
                <table>
                    <tr>
                        <th style="text-align:center">#</th>
                        <th>Question</th>
                        <th>Sub-category</th>
                        <th>Category</th>
                        <th>Delete</th>
                        <th>Edit</th>
                        <th>Status</th>
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

                        if ($row['qusStatus'] == 1)
                            $status = "enabled.png";
                        else
                            $status = "disabled.png";
                        ?>
                        <tr class="<?php echo $class ?>">
                            <td align="center"><?php echo $rownum; ?></td>
                            <td><?php echo $row['qusTitle']; ?></td>
                            <td><?php echo $row['catTitle']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td><a onclick="return confirm('Are you sure?')" href="<?php echo URL ?>admin/questions/manageQuestions.php?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : "" ?>&opt=delete&qusid=<?php echo $row['qusId']; ?>"/><img class="button" src="<?php echo URL; ?>images/delete.png" /></a></td>
                            <td><a href="<?php echo URL ?>admin/questions/editQuestion.php?qusid=<?php echo $row['qusId'] ?>"><img class="button" src="<?php echo URL; ?>images/edit.png" /></a></td>
                            <td><a href="?pageIndex=<?php echo isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 0 ?>&opt=status&qusid=<?php echo $row['qusId'] ?>"><img class="button" src="<?php echo URL; ?>images/<?php echo $status ?>"></a></td>
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
include_once '../../include/footer.php';
?>