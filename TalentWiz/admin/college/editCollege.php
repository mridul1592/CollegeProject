<?php
include_once '../../include/header.php';

if (isset($_POST['smtUpdateCollege'])) {
    $clgName = trim(addslashes($_POST['txtClgName']));
    $clgShortName = trim(addslashes($_POST['txtClgShortName']));
    $street = trim(addslashes($_POST['txtStreet']));
    $country = $_POST['ddlCountry'];
    $state = $_POST['ddlState'];
    $city = $_POST['ddlCity'];
    $pin = trim(addslashes($_POST['txtPIN']));
    $clgPhone = trim(addslashes($_POST['txtClgPhone']));
    $url = trim(addslashes($_POST['txtUrl']));
    $hrName = trim(addslashes($_POST['txtHrName']));
    $hrEmail = trim(addslashes($_POST['txtHrEmail']));
    $hrPhone = trim(addslashes($_POST['txtHrPhone']));
    $tpoName = trim(addslashes($_POST['txtTpoName']));
    $tpoEmail = trim(addslashes($_POST['txtTpoEmail']));
    $tpoPhone = trim(addslashes($_POST['txtTpoPhone']));

    $query = "update tblcollege set
			clgName='$clgName',
			clgShortName='$clgShortName',
			clgStreet='$street',
			clgCountry=$country,
			clgState=$state,
			clgCity=$city,
			clgPIN='$pin',
			clgPhoneNos='$clgPhone',
			clgWebsiteUrl='$url',
			clgHRName='$hrName',
			clgHREmail='$hrEmail',
			clgHRPhoneNos='$hrPhone',
			clgTPOName='$tpoName',
			clgTPOEmail='$tpoEmail',
			clgTPOPhoneNos='$tpoPhone'
			where clgId=" . $_GET['clg'] . "
			";
    //exit;
    $result = mysql_query($query);
    if ($result) {
        header('location:' . URL . 'admin/college/manageCollege.php?msg=updated');
    }
} else if (isset($_GET['clg'])) {
    $qry = "select * from tblcollege where clgId=" . $_GET['clg'];
    $result = mysql_query($qry);
    $retrieve = mysql_fetch_assoc($result);
    //print_r($retrieve);
}
?>
<script>
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
            }
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
            }
        }
        xmlhttp.open("GET", "GetCitiesByStateId.php?sid=" + sid, true);
        xmlhttp.send();
    }

    $(document).ready(function() {
        $(document).submit(function() {
            var clgname;
            var street;
            var country;
            var state;
            var city;
            var pin;
            var clgphoneno;
            var hrname;
            var hrphone;
            var tponame;
            var tpophone;
            var flag = 0;

            clgname = $("#txtClgName").val().trim();
            street = $("#txtStreet").val().trim();
            country = $("#ddlCountry").val();
            state = $("#ddlState").val();
            city = $("#ddlCity").val();
            pin = $("#txtPIN").val().trim();
            clgphoneno = $("#txtClgPhone").val().trim();
            hrname = $("#txtHrName").val().trim();
            hremail = $("#txtHrEmail").val().trim();
            tponame = $("#txtTpoName").val().trim();
            tpoemail = $("#txtTpoEmail").val().trim();
            if (clgname == "")
            {
                flag = 1;
                $("#txtClgNameErr").html("Required!");
            }
            if (street == "")
            {
                flag = 1;
                $("#txtStreetErr").html("Required!");
            }
            if (country == -1)
            {
                flag = 1;
                $("#ddlCountryErr").html("Required!");
            }
            if (state == -1)
            {
                flag = 1;
                $("#ddlStateErr").html("Required!");
            }
            if (city == -1)
            {
                flag = 1;
                $("#ddlCityErr").html("Required!");
            }

            if (pin == "")
            {
                flag = 1;
                $("#txtPINErr").html("Required!");
            }
            if (clgphoneno == "")
            {
                flag = 1;
                $("#txtClgPhoneErr").html("Required!");
            }
            if (hrname == "")
            {
                flag = 1;
                $("#txtHrNameErr").html("Required!");
            }
            if (hremail == "")
            {
                flag = 1;
                $("#txtHrEmailErr").html("Required!");
            }
            if (tponame == "")
            {
                flag = 1;
                $("#txtTpoNameErr").html("Required!");
            }
            if (tpoemail == "")
            {
                flag = 1;
                $("#txtTpoEmailErr").html("Required!");
            }

            return parseInt(flag) == 1 ? false : true;
        });
    });
function clearValidation()
{
	$("#txtClgNameErr").html("");
    $("#txtStreetErr").html("");
    $("#ddlCountryErr").html("");
    $("#ddlStateErr").html("");
    $("#ddlCityErr").html("");
    $("#txtPINErr").html("");
    $("#txtClgPhoneErr").html("");
    $("#txtHrNameErr").html("");
    $("#txtTpoNameErr").html("");
    $("#txtTpoEmailErr").html("");
}
</script>

<div class="content">
    <h4 class="pageHeader">Update College</h4>
    <div class="small_form">
        <fieldset>
            <form method="post">
                <table>
                    <tr>
                        <td width="134"><label>Name<span class="red">*</span></label></td>
                        <td width="145"><input type="text" id="txtClgName" name="txtClgName" value="<?php echo isset($retrieve['clgName']) ? $retrieve['clgName'] : "" ?>" />
                            <span id="txtClgNameErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>Short Name</label></td>
                        <td><input type="text" id="txtClgShortName" name="txtClgShortName" value="<?php echo isset($retrieve['clgShortName']) ? $retrieve['clgShortName'] : "" ?>" />
                            <span id="txtClgNameErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>Street<span class="red">*</span></label></td>
                        <td><input type="text" id="txtStreet" name="txtStreet" value="<?php echo isset($retrieve['clgStreet']) ? $retrieve['clgStreet'] : "" ?>" />
                            <span id="txtStreetErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>Country<span class="red">*</span></label></td>
                        <td><select id="ddlCountry" name="ddlCountry" onchange="return GetAllStateByCountryId(this.value)" >
                                <option value="-1">--select country--</option>
                                <?php
                                $query = "select * from tblgicountry where countryStatus = 1";
                                $result = mysql_query($query);
                                while ($row = mysql_fetch_assoc($result)) {
                                    if (isset($retrieve))
                                        if ($row['countryId'] == $retrieve['clgCountry'])
                                            $selected = 'selected="selected"';
                                        else
                                            $selected = "";
                                    ?>
                                    <option <?php echo isset($selected) ? $selected : "" ?> value="<?php echo $row['countryId'] ?>"><?php echo $row['countryName'] ?></option>
                                <?php }
                                ?>
                            </select>
                            <span class="red_error" id="ddlCountryErr"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>State<span class="red">*</span></td>
                        <td>
                            <span id="spnState">
                                <?php
                                if ((isset($_POST['smtUpdateCollege']) && isset($_POST['ddlCountry']) && $_POST['ddlCountry'] != -1) || isset($_GET['clg'])) {
                                    $query = "select * from tblgistate where countryId=" . $retrieve['clgCountry'] . " and stateStatus=1;";
                                    $result = mysql_query($query);
                                    //print_r($_GET);exit;
                                    ?>

                                    <select id="ddlState" name="ddlState" onchange="GetAllCityByStateId(this.value)">
                                        <option value="-1">--select state--</option>
                                        <?php
                                        while ($row = mysql_fetch_assoc($result)) {
                                            if ($row['stateId'] == $retrieve['clgState'])
                                                $selected = 'selected="selected"';
                                            else
                                                $selected = "";
                                            ?>
                                            <option <?php echo isset($selected) ? $selected : "" ?> value="<?php echo $row['stateId'] ?>"><?php echo $row['stateName'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    <span class="red_error" id="ddlStateErr"></span>
                                </span>
                                <?php
                            }
                            else {
                                ?><select id="ddlState" name="ddlState" onchange="GetAllCityByStateId(this.value)">
                                    <option value="-1">--select state--</option>
                                </select><span class="red_error" id="ddlStateErr"></span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label>City:<span class="red	">*</span></label></td>
                        <td>
                            <span id="spnCity">
                                <?php
                                //echo "asdfasdf";
                                if (isset($retrieve) && isset($retrieve) && $retrieve['clgState'] != -1) {
                                    $query = "select * from tblgicity where stateId=" . $retrieve['clgState'] . " and cityStatus=1;";
                                    $result = mysql_query($query);
                                    //print_r($_GET);exit;
                                    ?>
                                    <select id="ddlCity" name="ddlCity">
                                        <option value="-1">--select city--</option>
                                        <?php
                                        while ($row = mysql_fetch_assoc($result)) {
                                            //echo $_POST['ddlCity'];
                                            //echo $row['cityId'];
                                            //echo $row['cityId']==$_POST['ddlCity'];
                                            if ($row['cityId'] == $retrieve['clgCity'])
                                                $selected = 'selected="selected"';
                                            else
                                                $selected = "";
                                            ?>
                                            <option <?php echo isset($selected) ? $selected : "" ?> value="<?php echo $row['cityId'] ?>"><?php echo $row['cityName'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                    <span class="red_error" id="ddlCityErr"></span>
                                    <?php
                                }
                                else {
                                    ?>
                                    <select id="ddlCity" name="ddlCity">
                                        <option value="-1">--select city--</option>
                                    </select><span class="red_error" id="ddlCityErr"></span>
                                    <?php
                                }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><label>PIN<span class="red">*</span></label></td>
                        <td><input type="text" name="txtPIN" id="txtPIN" value="<?php echo isset($retrieve['clgPIN']) ? $retrieve['clgPIN'] : "" ?>" />
                            <span id="txtPINErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>College Phone no.s<span class="red">*</span></label></td>
                        <td><input type="text" name="txtClgPhone" id="txtClgPhone" value="<?php echo isset($retrieve['clgPhoneNos']) ? $retrieve['clgPhoneNos'] : "" ?>" />
                            <span id="txtClgPhoneErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>Website</label></td>
                        <td><input type="text" name="txtUrl" id="txtUrl" value="<?php echo isset($retrieve['clgWebsiteUrl']) ? $retrieve['clgWebsiteUrl'] : "" ?>" /></td>
                    </tr>
                    <tr>
                        <td><label>HR Name<span class="red">*</span></label></td>
                        <td><input type="text" name="txtHrName" id="txtHrName" value="<?php echo isset($retrieve['clgHRName']) ? $retrieve['clgHRName'] : "" ?>" />
                            <span id="txtHrNameErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>HR email<span class="red">*</span></label></td>
                        <td><input type="email" name="txtHrEmail" id="txtHrEmail" value="<?php echo isset($retrieve['clgHREmail']) ? $retrieve['clgHREmail'] : "" ?>" />
                            <span id="txtHrEmailErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>HR phone no.s</label></td>
                        <td><input type="text" name="txtHrPhone" id="txtHrPhone" value="<?php echo isset($retrieve['clgHRPhoneNos']) ? $retrieve['clgHRPhoneNos'] : "" ?>" /></td>
                    </tr>
                    <tr>
                        <td><label>TPO Name<span class="red">*</span></label></td>
                        <td><input type="text" name="txtTpoName" id="txtTpoName" value="<?php echo isset($retrieve['clgTPOName']) ? $retrieve['clgTPOName'] : "" ?>" />
                            <span id="txtTpoNameErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>TPO email<span class="red">*</span></label></td>
                        <td><input type="email" name="txtTpoEmail" id="txtTpoEmail" value="<?php echo isset($retrieve['clgTPOEmail']) ? $retrieve['clgTPOEmail'] : "" ?>" />
                            <span id="txtTpoEmailErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td><label>TPO phone no.s</label></td>
                        <td><input type="text" name="txtTpoPhone" id="txtTpoPhone" value="<?php echo isset($retrieve['clgTPOPhoneNos']) ? $retrieve['clgTPOPhoneNos'] : "" ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                            <input type="submit" name="smtUpdateCollege" value="Update College"/>
                            <input type="reset" onclick=" return clearValidation()"/>
                            <input type="button" onclick="window.location = '<?php echo URL ?>admin/college/manageCollege.php'" value="Cancel"/></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>
