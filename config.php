<?php

define('db_host', "localhost");
define("db", "ovp_db");
define("db_password", "");
define("db_username", "root");
define("db_port", 3306);

$connection = new mysqli(db_host, db_username, db_password, db, db_port);