<?php
include_once '../../include/header.php';

if (isset($_GET['disc']) && !empty($_GET['disc'])) {
    $disc = $_GET['disc'];
    $queryRep = "select * from tblpostdiscussion a inner join tblreplydiscussion b on a.postId=b.postId where b.postId=" . $disc;
    $resultRep = mysql_query($queryRep);

    $queryPost = "select * from tblpostdiscussion where postId=$disc";
    $resultPost = mysql_query($queryPost);
    $rowPost = mysql_fetch_assoc($resultPost);
}
if (isset($_POST['smtPost'])) {
    $reply = trim(addslashes($_POST['txtResponse']));
    $query = "insert into tblreplydiscussion set	
			postId=" . $disc . ",
			replyDesc='" . $reply . "',
			replyBy='" . $_SESSION['userid'] . "',
			replyDate=now(),
			replyStatus=1
			";
    $result = mysql_query($query);
    if ($result) {
        header('location:' . URL . 'candidate/discussion/participateDiscussion.php?disc=' . $_GET['disc'] . '&msg=added');
    }
}
$date = getdate();
?>
<script>
$(document).ready(function() {
	$(document).submit(function(){
		var flag=0;
		
		var response=$("#txtResponse").val().trim();
		if(response=="")
		{
			$("#txtResponseErr").html("Required!");
			flag=1;
		}
		return parseInt(flag)==0?true:false;
		});
});
</script>
<div id="divParticipateDiscussion" class="content">
    <div class="big_form">
        <h3 class="pageHeader">Participate Discussion</h3>
        <?php
        if (isset($_GET['msg'])) {
            switch ($_GET['msg']) {
                case "added": {
                        echo '<span class="spnGreen">Reply Posted</span>';
                        break;
                    }
            }
        }
        ?>
        <br />
        <fieldset>
            <form method="post">
                <table width='100%'>
                    <tr>
                        <td class='bold'> Topic </td>
                        <td colspan="3"><?php
                            echo $rowPost['postTopic'];
                            ?></td>
                    </tr>
                    <tr>
                        <td class='bold'> Description </td>
                        <td colspan="2"><?php
                            echo $rowPost['postDesc'];
                            ?></td>
                    </tr>
                    <tr>
                        <td class='bold'> Created By </td>
                        <td colspan="3"><?php
                            echo $rowPost['postBy'];
                            ?></td>
                    </tr>
                    <tr>
                        <td class='bold'> Created Date </td>
                        <td colspan="3"><?php
                            $temp = explode(" ", $rowPost['postDate']);
                            echo $temp[0];
                            ?></td>
                    </tr>
                    <?php
                    while ($rowRep = mysql_fetch_assoc($resultRep)) {
                        $replyDate = explode(" ", $rowRep['replyDate']);
                        ?>
                        <tr>
                            <td colspan="4"><fieldset>
                                    <table width='100%'>
                                        <tr>
                                            <td class='bold'> Reply Date </td>
                                            <td><?php echo $replyDate[0]; ?></td>
                                            <td class='bold'> Reply By </td>
                                            <td><?php echo $rowRep['replyBy']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class='bold' colspan="4"> Reply </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><fieldset style="background-color:#CCD6DB">
                                                    <?php echo $rowRep['replyDesc']; ?>
                                                </fieldset></td>
                                        </tr>

                                    </table>
                                </fieldset></td>
                        </tr>
                        <?php
                    }
                    ?>

                    <tr>
                        <td class='bold'> Reply Date </td>
                        <td><?php echo $date['mday'] . "-" . $date['month'] . "-" . $date['year'] ?></td>
                        <td class='bold'> Reply By </td>
                        <td><?php echo $_SESSION['userid'] ?></td>
                    </tr>
                    <tr>
                        <td class='bold' colspan="4"> Reply </td>
                    </tr>
                    <tr>
                        <td colspan="4"><textarea name="txtResponse" id="txtResponse" cols="46" ></textarea><span id="txtResponseErr" class="red_error"></span></td>
                    </tr>
                </table>
                <button type="submit" name="smtPost">Post Response</button>
                <input type="button" value="Cancel" onclick="window.location = '<?php echo URL ?>candidate/discussion/viewDiscussion.php'">
            </form>
        </fieldset>
    </div>
</div>

<?php
include_once '../../include/footer.php';
?>