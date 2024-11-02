<?php
if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "admin") {
    ?>
    <!-- Menu -->
    <div id="glowmenu" class="glowingtabs">
        <ul>
            <li><a href="<?php echo URL ?>admin/"><span>Home</span></a></li>
            <li><a rel="dropmenu1_d"><span>Manage</span></a></li>
            <li><a rel="dropmenu2_d"><span>Questions</span></a></li>
            <li><a rel="dropmenu3_d"><span>Account</span></a></li>
            <li><a rel="dropmenu4_d"><span>Jobs</span></a></li>
        </ul>
    </div>
    <!--1st drop down menu -->
    <div id="dropmenu1_d" class="dropmenudiv_d">
        <a href="<?php echo URL ?>admin/geographicInformation/manageCountries.php">Geographic Information</a>
        <a href="<?php echo URL ?>admin/manageUsers.php">Users</a>
        <a href="<?php echo URL ?>admin/candidate/manageCandidate.php">Candidates</a>
        <a href="<?php echo URL ?>admin/faq/manageFAQ.php">FAQ's</a>
        <a href="<?php echo URL ?>admin/sq/manageSQ.php">Security Questions</a>
        <a href="<?php echo URL ?>admin/college/manageCollege.php">Colleges</a>
        <a href="<?php echo URL ?>admin/discussion/manageDiscussion.php">Discussions</a>
        <a href="<?php echo URL ?>admin/feedback/manageFeedback.php">Feedback</a>
        <a href="<?php echo URL ?>admin/request/manageRequest.php">Request</a>
    </div>
    <!--2nd drop down menu-->
    <div id="dropmenu2_d" class="dropmenudiv_d" style="width: 150px;">
        <a href="<?php echo URL ?>admin/questions/manageCategory.php">Question Category</a>
        <a href="<?php echo URL ?>admin/questions/manageQuestions.php">Question Bank</a>
    </div>
    <!--3rd drop down menu -->
    <div id="dropmenu3_d" class="dropmenudiv_d" style="width: 150px;">
        <a href="<?php echo URL ?>admin/account/manageProfile.php">Profile</a>
        <a href="<?php echo URL ?>admin/account/changePassword.php">Change Password</a>
    </div>
    <!--4th drop down menu -->
    <div id="dropmenu4_d" class="dropmenudiv_d" style="width: 150px;">
        <a href="<?php echo URL ?>admin/jobs/manageJobs.php">Job openings</a>
    </div>
    <?php
} else if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "operator") {
    ?>
    <!-- Menu -->
    <div id="glowmenu" class="glowingtabs">
        <ul>
            <li><a href="<?php echo URL ?>admin/"><span>Home</span></a></li>
            <li><a rel="dropmenu1_d"><span>Manage</span></a></li>
            <li><a rel="dropmenu2_d"><span>Questions</span></a></li>
            <li><a rel="dropmenu3_d"><span>Account</span></a></li>
            <li><a rel="dropmenu4_d"><span>Jobs</span></a></li>
        </ul>
    </div>
    <!--1st drop down menu -->
    <div id="dropmenu1_d" class="dropmenudiv_d">
        <a href="<?php echo URL ?>admin/faq/manageFAQ.php">FAQ's</a>
        <a href="<?php echo URL ?>admin/college/manageCollege.php">Colleges</a>
        <a href="<?php echo URL ?>admin/discussion/manageDiscussion.php">Discussions</a>
        <a href="<?php echo URL ?>admin/feedback/manageFeedback.php">Feedback</a>
    </div>

    <!--2nd drop down menu-->
    <div id="dropmenu2_d" class="dropmenudiv_d" style="width: 150px;">
        <a href="<?php echo URL ?>admin/questions/manageCategory.php">Question Category</a>
        <a href="<?php echo URL ?>admin/questions/manageQuestions.php">Question Bank</a>
    </div>
    <!--3rd drop down menu -->
    <div id="dropmenu3_d" class="dropmenudiv_d" style="width: 150px;">
        <a href="<?php echo URL ?>admin/account/manageProfile.php">Profile</a>
        <a href="<?php echo URL ?>admin/account/changePassword.php">Change Password</a>
    </div>
    <!--4th drop down menu -->
    <div id="dropmenu4_d" class="dropmenudiv_d" style="width: 150px;">
        <a href="<?php echo URL ?>admin/jobs/manageJobs.php">Job openings</a>
    </div>
    <?php
} else if (isset($_SESSION["usertype"]) && $_SESSION["usertype"] == "candidate") {
    ?>
    <!-- Menu -->
    <?php
    if (!isset($_SESSION['jobid'])) {
        ?>
        <!-- Menu -->
        <div id="glowmenu" class="glowingtabs">
            <ul>
                <li><a href="<?php echo URL ?>candidate/"><span>Home</span></a></li>
                <li><a rel="dropmenu1_d"><span>Account</span></a></li>
                <li><a rel="dropmenu2_d" href=""><span>Feedback and requests</span></a></li>
                <li><a rel="dropmenu3_d" href=""><span>Jobs</span></a></li>
                <li><a href="<?php echo URL ?>candidate/faq.php"><span>FAQ's</span></a></li>
                <li><a href="<?php echo URL ?>candidate/discussion/viewDiscussion.php"><span>Discussion Forum</span></a></li>
            </ul>
        </div>
        <!--1st drop down menu -->
        <div id="dropmenu1_d" class="dropmenudiv_d" style="width: 150px;">
            <a href="<?php echo URL ?>candidate/account/manageProfile.php">Profile</a>
            <a href="<?php echo URL ?>candidate/account/changePassword.php">Change Password</a>
        </div>

        <!--2nd drop down menu -->
        <div id="dropmenu2_d" class="dropmenudiv_d" style="width: 150px;">
            <a href="<?php echo URL ?>candidate/feedback/sendFeedback.php">Give Feedback</a>
            <a href="<?php echo URL ?>candidate/feedback/sendRequest.php">Request</a>
        </div>
        <!--2nd drop down menu -->
        <div id="dropmenu3_d" class="dropmenudiv_d" style="width: 150px;">
            <a href="<?php echo URL ?>candidate/jobs/searchJobs.php">Search Jobs</a>
            <a href="<?php echo URL ?>candidate/jobs/result.php">Results</a>
        </div>
        <?php
    } else if (isset($_SESSION['jobid'])) {
        ?>
        <!-- Menu -->
        <div id="glowmenu" class="glowingtabs">
            <ul>
                <li><span></span></li>
            </ul>
        </div>
        <!--1st drop down menu -->
        <?php
    }
} else {
    ?>
    <!-- Menu -->
    <div id="glowmenu" class="glowingtabs">
        <ul>
            <li><a href="<?php echo URL ?>guest/index.php"><span>Home</span></a></li>
            <li><a href="<?php echo URL ?>guest/faq.php"><span>FAQ's</span></a></li>
            <li><a href="<?php echo URL ?>aboutUs.php"><span>About Us</span></a></li>
        </ul>
    </div>
    <!--1st drop down menu -->
<?php } ?>