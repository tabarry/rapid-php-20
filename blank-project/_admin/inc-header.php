<?php if ($_SESSION[SESSION_PREFIX . 'user__ID'] != '') { ?>
    <div class="head-user dropdown pull-right">
        <a href="#" data-toggle="dropdown" id="profile">
            <!-- Icon 
            <i class="fa fa-user"></i>  -->
            <?php if ((file_exists(ADMIN_UPLOAD_PATH . $_SESSION[SESSION_PREFIX . 'user__Picture'])) && ($_SESSION[SESSION_PREFIX . 'user__Picture'] != '')) { ?>
                <img src="<?php echo BASE_URL . 'files/' . $_SESSION[SESSION_PREFIX . 'user__Picture']; ?>" alt="" class="img-responsive img-circle"/>
            <?php } ?> 

            <!-- User name -->
            <?php echo $_SESSION[SESSION_PREFIX . 'user__Name']; ?> 
            <i class="fa fa-caret-down"></i> 
        </a>
        <!-- Dropdown -->
        <ul class="dropdown-menu" aria-labelledby="profile">
            <li><a href="<?php echo ADMIN_URL; ?>users-update.php"><i class="fa fa-user"></i> Update Profile</a></li>
            <li><a href="<?php echo ADMIN_URL; ?>settings.php"><i class="fa fa-cogs"></i> Change Settings</a></li>
            <li><a href="<?php echo ADMIN_URL; ?>login.php?do=logout" target="remote"><i class="fa fa-power-off"></i> Log Out</a></li>
        </ul>
    </div>
<?php } ?>