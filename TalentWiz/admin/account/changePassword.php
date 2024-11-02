<?php
include_once '../../include/header.php';
include_once '../checksession.php';
?>

<div class="content" style="height:370px">

    <h4 class="pageHeader">Change Password</h4>
    <?php
    if (isset($_POST['userid'])) {
        $oldpass = addslashes($_POST['txtPassword']);
        $newpass = addslashes($_POST['txtNewPassword']);
        $confirm = addslashes($_POST['txtConfirm']);

        if ($newpass == "" || $newpass == NULL) {
            $newpassErr = "Required!";
        }
        if ($confirm == "" || $confirm == NULL) {
            $confirmErr = "Required!";
        }

        $query = "select * from tbluser where usrId='" . $_SESSION['userid'] . "' and usrPwd='" . $oldpass . "'";
        $result = mysql_query($query);
        $count = mysql_num_rows($result);
        if ($count) {
            $row = mysql_fetch_assoc($result);
            if ($newpass == $confirm) {
                $query = "update tbluser set usrPwd='" . $newpass . "' where usrId='" . $_SESSION['userid'] . "'";
                $result = mysql_query($query);
                //echo mysql_error();
                if ($result) {
                    header('location:' . URL . 'admin/index.php?msg=passwordUpdated');
                }
            } else {
                $confirmErr = "Passwords do not match!";
            }
        } else {
            $oldpassErr = "Incorrect password";
        }
        if ($oldpass == "" || $oldpass == NULL) {
            $oldpassErr = "Required!";
        }
    }
    ?>
    <script>
        $(document).ready(function() {
            $(document).submit(function() {
                var flag = 0;
                var oldpassword = trim($("#txtPassword").val());
                var newpassword = trim($("#txtNewPassword").val());
                var conf = trim($("#txtConfirm").val());

                if (oldpassword == "")
                {
                    flag = 1;
                    $("#txtPasswordErr").html("*Required!");
                }
                if (newpassword == "")
                {
                    flag = 1;
                    $("#txtNewPasswordErr").html("*Required!");
                }
                if (conf == "")
                {
                    flag = 1;
                    $("#txtConfirmErr").html("*Required!");
                }

                return parseInt(flag) == 1 ? false : true;
            });
        });
    </script>
    <span class="green_success"><?php echo isset($msg) ? $msg : "" ?></span>
    <div id="frmChangePassword" class="small_form">
        <fieldset>
            <form action="" method="post">
                <p><label class="field">User ID:</label><input name="userid" type="text" readonly="readonly" value="<?php echo $_SESSION['userid'] ?>" /></p>
                <p><label class="field">Old Password:<span class="red">*</span></label><input type="password" id="txtPassword" name="txtPassword" /><span id="txtPasswordErr" class="red_error"><?php if (isset($oldpassErr)) echo $oldpassErr; ?></span></p>
                <p><label class="field">New Password:<span class="red">*</span></label><input type="password" id="txtNewPassword" name="txtNewPassword" /><span id="txtNewPasswordErr" class="red_error"><?php if (isset($newpassErr)) echo $newpassErr; ?></span></p>
                <p><label class="field">Confirm Password:<span class="red">*</span></label><input type="password" id="txtConfirm" name="txtConfirm" /><span id="txtConfirmErr" class="red_error"><?php if (isset($confirmErr)) echo $confirmErr; ?></span></p>
                <ul class="bottom_options">
                    <li><input type="submit" value="Update" />
                        <input type="button" onclick="window.location = '<?php echo URL ?>admin/'" value="Cancel" /></li>
                </ul>
            </form>
        </fieldset>
    </div>
</div>

<?php
include_once '../../include/footer.php';
?>