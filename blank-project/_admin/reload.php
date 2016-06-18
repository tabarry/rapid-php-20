<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');

//Check to stop page opening outside iframe
//Check referrer
suCheckRef();
if ($_GET['type'] == 'chk') {
    $tbl = suDecrypt($_GET['tbl']);
    $f1 = suDecrypt($_GET['f1']);
    $f2 = suDecrypt($_GET['f2']);
    $tblb = suDecrypt($_GET['tblb']);
    $f1b = suDecrypt($_GET['f1b']);
    $f2b = suDecrypt($_GET['f2b']);
    $id = suDecrypt($_GET['id']);

    //Get entered data
    $sql = "SELECT " . $f1b . " FROM " . $tblb . " WHERE " . $f2b . "='" . $id . "'";
    $result = suQuery($sql);
    $chkArr = array();

    while ($row = suFetch($result)) {
        array_push($chkArr, $row[$f1b]);
    }
    suFree($result);

//Build checkboxes
    //State field
    $stateField = explode('__', $f1);
    $stateField = $stateField[0] . '__dbState';

    $sql = "SELECT $f1 AS f1, $f2 AS f2 FROM $tbl WHERE $stateField='Live' ORDER BY $f2";
    $result = suQuery($sql);
    echo '
        <div class="widget tasks-widget col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding:0px;margin:0px;">
        <ul>';
    while ($row = suFetch($result)) {
        echo '
            <li class="task-pending"> 
            <label style="font-weight:normal;">';
        if (in_array($row['f1'], $chkArr)) {
            $arg = array('type' => 'checkbox', 'name' => $f2 . '[]', 'id' => $f2 . '[]', 'value' => $row['f1'], 'checked' => 'checked');
        } else {
            $arg = array('type' => 'checkbox', 'name' => $f2 . '[]', 'id' => $f2 . '[]', 'value' => $row['f1']);
        }
        echo suInput('input', $arg) . " " . suUnstrip($row['f2']);
        echo '
            </label>
            </li>';
    }suFree($result);
    echo '
        </ul>
        </div>';
} else {
    $dd = "<option value='^'>Select..</option>";
    $tbl = suDecrypt($_GET['tbl']);
    $f1 = suDecrypt($_GET['f1']);
    $f2 = suDecrypt($_GET['f2']);
    $stateField = explode('__', $f1);
    $stateField = $stateField[0] . '__dbState';
    $sql = "SELECT $f1 AS f1, $f2 AS f2 FROM $tbl WHERE $stateField='Live' ORDER BY $f2";
    $result = suQuery($sql);
    while ($row = suFetch($result)) {
        $dd.="<option value='" . $row['f1'] . "'>" . suUnstrip($row['f2']) . "</option>";
    }suFree($result);
    echo $dd;
}
?>