<?php

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//E_NOTICE for undefine varibale; 

include_once 'IConnectInfo.php';

define("DOMAIN", $_SERVER['SERVER_NAME'] . "/");
define("DOMAIN_PUBLIC", DOMAIN . "public/");
define("ROOT", __DIR__ . "/");
define('PROJECT_ROOT', getcwd());
//echo ROOT. '=='. PROJECT_ROOT;
//echo DOMAIN_PUBLIC;

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

include('standard_include.php');
include 'functionsList.php';

//$mode = getParam('mode');
//$employeeId = get('employeeId');
//$userName = get('userName');
//$DB_NAME = get('DBNAME');
//$DB_TYPE = get('DB_TYPE');
//$designationId = get('designationId');
//$designationName = get('designationName');
//$companyId = get('companyId');
//$logoPath = get('logoPath');

$mode = getParam('mode');
$employeeId = get('employeeId');
$userName = get('userName');
$designationId = get('designationId');
$companyId = get('companyId');
$companyCode = get('cCode');
$companyName = get('companyName');
$roleId = get('roleId');
$nextApprovalId = get('nextApprovalId');
$logoPath = get('logoPath');

$userName='rajib';

if (mysqli_connect_errno()) {
    echo "Connection Failed: " . mysqli_connect_errno();
    exit();
}
authenticate($userName);
?>
