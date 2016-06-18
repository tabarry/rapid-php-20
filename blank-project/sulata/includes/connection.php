<?php

/*
 * SULATA FRAMEWORK
 * This file contains the database connection.
 */

$cn = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or suDie();
mysql_query("SET NAMES utf8");
@mysql_select_db(DB_NAME, $cn) or suDie();
