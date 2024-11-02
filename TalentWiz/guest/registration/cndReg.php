<?php
include_once '../../include/header.php';

/* $query = "select usrId from tbluser";
  $resultUserid = mysql_query($query);
  $rowUserId = mysql_fetch_assoc($resultUserid);
 */
if (isset($_POST['smtSignUp'])) {

    $qryRepeat = "select * from tbluser where usrId='" . $_POST['txtUserId'] . "'";
    $resultRepeat = mysql_query($qryRepeat);
    $repeat = mysql_num_rows($resultRepeat);

    if (!$repeat) {
        $blnCheckForFile = true;

        $id = trim(addslashes($_POST['txtUserId']));
        $password = addslashes($_POST['txtNewPassword']);
        $sq = trim(addslashes($_POST['ddlSQ']));
        $sa = trim(addslashes($_POST['txtSA']));
        $first = trim(addslashes($_POST['txtFirstName']));
        $last = trim(addslashes($_POST['txtLastName']));
        $dob = trim(addslashes($_POST['txtDob']));
        $gender = trim(addslashes($_POST['rbtnGender']));
        $emailOff = trim(addslashes($_POST['txtOffEmail']));
        $emailPer = trim(addslashes($_POST['txtPerEmail']));
        $mobilePri = trim(addslashes($_POST['txtPriMobile']));
        $mobileSec = trim(addslashes($_POST['txtSecMobile']));

        $streetPer = trim(addslashes($_POST['txtStreet']));
        $countryPer = trim(addslashes($_POST['ddlCountry']));
        $statePer = trim(addslashes($_POST['ddlState']));
        $cityPer = trim(addslashes($_POST['ddlCity']));
        $pinPer = trim(addslashes($_POST['txtPin']));

        if (isset($_POST['cbxSame']) && $_POST['cbxSame'] == 1) {
            $streetTemp = $streetPer;
            $countryTemp = $countryPer;
            $stateTemp = $statePer;
            $cityTemp = $cityPer;
            $pinTemp = $pinPer;
        } else {
            $streetTemp = trim(addslashes($_POST['txtStreetTemp']));
            $countryTemp = $_POST['ddlCountryTemp'];
            $stateTemp = $_POST['ddlStateTemp'];
            $cityTemp = $_POST['ddlCityTemp'];
            $pinTemp = trim(addslashes($_POST['txtPinTemp']));
        }

        $batch = trim(addslashes($_POST['txtBatch']));
        $percentage = trim(addslashes($_POST['txtPercentage']));
        $college = trim(addslashes($_POST['ddlCollege']));
        $regulation = trim(addslashes($_POST['ddlRegulation']));

        $majorProject = trim(addslashes($_POST['txtMajorProject']));
        $minorProject = trim(addslashes($_POST['txtMinorProject']));
        $language = trim(addslashes($_POST['txtLanguage']));
        $technology = trim(addslashes($_POST['txtTechnologies']));

        ////////////////////////
        if (isset($_FILES['fileResume']["name"]) && !empty($_FILES['fileResume']["name"])) {
            $allowedExtentions = array("doc", "docs", "docx", "pdf");
            $imageName = (explode(".", $_FILES["fileResume"]["name"]));
            $extention = end($imageName);

            if (($_FILES["fileResume"]["size"]) && in_array($extention, $allowedExtentions)) {

                $uploadPath = "../../documents/resumes/" . $_SESSION['userid'] . "." . $extention;
                move_uploaded_file($_FILES["fileResume"]["tmp_name"], $uploadPath);
                
                $uploadPath = "documents/resumes/" . $_SESSION['userid'] . "." . $extention;
            } else {
                $msg = "Select valid resume file.";
                $blnCheckForFile = false;
            }
        }

        ///////////////////////
        if ($blnCheckForFile == true) {
            $query1 = "insert into tbluser set
			usrId='$id',
			usrPwd='$password',
			usrSQ='$sq',
			usrSA='$sa',
			usrType='candidate',
			usrStatus='active'
			";
            $query2 = "insert into tblcandidate set
			cndId='$id',
			cndFirstName='$first',
			cndLastName='$last',
			cndDOB='$dob',
			cndGender='$gender',
			cndEmailOfficial='$emailOff',
			cndEmailPersonal='$emailPer',
			cndStreetPermanent='$streetPer',
			cndCountryPermanent=$countryPer,
			cndStatePermanent=$statePer,
			cndCityPermanent=$cityPer,
			cndPinPermanent='$pinPer',
			cndStreetTemporary='$streetTemp',
			cndPinTemporary='$pinTemp',
			cndMobilePrimary='$mobilePri',
			cndMobileSecondary='$mobileSec',
			cndBatch='$batch',
			cndCollege=$college,
			cndMajorProject='$majorProject',
			cndMinorProject='$minorProject',
			cndExpertiseInLanguages='$language',
			cndExpertiseInTechnologies='$technology',
			cndAcademicPercentage=$percentage
			"; // validations
            if ($countryTemp != -1) {
                $query2.=",cndCountryTemporary=$countryTemp";
            }
            if ($stateTemp != -1) {
                $query2.=",cndStateTemporary=$stateTemp";
            }
            if ($cityTemp != -1) {
                $query2.=",cndCityTemporary=$cityTemp";
            }
//die($query2);
            if (isset($uploadPath) && !empty($uploadPath)) {
                $query2 .= ",cndResumePath=" . $uploadPath;
            }
            //die;

            $result1 = mysql_query($query1) or die(mysql_error());
            $result2 = mysql_query($query2) or die(mysql_error());
            if ($result1 && $result2) {
                header('location:' . URL . 'guest/index.php?msg=signedup');
            }
        }
    } else {
        $msg = "Sorry! Candidate id already exists";
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {

            var flag = 0;
            var id = $("#txtUserId").val().trim();

            var newpassword = $("#txtNewPassword").val();
            var confirmpassword = $("#txtConfirm").val();
            var sq = $("#ddlSQ").val();
            var sa = $("#txtSA").val();
            var first = $("#txtFirstName").val().trim();
            var dob = $("#txtDob").val().trim();

            var emailOff = $("#txtOffEmail").val().trim();
            var mobilePri = $("#txtPriMobile").val().trim();
            var mobileSec = $("#txtSecMobile").val().trim();
            var streetPer = $("#txtStreet").val().trim();
            var countryPer = $("#ddlCountry").val().trim();

            var statePer = $("#ddlState").val().trim();
            var cityPer = $("#ddlCity").val().trim();

            var pinPer = $("#txtPin").val().trim();

            var batch = $("#txtBatch").val().trim();
            //alert();

            var percentage = $("#txtPercentage").val().trim();

            var college = $("#ddlCollege").val().trim();
            var regulation = $("#ddlRegulation").val().trim();

            if (id == "")
            {
                flag = 1;
                $("#txtUserIdErr").html("Required!");
            }
            if (newpassword == "")
            {
                flag = 1;
                $("#txtNewPasswordErr").html("Required!");
            }
            if (confirmpassword == "")
            {
                flag = 1;
                $("#txtConfirmErr").html("Required!");
            }
            if (newpassword != confirmpassword)
            {
                flag = 1;
                $("#txtConfirmErr").html("Password mismatch!")
            }
            if (first == "")
            {
                flag = 1;
                $("#txtFirstNameErr").html("Required!");
            }
            if (sq == -1)
            {
                flag = 1;
                $("#ddlSQErr").html("Required!");
            }
            if (sa == "")
            {
                flag = 1;
                $("#txtSAErr").html("Required!");
            }

            if (dob == "")
            {
                flag = 1;
                $("#txtDobErr").html("Required!");
            }
            if (emailOff == "")
            {
                flag = 1;
                $("#txtOffEmailErr").html("Required!");
            }
            if (mobilePri == "")
            {
                flag = 1;
                $("#txtPriMobileErr").html("Required!");
            }
            else if (mobilePri.length != 10)
            {
                flag = 1;
                $("#txtPriMobileErr").html("Enter a 10 digit number!");
            }
            if (!(mobileSec.length == 10 || mobileSec.length == 0))
            {
                flag = 1;
                $("#txtSecMobileErr").html("Enter a 10 digit number!");
            }
            if (streetPer == "")
            {
                flag = 1;
                $("#txtStreetErr").html("Required!");
            }
            if (countryPer == -1)
            {
                flag = 1;
                $("#ddlCountryErr").html("Required!");
            }
            if (statePer == -1)
            {
                flag = 1;
                $("#ddlStateErr").html("Required!");
            }
            if (cityPer == -1)
            {
                flag = 1;
                $("#ddlCityErr").html("Required!");
            }
            if (pinPer == "")
            {
                flag = 1;
                $("#txtPinErr").html("Required!");
            }
            if (batch == "")
            {
                flag = 1;
                $("#txtBatchErr").html("Required!");
            }
            if (percentage == "")
            {
                flag = 1;
                $("#txtPercentageErr").html("Required!");
            }
            if (college == -1)
            {
                flag = 1;
                $("#ddlCollegeErr").html("Required!");
            }
            if (regulation == -1)
            {
                flag = 1;
                $("#ddlRegulationErr").html("Required!");
            }
            return parseInt(flag) == 1 ? false : true;
        });
    });

    window.onload = function() {
        new JsDatePick({
            useMode: 2,
            target: "txtDob",
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
            //alert(xmlhttp.responseText);
        }
        xmlhttp.open("GET", "GetStatesByCountryId.php?cid=" + cid, true);
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
        xmlhttp.open("GET", "GetCitiesByStateId.php?sid=" + sid, true);
        xmlhttp.send();
    }


    function GetAllStateByCountryIdTemp(cid)
    {
        GetAllCityByStateIdTemp(-1);
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
                document.getElementById("spnStateTemp").innerHTML = xmlhttp.responseText;
            }
            //alert(xmlhttp.responseText);
        }
        xmlhttp.open("GET", "GetStatesByCountryIdTemp.php?cid=" + cid, true);
        xmlhttp.send();
    }
    function GetAllCityByStateIdTemp(sid)
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
                document.getElementById("spnCityTemp").innerHTML = xmlhttp.responseText;
                //alert(xmlhttp.responseText);
            }
        }
        xmlhttp.open("GET", "GetCitiesByStateIdTemp.php?sid=" + sid, true);
        xmlhttp.send();
    }


    function sameAddress()
    {
        var cbxvalue = document.getElementById("cbxSame").checked;
        //alert(cbxvalue);
        //alert(cbxvalue);
        if (cbxvalue == true)
        {
            document.getElementById("txtStreetTemp").value = document.getElementById("txtStreet").value;
            document.getElementById("txtPinTemp").value = document.getElementById("txtPin").value;
            GetAllStateByCountryIdTemp(document.getElementById("ddlCountry").value);
            GetAllCityByStateIdTemp(document.getElementById("ddlState").value);

            //setTimeInterval(function(){alert("asdf")},500);
            //alert(document.getElementById("ddlCountryTemp").value);
            document.getElementById("ddlCountryTemp").value = document.getElementById("ddlCountry").value;

            //setTimeOut(function(){alert()},500);
            //alert(document.getElementByIdlementById("ddlCountryTemp").value);
            document.getElementById("ddlStateTemp").value = document.getElementById("ddlState").value;

            /*alert(document.getElementById("ddlStateTemp").length);
             for (i = 0; i < document.getElementById("ddlStateTemp").length; i++) {
             if (document.getElementById("ddlStateTemp").options[i].value==document.getElementById("ddlState").value) {
             //						alert(document.getElementById("ddlStateTemp").options[i].selected);
             
             document.getElementById("ddlStateTemp").options[i].selected=true;
             //alert(document.getElementById("ddlStateTemp").options[i].selected);
             break;
             }
             }/**/
            document.getElementById("ddlCityTemp").value = document.getElementById("ddlCity").value;
            return 1;
        }
        else
        {
            document.getElementById("txtStreetTemp").value = "";
            document.getElementById("txtPinTemp").value = "";
            document.getElementById("ddlCountryTemp").value = -1;
            document.getElementById("ddlStateTemp").value = -1;
            document.getElementById("ddlCityTemp").value = -1;
            return 1;
        }
    }
    function isNumberKey(evt)
    {
        /* var charCode = (evt.which)?evt.which:evt.keyCode;
         
         if (charCode<48||charCode>57)
         {
         keyCode=8;
         return false;
         }
         return true; 
         /**/
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key))
        {
            theEvent.returnValue = false;
            if (theEvent.preventDefault)
                theEvent.preventDefault();
        }/**/
    }
</script>
<div class="content">
    <h4 class="pageHeader">Add Candidate</h4>
    <form method="post" enctype="multipart/form-data">
        <div class="content">
            <span class="red_error"> <?php echo isset($msg) ? $msg : ""; ?></span>
            <table>
                <tr>
                    <td><fieldset>
                            <legend>Account Information</legend>
                            <table>
                                <tr>
                                    <td style="width:150px;"><label>Candidate Id</label>
                                        <span class="red_error">*</span></td>
                                    <td><input type="text" name="txtUserId" id="txtUserId" /><span id="txtUserIdErr" class="red_error"></span></td>
                                </tr>
                                <tr>
                                    <td><label>New Password</label>
                                        <span class="red_error">*</span></td>
                                    <td><input type="password" name="txtNewPassword" id="txtNewPassword" /><span id="txtNewPasswordErr" class="red_error"></span></td>
                                </tr>
                                <tr>
                                    <td><label>Confirm Password</label>
                                        <span class="red_error">*</span></td>
                                    <td><input type="password" name="txtConfirm" id="txtConfirm" /><span id="txtConfirmErr" class="red_error"></span></td>
                                </tr>
                                <tr>
                                    <td><label>Security Question</label>
                                        <span class="red_error">*</span></td>
                                    <td><select name="ddlSQ" id="ddlSQ">
                                            <option value="-1">--select--</option>
                                            <?php
                                            $query = "select * from tblusersq";
                                            $result = mysql_query($query);
                                            while ($row = mysql_fetch_assoc($result)) {
                                                ?>
                                                <option value="<?php echo $row['usrSQ'] ?>"><?php echo $row['usrSQ'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select><span id="ddlSQErr" class="red_error"></span></td>
                                </tr>
                                <tr>
                                    <td><label>Security Answer</label>
                                        <span class="red_error">*</span></td>
                                    <td><input type="text" name="txtSA" id="txtSA" /><span id="txtSAErr" class="red_error"></span></td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <table>
                <tr>
                    <td><fieldset>
                            <legend>Candidate's Personal Information</legend>
                            <table>
                                <tr>
                                    <td style="width:150px;"><label>First Name</label>
                                        <span class="red_error">*</span></td>
                                    <td><input type="text" name="txtFirstName" id="txtFirstName" />
                                        <span id="txtFirstNameErr" class="red_error"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Last Name</label></td>
                                    <td><input type="text" name="txtLastName" id="txtLastName" /></td>
                                </tr>
                                <tr>
                                    <td><label>Date of Birth</label>
                                        <span class="red_error">*</span></td>
                                    <td><input type="date" name="txtDob" id="txtDob" />
                                        <span id="txtDobErr" class="red_error"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Gender</label></td>
                                    <td><input type="radio" name="rbtnGender" value="male" checked="checked" />
                                        Male
                                        <input type="radio" name="rbtnGender" value="female" />
                                        Female </td>
                                </tr>
                                <tr>
                                    <td><label>Email(official)</label>
                                        <span class="red_error">*</span></td>
                                    <td><input type="email" name="txtOffEmail" id="txtOffEmail" />
                                        <span id="txtOffEmailErr" class="red_error"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Email(personal)</label></td>
                                    <td><input type="text" name="txtPerEmail" id="txtPerEmail" /></td>
                                </tr>
                                <tr>
                                    <td><label>Mobile(primary)</label>
                                        <span class="red_error">*</span></td>
                                    <td><input onkeypress="return isNumberKey(this.value)" type="text" name="txtPriMobile" id="txtPriMobile" />
                                        <span id="txtPriMobileErr" class="red_error"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Mobile(secondary)</label></td>
                                    <td><input onkeypress="return isNumberKey(this.value)" type="text" name="txtSecMobile" id="txtSecMobile" />
                                        <span id="txtSecMobileErr" class="red_error"></span>
                                    </td>
                                </tr>
                            </table>
                        </fieldset></td>
                </tr>
            </table>
        </div>

        <div class="content">
            <table>
                <tr>
                    <td><fieldset>
                            <legend>Candidate Address Information</legend>
                            <table width="100%">
                                <tr>
                                    <td colspan="6"><b>Permanent Address</b></td>
                                </tr>
                                <tr>
                                    <td><label>Street</label>
                                        <span class="red_error">*</span></td>
                                    <td colspan="5"><input size="68" type="text" name="txtStreet" id="txtStreet" />
                                        <span id="txtStreetErr" class="red_error"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Country<span class="red_error">*</span></td>
                                    <td><select id="ddlCountry" name="ddlCountry" onchange="return GetAllStateByCountryId(this.value)">
                                            <option value="-1">--select--</option>
                                            <?php
                                            $query = "select * from tblgicountry where countryStatus = 1";
                                            $result = mysql_query($query);

                                            while ($row = mysql_fetch_assoc($result)) {
                                                ?>
                                                <option value="<?php echo $row['countryId'] ?>"><?php echo $row['countryName'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                        <span class="red_error" id="ddlCountryErr"></span></td>
                                    <td>

                                        <label>State<span class="red_error">*</span></label></td>
                                    <td>
                                        <span id="spnState">
                                            <select id="ddlState" name="ddlState"  onchange="return GetAllCityByStateId(this.value)">
                                                <option value="-1">--select--</option>
                                            </select>
                                            <span class="red_error" id="ddlStateErr"></span>
                                        </span>
                                    </td>
                                    <td>
                                        <label>City<span class="red_error">*</span></label></td>
                                    <td>
                                        <span id="spnCity">
                                            <select id="ddlCity" name="ddlCity">
                                                <option value="-1">--select--</option>
                                            </select>
                                            <span class="red_error" id="ddlCityErr"></span>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>PIN</label>
                                        <span class="red_error">*</span></td>
                                    <td colspan="2"><input onkeypress="return isNumberKey(this.value)" type="text" name="txtPin" id="txtPin" />
                                        <span id="txtPinErr" class="red_error"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6"><input type="checkbox" onclick="return sameAddress()" id="cbxSame" name="cbxSame" value="1" />
                                        Temporary mailing address is same as Permanent Address<br />
                                        <br /></td>
                                </tr>
                                <tr>
                                    <td colspan="6"><b>Temporary Address</b></td>
                                </tr>
                                <tr>
                                    <td><label>Street</label></td>
                                    <td colspan="5"><input size="68" type="text" name="txtStreetTemp" id="txtStreetTemp" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Country</label></td>
                                    <td><select id="ddlCountryTemp" name="ddlCountryTemp" onchange="GetAllStateByCountryIdTemp(this.value)">

                                            <option value="-1">--select--</option>
                                            <?php
                                            $query = "select * from tblgicountry where countryStatus = 1";
                                            $result = mysql_query($query);

                                            while ($row = mysql_fetch_assoc($result)) {
                                                ?>
                                                <option value="<?php echo $row['countryId'] ?>"><?php echo $row['countryName'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                        <span class="red_error" id="ddlCountryErr"></span></td>
                                    <td><label>State</label></td>
                                    <td>
                                        <span id="spnStateTemp">
                                            <select name="ddlStateTemp">
                                                <option value="-1">--select--</option>
                                            </select>
                                        </span>
                                    </td>
                                    <td><label>City</label></td>
                                    <td>
                                        <span id="spnCityTemp">
                                            <select name="ddlCityTemp">
                                                <option value="-1">--select--</option>
                                            </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>PIN</label></td>
                                    <td colspan="2"><input onkeypress="return isNumberKey(this.value)" type="text" name="txtPinTemp" id="txtPinTemp" /></td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <table>
                <tr>
                    <td><fieldset>
                            <legend>Candidate Academic Information</legend>
                            <table>
                                <tr>
                                    <td><table>
                                            <tr>
                                                <td style="width:150px;"><label>Batch</label>
                                                    <span class="red_error">*</span></td>
                                                <td><input type="text" id="txtBatch" name="txtBatch" />
                                                    <span id="txtBatchErr" class="red_error"></span>
                                                </td>
                                                <td style="width:150px;"><label>Percentage</label>
                                                    <span class="red_error">*</span></td>
                                                <td><input type="text" id="txtPercentage" name="txtPercentage" />
                                                    <span id="txtPercentageErr" class="red_error"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label>College</label>
                                                    <span class="red_error">*</span></td>
                                                <td><select id="ddlCollege" name="ddlCollege">

                                                        <option value="-1">--select--</option>
                                                        <?php
                                                        $query = "select * from tblcollege";
                                                        $result = mysql_query($query);
                                                        while ($row = mysql_fetch_assoc($result)) {
                                                            ?>
                                                            <option  value="<?php echo $row['clgId'] ?>"><?php echo $row['clgShortName'] ?></option>		
                                                        <?php }
                                                        ?>

                                                    </select>
                                                    <span id="ddlCollegeErr" class="red_error"></span>
                                                </td>
                                                <td><label>Regulation/Discipline</label>
                                                    <span class="red_error">*</span></td>
                                                <td><select id="ddlRegulation" name="ddlRegulation">

                                                        <option value="-1">--select--</option>
                                                        <option  value="B.Tech/BE">B.Tech/BE</option>
                                                        <option  value="B.Sc(IT)/CS">B.Sc(IT)/CS</option>
                                                        <option  value="BCA">BCA</option>
                                                        <option  value="MCA/M.Sc/M-Tech">MCA/M.Sc/M-Tech</option>
                                                        <option  value="MBA">MBA</option>
                                                        <option  value="Other">Other</option>

                                                    </select>
                                                    <span id="ddlRegulationErr" class="red_error"></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>
                                            Major Project</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td><textarea rows="4"  cols="107" name="txtMajorProject"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label>Minor Project</label></td>
                                </tr>
                                <tr>
                                    <td><textarea rows="4"  cols="107" name="txtMinorProject"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label>Expertise in Languages</label></td>
                                </tr>
                                <tr>
                                    <td><textarea rows="4"  cols="107" name="txtLanguage"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label>Expertise in Technologies</label></td>
                                </tr>
                                <tr>
                                    <td><textarea rows="4"  cols="107" name="txtTechnologies"></textarea></td>
                                </tr>
                                <tr>
                                    <td><label>Resume:</label>
                                        <input type="file" id="fileResume" name="fileResume" /></td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </div>
        <input type="submit" name="smtSignUp" value="Sign Up" >
        <input type="button" name="btnCancel" value="Cancel" onclick='window.location = "<?php echo URL ?>guest/index.php"'>
    </form>
</div>
<?php
include_once '../../include/footer.php';
?>