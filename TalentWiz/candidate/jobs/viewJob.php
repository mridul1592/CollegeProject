<?php
include_once '../../include/header.php';

if (isset($_GET['jobid']) && !empty($_GET['jobid'])) {
    $query = "select * from tbljobtest where jobid=" . $_GET['jobid'] . " and cndId='" . $_SESSION['userid'] . "'";
    $result = mysql_query($query);
    $rowTestValidity = mysql_num_rows($result);
    //	print_r($rowTestValidity['jobTestOn']);
//	$reTestLimit=13046400;
//	$today=  getdate();
//	$datetoday=array($today['year'],$today['mon'],$today['mday']);
//	$todaydate=implode("-",$datetoday);
//	$todayDate=strtotime($todaydate);
//	
//	$testDate=strtotime($rowTestValidity['jobTestOn'],$todayDate);
//	echo $datediff=$testDate-$todayDate;
//	//echo strtotime("1970");
//	echo $canGiveTest=$datediff-$reTestLimit;

    if ($rowTestValidity == 0) {
        $query = "select * from tbljobopening where jobId=" . $_GET['jobid'];
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        $query = "select a.*,b.catTitle,b.catParentId from tbljobcategory a left outer join tblcategory b on a.catId=b.catId where a.jobId=" . $_GET['jobid'];
        $resultCategory = mysql_query($query) or die(mysql_error());
        $resultSubCategory = mysql_query($query) or die(mysql_error());
        if (isset($_GET['task']) && $_GET['task'] == "giveTest") {
            //initiating session for the test
            $query = "select * from tbljobopening where jobId=" . $_GET['jobid'];
            $result = mysql_query($query);
            $row = mysql_fetch_assoc($result);

            $query = "insert into tbljobtest set
				cndId='" . $_SESSION['userid'] . "',
				jobId=" . $_GET['jobid'] . ",
				jobTestOn=now()
				";
            $result = mysql_query($query) or die("You are not allowed to give the test");

            $_SESSION['jobid'] = $_GET['jobid'];
            $_SESSION['jobTitle'] = $row['jobTitle'];
            $_SESSION['desig'] = $row['jobDesignation'];
            $_SESSION['positions'] = $row['jobPositionCount'];
            $_SESSION['timeout'] = "600";

            //test id in session variable
            $query = "select MAX(jobTestId) from tbljobtest";
            $result = mysql_query($query);
            $_SESSION['testid'] = mysql_result($result, 0, 0);
            header('location:' . URL . 'candidate/jobs/giveTest.php?jobid=' . $_GET['jobid']);
        }
        ?>
        <script>
            function confirmTest()
            {
                var conf = confirm("This step will take you to the Test.Do you wish to proceed?");
                if (conf)
                {
                    return 1;
                    window.location = "<?php echo URL ?>candidate/jobs/giveTest.php?jobid=<?php echo $_GET['jobid'] ?>";
                            }
                            else
                            {
                                return 0;
                            }
                        }
        </script>
        <div class="content">
            <div class="big_form">
                <fieldset>
                    <table>
                        <tr>
                            <td class="bold">Job Title</td>
                            <td><?php echo $row['jobTitle'] ?> </td>
                            <td class="bold">Position(count)</td>
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
                            <td colspan="3"><textarea name="txtDescription" readonly="readonly"><?php echo $row['jobDesc'] ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="bold">Technology</td>
                            <td colspan="3"><textarea name="txtDescription" readonly="readonly"><?php echo $row['jobTechnology'] ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="bold">Job Category</td>
                            <td colspan="2"><?php
                                while ($rowCategory = mysql_fetch_assoc($resultCategory)) {
                                    //print_r($rowCategory);
                                    if (empty($rowCategory['catParentId'])) {
                                        echo $rowCategory['catTitle'];
                                    }
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td class="bold">Job SubCategory</td>
                            <td colspan="2">
                                <br>
                                <?php
                                //echo "asdf";			
                                while ($rowSubCategory = mysql_fetch_assoc($resultSubCategory)) {
                                    //echo	!empty($rowSubCategory['catParentId']);
                                    //print_r($rowCategory);
                                    if (!empty($rowSubCategory['catParentId'])) {
                                        echo $rowSubCategory['catTitle'] . "<br>";
                                    }
                                }
                                ?>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input type="button" name="btnApply" value="Apply(Give Test)" onclick="window.location = '<?php echo URL ?>candidate/jobs/viewJob.php?task=giveTest&jobid=<?php echo $_GET['jobid'] ?>'">
                                <input type="button" value="Back" onclick="window.location = '<?php echo URL ?>candidate/jobs/searchJobs.php'">
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
        </div>

        <?php
    } else {
        ?>
        <div class="content">
            <br><br><br><br>
            <span class="red">You have already applied for this test.<br></span><br>
            <a href="<?php echo URL ?>candidate/jobs/searchJobs.php"> Go Back</a>
        </div>
        <?php
    }
}
include_once '../../include/footer.php';
?>