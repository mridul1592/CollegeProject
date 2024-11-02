<?php
include_once "../include/settings.php";
?>
<?php
if (isset($_POST['smtLogin'])) {
    $flag = 1;
    $userid = addslashes(trim($_POST['txtUserId']));
    $password = addslashes($_POST['txtPassword']);
    if ($userid == "" || $userid == NULL) {
        //$useridErr="Required!";
        $flag = 0;
    }
    if ($password == "" || $password == NULL) {
        //$passwordErr="Required!";
        $flag = 0;
    }
    if ($flag) {
        $query = "select * from tbluser where usrId='" . $userid . "' and usrPwd='" . $password . "' and usrType!='candidate'";
        $result = mysql_query($query);
        if ($row = mysql_fetch_assoc($result)) {
            if ($row['usrStatus'] == "active") {
                if ($row['usrType'] == "admin") {
                    $_SESSION['usertype'] = "admin";
                    $_SESSION['userid'] = $row['usrId'];
                } else if ($row['usrType'] == "operator") {
                    $_SESSION['usertype'] = "operator";
                    $_SESSION['userid'] = $row['usrId'];
                }
                echo URL . 'admin/';
                print_r($_SESSION);
                //exit;
                header('location:' . URL . 'admin/');
            } else {
                $msg = "Your account has not been activated";
            }
        } else {
            $msg = "Invalid username or password";
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/siteStyle.css">
        <script type="text/javascript" src="../scripts/jquery-1.4.1.js"></script>
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
                //alert();
                $("#txtUserIdErr").html("");
                $("#txtPasswordErr").html("");
            }
        </script>
    </head>
    <body>
        <br />
        <br />
        <br />
        <br />
        <br />
          <table width="300px" height="200px" style="margin:0 auto;background:url(<?php echo URL; ?>images/admin_bg.jpg);border:1px solid #006;">
            <tr>
                <td align="center"><br /><label class="pageHeader">Login</label></td>
            </tr>
            <tr>
                <td align="center"><span class="red"><?php echo isset($msg) ? $msg : "" ?></span></td>
            </tr>
            <tr>
                <td><form name="frmLogin" method="post">
                        <table style="margin:0 auto">
                            <tr>
                                <td> User Id <span class="red">*</span></td>
                                <td><input type="text" id="txtUserId" name="txtUserId" value="<?php echo isset($_POST['txtUserId']) ? $_POST['txtUserId'] : '' ?>" /></td>
                                <td>
                                    <span id="txtUserIdErr" class="red">
                                        <?php if (isset($useridErr)) echo $useridErr; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Password <span class="red">*</span></td>
                                <td><input type="password" id="txtPassword" name="txtPassword" /></td>
                                <td>
                                    <span id="txtPasswordErr" class="red">
                                        <?php if (isset($passwordErr)) echo $passwordErr; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3" align="center"><input type="submit" id="smtLogin" name="smtLogin" value="Login" />
                                    <input onClick="javascript:return clearValidation()" type="reset" /></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><br><a href="<?php echo URL ?>guest/login.php">View site</a></td>

                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    
    </body>
</html>