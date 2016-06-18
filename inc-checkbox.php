<?php

//Build details table checkbox section                    
if ($_POST['frmDetailsSourceText'] != 'Checkbox Text..') {
    $f2 = explode('.', $_POST['frmDetailsSourceText']);
    $f2 = end($f2);

    $f1 = explode('.', $_POST['frmDetailsSourceValue']);
    $f1 = end($f1);

    $t1 = explode('.', $_POST['frmDetailsSourceValue']);
    $t1 = current($t1);

    //id
    $f1a = explode('.', $_POST['frmDetailsDestValue']);
    $f1a = end($f1a);
    $t1a = explode('.', $_POST['frmDetailsDestValue']);
    $t1a = current($t1a);
    //text
    $f2a = explode('.', $_POST['frmDetailsDestText']);
    $f2a = end($f2a);
    $prefix = explode('__', $f2a);
    $prefix = $prefix[0];

    $newPage = explodeExtract($t1, "_", 0);
    $newPage = str_replace('_', '-', $newPage);


    //Add sections        
    $addCheckBox = " 
<h2>" . strtoupper(str_replace('-', ' ', explodeExtract($t1, "_", 0))) . "</h2>
<?php if (\$addAccess == 'true') { ?>
<div>
    <a title=\"Add new record..\" rel=\"prettyPhoto[iframes]\" href=\"<?php echo ADMIN_URL; ?>" . $newPage . "-add.php?overlay=yes&iframe=true&width=100%&height=100%\"><img border='0' src='<?php echo BASE_URL; ?>sulata/images/add-icon.png'/></a>

    <a onclick=\"suReload2('chk_div','<?php echo ADMIN_URL; ?>','<?php echo suCrypt('" . $t1 . "'); ?>','<?php echo suCrypt('" . $f1 . "'); ?>','<?php echo suCrypt('" . $f2 . "'); ?>','<?php echo suCrypt('" . $t1a . "'); ?>','<?php echo suCrypt('" . $f1a . "'); ?>','<?php echo suCrypt('" . $f2a . "'); ?>','<?php echo suCrypt(\$id); ?>');\" href=\"javascript:;\"><img border='0' src='<?php echo BASE_URL; ?>sulata/images/reload-icon.png'/></a>    
</div> 
<?php } ?>  
                                
                                
    <div id=\"chk_div\">
<?php
//Build checkboxes
\$sql = \"SELECT " . $f1 . ", " . $f2 . " FROM " . $t1 . " ORDER BY " . $f2 . "\";
\$result = suQuery(\$sql);
?>
<div class=\"widget tasks-widget col-xs-12 col-sm-12 col-md-6 col-lg-6\" style=\"padding:0px;margin:0px;\">
<ul>
<?php
while (\$row = suFetch(\$result)) {
    ?>
    <li class=\"task-pending\"> 
     <label style=\"font-weight:normal;\">
        <?php
        \$arg = array('type' => 'checkbox', 'name' => '" . $f2 . "[]', 'id' => '" . $f2 . "[]', 'value' => \$row['" . $f1 . "']);
        echo suInput('input', \$arg) . \" \" . suUnstrip(\$row['" . $f2 . "']);
        ?>
    </label>
     </li>
    <?php
}suFree(\$result);
?>
</ul>
</div>
</div>";
//Update code
    $updateCheckBox = "
<h2>" . strtoupper(str_replace('-', ' ', explodeExtract($t1, "_", 0))) . "</h2>
<?php if (\$addAccess == 'true') { ?>    
<div>
    <a title=\"Add new record..\" rel=\"prettyPhoto[iframes]\" href=\"<?php echo ADMIN_URL; ?>" . $newPage . "-add.php?overlay=yes&iframe=true&width=100%&height=100%\"><img border='0' src='<?php echo BASE_URL; ?>sulata/images/add-icon.png'/></a>

    <a onclick=\"suReload2('chk_div','<?php echo ADMIN_URL; ?>','<?php echo suCrypt('" . $t1 . "'); ?>','<?php echo suCrypt('" . $f1 . "'); ?>','<?php echo suCrypt('" . $f2 . "'); ?>','<?php echo suCrypt('" . $t1a . "'); ?>','<?php echo suCrypt('" . $f1a . "'); ?>','<?php echo suCrypt('" . $f2a . "'); ?>','<?php echo suCrypt(\$id); ?>');\" href=\"javascript:;\"><img border='0' src='<?php echo BASE_URL; ?>sulata/images/reload-icon.png'/></a>    
</div> 
<?php } ?>  

  

<div id=\"chk_div\">
<?php
//Get entered data
\$sql = \"SELECT " . $f1a . " FROM " . $t1a . " WHERE " . $f2a . "='\" . \$id . \"'\";
\$result = suQuery(\$sql);
\$chkArr = array();

while (\$row = suFetch(\$result)) {
    array_push(\$chkArr, \$row['" . $f1a . "']);
}
suFree(\$result);


//Build checkboxes
\$sql = \"SELECT " . $f1 . ", " . $f2 . " FROM " . $t1 . " ORDER BY " . $f2 . "\";
\$result = suQuery(\$sql);
?>
<div class=\"widget tasks-widget col-xs-12 col-sm-12 col-md-6 col-lg-6\" style=\"padding:0px;margin:0px;\">
<ul>
<?php
while (\$row = suFetch(\$result)) {
    ?>
    <li class=\"task-pending\"> 
    <label style=\"font-weight:normal;\">
        <?php
        if (in_array(\$row['" . $f1 . "'], \$chkArr)) {
            \$arg = array('type' => 'checkbox', 'name' => '" . $f2 . "[]', 'id' => '" . $f2 . "[]', 'checked'=>'checked','value' => \$row['" . $f1 . "']);
        }else{
            \$arg = array('type' => 'checkbox', 'name' => '" . $f2 . "[]', 'id' => '" . $f2 . "[]', 'value' => \$row['" . $f1 . "']);
        
        }
        echo suInput('input', \$arg) . \" \" . suUnstrip(\$row['" . $f2 . "']);
        ?>
    </label>
     </li>
    <?php
}suFree(\$result);
?>
</ul>
</div>
</div>

";
//Validate remote
    $validateAddRemote = "
//Check if at least one checkbox is selected
if (sizeof(\$_POST['" . $f2 . "'])==0) {
    \$vError[]=VALIDATE_EMPTY_CHECKBOX;
}  
";

//Delete remote
    $deleteCheckBoxRemote = "
//Delete from child checkboxes table
\$sql = \"UPDATE " . $t1a . " SET ".$prefix."__Last_Action_On='\".date('Y-m-d H:i:s').\"', ".$prefix."__Last_Action_By='\".\$_SESSION[SESSION_PREFIX . 'user__Name'] .\" WHERE " . $f2a . "='\".\$_POST[\"" . $_POST['primary'] . "\"].\"'\";
suQuery(\$sql);
";


    //Add remote
    $addCheckBoxRemote = "
//Add details data
        for (\$i = 0; \$i <= sizeof(\$_POST['" . $f2 . "'])-1; \$i++) {
            \$sql = \"INSERT INTO " . $t1a . " SET " . $f2a . "='\".\$max_id.\"', $f1a='\".\$_POST['" . $f2 . "'][\$i].\"', ".$prefix."__Last_Action_On='\".date('Y-m-d H:i:s').\"', ".$prefix."__Last_Action_By='\".\$_SESSION[SESSION_PREFIX . 'user__Name'] .\"'\";
            suQuery(\$sql);
        }
        
";
    //update remote
    $updateCheckBoxRemote = "
//update details data
        //Delete privious data
        \$sql = \"DELETE FROM " . $t1a . " WHERE " . $f2a . "='\".\$max_id.\"'\";
        suQuery(\$sql);
       
        for (\$i = 0; \$i <= sizeof(\$_POST['" . $f2 . "'])-1; \$i++) {
            \$sql = \"INSERT INTO " . $t1a . " SET " . $f2a . "='\".\$max_id.\"', $f1a='\".\$_POST['" . $f2 . "'][\$i].\"', ".$prefix."__Last_Action_On='\".date('Y-m-d H:i:s').\"', ".$prefix."__Last_Action_By='\".\$_SESSION[SESSION_PREFIX . 'user__Name'] .\"'\";            
            suQuery(\$sql);
        }
        
";
}
?>