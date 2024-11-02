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
$countQuery = "select * from tblusersq";
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

$query = "select * from tblusersq where usrSQ like '%" . $search . "%' limit " . $pageIndex . "," . $pageSize;
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
    if (isset($_POST['smtSave'])) {
        $sq = trim(addslashes($_POST['txtSQ']));
        echo $qry = "insert into tblusersq set
			usrSQ='" . $sq . "'
			";
        $exe = mysql_query($qry);
        //echo mysql_error();
        if ($exe) {
            header('location:?msg=added');
        }
    }
}
?>
<script>
    function frmManagesq_submit()
    {
        document.search_sq.submit();
    }
    $(document).ready(function() {
        $(document.frmAddSQ).submit(function() {
            var sq = $("#txtSQ").val().trim();
            var flag = 0;
            if (sq == "")
            {
                $("#spnSQErr").html("*required!");
                flag = 1;
            }
            return parseInt(flag) == 1 ? false : true;
        });
    });
    /*function manage_sq_submit(sq)
     {
     
     document.manage_sq.submit();
     }/**/
</script>
<div class="content" style="height:370px">

    <h4 class="pageHeader">Manage Security Questions</h4>
    <?php
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        switch ($msg) {
            case "updated": {
                    echo "<span class='spnGreen'>Question Updated</span>";
                }
        }
    }
    ?>
    <div id="manage_sq" class="small_form">

        <fieldset>
            <form method="post" name="frmAddSQ" id="frmAddSQ">
                <table>
                    <tr>
                        <td>Security Question</td>
                        <td><input type="text" name="txtSQ" id="txtSQ" /><span id="spnSQErr" class="red_error"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                            <input type="submit" name="smtSave" value="Save" />
                            <input type="reset" />
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>

        <fieldset>
            <form name="search_sq" method="post">
                <ul class="search">
                    <li>&nbsp <input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManagesq_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
                </ul>
            </form>
            <div style="clear:both">
                <?php
                if (isset($_GET['msg'])) {
                    if ($_GET['msg'] == "added") {
                        echo '<span class="spnGreen">Question Inserted</span>';
                    }
                    if ($_GET['msg'] == "edited") {
                        echo '<span class="spnGreen">Question Edited</span>';
                    }
                }
                ?>
                <form name="manage_sq" method="post">
                    <table>
                        <tr>
                            <th>#</th>
                            <th>Security Question</th>
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
                            ?>
                            <tr class="<?php echo $class ?>">
                                <td><?php echo $rownum ?></td>
                                <td><?php echo $row['usrSQ'] ?></td>
                                <td><a href="<?php echo URL ?>admin/sq/editSQ.php?sq=<?php echo $row['usrSQ'] ?>"><img class="button" src="<?php echo URL; ?>images/edit.png" /></a></td>
                            </tr>

                        <?php }
						$count=mysql_num_rows($result);
					if($count==0)
					{?>
					<tr>
						<td class="odd" align="center" colspan="3">No Record found</td>
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