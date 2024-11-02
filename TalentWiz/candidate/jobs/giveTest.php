<?php
include_once '../../include/settings.php';

if (isset($_SESSION['jobid']) && !empty($_SESSION['jobid'])) {

    include_once '../../include/header.php';

    if (isset($_POST['smtSubmitTest']) || isset($_POST['smtSubmitTestJS'])) {
        echo "<pre>";
        //print_r($_SESSION);
//		print_r($_POST);
        $corrAns = 0;
        $inCorrAns = 0;
        $totalQues = 0;
        echo count($_POST['qusType']);
        for ($i = 0; $i < count($_POST['qusType']); $i++) {
            //echo $_POST['qusType'][$i];
            $query = "select * from tblquestion where qusId=" . $_POST['qusId'][$i];
            $result = mysql_query($query);
            $row = mysql_fetch_assoc($result);
            //print_r($row);
            if (!empty($_POST['rbtnOption' . $_POST['qusId'][$i]])) {
                if ($row['qusCorrectAns'] == $_POST['rbtnOption' . $_POST['qusId'][$i]]) {
                    $corrAns++;
                } else {
                    $inCorrAns++;
                }
            }

            $totalQues++;
            //echo $_POST['qusId'][$i]."<br>";
            //echo $_POST['rbtnOption'.$_POST['qusId'][$i]];
            //print_r($_POST['qusId']);
        }

        //die;
//		echo "<br>-corr-".$corrAns;
//		echo "<br>-incorr-".$inCorrAns;
        echo $query = "update tbljobtest set jobTestCorrectAns=$corrAns,jobTestWrongAns=$inCorrAns,jobTestTotalQuestions=$totalQues where jobTestId=" . $_SESSION['testid'];
        $result = mysql_query($query) or die(mysql_error());
        header('location:endTest.php');
        //print_r($_POST['qusType']);
        echo "</pre>";
        die;
    }
    //print_r($_SESSION);
    $query = "select * from tbljobcategory where jobId=" . $_GET['jobid'];
    $result = mysql_query($query);
    $categories = array();
    while ($row = mysql_fetch_array($result)) {
        $categories[] = $row['catId'];
    }
    mysql_query("set @n = 0;");
    $query = "select * from (select @n:=@n+1 as count,a.* from tblquestion a where a.qusStatus=1 and qusCategory in (0";
    foreach ($categories as $value) {
        $query .= ",$value";
    }
    $query .= ")) as aliastblquestion";
    //die($query);
    $resultQuestions = mysql_query($query);
    $totalQuestions = mysql_num_rows($resultQuestions);
    
    $totalQuestions < 15 ? $testQuestions = $totalQuestions : $testQuestions = 15;
    
    //print_r($row);
    //setting random questions order in session variable
    if (!isset($_SESSION['randQuestions']) || empty($_SESSION['randQuestions'])) {
        $random = array();
        $i = 0;
        while (count($random) < $totalQuestions) {
            $rand = rand(1, $totalQuestions);
            //echo $rand;
            in_array($rand, $random);
            if (!in_array($rand, $random)) {
                $random[] = $rand;
            }
        }
        $_SESSION['randQuestions'] = $random;
    }

    //print_r($_SESSION['randQuestions']);
    ?>
    <?php 
        $testTime=60 * $totalQuestions;
    ?>
    <script>

        var timer;
        var totalSeconds;
        var timerRef;
        
        function createTimer(etime)
        {
            timer = document.getElementById("spnTimer");
            totalSeconds = etime;
            updateTimer();
            timerRef=window.setTimeout("tick()", 1000);
        }

        function tick()
        {
            if (totalSeconds <= 0)
            {
                window.clearTimeout(timerRef);
                alert("your time is over!");
                document.frmTest.submit();
                //window.location='endTest.php';
            }
            else
            {
                totalSeconds -= 1;
                //document.getV
                updateTimer();
                window.setTimeout("tick()", 1000);
            }
        }
        function updateTimer()
        {
            var seconds = totalSeconds;

            var hours = Math.floor(seconds / 3600);
            seconds -= hours * (3600);

            var minutes = Math.floor(seconds / 60);
            seconds -= minutes * (60);

            var timerStr = LeadingZero(hours) + ":" + LeadingZero(minutes) + ":" + LeadingZero(seconds);
            timer.innerHTML = "Timer " + timerStr;
        }
        function LeadingZero(time)
        {
            return time < 10 ? "0" + time : +time;
        }

        function confirmFinish()
        {
            var conf = confirm("Are you sure want to finish the test?");
            if (conf)
            {
                window.clearTimeout(timerRef);
                return true;
            }
            return false;
        }
    </script>
    <script>
        /*window.onbeforeunload = function () {
         
         window.frmTest.submit();
         return "leave the test?";
         }	/**/
    </script>
    
    <span style="position:fixed" id="spnTimer">
        <script type="text/javascript">$(document).ready(function(){createTimer(<?php echo $testTime; ?>);});</script>
    </span>
    <div id="question" class="content">
        <div class="small_form">
            <fieldset>
                <table width='100%'>
                    <tr>
                        <td class="bold">Test for the Job: </td>
                        <td colspan="2"><?php echo $_SESSION['jobTitle'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Position:</td>
                        <td><?php echo $_SESSION['positions'] ?></td>
                        <td class="bold">Designation:</td>
                        <td><?php echo $_SESSION['desig'] ?></td>
                    </tr>
                </table>
            </fieldset>
        </div>


        <div class="big_form">
            <form method="post" name="frmTest">
                <?php
                $questionNumber = 0;
                for ($i = 0; $i < $testQuestions; $i++) {
                    ++$questionNumber;
                    mysql_query("set @n=0;");
                    $qry[$i] = $query . " where count=" . $_SESSION['randQuestions'][$i];
                    //echo $qry[$i];
                    $resultRandQuestion = mysql_query($qry[$i]);
                    $row = mysql_fetch_assoc($resultRandQuestion);
                    ?>
                    <fieldset>

                        <table>
                            <tr>
                                <td colspan='2' class="bold">Question:<?php echo $questionNumber ?></td>
                            </tr>
                            <tr>
                                <td colspan='2'><?php echo $row['qusTitle'] ?> <br /><br /></td>
                            </tr>
                            
                            <?php
                            if (!empty($row['qusImagePath'])) {
                                ?>
                                <tr>
                                    <td colspan="2" align="center"><img src="<?php echo URL . $row['qusImagePath'].""; ?>" height="150px" width="150px" /></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="2">

                                    <input type="hidden" name="qusId[]" value="<?php echo $row['qusId'] ?>">
                                    <?php
                                    if ($row['qusType'] == "tf") {
                                        ?>
                                        <fieldset class="small_form">
                                            <div id="tf">
                                                <table width='300px'>
                                                    <tr>
                                                        <td>Answer</td>
                                                        <td> <input type="hidden" name="qusType[]" value="tf">
                                                            <input type="radio" value="1" name="rbtnOption<?php echo $row['qusId'] ?>" />
                                                            True
                                                            <input type="radio" value="0" name="rbtnOption<?php echo $row['qusId'] ?>">
                                                            False</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </fieldset>
                                        <?php
                                    } elseif ($row['qusType'] == "obj") {
                                        ?>
                                        <fieldset>
                                            <div id="obj">
                                                <table width='300px'>
                                                    <tr><input type="hidden" name="qusType[]" value="obj">
                                                    <td><input type="radio" name="rbtnOption<?php echo $row['qusId'] ?>" value="1">A.<?php echo $row['qusOption1'] ?></td>
                                                    <td><input type="radio" name="rbtnOption<?php echo $row['qusId'] ?>" value="2">B.<?php echo $row['qusOption2'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="radio" name="rbtnOption<?php echo $row['qusId'] ?>" value="3">C.<?php echo $row['qusOption3'] ?></td>
                                                        <td><input type="radio" name="rbtnOption<?php echo $row['qusId'] ?>" value="4">D.<?php echo $row['qusOption4'] ?></td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </fieldset>
                                        <?php
                                    }
                                    ?>
                                </td>
                            </tr>

                        </table>
                    </fieldset>

                <?php }
                ?>
                <input type='hidden' name='smtSubmitTestJS' value='Finish'>
                <input type="submit" name="smtSubmitTest" value="Finish" onclick="return confirmFinish()">
            </form>
        </div>
    </div>
    <?php
    include_once '../../include/footer.php';
} else {
    header('location:../../');
}
?>