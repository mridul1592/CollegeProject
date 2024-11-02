<?php
include_once '../../include/header.php';
include_once '../checksession.php';
if (isset($_GET['reqid'])) {
    $query = "select * from tblrequest where requestId=" . $_GET['reqid'];
    $result = mysql_query($query);
    $row = mysql_fetch_assoc($result);

    $dateResponse = explode(' ', $row['responseDate']);
    $dateRequest = explode(' ', $row['requestDate']);
    ?>
    <div class="content">
        <h2 class="pageHeader">View Response</h2>
        <div class="big_form">
            <fieldset>
                <table>
                    <tr>
                        <td class="bold">Request Title</td>
                        <td><?php echo $row['requestTitle'] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Request Date</td>
                        <td><?php echo $dateRequest[0] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Request Description</td>
                        <td><textarea readonly="readonly"><?php echo $row['requestDesc'] ?></textarea></td>
                    </tr>
                    <tr>
                        <td class="bold">Response Date</td>
                        <td><?php echo $dateResponse[0] ?></td>
                    </tr>
                    <tr>
                        <td class="bold">Response</td>
                        <td><textarea readonly="readonly"><?php echo $row['responseDesc'] ?></textarea></td>
                    </tr>
                </table>
            </fieldset>
        </div>
    </div>
    <?php
}
include_once '../../include/footer.php';
?>
