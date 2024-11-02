<?php
include_once '../../include/settings.php';
include_once '../checksession.php';

$query = "select a.*,b.jobTestId,b.jobTestOn,b.jobTestCorrectAns,b.jobTestWrongAns,b.jobTestTotalQuestions,b.jobIsSelected from tbljobopening a join tbljobtest b on a.jobId=b.jobId where b.jobTestId=" . $_GET['jobtestid'];
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$query = "select a.*,b.catTitle,b.catParentId from tbljobcategory a left outer join tblcategory b on a.catId=b.catId where a.jobId=" . $row['jobId'];
$resultCategory = mysql_query($query) or die(mysql_error());
$resultSubCategory = mysql_query($query) or die(mysql_error());
?>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="<?php echo URL ?>css/alpha.css">
        <link type="text/css" rel="stylesheet" href="<?php echo URL ?>css/siteStyle.css">
        <script>
            if (window.print)
                self.print();
            setTimeout('window.close()', 1000);
        </script>
    </head>
    <body>

        <div class="content">
            <h1>Test Result</h1>
        </div>
        <div class="content">
            <div class="small_form">
                <fieldset>
                    <table>
                        <tr>
                            <td width="120px" class="bold">Job Title</td>
                            <td width="120px"><?php echo $row['jobTitle'] ?> </td>
                            <td width="120px" class="bold">Position(count)</td>
                            <td><?php echo $row['jobPositionCount'] ?> </td>
                        </tr>
                        <tr>
                            <td class="bold">Designation</td>
                            <td><?php echo $row['jobDesignation'] ?> </td>
                            <td class="bold">Qualification</td>
                            <td><?php echo $row['jobQualification'] ?> </td>
                        </tr>
                        <tr>
                            <td class="bold">Description</td>
                            <td colspan="3"><br><fieldset><?php echo $row['jobDesc'] ?></fieldset></td>
                        </tr>
                        <tr>
                            <td class="bold">Technology</td>
                            <td colspan="3"><fieldset><?php echo $row['jobTechnology'] ?></fieldset></td>
                        </tr>
                        <tr>
                            <td class="bold">Job Category</td>
                            <td colspan="3"><fieldset><?php
                                    while ($rowCategory = mysql_fetch_assoc($resultCategory)) {
                                        //print_r($rowCategory);
                                        if (empty($rowCategory['catParentId'])) {
                                            echo $rowCategory['catTitle'];
                                        }
                                    }
                                    ?></fieldset></td>
                        </tr>
                        <tr>
                            <td class="bold">Job SubCategory</td>
                            <td colspan="3">
                                <fieldset>
                                    <?php
                                    //echo "asdf";			
                                    while ($rowSubCategory = mysql_fetch_assoc($resultSubCategory)) {
                                        //echo	!empty($rowSubCategory['catParentId']);
                                        //print_r($rowCategory);
                                        if (!empty($rowSubCategory['catParentId'])) {
                                            echo $rowSubCategory['catTitle'] . "<br>";
                                        }
                                    }
                                    ?></fieldset>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td class="bold">Score</td>
                            <td><?php echo $row['jobTestCorrectAns'] . "/" . $row['jobTestTotalQuestions'] ?></td>
                        </tr>
                        <tr>
                            <td class="bold">Result</td>
                            <td><?php echo $row['jobIsSelected'] == NULL ? "Pending" : ($row['jobIsSelected'] == true ? "Selected" : "Not Selected") ?></td>
                        </tr>

                    </table>
                </fieldset>
            </div>
        </div>

    </body>
</html>