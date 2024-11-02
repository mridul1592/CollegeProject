<?php
include_once '../include/header.php';

if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'candidate')) {
    header('location:' . URL . 'candidate/index.php');
} else {
    if (isset($_POST['smtLogin'])) {
        $flag = 1;
        $userid = addslashes(trim($_POST['txtUserId']));
        $password = addslashes($_POST['txtPassword']);
        if ($userid == "" || $userid == NULL) {
            $useridErr = "Required!";
            $flag = 0;
        }
        if ($password == "" || $password == NULL) {
            $passwordErr = "Required!";
            $flag = 0;
        }
        if ($flag) {
            $query = "select * from tbluser where usrId='" . $userid . "' and usrPwd='" . $password . "' and usrType='candidate'";
            $result = mysql_query($query);
            if ($row = mysql_fetch_assoc($result)) {
                if ($row['usrStatus'] == "active") { {
                        $_SESSION['usertype'] = $row['usrType'];
                        $_SESSION['userid'] = $row['usrId'];
                    }
                    header('location:' . URL . 'candidate/index.php');
                } else {
                    $msg = "Your account has not been activated";
                }
            } else {
                $msg = "Invalid username or password";
            }
        }
    }
    ?>
    <script>
        $(document).ready(function() {
            $(document).submit(function() {

                var flag = 0;
                var userid = $("#txtUserId").val();
                var password = $("#txtPassword").val();
                //alert(userid);
                if (userid == "")
                {
                    flag = 1;
                    $("#txtUserIdErr").html("Required!");
                }
                if (password == "")
                {
                    flag = 1;
                    $("#txtPasswordErr").html("Required!");
                }
                return parseInt(flag) == 1 ? false : true;
            });

        });
        function clearValidation()
        {
            $("#txtUserIdErr").html("");
            $("#txtPasswordErr").html("");
        }
    </script>
    <br />
    <div style="margin:0 auto;border:1px solid #ccc;width:400px;padding:20px;">
        <table style="margin:0 auto;width:250px;">
            <tr>
                <td align="center"><label class="pageHeader">Login</label></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><span class="red_error"><?php echo isset($msg) ? $msg : "" ?></span></td>
            </tr>
            <tr>
                <td>
                    <form name="frmLogin" method="post">
                        <table style="margin:0 auto">
                            <tr>
                                <td> User Id <span class="red">*</span></td>
                                <td><input type="text" id="txtUserId" name="txtUserId" value="<?php echo isset($_POST['txtUserId']) ? $_POST['txtUserId'] : "" ?>" /></td>
                                <td><span id="txtUserIdErr" class="red">
                                        <?php if (isset($useridErr)) echo $useridErr; ?>
                                    </span></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Password<span class="red">*</span></td>
                                <td><input type="password" id="txtPassword" name="txtPassword" /></td>
                                <td><span id="txtPasswordErr" class="red">
                                        <?php if (isset($passwordErr)) echo $passwordErr; ?>
                                    </span></td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center"><input type="submit" id="smtLogin" name="smtLogin" value="Login" />
                                    <input onclick="return clearValidation()" type="reset" /></td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">
                                    <a href="<?php echo URL ?>guest/forgotPassword.php">Forgot Password?</a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo URL ?>guest/registration/cndReg.php">Sign Up</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </div>
    <?php
}
include_once '../include/footer.php';
?>