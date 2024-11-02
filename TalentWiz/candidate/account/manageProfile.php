<?php
include_once '../../include/header.php';

if (isset($_SESSION['userid'])) {
    $query = "select * from tbluser a left outer join tblcandidate b on a.usrId=b.cndId where a.usrId='" . $_SESSION['userid'] . "'";
    $resultDetails = mysql_query($query);
    $details = mysql_fetch_assoc($resultDetails);

    if (isset($_POST['smtUpdateProfile'])) {
        $blnCheckForFile = true;

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
				deleteExistingFile($_SESSION['userid']);
                $uploadPath = PATH."documents/resumes/" . $_SESSION['userid'] . "." . $extention;
                move_uploaded_file($_FILES["fileResume"]["tmp_name"], $uploadPath);
                
                $uploadPath = "documents/resumes/" . $_SESSION['userid'] . "." . $extention;
                $query = "update tblcandidate set cndResumePath='$uploadPath' where cndId='" . $_SESSION['userid'] . "'";
                $result = mysql_query($query) or die(mysql_error());
            } else {
                $msg = "Select valid resume file.";
                $blnCheckForFile = false;
            }
        }
		

        ///////////////////////
        ///////////////////////
        if ($blnCheckForFile == true) {
            $query1 = "update tbluser set
			usrSQ='$sq',
			usrSA='$sa'
			where usrId='" . $_SESSION['userid'] . "'
			";
            $query2 = "update tblcandidate set
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
			";
            if ($countryTemp != -1) {
                $query2.=",cndCountryTemporary=$countryTemp";
            }
            if ($stateTemp != -1) {
                $query2.=",cndStateTemporary=$stateTemp";
            }
            if ($cityTemp != -1) {
                $query2.=",cndCityTemporary=$cityTemp";
            }
            /* if (isset($uploadPath) && !empty($uploadPath)) {
              $query2 .= ",cndResumePath=" . $uploadPath;
              } */

            $query2.=" where cndId='" . $_SESSION['userid'] . "'";

            $result1 = mysql_query($query1) or die(mysql_error());
            $result2 = mysql_query($query2) or die(mysql_error());

            if ($result1 && $result2) {
                header('location:' . URL . 'candidate/index.php?msg=profileUpdated');
            }
        }
    }
}
function deleteExistingFile($id)
{
	echo $path=PATH."documents/resumes/";
	echo $dir= opendir($path);
	while($file=  readdir($dir))
	{
		$fileArray=  explode(".", $file);
		array_pop($fileArray);
		$fileName=  implode(".", $fileArray);
		if($id==$fileName)
		{
		unlink($path.$file);
		}
	}
}
?>
<script>
    /* $(function()
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
     });/**/
    $(document).ready(function() {
        $(document).submit(function() {

            var flag = 0;


            var sq = $("#ddlSQ").val();
            var sa = $("#txtSA").val().trim();
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

            var percentage = $("#txtPercentage").val().trim();
            var college = $("#ddlCollege").val().trim();
            var regulation = $("#ddlRegulation").val().trim();



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
            if (first == "")
            {
                flag = 1;
                $("#txtFirstNameErr").html("Required!");
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
</script>
<script>
    $(function()
     {
     $("#wizard").steps({
     headerTag: "h2",
     bodyTag: "section",
     transitionEffect: "slideLeft"
     });
     });/**/
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
                //GetAllCityByStateId(objState.value);
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
    <h4 class="pageHeader">Profile</h4>
    <span class="red_error"> <?php echo isset($msg) ? $msg : ""; ?></span>
    <form id="wizard" method="post" enctype="multipart/form-data">
        <h2>Account Information</h2>
        <section class="content">
            <table>
                <tr>
                    <td>
                        <fieldset>
                            <legend>Account Information</legend>
                            <table>
                                <tr>
                                    <td style="width:150px;"><label>Candidate Id</label>
                                        <span class="red">*</span></td>
                                    <td><input type="text" id="txtUserId" name="txtUserId" readonly="readonly" value="<?php echo $details['usrId'] ?>" />
                                        <span id="txtUserIdErr" class="red"></span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Security Question</label>
                                        <span class="red">*</span>
                                    </td>
                                    <td>
                                        <select name="ddlSQ" id="ddlSQ">
                                            <option value="-1">--select--</option>
                                            <?php
                                            $query = "select * from tblusersq";
                                            $result = mysql_query($query);
                                            while ($row = mysql_fetch_assoc($result)) {
                                                ?>
                                                <option value="<?php echo $row['usrSQ'] ?>" <?php echo $row['usrSQ'] == $details['usrSQ'] ? "selected='selected'" : "" ?>><?php echo $row['usrSQ'] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <span id="ddlSQErr" class="red"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Security Answer</label>
                                        <span class="red">*</span>
                                    </td>
                                    <td><input type="text" name="txtSA" id="txtSA" value="<?php echo $details['usrSA'] ?>" />
                                        <span id="txtSAErr" class="red"></span>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>          
                <tr>
                    <td>
                        <fieldset>
                            <legend>Personal information</legend>
                            <table>
                                <tr>
                                    <td style="width:150px;">
                                        <label>First Name</label>
                                        <span class="red">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="txtFirstName" id="txtFirstName" value="<?php echo $details['cndFirstName'] ?>" /><span class="red" id="txtFirstNameErr"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Last Name</label></td>
                                    <td><input type="text" name="txtLastName" id="txtLastName" value="<?php echo $details['cndLastName'] ?>" /></td>
                                </tr>
                                <tr>
                                    <td><label>Date of Birth</label>
                                        <span class="red">*</span></td>
                                    <td><input type="text" name="txtDob" id="txtDob" value="<?php echo $details['cndDOB'] ?>" />
                                        <span id="txtDobErr" class="red"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Gender</label></td>
                                    <td><input type="radio" name="rbtnGender" value="male" checked="checked" <?php echo $details['cndGender'] == "male" ? "checked='checked'" : "" ?> />
                                        Male
                                        <input type="radio" name="rbtnGender" value="female" <?php echo $details['cndGender'] == "female" ? "checked='checked'" : "" ?> />
                                        Female </td>
                                </tr>
                                <tr>
                                    <td><label>Email(official)</label>
                                        <span class="red">*</span></td>
                                    <td><input type="email" name="txtOffEmail" id="txtOffEmail" value="<?php echo $details['cndEmailOfficial'] ?>" /><span id="txtOffEmailErr" class="red"></span></td>
                                </tr>
                                <tr>
                                    <td><label>Email(personal)</label></td>
                                    <td><input type="text" name="txtPerEmail" id="txtPerEmail" value="<?php echo $details['cndEmailPersonal'] ?>" /></td>
                                </tr>
                                <tr>
                                    <td><label>Mobile(primary)</label>
                                        <span class="red">*</span></td>
                                    <td><input onkeypress="return isNumberKey(this.value);" type="text" name="txtPriMobile" id="txtPriMobile" value="<?php echo $details['cndMobilePrimary'] ?>" /><span id="txtPriMobileErr" class="red"></span></td>
                                </tr>
                                <tr>
                                    <td><label>Mobile(secondary)</label></td>
                                    <td><input onkeypress="return isNumberKey(this.value);" type="text" name="txtSecMobile" id="txtSecMobile" value="<?php echo $details['cndMobileSecondary'] ?>" /><span id="txtSecMobileErr" class="red"></span></td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </section>
        <h2>Address Information</h2>
        <section class="content">
            <fieldset>
                <legend>Address information</legend>
                <table>
                    <tr>
                        <td colspan="6"><b>Permanent Address</b></td>
                    </tr>
                    <tr>
                        <td><label>Street</label>
                            <span class="red">*</span></td>
                        <td colspan="5"><input size="68" type="text" name="txtStreet" id="txtStreet" value="<?php echo $details['cndStreetPermanent'] ?>" /><span class="red" id="txtStreetErr"></span></td>
                    </tr>
                    <tr>
                        <td>Country:</td>
                        <td><select id="ddlCountry" name="ddlCountry" onchange="return GetAllStateByCountryId(this.value)">
                                <option value="-1">--select country--</option>
                                <?php
                                $query = "select * from tblgicountry where countryStatus = 1";
                                $result = mysql_query($query);

                                while ($row = mysql_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $row['countryId'] ?>" <?php echo $details['cndCountryPermanent'] == $row['countryId'] ? "selected='selected'" : "" ?>><?php echo $row['countryName'] ?></option>
                                <?php }
                                ?>
                            </select>
                            <span class="red_error" id="ddlCountryErr"></span></td>
                        <td>
                            <span id="spnState">

                                <label>State:</label>
                                <select id="ddlState" name="ddlState"  onchange="return GetAllCityByStateId(this.value)">
                                    <option value="-1">--select state--</option>
                                    <?php
                                    $query = "select * from tblgistate where stateStatus=1";
                                    if (!empty($details['cndCountryPermanent'])) {
                                        $query .= " and countryId=" . $details['cndCountryPermanent'];
                                    }
                                    $result = mysql_query($query);
                                    while ($row = mysql_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['stateId'] ?>" <?php echo $details['cndStatePermanent'] == $row['stateId'] ? "selected='selected'" : "" ?>><?php echo $row['stateName'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <span class="red_error" id="ddlStateErr"></span> </span></td>
                        <td>
                            <span id="spnCity">

                                <label class=" ">City:</label>
                                <select id="ddlCity" name="ddlCity">
                                    <option value="-1">--select city--</option>
                                    <?php
                                    $query = "select * from tblgicity where cityStatus=1";
                                    if (!empty($details['cndStatePermanent'])) {
                                        $query .= " and stateId=" . $details['cndStatePermanent'];
                                    }
                                    $result = mysql_query($query);
                                    while ($row = mysql_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['cityId'] ?>" <?php echo $details['cndCityPermanent'] == $row['cityId'] ? "selected='selected'" : "" ?>><?php echo $row['cityName'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <span class="red_error" id="ddlCityErr"></span>
                            </span>
                        </td>

                    </tr>

                    <tr>
                        <td><label>PIN</label>
                            <span class="red">*</span></td>
                        <td><input type="text" onkeypress="return isNumberKey(this.value)" name="txtPin" id="txtPin" value="<?php echo $details['cndPinPermanent'] ?>" />
                            <span class="red" id="txtPinErr">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"><br /><input type="checkbox" onclick="return sameAddress()" id="cbxSame" name="cbxSame" value="1" />Temporary mailing address is same as Permanent Address<br />
                            <br /></td>
                    </tr>
                    <tr>
                        <td colspan="6" class="bold">Temporary Address</td>
                    </tr>
                    <tr>
                        <td><label>Street</label></td>
                        <td colspan="5"><input size="68" type="text" name="txtStreetTemp" id="txtStreetTemp" value="<?php echo $details['cndStreetTemporary'] ?>" /></td>
                    </tr>
                    <tr>
                        <td>Country:</td>
                        <td><select id="ddlCountryTemp" name="ddlCountryTemp" onchange="return GetAllStateByCountryIdTemp(this.value)">
                                <option value="-1">--select country--</option>
                                <?php
                                $query = "select * from tblgicountry where countryStatus = 1";
                                $result = mysql_query($query);
                                while ($row = mysql_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?php echo $row['countryId'] ?>" <?php echo $details['cndCountryTemporary'] == $row['countryId'] ? "selected='selected'" : "" ?>><?php echo $row['countryName'] ?></option>
                                <?php }
                                ?>
                            </select>
                            <span class="red_error" id="ddlCountryErr"></span></td>
                        <td>
                            <span id="spnStateTemp">
                                <label class=" ">State:</label>
                                <select id="ddlStateTemp" name="ddlStateTemp"  onchange="return GetAllCityByStateIdTemp(this.value)">
                                    <option value="-1">--select state--</option>
                                    <?php
                                    $query = "select * from tblgistate where stateStatus=1";
                                    if (!empty($details['cndCountryTemporary'])) {
                                        $query .= " and countryId=" . $details['cndCountryTemporary'];
                                    }
                                    $result = mysql_query($query);
                                    while ($row = mysql_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['stateId'] ?>" <?php echo $details['cndStateTemporary'] == $row['stateId'] ? "selected='selected'" : "" ?>><?php echo $row['stateName'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <span class="red_error" id="ddlStateErr"></span> </span></td>
                        <td>
                            <span id="spnCityTemp">

                                <label class=" ">City:</label>
                                <select id="ddlCityTemp" name="ddlCityTemp">
                                    <option value="-1">--select city--</option>
                                    <?php
                                    $query = "select * from tblgicity where cityStatus=1";
                                    if (!empty($details['cndStateTemporary'])) {
                                        $query .= " and stateId=" . $details['cndStateTemporary'];
                                    }
                                    $result = mysql_query($query);
                                    while ($row = mysql_fetch_assoc($result)) {
                                        ?>
                                        <option value="<?php echo $row['cityId'] ?>" <?php echo $details['cndCityTemporary'] == $row['cityId'] ? "selected='selected'" : "" ?>><?php echo $row['cityName'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                                <span class="red_error" id="ddlCityErr"></span>
                            </span>
                        </td>

                    <tr>
                        <td><label>PIN</label></td>
                        <td><input type="text" onkeypress="return isNumberKey(this.value)" name="txtPinTemp" id="txtPinTemp" value="<?php echo $details['cndPinTemporary'] ?>" /></td>
                    </tr>
                </table>
            </fieldset>	
        </section>
        <h2>Academic Information</h2>
        <section class="content">
            <fieldset>
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td style="width:150px;"><label>Batch</label>
                                        <span class="red">*</span></td>
                                    <td><input type="text" id="txtBatch" name="txtBatch" value="<?php echo $details['cndBatch'] ?>" />
                                        <span id="txtBatchErr" class="red"></span>
                                    </td>
                                    <td style="width:150px;"><label>Percentage</label>
                                        <span class="red">*</span></td>
                                    <td><input type="text" id="txtPercentage" name="txtPercentage" value="<?php echo $details['cndAcademicPercentage'] ?>" />
                                        <span id="txtPercentageErr" class="red"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>College</label>
                                        <span class="red">*</span></td>
                                    <td><select name="ddlCollege" id="ddlCollege">
                                            <option value="-1">--select--</option>
                                            <?php
                                            $query = "select * from tblcollege";
                                            $result = mysql_query($query);
                                            while ($row = mysql_fetch_assoc($result)) {
                                                ?>
                                                <option <?php echo $row['clgId'] == $details['cndCollege'] ? "selected='selected'" : "" ?> value="<?php echo $row['clgId'] ?>"><?php echo $row['clgShortName'] ?></option>		
                                            <?php }
                                            ?>
                                        </select>
                                        <span id="ddlCollegeErr" class="red"></span>
                                    </td>
                                    <td><label>Regulation/Discipline</label>
                                        <span class="red">*</span></td>
                                    <td><select id="ddlRegulation" name="ddlRegulation">
                                            <option value="-1">--select--</option>
                                            <option <?php echo "B.Tech/BE" == $details['cndRegDisId'] ? "selected='selected'" : "" ?> value="B.Tech/BE">B.Tech/BE</option>
                                            <option <?php echo "B.Sc(IT)/CS" == $details['cndRegDisId'] ? "selected='selected'" : "" ?> value="B.Sc(IT)/CS">B.Sc(IT)/CS</option>
                                            <option <?php echo "BCA" == $details['cndRegDisId'] ? "selected='selected'" : "" ?> value="BCA">BCA</option>
                                            <option <?php echo "MCA/M.Sc/M-Tech" == $details['cndRegDisId'] ? "selected='selected'" : "" ?> value="MCA/M.Sc/M-Tech">MCA/M.Sc/M-Tech</option>
                                            <option <?php echo "MBA" == $details['cndRegDisId'] ? "selected='selected'" : "" ?> value="MBA">MBA</option>
                                            <option <?php echo "Other" == $details['cndRegDisId'] ? "selected='selected'" : "" ?> value="Other">Other</option>
                                        </select>
                                        <span id="ddlRegulationErr" class="red"></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Major Project</label></td>
                    </tr>
                    <tr>
                        <td><textarea rows="4"    cols="107" id="txtMajorProject" name="txtMajorProject"> <?php echo $details['cndMajorProject'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Minor Project</label></td>
                    </tr>
                    <tr>
                        <td><textarea rows="4"     cols="107" id="txtMinorProject" name="txtMinorProject"><?php echo $details['cndMinorProject'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Expertise in Languages</label></td>
                    </tr>
                    <tr>
                        <td><textarea rows="4"     cols="107" id="txtLanguage" name="txtLanguage"><?php echo $details['cndExpertiseInLanguages'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Expertise in Technologies</label></td>
                    </tr>
                    <tr>
                        <td><textarea rows="4"     cols="107" id="txtTechnologies" name="txtTechnologies"><?php echo $details['cndExpertiseInTechnologies'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Resume:</label>
                            <input type="file" id="fileResume" name="fileResume" <?php echo $details['cndResumePath'] ?>/></td>
                    </tr>
                    <tr>
                        <td><br>

                            <input type="submit" name="smtUpdateProfile" value="Update">
                            <input type="button" value="Cancel" onClick="window.location = '<?php echo URL ?>candidate/index.php'">
                        </td>
                    </tr>
                </table>
            </fieldset>
        </section>
    </form>
</div>
<?php
include_once '../../include/footer.php';
?>