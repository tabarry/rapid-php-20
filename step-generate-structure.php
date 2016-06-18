<?php include('includes/include.php'); ?>
<?php

$functions .="<?php
     ";
$sql = "USE " . $_POST['db'];
mysql_query($sql) or die(mysql_error());

$sql = "SHOW TABLES FROM " . $_POST['db'];
$rs = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($rs)) {
    $arr = '';
    $arr2 = '';

    $functions .="\$dbs_" . $row[0] . " = 
        array(";
    $sql2 = "SHOW FULL FIELDS FROM " . $row[0];
    $rs2 = mysql_query($sql2) or die(mysql_error());
    while ($row2 = mysql_fetch_array($rs2)) {

        if ($row2[4] == 'UNI') {
            $uniqueArray.= "'" . $row2[0] . "',";
        }
        $arr2 = '';
        if ($row2[3] == 'NO') {
            $req = "*";
            $js_required = 'required';
            $html5_required = 'required';
            $html5_type = 'text';
        } else {
            $req = "";
            $js_required = '';
            $html5_required = '';
        }


        if (stristr($row2[0], 'Email')) {

            if ($row2[3] == 'NO') {
                $req = "*";
                $js_required = "email";
                $html5_type = 'email';
                $html5_type = 'text';
            } else {
                $req = "";
                $js_required = '';
                $html5_required = '';
            }
        }


        if (stristr($row2[0], 'Phone')) {

            if ($row2[3] == 'NO') {
                $req = "*";
                $js_required = 'required';
                $html5_required = 'required';
                $html5_type = 'text';
            } else {
                $req = "";
                $js_required = '';
                $html5_required = '';
            }
        }

        if (stristr($row2[1], 'int(')) {
            $js_required = "int";
            $html5_type = 'text';
        }

        if (stristr($row2[1], 'double(')) {
            $js_required = "double";
            $html5_type = 'text';
        }

        if (stristr($row2[1], 'float(')) {
            $js_required = "float";
            $html5_type = 'text';
        }

        if (stristr($row2[0], 'Attachment')) {
            $js_required = "attachment";
            $html5_type = 'file';
        }
        if (stristr($row2[0], 'Picture')) {
            $js_required = "image";
            $html5_type = 'file';
        }
        if (strstr($row2[0], 'File')) {
            $js_required = "file";
            $html5_type = 'file';
        }
        if (stristr($row2[0], 'Password')) {
            $js_required = "password";
            $html5_type = 'password';
        }

        $max = explode('(', $row2[1]);
        $max = explode(')', $max[1]);
        $max = $max[0];

        if (stristr($row2[1], 'enum(')) {
            $enum = explode(',', $max);
            $en = "";

            for ($i = 0; $i <= sizeof($enum) - 1; $i++) {
                $e = $enum[$i];
                $en .= $e . "=>" . $e . ",";
            }
            $arr2 = "'" . $row2[0] . "_array'=>array(''=>'Select..',$en),";
            $js_required = "enum";
        }


        if (stristr($row2[1], 'enum(')) {
            $max = '';
        } else {
            $max = $max;
        }
        $arr.="
            '" . $row2[0] . "_req'=>'" . $req . "',
            '" . $row2[0] . "_title'=>'" . makeFieldLabel($row2[0]) . "',
            '" . $row2[0] . "_max'=>'" . $max . "',
            '" . $row2[0] . "_validateas'=>'" . $js_required . "',
            '" . $row2[0] . "_html5_req'=>'" . $html5_required . "',
            '" . $row2[0] . "_html5_type'=>'" . $html5_type . "',
            $arr2
            ";
    }mysql_free_result($rs2);
    $functions.="
        $arr
        );
    
    ";
}mysql_free_result($rs);
$uniqueArray = "\$uniqueArray = array(" . substr($uniqueArray, 0, -1) . ");";

$dbStructurePath = $sitePath . '/includes/db-structure.php';
suWrite($dbStructurePath, $functions . $uniqueArray);
echo "
<script>
top.$('#result').html(top.$('#result').html()+'DB structure generated.<br/>');
</script>
";
?>