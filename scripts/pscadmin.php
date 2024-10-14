<?php
ini_set('max_execution_time', 0);
date_default_timezone_set("Asia/Kolkata");
include_once ('dbconnect.inc.php');
include_once ('Couchdb.php');
$db = new databaseConnection;
$db->setConnection();

$couchdb =  new Couchdb("swmqrcode");


$sql = "select master_admin.* , master_admin_role.role_name from master_admin, master_admin_role WHERE master_admin.user_role_id = master_admin_role.role_id   ";
$result = $db->runQuery($sql);
$db->close();

$table_name = "PSC_ADMIN" ;
for($i=0; $i<count($result); $i++) {
$doc_id = "UID".$result[$i]['admin_id'];    
$admin_id = $result[$i]['admin_id'];
$first_name = $result[$i]['first_name'];
$last_name = $result[$i]['last_name'];
$user_id = $result[$i]['user_id'];
$user_password = $result[$i]['user_password'];
$user_role_id = $result[$i]['user_role_id'];
$role_name = $result[$i]['role_name'];
$doc_obj = array(
    'table_name' => $table_name,
    'doc_id' => $doc_id,
    'admin_id' => trim($admin_id),
    'first_name' => trim($first_name),
    'last_name' => trim($last_name),
    'user_id' => trim($user_id),
    'user_password' => trim($user_password),
    'user_role_id' => trim($user_role_id),
    'role_name' => trim($role_name),
);

$couchdb->createCouchDbDoc($doc_obj, $doc_id, 'application/json');
echo "<pre>";
print_r($doc_obj);
}
?>
