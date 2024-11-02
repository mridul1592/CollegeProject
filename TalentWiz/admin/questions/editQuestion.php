<?php
include_once '../../include/header.php';

//print_r($_FILES);
//print_r($_POST);
if (isset($_GET['qusid']) && !empty($_GET['qusid'])) {
    $query = "select a.*,b.catTitle as subcategoryName,b.catId as subcategoryId,b.rootName,b.rootId from tblquestion a left outer join (select c.*,d.catTitle as rootName,d.catId as rootId from tblcategory c left outer join tblcategory d on c.catParentId=d.catId) b on a.qusCategory=b.catId where qusId=" . $_GET['qusid'];
    $result = mysql_query($query);
    $rowfetch = mysql_fetch_assoc($result);
    echo "<pre>";
    //print_r($rowfetch);
    echo "</pre>";
}
if (isset($_POST['smtUpdate'])) {
    $question = trim(addslashes($_POST['txtQuestion']));

    $query = "update tblquestion set
                qusTitle='$question',
                qusCategory=" . $_POST['ddlSubCategory'] . ",
                qusIQLevel='" . $_POST['ddlQuestionLevel'] . "',
                qusType='" . $_POST['ddlQuestionType'] . "',
                qusCorrectAns=" . $_POST['corrAnswer'] . ",
                qusStatus=" . $_POST['rbtnStatus'] . "
                ";
    if (isset($_POST['ddlQuestionType']) && $_POST['ddlQuestionType'] == "obj") {
        $option1 = trim(addslashes($_POST['txtOption1']));
        $option2 = trim(addslashes($_POST['txtOption2']));
        $option3 = trim(addslashes($_POST['txtOption3']));
        $option4 = trim(addslashes($_POST['txtOption4']));

        $query .= ", qusOption1='$option1',
                    qusOption2='$option2',
                    qusOption3='$option3',
                    qusOption4='$option4'
                ";
    }
    ////////////////////////
    if (isset($_FILES['flQuestion']["name"]) && !empty($_FILES['flQuestion']["name"])) {

        $allowedExtentions = array("gif", "jpg", "png", "pdf");
        $imageName = (explode(".", $_FILES["flQuestion"]["name"]));
		$firstName=$imageName[0];
		
        $extention = end($imageName);

        if (($_FILES["flQuestion"]["size"]) && in_array($extention, $allowedExtentions)) {

			deleteExistingFile($_GET['qusid']);
            $uploadPath = PATH . "documents/qusImages/" . $_GET['qusid'] . "." . $extention;
            move_uploaded_file($_FILES["flQuestion"]["tmp_name"], $uploadPath);

            $uploadPath = "documents/qusImages/" . $_GET['qusid'] . "." . $extention;
            $query .= ",qusImagePath='$uploadPath'";
        }
    }

    $query .= " where qusId=" . $_GET['qusid'];
    $result = mysql_query($query) or die(mysql_error());
    if ($result) {
        header('location:manageQuestions.php?msg=edited');
    }
}
function deleteExistingFile($id)
{
	echo $path=PATH."documents/qusImages/";
echo 	$dir= opendir($path);
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
    $(document).ready(function() {
        $(document).submit(function() {
            var flag = 0;

            var question = String.trim($("#txtQuestion").val());
            var qtype = $("#ddlQuestionType").val();
            var rootcat = $("#ddlRootCategory").val();
            var subcat = $("#ddlSubCategory").val();
            var qlevel = $("#ddlQuestionLevel").val();

            if (rootcat == -1)
            {
                flag = 1;
                $("#ddlRootCategoryErr").html("Required!");
            }
            if (subcat == -1)
            {
                flag = 1;
                $("#ddlSubCategoryErr").html("Required!");
            }
            if (qlevel == -1)
            {
                flag = 1;
                $("#ddlQuestionLevelErr").html("Required!");
            }
            if (question == "")
            {
                flag = 1;
                $("#txtQuestionErr").html("*Required!");
            }

            if (qtype == -1)
            {
                flag = 1;
                $("#ddlQuestionTypeErr").html("Required!");
            }
            else if (qtype == "obj")
            {
                var option1 = String.trim($("#txtOption1").val());
                var option2 = String.trim($("#txtOption2").val());
                var option3 = String.trim($("#txtOption3").val());
                var option4 = String.trim($("#txtOption4").val());

                if (option1 == "")
                {
                    flag = 1;
                    $("#txtOption1Err").html("Required!");
                }
                if (option2 == "")
                {
                    flag = 1;
                    $("#txtOption2Err").html("Required!");
                }
                if (option3 == "")
                {
                    flag = 1;
                    $("#txtOption3Err").html("Required!");
                }
                if (option4 == "")
                {
                    flag = 1;
                    $("#txtOption4Err").html("Required!");
                }
            }
            return parseInt(flag) == 1 ? false : true;
        });
    });
    function getSubCategory(cat)
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
                document.getElementById("spnSubCat").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "getSubCategory.php?cat=" + cat, true);
        xmlhttp.send();
    }
    function getAnswerOptions(qtype)
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
                document.getElementById("spnAnswers").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "getAnswers.php?qtype=" + qtype, true);
        xmlhttp.send();
    }
</script>

<div id="addQuestion" class="content">
    <h3 class="pageHeader">Edit Question</h3>
    <div class="big_form">
        <fieldset>
            <form method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td align="left" colspan="2">Question<span id="txtQuestionErr" class="red">*</span></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="text" id="txtQuestion" name="txtQuestion" value="<?php echo $rowfetch['qusTitle'] ?>" style="width:100%" /></td>
                    </tr>
                    <tr>
                        <td>Image(if any)</td>
                        <td><input type="file" name="flQuestion" value="<?php echo $rowfetch['qusImagePath'] ?>" /></td>
                    </tr>
                    <tr>
                        <td width="43%">Root Category<span class="red">*</span></td>
                        <td><select id="ddlRootCategory" name="ddlRootCategory" onchange="return getSubCategory(this.value)">
                                <option value="-1">--select--</option>
                                <?php
                                $query = "select * from tblcategory where catParentId is NULL";
                                $result = mysql_query($query);
                                while ($row = mysql_fetch_assoc($result)) {
                                    ?>
                                    <option <?php echo $row['catId'] == $rowfetch['rootId'] ? "selected='selected'" : "" ?> value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span id="ddlRootCategoryErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Sub-Category<span class="red">*</span></td>
                        <td><span id="spnSubCat">
                                <select id="ddlSubCategory" name="ddlSubCategory">
                                    <option value="-1">--select--</option>
                                    <?php
                                    $query = "select * from tblcategory where catParentId=" . $rowfetch['rootId'];
                                    $result = mysql_query($query);
                                    while ($row = mysql_fetch_assoc($result)) {
                                        ?>
                                        <option <?php echo $row['catId'] == $rowfetch['subcategoryId'] ? "selected='selected'" : "" ?> value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </span> <span id="ddlSubCategoryErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Question Level<span class="red">*</span></td>
                        <td><select id="ddlQuestionLevel" name="ddlQuestionLevel">
                                <option value="-1">--select--</option>
                                <option value="easy" <?php echo $rowfetch['qusIQLevel'] == "easy" ? "selected='selected'" : "" ?>>Easy</option>
                                <option value="difficult" <?php echo $rowfetch['qusIQLevel'] == "difficult" ? "selected='selected'" : "" ?>>Difficult</option>
                            </select>
                            <span class="red" id="ddlQuestionLevel Err"></span></td>
                    </tr>
                    <tr>
                        <td>Question type<span class="red">*</span></td>
                        <td><select id="ddlQuestionType" name="ddlQuestionType" onchange="return getAnswerOptions(this.value)">
                                <option value="-1">--select--</option>
                                <option <?php echo $rowfetch['qusType'] == "tf" ? "selected='selected'" : "" ?> value="tf">True/False</option>
                                <option <?php echo $rowfetch['qusType'] == "obj" ? "selected='selected'" : "" ?> value="obj">Objective type</option>
                            </select>
                            <span class="red" id="ddlQuestionTypeErr"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2"><span id="spnAnswers">
                                <?php
                                if ($rowfetch['qusType'] == "tf") {
                                    ?>
                                    <fieldset class="small_form">
                                        <legend>Correct Answer</legend>
                                        <div id="tf">
                                            <table>
                                                <tr>
                                                    <td>Answer<span class="red">*</span></td>
                                                    <td><input checked="checked" type="radio" value="1" name="corrAnswer" <?php echo $rowfetch['qusCorrectAns'] == 1 ? "checked='checked'" : "" ?> />
                                                        True
                                                        <input type="radio" value="0" name="corrAnswer" <?php echo $rowfetch['qusCorrectAns'] == 2 ? "checked='checked'" : "" ?>>
                                                        False</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <?php
                                } elseif ($rowfetch['qusType'] == "obj") {
                                    ?>
                                    <fieldset>
                                        <legend>Correct Answer</legend>
                                        <div id="obj">
                                            <table>
                                                <tr>
                                                    <td>Option 1<span class="red">*</span></td>
                                                    <td><input value="<?php echo isset($rowfetch['qusOption1']) ? $rowfetch['qusOption1'] : "" ?>" type="text" id="txtOption1" name="txtOption1">
                                                        <span id="txtOption1Err" class="red"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Option 2<span class="red">*</span></td>
                                                    <td><input value="<?php echo isset($rowfetch['qusOption2']) ? $rowfetch['qusOption2'] : "" ?>" type="text" id="txtOption2" name="txtOption2">
                                                        <span id="txtOption2Err" class="red"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Option 3<span class="red">*</span></td>
                                                    <td><input value="<?php echo isset($rowfetch['qusOption3']) ? $rowfetch['qusOption3'] : "" ?>" type="text" id="txtOption3" name="txtOption3">
                                                        <span id="txtOption3Err" class="red"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Option 4<span class="red">*</span></td>
                                                    <td><input value="<?php echo isset($rowfetch['qusOption4']) ? $rowfetch['qusOption4'] : "" ?>" type="text" id="txtOption4" name="txtOption4">
                                                        <span id="txtOption4Err" class="red"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>Correct Option<span class="red">*</span></td>
                                                    <td><input <?php echo $rowfetch['qusCorrectAns'] == 1 ? "checked='checked'" : "" ?> checked="checked" type="radio" value="1" name="corrAnswer">
                                                        1
                                                        <input <?php echo $rowfetch['qusCorrectAns'] == 2 ? "checked='checked'" : "" ?> type="radio" value="2" name="corrAnswer">
                                                        2
                                                        <input <?php echo $rowfetch['qusCorrectAns'] == 3 ? "checked='checked'" : "" ?> type="radio" value="3" name="corrAnswer">
                                                        3
                                                        <input <?php echo $rowfetch['qusCorrectAns'] == 4 ? "checked='checked'" : "" ?> type="radio" value="4" name="corrAnswer">
                                                        4 </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </fieldset>
                                    <?php
                                }
                                ?>
                            </span></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><input type="radio" checked="checked" name="rbtnStatus" value="1" />
                            Active
                            <input type="radio" name="rbtnStatus" />
                            Inactive</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                            <input type="submit" name="smtUpdate" value="Save Question" />
                            <input type="button" value="Cancel" onclick="window.location = 'manageQuestions.php'" /></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>