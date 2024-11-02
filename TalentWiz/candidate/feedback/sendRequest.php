<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_POST['smtSend'])) {
    $title = trim(addslashes($_POST['txtTitle']));
    $desc = trim(addslashes($_POST['txtDescription']));

    echo $query = "insert into tblrequest set
			requestTitle='$title',
			requestDesc='$desc',
			requestDate=now(),
			requestBy='" . $_SESSION['userid'] . "',
			requestStatus=0
			";
    $result = mysql_query($query) or die(mysql_error());
    if ($result) {
        header('location:' . URL . 'candidate/index.php?msg=requestSent');
    }
}


$pageIndex = 0;
$pageSize = 4;

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
$countQuery = "select * from tblrequest where requestBy='" . $_SESSION['userid'] . "'";
$countResult = mysql_query($countQuery);
$totalCount = mysql_num_rows($countResult);
$totalCount;


$left = "";
$right = "";

$query = "select * from tblrequest where requestBy='" . $_SESSION['userid'] . "' limit " . $pageIndex . "," . $pageSize;
$result = mysql_query($query);
$countMessage = "";
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
    $(document).ready(function(e) {
        $(document.frmSendrequest).submit(function() {
            var title = $("#txtTitle").val().trim();
            var desc = $("#txtDescription").val().trim();
            var flag = 0;
            if (title == "")
            {
                flag = 1;
                $("#txtTitleErr").html("Required!");
            }
            if (desc == "")
            {
                flag = 1;
                $("#txtDescriptionErr").html("Required!");
            }
            return parseInt(flag) == 1 ? false : true;
        });
    });
	function clearValidation()
        {
            $("#txtDescriptionErr").html("");
            $("#txtTitleErr").html("");
        }
</script>
<div id="divSendrequest" class="content">
    <h3 class="pageHeader">Send Request</h3>

    <div class="small_form">
        <fieldset>
            <form name="frmSendrequest" method="post">
                <table>
                    <tr>
                        <td>
                            <label>Request Title</label><span class="red">*</span>
                        </td>
                        <td>
                            <input type="text" name="txtTitle" id="txtTitle" />
                        </td>
                        <td>
                            <span id="txtTitleErr" class="red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Description</label><span class="red">*</span>
                        </td>
                        <td>
                            <textarea name="txtDescription" id="txtDescription"></textarea>
                        </td>
                        <td>
                            <span id="txtDescriptionErr" class="red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" name="smtSend" id="smtSend" value="Send" />
                            <input type="reset"  onclick='return clearValidation()'/>
                            <input type="button" value="Cancel" onclick="window.location = '<?php echo URL ?>candidate/index.php'" /></td>
                    </tr>
                </table>
            </form>
        </fieldset>
        <fieldset>
            <h4 class="pageHeader">My Requests</h4>
            <form method="post">
                <table width="100%">
                    <tr>
                        <th>#</th>
                        <th>Request Title</th>
                        <th>Date</th>
                        <th>Response</th>
                    </tr>
                    <?php
                    isset($_GET['pageIndex']) ? $rownum = $_GET['pageIndex'] : $rownum = 0;
                    $class = "odd";
                    while ($row = mysql_fetch_assoc($result)) {
                        ++$rownum;

                        $class == "odd" ? $class = "even" : $class = "odd";
                        $date = explode(' ', $row['requestDate']);
                        ?>
                        <tr class="<?php echo $class ?>">
                            <td><?php echo $rownum; ?></td>
                            <td><a href="<?php echo URL ?>candidate/feedback/viewRequest.php?reqid=<?php echo $row['requestId'] ?>"><?php echo $row['requestTitle'] ?></td>
                            <td><?php echo $date[0] ?></td>
                            <td><?php echo $row['responseDesc'] == "" ? "No Response" : "Responded"; ?></td>
                        </tr>	
                    <?php }
                    ?>
                </table>
                <ul class="bottom_options">
                    <li><input type="submit" value="&lt&lt" name="smtLeft" <?php if (isset($left)) echo $left ?> />
                        <input type="submit" value="&gt&gt" name="smtRight" <?php if (isset($right)) echo $right ?> /></li>
                </ul>
            </form>
        </fieldset>

    </div> 
</div>
<?php
include_once '../../include/footer.php';
?>