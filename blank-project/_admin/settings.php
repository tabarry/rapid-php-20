<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
$pageName = 'Manage Settings';
$pageTitle = 'Manage Settings';

checkLogin();
$sql = "SELECT setting__ID,setting__Setting,setting__Value
 FROM sulata_settings WHERE setting__Type='Public' AND setting__dbState='Live'";
//Download CSV
if (suSegment(1) == 'stream-csv' && $downloadAccess == TRUE) {
    $outputFileName = 'settings.csv';
    $headerArray = array('Setting', 'Value');
    suSqlToCSV($sql, $headerArray, $outputFileName);
    exit;
}
$addAccess = FALSE;
$deleteAccess = FALSE;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc-head.php'); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                //Keep session alive
                $(function() {
                    window.setInterval("suStayAlive('<?php echo PING_URL; ?>')", 300000);
                });
                //Disable submit button
                suToggleButton(1);
            });</script> 
    </head>

    <body>

        <div class="outer">

            <!-- Sidebar starts -->

            <?php include('inc-sidebar.php'); ?>
            <!-- Sidebar ends -->

            <!-- Mainbar starts -->
            <div class="mainbar">
                <?php include('inc-heading.php'); ?>
                <!-- Mainbar head starts -->
                <div class="main-head">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <!-- Bread crumbs -->
                                <?php include('inc-breadcrumbs.php'); ?>
                            </div>

                            <div class="col-md-3 col-sm-4 col-xs-6">
                                <!-- Search block -->

                            </div>

                            <div class="col-md-3 col-sm-4 hidden-xs">
                                <!-- Notifications -->
                                <div class="head-noty text-center">

                                </div>
                                <div class="clearfix"></div>
                            </div>


                            <div class="col-md-3 hidden-sm hidden-xs">
                                <!-- Head user -->

                                <?php include('inc-header.php'); ?>
                                <div class="clearfix"></div>
                            </div>
                        </div>	
                    </div>

                </div>

                <!-- Mainbar head ends -->

                <div class="main-content">
                    <div class="container">

                        <div class="page-content">

                            <!-- Heading -->
                            <div class="single-head">
                                <!-- Heading -->
                                <h3 class="pull-left"><i class="fa fa-table red"></i> <?php echo $pageTitle; ?></h3>

                                <div class="clearfix"></div>
                            </div>

                            <div id="content-area">

                                <div id="error-area">
                                    <ul></ul>
                                </div>    
                                <div id="message-area">
                                    <p></p>
                                </div>
                                <!--SU STARTS-->
                                <form class="form-horizontal" name="searchForm" id="searchForm" method="get" action="">
                                    <fieldset id="search-area1">
                                        <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><i class="fa fa-search blue"></i> Search by Setting</label>
                                        <div class="col-xs-7 col-sm-10 col-md-10 col-lg-10">
                                            <input id="q" type="text" value="" name="q" class="form-control">
                                        </div>
                                        <div class="col-xs-5 col-sm-2 col-md-2 col-lg-2">
                                            <input id="Submit" type="submit" value="Search" name="Submit" class="btn btn-primary pull-right">
                                        </div>
                                    </fieldset>
                                </form>
                                <div class="lineSpacer clear"></div>
                                <?php if ($addAccess == 'true') { ?>
                                    <div id="table-area"><a href="settings-add.php" class="btn btn-black">Add new..</a></div>
                                <?php } ?>
                                <?php
                                $fieldsArray = array('setting__Setting', 'setting__Value');
                                suSort($fieldsArray);
                                ?>
                                <table width="100%" class="table table-hover table-bordered tbl">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">
                                                Sr.
                                            </th>

                                            <th style="width:42%">
                                                Setting
                                            </th>
                                            <th style="width:43%">
                                                Value
                                            </th>

                                            <?php if (($editAccess == TRUE) || ($deleteAccess == TRUE)) { ?>
                                                <th style="width:10%">&nbsp;</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($_GET['q'] != '') {
                                            $where .= " AND setting__Setting LIKE '%" . suStrip($_GET['q']) . "%' ";
                                        }
                                        if (!$_GET['start']) {
                                            $_GET['start'] = 0;
                                        }
                                        if (!$_GET['sr']) {
                                            $sr = 0;
                                        } else {
                                            $sr = $_GET['sr'];
                                        }
                                        if (!$_GET['sort']) {
                                            $sort = " ORDER BY setting__Setting";
                                        } else {
                                            $sort = " ORDER BY " . $_GET['f'] . " " . $_GET['sort'];
                                        }
                                        $sql = "$sql $where $sort LIMIT " . $_GET['start'] . "," . $getSettings['page_size'];

                                        $result = suQuery($sql);
                                        $numRows = suNumRows($result);
                                        while ($row = suFetch($result)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $sr = $sr + 1; ?>.
                                                </td>
                                                <td>
                                                    <?php echo suUnstrip($row['setting__Setting']); ?>
                                                </td>
                                                <td>
                                                    <?php echo suUnstrip($row['setting__Value']); ?>
                                                </td>
<?php if (($editAccess == TRUE) || ($deleteAccess == TRUE)) { ?>
                                                <td style="text-align: center;">
                                                     <?php if ($editAccess == TRUE) { ?>
                                                    <a href="<?php echo ADMIN_URL; ?>settings-update.php/<?php echo $row['setting__ID']; ?>/"><img border="0" src="<?php echo BASE_URL; ?>sulata/images/edit.png" title="<?php echo EDIT_RECORD; ?>"/></a>
                                                    <?php } ?>
                                                        <?php if ($deleteAccess == TRUE) { ?>
                                                    <a onclick="return delRecord(this, '<?php echo CONFIRM_DELETE; ?>')" href="<?php echo ADMIN_URL; ?>settings-remote.php/delete/<?php echo $row['setting__ID']; ?>/" target="remote"><img border="0" src="<?php echo BASE_URL; ?>sulata/images/delete.png" title="<?php echo DELETE_RECORD; ?>"/></a>
                                                    <?php } ?>
                                                </td>
<?php } ?>
                                            </tr>
                                        <?php }suFree($result) ?>

                                    </tbody>
                                </table>
                                <?php
                                $sqlP = "SELECT COUNT(setting__ID) AS totalRecs FROM sulata_settings WHERE setting__Type='Public' AND setting__dbState='Live' $where ";
                                suPaginate($sqlP);
                                ?>
                                <?php if ($downloadAccess == TRUE && $numRows > 0) { ?>
                                    <p>&nbsp;</p>
                                    <p><a target="remote" href="<?php echo $_SERVER['PHP_SELF']; ?>/stream-csv/" class="btn btn-black pull-right"><i class="fa fa-download"></i> Download</a></p>
                                    <p>&nbsp;</p>
                                    <div class="clearfix"></div>
                                <?php } ?>
                                <!--SU ENDS-->
                            </div>
                        </div>
                        <?php include('inc-site-footer.php'); ?>
                    </div>
                </div>

            </div>

            <!-- Mainbar ends -->

            <div class="clearfix"></div>
        </div>
        <?php include('inc-footer.php'); ?>
        <?php suIframe(); ?>  
    </body>
    <!--PRETTY PHOTO-->
    <?php include('inc-pretty-photo.php'); ?>    
</html>