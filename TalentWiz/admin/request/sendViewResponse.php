<?php
include_once '../../include/header.php';

if (isset($_GET['req']) && !empty($_GET['req'])) {
    $query = "select * from tblrequest where requestId=" . $_GET['req'];
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);
    $reqdate = explode(' ', $row['requestDate']);
    $getdate = getdate();
    //print_r($getdate);
    $date = $getdate['year'] . "-" . $getdate['mon'] . "-" . $getdate['mday'];
    if (isset($_POST['smtRespond'])) {
        $response = trim(addslashes($_POST['txtResponse']));
    }
    if (isset($_POST['smtSend'])) {
        $response = trim(addslashes($_POST['txtResponse']));
        $query = "update tblrequest set responseDesc='$response',responseDate=now(),requestStatus=1 where requestId=" . $_GET['req'];
        $result = mysql_query($query);
        if ($result) {
            header('location:' . URL . 'admin/request/sendViewResponse.php?msg=response');
        }
    }
    ?>
    <script>
        $(document).ready(function(e) {
            $(document).submit(function() {
                var response = $("#txtResponse").val().trim();
                var flag = 0;
                if (response == "")
                {
                    flag = 1;
                    $("#txtResponseErr").html("Required!");
                }

                return parseInt(flag) == 1 ? false : true;
            });
        });
    </script>
    <div id="divSendViewResponse" class="content">
        <h3 class="pageHeader">Send/View Response</h3>
        <div class="big_form">
            <form method='post'>
                <fieldset>
                    <table>
                        <tr>
                            <td> Request:- </td>
                            <td colspan="3"><?php echo $row['requestTitle'] ?> </td>
                        </tr>
                        <tr>
                            <td> Description:- </td>
                            <td colspan="3"> <?php echo $row['requestDesc'] ?></td>
                        </tr>
                        <tr>
                            <td> Request Date:- </td>
                            <td><?php echo $reqdate[0] ?></td>
                            <td> Response Date:- </td>
                            <td> <?php echo $date ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"> Response </td>
                        </tr>
                        <tr>
                            <td colspan="4"><textarea name="txtResponse" id="txtResponse" cols="46" ></textarea>
                                <span class='red_error' id='txtResponseErr'></span>
                            </td>
                        </tr>
                    </table>
                    <ul class="bottom_options">
                        <li><input type="submit" value="Send Response" name="smtSend" />
                            <input type="button" value="Cancel" name="btnCancel" onclick="window.location = '<?php echo URL ?>admin/request/manageRequest.php'" /></li>
                    </ul>
                </fieldset>
            </form>

        </div>
    </div>
    <?php
}
include_once '../../include/footer.php';
?>