<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();
$pageName = 'Update Settings';
$pageTitle = 'Update Settings';
$id = suSegment(1);
$sql = "SELECT setting__ID,setting__Setting,setting__Key,setting__Value,setting__Type FROM sulata_settings WHERE setting__ID='" . $id . "' AND setting__dbState='Live'";
$result = suQuery($sql);
if (suNumRows($result) == 0) {
    suExit(INVALID_RECORD);
}
$row = suFetch($result);
suFree($result);
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
            });
        </script> 
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
                                <h3 class="pull-left"><i class="fa fa-desktop purple"></i> <?php echo $pageTitle; ?></h3>

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
                                <form class="form-horizontal" action="<?php echo ADMIN_URL; ?>settings-remote.php/update/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote" >			
                                    <div class="gallery clearfix">
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <label><?php echo $dbs_sulata_settings['setting__Setting_req']; ?>Setting:</label>
                                                <?php
                                                $arg = array('type' => 'text', 'name' => 'setting__Setting', 'id' => 'setting__Setting', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_settings['setting__Setting_max'], 'class' => 'form-control', 'value' => suUnstrip($row['setting__Setting']), 'readonly' => 'readonly');
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="display:none">
                                                <label><?php echo $dbs_sulata_settings['setting__Key_req']; ?>Key:</label>
                                                <?php
                                                $arg = array('type' => 'text', 'name' => 'setting__Key', 'id' => 'setting__Key', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_settings['setting__Key_max'], 'class' => 'form-control', 'value' => suUnstrip($row['setting__Key']));
                                                echo suInput('input', $arg);
                                                ?>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                <label><?php echo $dbs_sulata_settings['setting__Value_req']; ?>Value:</label>
                                                <?php
                                                $arg = array('type' => 'text', 'name' => 'setting__Value', 'id' => 'setting__Value', 'autocomplete' => 'off', 'maxlength' => $dbs_sulata_settings['setting__Value_max'], 'class' => 'form-control', 'value' => suUnstrip($row['setting__Value']));
                                                echo suInput('input', $arg);
                                                ?>
                                            </div>


                                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="display:none">
                                                <label><?php echo $dbs_sulata_settings['setting__Type_req']; ?>Type:</label>
                                                <?php
                                                $options = $dbs_sulata_settings['setting__Type_array'];
                                                $js = "class=\"form-control\"";
                                                echo suDropdown('setting__Type', $options, suUnstrip($row['setting__Type']), $js)
                                                ?>

                                            </div>
                                        </div>
                                        <div class="lineSpacer clear"></div>
                                        <p>
                                            <?php
                                            $arg = array('type' => 'submit', 'name' => 'Submit', 'id' => 'Submit', 'value' => 'Submit', 'class' => 'btn btn-primary pull-right');
                                            echo suInput('input', $arg);
                                            ?>                              
                                        </p>
                                        <?php
                                        //Id field
                                        $arg = array('type' => 'hidden', 'name' => 'setting__ID', 'id' => 'setting__ID', 'value' => $id);
                                        echo suInput('input', $arg);
                                        ?>
                                    </div>
                                </form>                        
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