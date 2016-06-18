<?php include('includes/include.php'); ?>
<?php

//print_array($_POST);

@mkdir('../' . $_POST['directory']);
//Copy folder
//function recurse_copy($src,$dst,$directory,$db,$db_user,$db_password)
recurse_copy('./blank-project', '../' . $_POST['directory'], $_POST['directory'], $_POST['db'], $_POST['db_user'], $_POST['db_password']);
//Create database

$sql = "DROP DATABASE IF EXISTS " . $_POST['db'];
mysql_query($sql) or die(mysql_error());
$sql = "CREATE DATABASE " . $_POST['db'];
mysql_query($sql) or die(mysql_error());
$sql = "USE " . $_POST['db'];
mysql_query($sql) or die(mysql_error());
$sql = file_get_contents('./blank-project/db/db.sql');
$sql = explode(';', $sql);
for ($i = 0; $i <= sizeof($sql); $i++) {
    //echo $sql[$i].'<br>'.'<br>';
    if ($sql[$i]) {
        mysql_query($sql[$i]) or die(mysql_error());
    }
}
//Drop unwanted tables and files
if ($_POST['sulata_faqs'] == 'drop') {
    echo $sql = "DROP TABLE IF EXISTS sulata_faqs";
    mysql_query($sql) or die(mysql_error());
    unlink('../' . $_POST['directory'] . '/_admin/faqs.php');
    unlink('../' . $_POST['directory'] . '/_admin/faqs-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/faqs-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/faqs-remote.php');
}
if ($_POST['sulata_media_files'] == 'drop') {
    $sql = "DROP TABLE IF EXISTS sulata_media_categories";
    mysql_query($sql) or die(mysql_error());
    $sql = "DROP TABLE IF EXISTS sulata_media_files";
    mysql_query($sql) or die(mysql_error());
    unlink('../' . $_POST['directory'] . '/_admin/media-categories.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-categories-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-categories-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-categories-remote.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-files.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-files-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-files-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/media-files-remote.php');
}

if ($_POST['sulata_pages'] == 'drop') {
    $sql = "DROP TABLE IF EXISTS sulata_pages";
    mysql_query($sql) or die(mysql_error());
    $sql = "DROP TABLE IF EXISTS sulata_headers";
    mysql_query($sql) or die(mysql_error());
    unlink('../' . $_POST['directory'] . '/_admin/pages.php');
    unlink('../' . $_POST['directory'] . '/_admin/pages-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/pages-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/pages-remote.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers-add.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers-update.php');
    unlink('../' . $_POST['directory'] . '/_admin/headers-remote.php');
}

echo "
<script>
top.$('#result').html('Project created.');
</script>
";
?>