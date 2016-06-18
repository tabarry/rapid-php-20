<?php

//View code starts
//Get fields to show
$fieldsToShow = "";
$fieldsToShowRemote = "";
$setSql = "";
//$colSize = sizeof($_POST['frmShow']) - 1;

for ($i = 0; $i <= sizeof($_POST['frmShow']) - 1; $i++) {
    if (strstr($_POST['frmShow'][$i], '_Date')) {
        //$colSize = $colSize + 2;
    } else {
        //$colSize = $colSize + 1;
    }
    $colSize = $colSize + 1;
}

$colSize = round(85 / ($colSize - 1));
$colData = "";
$csvHeaders = "";
$fieldsArray = "";
for ($i = 0; $i <= sizeof($_POST['frmShow']) - 1; $i++) {
    if ($_POST['frmShow'][$i] != $_POST['primary']) {
        if (strstr($_POST['frmShow'][$i], '_Date')) {
            $fieldsToShow .= "<th style=\"width:" . $colSize . "%\">" . makeFieldLabel($_POST['frmShow'][$i]) . "</th>\n";
            $colData .= "<td><?php echo suUnstrip(\$row['" . $_POST['frmShow'][$i] . "2']);?></td>\n";
        } else {
            $fieldsToShow .= "<th style=\"width:" . $colSize . "%\">" . makeFieldLabel($_POST['frmShow'][$i]) . "</th>\n";
            $colData .= "<td><?php echo suUnstrip(\$row['" . $_POST['frmShow'][$i] . "']);?></td>\n";
        }
        $fieldsArray.="'" . $_POST['frmShow'][$i] . "',";
        $csvHeaders .= "'" . makeFieldLabel($_POST['frmShow'][$i]) . "',";
    }


    if (strstr($_POST['frmShow'][$i], '_Date')) {
        $fieldsToShowRemote .= $_POST['frmShow'][$i] . ",";
        $fieldsToShowRemote .= " DATE_FORMAT(" . $_POST['frmShow'][$i] . ", '%b %d, %y') AS " . $_POST['frmShow'][$i] . "2,";
    } else {
        $fieldsToShowRemote .= $_POST['frmShow'][$i] . ",";
    }
}
$csvHeaders = substr($csvHeaders, 0, -1);
$colData.="
    <?php if ((\$editAccess == TRUE) || (\$deleteAccess == TRUE)) { ?>
    <td style=\"text-align: center;\">
    <?php if (\$editAccess == TRUE) { ?>
                                                <a href=\"<?php echo ADMIN_URL;?>" . $_POST['frmFormsetvalue'] . "-update.php/<?php echo \$row['" . $_POST['primary'] . "'];?>/\"><img border=\"0\" src=\"<?php echo BASE_URL; ?>sulata/images/edit.png\" title=\"<?php echo EDIT_RECORD; ?>\"/></a>
                                                    <?php } ?>
<?php if (\$deleteAccess == TRUE) { ?>
                                                <a onclick=\"return delRecord(this, '<?php echo CONFIRM_DELETE; ?>')\" href=\"<?php echo ADMIN_URL; ?>" . $_POST['frmFormsetvalue'] . "-remote.php/delete/<?php echo \$row['" . $_POST['primary'] . "']; ?>/\" target=\"remote\"><img border=\"0\" src=\"<?php echo BASE_URL; ?>sulata/images/delete.png\" title=\"<?php echo DELETE_RECORD; ?>\"/></a>
                                                    <?php } ?>
                                            </td>
                                            <?php } ?>
                                            
";
/* $fieldsToShow .= "
  edit: {title: '',width: '2%',sorting:false,list:<?php echo \$editAccess; ?>},"; */

$fieldsToShow .= "<?php if ((\$editAccess == TRUE) || (\$deleteAccess == TRUE)) { ?>"
        . "\n<th style=\"width:10%\">&nbsp;</th>\n"
        . "<?php } ?>";

//$fieldsToShow = substr($fieldsToShow, 0, -1);


$fieldsToShowRemote = substr($fieldsToShowRemote, 0, -1);
$fieldsArray = substr($fieldsArray, 0, -1);


$viewPath = $appPath . $_POST['frmSubFolder'] . '/' . $_POST['frmFormsetvalue'] . '.php';
$viewCode = "
                                <form class=\"form-horizontal\" name=\"searchForm\" id=\"searchForm\" method=\"get\" action=\"\">
                                    <fieldset id=\"search-area1\">
                                        <label class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><i class=\"fa fa-search blue\"></i> Search by " . makeFieldLabel($_POST['frmOrderby']) . "</label>
                                        <div class=\"col-xs-7 col-sm-10 col-md-10 col-lg-10\">
                                        <input id=\"q\" type=\"text\" value=\"\" name=\"q\" class=\"form-control\">
                                        </div>
                                        <div class=\"col-xs-5 col-sm-2 col-md-2 col-lg-2\">
                                        <input id=\"Submit\" type=\"submit\" value=\"Search\" name=\"Submit\" class=\"btn btn-primary pull-right\">
                                        </div>
                                        <?php if(\$_GET['q']){?>
                                        <div class=\"lineSpacer clear\"></div>
                                         <div class=\"pull-right\"><a style=\"text-decoration:underline !important;\" href=\"<?php echo ADMIN_URL;?>".$_POST['frmFormsetvalue'].".php\">Clear search.</a></div>
                                        </div>
                                        <?php } ?>
                                    </fieldset>
                                </form>
                               
                                
                    <div class=\"lineSpacer clear\"></div>
                    <?php if (\$addAccess == 'true') { ?>
                    <div id=\"table-area\"><a href=\"" . $_POST['frmFormsetvalue'] . "-add.php\" class=\"btn btn-black\">Add new..</a></div>
                        <?php } ?>
                        <?php
                                    \$fieldsArray = array(" . $fieldsArray . ");
                                    suSort(\$fieldsArray);
                                    ?>
<!-- TABLE -->

   <table width=\"100%\" class=\"table table-hover table-bordered tbl\">
                                    <thead>
                                        <tr>
                                            <th style=\"width:5%\">
                                                Sr.
                                            </th>
                                          
                                           $fieldsToShow
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
if (\$_GET['q'] != '') {
        \$where .= \" AND " . $_POST['uniqueField'] . " LIKE '%\" . suStrip(\$_GET['q']) . \"%' \";
    }
    
if (!\$_GET['start']) {
    \$_GET['start'] = 0;
}
if (!\$_GET['sr']) {
    \$sr = 0;
} else {
    \$sr = \$_GET['sr'];
}
if (!\$_GET['sort']) {
    \$sort = \" ORDER BY " . $_POST['uniqueField'] . "\";
} else {
    \$sort = \" ORDER BY \" . \$_GET['f'] . \" \" . \$_GET['sort'];
} 
//Get records from database
    
    \$sql = \"\$sql \$where \$sort LIMIT \" . \$_GET['start'] . \",\" . \$getSettings['page_size'];

    \$result = suQuery(\$sql);
    \$numRows = suNumRows(\$result);

    while(\$row=  suFetch(\$result)){
    
?>
                                        <tr>
                                            <td>
                                                <?php echo \$sr = \$sr + 1; ?>.
                                            </td>
                                            $colData
                                           
                                        </tr>
    <?php }suFree(\$result) ?>

                                    </tbody>
                                </table>
<!-- /TABLE -->
                    <?php
                                \$sqlP = \"SELECT COUNT(" . $_POST['primary'] . ") AS totalRecs FROM " . $_POST['table'] . " WHERE " . $fieldPrefix . "__dbState='Live' \$where\";
                                suPaginate(\$sqlP);
                                ?>
                                <?php if (\$downloadAccess == TRUE && \$numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target=\"remote\" href=\"<?php echo \$_SERVER['PHP_SELF']; ?>/stream-csv/\" class=\"btn btn-black pull-right\"><i class=\"fa fa-download\"></i> Download</a></p>
                                    <p>&nbsp;</p>
                                    <div class=\"clearfix\"></div>
                                <?php } ?>
                    
";

$pageTitle = 'Manage ' . ucwords(str_replace('-', ' ', $_POST['frmFormsetvalue']));
$pageTitle = "\$pageName='" . $pageTitle . "';\$pageTitle='" . $pageTitle . "';";
$csvDownloadCode = "
 \$sql = \"SELECT " . $fieldsToShowRemote . " FROM " . $_POST['table'] . " WHERE " . $fieldPrefix . "__dbState='Live'\";
//Download CSV
if (suSegment(1) == 'stream-csv' && \$downloadAccess == TRUE) {
    \$outputFileName = '" . $_POST['frmFormsetvalue'] . ".csv';
    \$headerArray = array(" . $csvHeaders . ");
    suSqlToCSV(\$sql, \$headerArray, \$outputFileName);
    exit;
}
";

//Write view code
$viewCode = str_replace('[RAPID-CODE]', $viewCode, $template);
$viewCode = str_replace("/* rapidSql */", $pageTitle . "\n" . $csvDownloadCode, $viewCode);
suWrite($viewPath, $viewCode);
//View code ends
?>
