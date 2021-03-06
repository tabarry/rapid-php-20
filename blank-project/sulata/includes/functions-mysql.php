<?php

/*
 * MySQL Functions
 */
/* Query function */
if (!function_exists('suQuery')) {

    function suQuery($sql, $catchError = TRUE) {
        if ($catchError == TRUE) {
            $result = mysql_query($sql) or suDie();
        } else {
            $result = mysql_query($sql);
        }
        return $result;
    }

}
/* fecth array */
if (!function_exists('suFetch')) {

    function suFetch($result) {
        return mysql_fetch_array($result);
    }

}
/* fecth assoc array */
if (!function_exists('suFetchAssoc')) {

    function suFetchAssoc($result) {
        return mysql_fetch_assoc($result);
    }

}
/* Die function */
if (!function_exists('suDie')) {

    function suDie() {
        if (DEBUG == TRUE) {
            return die(mysql_error());
        } else {
            return die(suExit(ERROR_MSG));
        }
    }

}
/* Get number of rows returned */
if (!function_exists('suNumRows')) {

    function suNumRows($result) {
        return mysql_num_rows($result);
    }

}
/* Free recordset function */
if (!function_exists('suFree')) {

    function suFree($result) {
        return mysql_free_result($result);
    }

}
/* Get last insert ID */
if (!function_exists('suInsertId')) {

    function suInsertId() {
        return mysql_insert_id();
    }

}
/* mysql error number */
if (!function_exists('suErrorNo')) {

    function suErrorNo() {
        return mysql_errno();
    }

}
/* Close connection function */
if (!function_exists('suClose')) {

    function suClose() {
        global $cn;
        return mysql_close($cn);
    }

}
/* Build dropdown pagination */
if (!function_exists('suPaginate')) {

    function suPaginate($sqlP, $cssClass = 'paginate') {
        //global $getSettings['page_size'];
        global $getSettings, $sr;
        $resultP = suQuery($sqlP);
        $rowP = suFetch($resultP);
        $totalRecs = $rowP['totalRecs'];
        suFree($resultP);
        $opt = '';
        if ($totalRecs > 0) {
            if ($totalRecs > $getSettings['page_size']) {
                for ($i = 1; $i <= ceil($totalRecs / $getSettings['page_size']); $i++) {
                    $j = $i - 1;
                    $sr = $getSettings['page_size'] * $j;
                    if ($_GET['start'] / $getSettings['page_size'] == $j) {
                        $sel = " selected='selected'";
                    } else {
                        $sel = "";
                    }
                    $opt.= "<option {$sel} value='" . $_SERVER['PHP_SELF'] . "?sr=" . $sr . "&q=" . $_GET['q'] . "&start=" . ($getSettings['page_size'] * $j) . "'>$i</option>";
                }
                echo "<div style=\"height:30px\">Go to page: <select class='{$cssClass}' onchange=\"window.location.href = this.value\">{$opt}></select></div>";
            }
        } else {
            if ($_GET['q'] == '') {
                echo '<div class="blue">' . RECORD_NOT_FOUND . '</div>';
            } else {
                echo '<div class="blue">' . SEARCH_NOT_FOUND . '</div>';
            }
        }
    }

}

/* Make label from field name */
if (!function_exists('makeFieldLabel')) {

    function makeFieldLabel($fld) {
        if (strstr($fld, "__")) {
            $fld = explode("__", $fld);
            $fld = $fld[1];
        } else {
            $fld = $fld;
        }

        return str_replace('_', ' ', $fld);
    }

}
/* Build dropdown for sorting */
if (!function_exists('suSort')) {

    function suSort($fieldsArray, $cssClass = 'paginate') {
        $opt = '';
        for ($i = 0; $i <= sizeof($fieldsArray) - 1; $i++) {
            if ($_GET['f'] == $fieldsArray[$i] && $_GET['sort'] == 'asc') {
                $sel1 = " selected='selected' ";
            } else {
                $sel1 = '';
            }
            if ($_GET['f'] == $fieldsArray[$i] && $_GET['sort'] == 'desc') {
                $sel2 = " selected='selected' ";
            } else {
                $sel2 = '';
            }
            $opt.="<option $sel1 value=\"" . $_SERVER['PHP_SELF'] . "?f=" . $fieldsArray[$i] . "&sort=asc&q=" . $_GET['q'] . "\">" . makeFieldLabel($fieldsArray[$i]) . " Asc</option>";
            $opt.="<option $sel2 value=\"" . $_SERVER['PHP_SELF'] . "?f=" . $fieldsArray[$i] . "&sort=desc&q=" . $_GET['q'] . "\">" . makeFieldLabel($fieldsArray[$i]) . " Desc</option>";
        }

        echo "<div class='paginateWrapper'>Sort by: <select class=\"{$cssClass}\" onchange=\"window.location.href=this.value\">{$opt}</select></div>";
    }

}
