<?php
include_once '../include/header.php';
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
$countQuery = "select * from tblfaq";
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

$query = "select * from tblfaq where faq like '%" . $search . "%' limit " . $pageIndex . "," . $pageSize;
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
?>
<script>
    function frmManageFaq_submit()
    {
        document.search_faq.submit();
    }
</script>
<div class="content" style="height:370px">
    <h4 class="pageHeader">Frequently Asked Questions</h4>
    <div id="manage_faq" class="small_form">
        <fieldset>
            <form name="search_faq" method="post">
                <ul class="search">
                    <li>&nbsp <input type="text" name="txtSearch" placeholder="search.." value="<?php echo isset($_GET['text'])?$_GET['text']:""?>" /></li>
                    <li><a onclick="return frmManageFaq_submit()"> <img src="<?php echo URL ?>images/search.png" /> </a></li>
                </ul>
            </form>
            <div style="clear:both">

                <form name="manage_countries" method="post">
                    <table width="100%">
                        <tr>
                            <th>#</th>
                            <th>FAQ</th>
                        </tr>
                        <?php
                        $result = mysql_query($query);
                        $class = "odd";

                        while ($row = mysql_fetch_assoc($result)) {

                            if ($class == "even")
                                $class = "odd";
                            else
                                $class = "even";

                            if ($row['faqStatus'] == 1)
                                $status = "enabled.png";
                            else
                                $status = "disabled.png";
                            ?>
                            <tr class="<?php echo $class ?>">
                                <td class="bold"><?php echo $row['faqId'] ?></td>
                                <td><?php echo $row['faq'] ?></td>
                            </tr>
                            <tr>
                                <td class="bold">Answer</td>
                                <td><?php echo $row['faqAns'] ?></td>
                            </tr>
                        <?php }
						$count=mysql_num_rows($result);
						if($count==0)
						{
							?>
							 <tr>
                                <td class="odd" colspan="2" align="center" class="bold">No Data Found</td>
                                
                            </tr>
							<?php	
						}
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