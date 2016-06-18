<?

/* --CONNECTION SETTINGS */
define('DB_HOST', 'localhost');
define('DB_NAME', 'test');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

/* --CONNECT */
$cn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
mysql_query("SET NAMES utf8");
mysql_select_db(DB_NAME, $cn) or die(mysql_error());
?>