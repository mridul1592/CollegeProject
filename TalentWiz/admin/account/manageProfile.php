<?php
include_once '../../include/header.php';
include_once '../checksession.php';

if (isset($_SESSION['userid'])) {


    //print_r($_SESSION);
    $query = "select * from tbluser a inner join tbluserdetail b on a.usrId=b.usrId where a.usrId='$_SESSION[userid]'";
    $result = mysql_query($query);
    //die($query);
    $data = mysql_fetch_assoc($result);
    isset($data['usrGender']) ? ($data['usrGender'] == 'male' ? $male = 'checked="checked"' : $female = 'checked="checked"') : $male = 'checked="checked"';

    $dob = explode(' ', $data['usrDOB']);

    if (isset($_POST['smtUpdate'])) {
        $question = addslashes($_POST['ddlSecQues']);
        $answer = addslashes($_POST['txtSecAns']);
        $name = trim(addslashes($_POST['txtName']));
        $dob = trim(addslashes($_POST['dtDob']));
        $email = trim(addslashes($_POST['txtEmail']));
        $street = trim(addslashes($_POST['txtStreet']));
        $pincode = trim(addslashes($_POST['txtPincode']));
        $mobile = trim(addslashes($_POST['txtMobile']));

        $query = "update tbluser set
			usrSQ='" . $question . "',
			usrSA='" . $answer . "',
			usrType='$_SESSION[usertype]',
			usrStatus='active'
			where usrId='" . $_SESSION['userid'] . "'
			";
        //	die($query); /**/
        //	echo "<br />";	
        $result = mysql_query($query);
        $query = "update tbluserdetail set
			usrName='" . $name . "',
			usrDOB='" . $dob . "',
			usrGender='" . $_POST['gender'] . "',
			usrEmail='" . $email . "',
			usrStreet='" . $street . "',
			usrCountry='" . $_POST['ddlCountry'] . "',
			usrState='" . $_POST['ddlState'] . "',
			usrCity='" . $_POST['ddlCity'] . "',
			usrPIN=" . $pincode . ",
			usrMobile=" . $mobile . "
			where usrId='" . $_SESSION['userid'] . "';
			";
        $result = mysql_query($query);
        header('location:' . URL . 'admin/index.php?msg=profileUpdated');
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {
            var flag = 0;
            var userid = $("#txtUserId").val();

            var ques = $("#ddlSecQues").val();
            var ans = $("#txtSecAns").val();
            var name = $("#txtName").val();
            var dob = $("#dtDob").val();
            var email = $("#txtEmail").val();
            var street = $("#txtStreet").val();
            var city = $("#ddlCity").val();
            var state = $("#ddlState").val();
            var country = $("#ddlCountry").val();
            var pincode = $("#txtPincode").val();
            var mobile = $("#txtMobile").val();

            if (userid == "")
            {
                flag = 1;
                $("#txtUserIdErr").html("*Required!");
            }
            else
            {
                $("#txtUserIdErr").html("");
            }

            if (ques == -1)
            {
                flag = 1;
                $("#ddlSecQuesErr").html("*Required!");
            }
            else
            {
                $("#ddlSecQuesErr").html("");
            }
            if (ans == "")
            {
                flag = 1;
                $("#txtSecAnsErr").html("*Required!");
            }
            else
            {
                $("#txtSecAnsErr").html("");
            }
            if (name == "")
            {
                flag = 1;
                $("#txtNameErr").html("*Required!");
            }
            else
            {
                $("#txtNameErr").html("");
            }
            if (dob == "")
            {
                flag = 1;
                $("#dtDobErr").html("*Required!");
            }
            else
            {
                $("#dtDobErr").html("");
            }
            if (email == "")
            {
                flag = 1;
                $("#txtEmailErr").html("*Required!");
            }
            else
            {
                $("#txtEmailErr").html("");
            }
            if (street == "")
            {
                flag = 1;
                $("#txtStreetErr").html("*Required!");
            }
            else
            {
                $("#txtStreetErr").html("");
            }
            if (city == -1)
            {
                flag = 1;
                $("#ddlCityErr").html("*Required!");
            }
            else
            {
                $("#ddlCityErr").html("");
            }
            if (state == -1)
            {
                flag = 1;
                $("#ddlStateErr").html("*Required!");
            }
            else
            {
                $("#ddlStateErr").html("");
            }
            if (country == -1)
            {
                flag = 1;
                $("#ddlCountryErr").html("*Required!");
            }
            else
            {
                $("#ddlCountryErr").html("");
            }
            if (pincode == "")
            {
                flag = 1;
                $("#txtPincodeErr").html("*Required!");
            }
            else
            {
                $("#txtPincodeErr").html("");
            }
            if (mobile == "")
            {
                flag = 1;
                $("#txtMobileErr").html("*Required!");
            }
            else
            {
                $("#txtMobileErr").html("");
            }

            return parseInt(flag) == 1 ? false : true;
        });
    });

    function GetAllStateByCountryId(cid)
    {
        GetAllCityByStateId(-1);
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        }
        else
        {
            xmlhttp = new ActiveXObject(Microsoft.XMLHTTP);
        }
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("spnState").innerHTML = xmlhttp.responseText;
                //GetAllCityByStateId(objState.value);
            }
        }
        xmlhttp.open("GET", "../GetStatesByCountryId.php?cid=" + cid, true);
        xmlhttp.send();
    }
    function GetAllCityByStateId(sid)
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        }
        else
        {
            xmlhttp = new ActiveXObject(Microsoft.XMLHTTP);
        }

        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("spnCity").innerHTML = xmlhttp.responseText;
                //alert(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET", "../GetCitiesByStateId.php?sid=" + sid, true);
        xmlhttp.send();
    }
    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "dtDob",
            dateFormat: "%Y-%m-%d"
                    /*selectedDate:{				This is an example of what the full configuration offers.
                     day:5,						For full documentation about these settings please see the full version of the code.
                     month:9,
                     year:2006
                     },
                     yearsRange:[1978,2020],
                     limitToToday:false,
                     cellColorScheme:"beige",
                     dateFormat:"%m-%d-%Y",
                     imgPath:"img/",
                     weekStartDay:1*/
        });
    };
    $(function()
    {
        $("#wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft"
        });
    });
    /*
     $(function ()
     {
     $("#wizard").steps({
     headerTag: "h2",
     bodyTag: "section",
     transitionEffect: "none",
     enableFinishButton: false,
     enablePagination: false,
     enableAllSteps: true,
     titleTemplate: "#title#",
     cssClass: "tabcontrol"
     });
     }); /**/
</script>

<div class="content">
    <h4 class="pageHeader">Manage Profile</h4>
    <span class="green_success">
        <?php if (isset($_GET['msg']) && $_GET['msg'] == "updated") echo "Profile Updated"; ?>
    </span>
    <div id="manage_profile" class="big_form">

        <form id="wizard" class="form" method="post">
            <h2>Account Information</h2>
            <section>
                <fieldset>
                    <p>
                        <label class="field">User ID:</label>
                        <input readonly="readonly" id="txtUserId" type="text" name="txtUserId" value="<?php echo isset($data['usrId']) ? $data['usrId'] : ""; ?>">
                        <span class="red_error" id="txtUserIdErr"></span></p>
                    <p>
                        <label class="field">Security Question:</label>
                        <select id="ddlSecQues" name="ddlSecQues">
                            <option value="-1">--select question--</option>
                            <?php
                            $query = "select * from tblusersq";
                            $result = mysql_query($query);

                            while ($row = mysql_fetch_assoc($result)) {
                                ($row['usrSQ'] == $data['usrSQ']) ? $selected = "selected" : $selected = "";
                                ?>
                                <option value="<?php echo $row['usrSQ'] ?>" <?php if (isset($selected)) echo $selected; ?>><?php echo $row['usrSQ'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="red_error" id="ddlSecQuesErr"></span></p>
                    <p>
                        <label class="field">Security Answer:</label>
                        <input id="txtSecAns" type="text" name="txtSecAns" value="<?php echo isset($data['usrSA']) ? $data['usrSA'] : ""; ?>" />
                        <span class="red_error" id="txtSecAnsErr"></span></p>
                </fieldset>
            </section>

            <h2>Personal Information</h2>
            <section>
                <fieldset>
                    <table>

                        <tr><td><p>
                                    <label class="field">Name:</label>
                                    <input id="txtName" type="text" name="txtName" value="<?php echo isset($data['usrName']) ? $data['usrName'] : ""; ?>"/>
                                    <span class="red_error" id="txtNameErr"></span></p></td></tr>
                        <tr><td><p>
                                    <label class="field">Date of Birth:</label>
                                    <input id="dtDob" type="date" name="dtDob" value="<?php echo isset($dob[0]) ? $dob[0] : "" ?>" />
                                    <span class="red_error" id="dtDobErr"></span></p></td></tr>
                        <tr><td><p>
                                    <label class="field">Gender:</label>
                                    <input id="radGender" type="radio" name="gender" value="male" <?php echo isset($male) ? $male : ""; ?>/>
                                    Male
                                    <input type="radio" name="gender" value="female" <?php echo isset($female) ? $female : "" ?> />
                                    Female </p></td></tr>
                        <tr><td><p>
                                    <label class="field">Email ID:</label>
                                    <input id="txtEmail" type="email" name="txtEmail"  value="<?php echo isset($data['usrEmail']) ? $data['usrEmail'] : "" ?>"/>
                                    <span class="red_error" id="txtEmailErr"></span></p></td></tr>
                        <tr><td><p>
                                    <label class="field">Street:</label>
                                    <input id="txtStreet" type="text" name="txtStreet" value="<?php echo isset($data['usrStreet']) ? $data['usrStreet'] : "" ?>" />
                                    <span class="red_error" id="txtStreetErr"></span></p></td></tr>
                        <tr><td><p>
                                    <label class="field">Country:</label>
                                    <select id="ddlCountry" name="ddlCountry" onchange="return GetAllStateByCountryId(this.value)">
                                        <option value="-1">--select country--</option>
                                        <?php
                                        $query = "select * from tblgicountry where countryStatus = 1";
                                        $result = mysql_query($query);

                                        while ($row = mysql_fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row['countryId'] ?>" <?php echo isset($data['usrCountry']) ? (($data['usrCountry'] == $row['countryId']) ? 'selected="selected"' : "") : "" ?> ?><?php echo $row['countryName'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    <span class="red_error" id="ddlCountryErr"></span></p></td></tr>
                        <tr><td><span id="spnState">
                                    <p>
                                        <label class="field">State</label>
                                        <select id="ddlState" name="ddlState"  onchange="return GetAllCityByStateId(this.value)">
                                            <option value="-1">--select state--</option>
                                            <?php
                                            $query = "select * from tblgistate where stateStatus=1";
                                            $result = mysql_query($query);
                                            while ($row = mysql_fetch_assoc($result)) {
                                                ?>
                                                <option value="<?php echo $row['stateId'] ?>" <?php echo isset($data['usrState']) ? (($data['usrState'] == $row['stateId']) ? 'selected="selected"' : "") : "" ?>><?php echo $row['stateName'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                        <span class="red_error" id="ddlStateErr"></span></p>
                                </span></td></tr>
                        <tr><td><span id="spnCity">
                                    <p>
                                        <label class="field">City:</label>
                                        <select id="ddlCity" name="ddlCity">
                                            <option value="-1">--select city--</option>
                                            <?php
                                            $query = "select * from tblgicity where cityStatus=1";
                                            $result = mysql_query($query);
                                            while ($row = mysql_fetch_assoc($result)) {
                                                ?>
                                                <option value="<?php echo $row['cityId'] ?>" <?php echo isset($data['usrCity']) ? (($data['usrCity'] == $row['cityId']) ? 'selected="selected"' : "") : "" ?>><?php echo $row['cityName'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                        <span class="red_error" id="ddlCityErr"></span></p>
                                </span></td></tr>
                        <tr><td><p>
                                    <label class="field">Pincode:</label>
                                    <input id="txtPincode" type="text" name="txtPincode" value="<?php echo isset($data['usrPIN']) ? $data['usrPIN'] : "" ?>" />
                                    <span class="red_error" id="txtPincodeErr"></span></p></td></tr>
                        <tr><td><p>
                                    <label class="field">Mobile:</label>
                                    <input id="txtMobile" type="text" name="txtMobile" value="<?php echo isset($data['usrMobile']) ? $data['usrMobile'] : "" ?>" />
                                    <span class="red_error" id="txtMobileErr"></span></p></td></tr>
                    </table>
                </fieldset>
                <div class="inputbtn">
                    <p>
                        <input name="smtUpdate" type="submit" value="Update" />
                        <input type="reset" />
                        <input type="button" value="Cancel"  onclick="window.location = '<?php echo URL ?>admin/'" />
                    </p>
                </div>
            </section>
        </form>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>
