<?php include('includes/include.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include('inc-head.php'); ?>
    </head>
    <body>
        <div id="wrapper">
            <!--HEADER-->
            <?php include('inc-header.php'); ?>
            <!--CONTENT-->
            <div id="content">
                <h2>Generate DB Structure</h2>
                <form id="form1" name="form1" method="post" action="step-generate-structure.php" target="remote" onsubmit="return validateDBStructure();">
                    <label>*Database:</label>
                    <select name="db" id="db">
                        <option>Select...</option>
                        <?PHP
                        //Select database
                        $sql = "SHOW DATABASES";
                        $rs = mysql_query($sql) or die(mysql_error());
                        while ($row = mysql_fetch_array($rs)) {
                            ?>
                            <option>
                                <?= $row[0]; ?>
                            </option>
                            <?PHP
                        }
                        mysql_free_result($rs);
                        mysql_close($cn);
                        ?>
                    </select>
                    <label>*Folder:</label>
                    <select name="folder" id="folder">
                        <option value="">Select..</option>
                        <?php echo buildWww("../"); ?>
                    </select>      
                    <p>
                        <input type="submit" name="Submit" value="Generate" />
                    </p>
                    <p id="result"></p>
            </div>
            <?php suIframe('remote'); ?> 
            <!--FOOTER-->
            <?php include('inc-footer.php'); ?>
        </div>
    </body>
</html>
