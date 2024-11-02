<?php
include_once 'settings.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>TalentWiz</title>
        <script src="<?php echo URL ?>scripts/jquery.min.js" type="text/javascript"></script>
        <link href="<?php echo URL ?>css/dropdowntab/glowtabs.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo URL ?>scripts/dropdowntab/dropdowntabs.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                tabdropdown.init("glowmenu", "auto")
            });
        </script>
        <link href="<?php echo URL ?>css/siteStyle.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>css/alpha.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" media="all" href="<?php echo URL ?>/scripts/calender/jsDatePick_ltr.min.css" />
        <script type="text/javascript" src="<?php echo URL ?>/scripts/calender/jsDatePick.min.1.3.js"></script>

        <link rel="stylesheet" href="<?php echo URL ?>scripts/steps/demo/css/normalize.css"></link>
        <link rel="stylesheet" href="<?php echo URL ?>scripts/steps/demo/css/main.css" ></link>
        <link rel="stylesheet" href="<?php echo URL ?>scripts/steps/demo/css/jquery.steps.css" ></link>
        <script src="<?php echo URL ?>scripts/steps/lib/modernizr-2.6.2.min.js"></script>
        <script src="<?php echo URL ?>scripts/steps/lib/jquery-1.9.1.min.js"></script>
        <script src="<?php echo URL ?>scripts/steps/lib/jquery.cookie-1.3.1.js"></script>
        <script src="<?php echo URL ?>scripts/steps/build/jquery.steps.js"></script>
    </head>        
    <body>
        <table id="mainContainer" style="width: 100%;
               border-collapse: collapse;">
            <tr>
                <td >
                    <div id="header">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="width: 120px;">&nbsp;

                                </td>
                                <td align="left" valign="bottom" style="font-family: Arial,Sans-Serif,Serif, Verdana,Monospace;
                                    font-size: 75px; line-height: 100px; width: 400px;">
                                    <span><span style="color: #c90c09;">T</span><span style="color: #31a913;">alent</span>
                                        <span style="color: #e88908;">W</span><span style="color: #1369f2;">iz</span>
                                    </span>
                                </td>
                                <td align="right" valign="bottom">
                                    <label id="lblMessage">
                                        Welcome 
                                        <?php
                                        if (isset($_SESSION["userid"])) {
                                            echo ucfirst($_SESSION['userid']);
                                            ?> !!!
                                            <a href="<?php echo URL ?>logout.php">Sign Out</a>
                                            <?php
                                        } else {
                                            echo "Guest";
                                            ?> !!!
                                            <a href="<?php echo URL ?>guest/login.php">Sign In</a>
                                        <?php } ?>
                                    </label>
                                </td>
                                <td style="width: 20px;">&nbsp;

                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>

            <?php
            if (isset($_SESSION["usertype"]) && ($_SESSION["usertype"] == "admin" || $_SESSION["usertype"] == "operator")) {
                ?>
                <tr>
                    <td style="background-image: url('<?php echo URL; ?>images/headerbg.png'); background-repeat: repeat-x;
                        background-position: center center;">
                        <table style="margin: 0 auto; border-collapse: collapse; width: 980px;">
                            <tr>
                                <td align="left">
                                    <img id="logoImage" alt="" src="<?php echo URL; ?>images/header.png" align="left" hspace="0" vspace="0"
                                         style="width: 375px; height: 38px;" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <td style="background-image: url('<?php echo URL; ?>images/headerbg.png'); background-repeat: repeat-x;
                        background-position: center center;">
                        <br />
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td id="BlueLine">
                </td>
            </tr>
            <tr>
                <td id="headerMenuBack">
                    <div id="headerMenuContainer">
                        <?php include_once 'topmenu.php'; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="containerOuter">
                        <div id="containerInner">