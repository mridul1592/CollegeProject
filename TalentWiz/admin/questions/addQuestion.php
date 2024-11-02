<?php
include_once '../../include/header.php';

if (isset($_POST['smtSave'])) {
    $question = trim(addslashes($_POST['txtQuestion']));

    $query = "select * from tblquestion where qusTitle='$question'";
    $result = mysql_query($query);
    $repeat = mysql_num_rows($result);
    if (!$repeat) {
        $query = "insert into tblquestion set
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
        //echo $query;
        $result = mysql_query($query) or die(mysql_error());
        $lastqusid = mysql_insert_id();

        if (isset($_FILES['flQuestion']["name"]) && !empty($_FILES['flQuestion']["name"])) {
            $allowedExtentions = array("gif", "jpg", "png", "pdf");
            $imageName = (explode(".", $_FILES["flQuestion"]["name"]));
            $extention = end($imageName);

            if (($_FILES["flQuestion"]["size"]) && in_array($extention, $allowedExtentions)) {

                $uploadPath = "../../documents/qusImages/" . $_GET['qusid'] . "." . $extention;
                move_uploaded_file($_FILES["flQuestion"]["tmp_name"], $uploadPath);

                $uploadPath = "documents/qusImages/" . $_GET['qusid'] . "." . $extention;
                echo $query = "update tblquestion set qusImagePath='" . $uploadPath . "' where qusId=" . $lastqusid;
                $result = mysql_query($query) or die(mysql_error());
            }
        }

        if ($result) {
            header('location:manageQuestions.php?msg=added');
        }
    } else {
        $errMsg = "Question already exists!";
    }
}
?>
<script>
    $(document).ready(function() {
        $(document).submit(function() {

            var flag = 0;

            var question = ($("#txtQuestion").val().trim());
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
                var option1 = ($("#txtOption1").val().trim());
                var option2 = ($("#txtOption2").val().trim());
                var option3 = ($("#txtOption3").val().trim());
                var option4 = ($("#txtOption4").val().trim());

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

    <h3 class="pageHeader">Add Question</h3>
    <span class="red"><?php echo isset($errMsg) ? $errMsg : "" ?></span>
    <div class="big_form">
        <fieldset>
            <form method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td align="left" colspan="2">Question<span id="txtQuestionErr" class="red">*</span></td></tr>
                    <tr>
                        <td colspan="2">
                            <input type="text" id="txtQuestion" name="txtQuestion" style="width:100%" /></td>
                    </tr>
                    <tr>
                        <td>Image(if any)</td>
                        <td><input type="file" id="flQuestion" name="flQuestion" /></td>
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
                                    <option value="<?php echo $row['catId'] ?>"><?php echo $row['catTitle'] ?></option>
                                    <?php
                                }
                                ?>
                            </select><span id="ddlRootCategoryErr" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Sub-Category<span class="red">*</span></td>
                        <td>
                            <span id="spnSubCat"><select id="ddlSubCategory" name="ddlSubCategory"><option value="-1">--select--</option></select></span>
                            <span id="ddlSubCategoryErr" class="red"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Question Level<span class="red">*</span></td>
                        <td>
                            <select id="ddlQuestionLevel" name="ddlQuestionLevel">
                                <option value="-1">--select--</option>
                                <option value="easy">Easy</option>
                                <option value="difficult">Difficult</option>
                            </select><span class="red" id="ddlQuestionLevel Err"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Question type<span class="red">*</span></td>
                        <td>
                            <select id="ddlQuestionType" name="ddlQuestionType" onchange="return getAnswerOptions(this.value)">
                                <option value="-1">--select--</option>
                                <option value="tf">True/False</option>
                                <option value="obj">Objective type</option>
                            </select><span class="red" id="ddlQuestionTypeErr"></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span id="spnAnswers">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><input type="radio" checked="checked" name="rbtnStatus" value="1" />Active<input type="radio" name="rbtnStatus" />Inactive</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />

                            <input type="submit" name="smtSave" value="Save Question" />
                            <input type="button" value="Cancel" onclick="window.location = 'manageQuestions.php'" />
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
</div>
<?php
include_once '../../include/footer.php';
?>