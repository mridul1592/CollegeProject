<?php
include_once '../include/header.php';
?>
<?php
$status = "";
if (isset($_POST['smtRecover'])) {
    $flag = 0;
    $userid = addslashes(trim($_POST['txtUserId']));
    $sec_ques = addslashes($_POST['ddlSecQues']);
    $sec_ans = trim(addslashes($_POST['txtSecAns']));
    if ($userid == "" || $userid == NULL) {
        $useridErr = "Required!";
        $flag = 1;
    }
    if ($sec_ques == -1 || $sec_ques == NULL) {
        $SecQuesErr = "Required!";
        $flag = 1;
    }
    if ($sec_ans == "" || $sec_ans == NULL) {
        $sec_ansErr = "Required!";
        $flag = 1;
    }
    if ($flag == 0) {
        $query = "select usrPwd from tbluser where usrId='" . $userid . "' and usrSQ='" . $sec_ques . "' and usrSA='" . $sec_ans . "'";
        $result = mysql_query($query);
        if (mysql_num_rows($result) > 0) {
            $password = mysql_result($result, 0, 0);
            $status = "success";
        } else {            
            $msg = "invalid information";
        }
    }
}
?>
<script>
function clearValidation()
        {
            $("#txtUserIdErr").html("");
            $("#ddlSecQuesErr").html("");
            $("#txtSecAnsErr").html("");
        }
</script>
<div class="content">
    <h4 class="pageHeader">Forgot Password?</h4>
    <div>
        <?php echo isset($msg) ? "<span class='red_error'>" . $msg . "</span>" : "" ?>
        <div id="forgot_password" class="big_form">
            <form action="" method="post">
                <fieldset>
                    <legend>Forgot Password</legend>
                    <p><label class="field">User ID:<span class="red_error">*</span></label><input type="text" value="<?php echo isset($_POST['txtUserId']) ? $_POST['txtUserId'] : "" ?>" name="txtUserId"/><span id="txtUserIdErr" class="red_error"><?php if (isset($useridErr)) echo $useridErr; ?></span></p>
                    <p><label class="field">Security Question:<span class="red_error">*</span></label>
                        <select name="ddlSecQues">
                            <option value="-1">--Select--</option>
                            <?php
                            echo $query = "select * from tblusersq";
                            $result = mysql_query($query);
                            while ($row = mysql_fetch_assoc($result)) {
                                if (isset($_POST['ddlSecQues'])) {
                                    if ($_POST['ddlSecQues'] == $row['usrSQ'])
                                        $selected = 'selected="selected"';
                                }
                                ?>
                                <option value="<?php echo $row['usrSQ'] ?>" <?php echo isset($selected) ? $selected : "" ?>><?php echo $row['usrSQ'] ?></option>		
                            <?php }
                            ?>
                        </select><span id="ddlSecQuesErr" class="red_error"><?php if (isset($SecQuesErr)) echo $SecQuesErr; ?></span></p>
                    <p><label class="field">Security Answer:<span class="red_error">*</span></label>
                        <input type="text" value="<?php echo isset($_POST['txtSecAns']) ? $_POST['txtSecAns'] : "" ?>" name="txtSecAns" /><span id="txtSecAnsErr" class="red_error"><?php if (isset($sec_ansErr)) echo $sec_ansErr; ?></span></p>

                    <input name="smtRecover" type="submit" value="Recover" />
                    <input type="reset"   onclick='return clearValidation()'/>
                </fieldset>
            </form>
            <fieldset style="visibility:<?php echo ($status=='success'?'visible':'hidden'); ?>">
                <span>Your password is: <span class="green_success"><?php if (isset($password)) echo $password; ?></span></span><br />
                <a href="<?php echo URL ?>guest/login.php">Click here</a> to continue
            </fieldset>
        </div>
    </div>
</div>
<?php
include_once '../include/footer.php';
?>