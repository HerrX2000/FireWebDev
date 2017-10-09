<?php
/**
 * Database configuration
 *
 * Please see the MyBB Docs for advanced
 * database configuration for larger installations
 * http://docs.mybb.com/
 */
//
//Enable Multi-Databases (not recommended)
$config['db']['multiple'] = true;
$config['db']['separate'] = false; //separate in read and write? not supported yet

//configuration of database
$config['db']['type'] = 'mysqli';
$config['db']['db'] = 'fireweb';
$config['db']['prefix'] = '';

$config['db']['hostname'] = 'localhost';
$config['db']['username'] = 'root';
$config['db']['password'] = '';

$config['db']['encoding'] = 'utf8';

$config['db2']['type'] = 'mysqli';
$config['db2']['db'] = 'DB2869729';
$config['db2']['prefix'] = 'core_';

$config['db2']['hostname'] = 'rdbms.strato.de';
$config['db2']['username'] = 'U2869729';
$config['db2']['password'] = 'Diabolo8';

$config['db2']['encoding'] = 'utf8';
?>