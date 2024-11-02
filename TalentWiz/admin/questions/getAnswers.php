
<?php
include_once '../../include/settings.php';
if (isset($_GET['qtype']) && !empty($_GET['qtype']) && $_GET['qtype'] != -1) {
    if ($_GET['qtype'] == "tf") {
        ?>
        <fieldset class="small_form">
            <legend>Correct Answer</legend>
            <div id="tf">
                <table>
                    <tr>
                        <td>Answer<span class="red">*</span></td>
                        <td><input checked="checked" type="radio" value="1" name="corrAnswer" />True <input type="radio" value="0" name="corrAnswer">False</td>
                    </tr>
                </table>
            </div>
        </fieldset>
        <?php
    } elseif ($_GET['qtype'] == "obj") {
        ?>
        <fieldset>
            <legend>Correct Answer</legend>
            <div id="obj">
                <table>
                    <tr>
                        <td>Option 1<span class="red">*</span></td>
                        <td><input type="text" id="txtOption1" name="txtOption1"><span id="txtOption1Err" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Option 2<span class="red">*</span></td>
                        <td><input type="text" id="txtOption2" name="txtOption2"><span id="txtOption2Err" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Option 3<span class="red">*</span></td>
                        <td><input type="text" id="txtOption3" name="txtOption3"><span id="txtOption3Err" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Option 4<span class="red">*</span></td>
                        <td><input type="text" id="txtOption4" name="txtOption4"><span id="txtOption4Err" class="red"></span></td>
                    </tr>
                    <tr>
                        <td>Correct Option<span class="red">*</span></td>
                        <td>
                            <input checked="checked" type="radio" value="1" name="corrAnswer">1
                            <input type="radio" value="2" name="corrAnswer">2
                            <input type="radio" value="3" name="corrAnswer">3
                            <input type="radio" value="4" name="corrAnswer">4
                        </td>
                    </tr>
                </table>
            </div>
        </fieldset>
        <?php
    }
}
?>