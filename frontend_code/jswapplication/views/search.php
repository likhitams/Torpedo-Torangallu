
<?php echo $updatelogin;

$uid = $detail[0]->userId;
$compny = $detail[0]->companyid;
$language = $detail[0]->language;
$role = $detail[0]->userRole;

require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["keyword"])) {
    if ($role == "c"){
       $query ="SELECT unitname FROM units u LEFT JOIN unitrouting ur on ur.unitnumber=u.unitnumber WHERE ur.companyid=$compny   and u.unitname like '%" . $_POST["keyword"] . "%' ORDER BY u.unitname";
    }
    else {
    	$query ="SELECT unitname FROM units u LEFT JOIN unitrouting ur on ur.unitnumber=u.unitnumber LEFT JOIN user_routing usr ON ur.routeid=usr.unitrouting_id WHERE usr.user_id=$uid  and  unitname like '%" . $_POST["keyword"] . "%' ORDER BY unitname";
    }
	$result = $db_handle->runQuery($query);

if(!empty($result)) {
?>
<ul id="unit-list">
<?php
foreach($result as $unit) {
?>
<li onClick="selectUnit('<?php echo $unit["unitname"]; ?>');"><?php echo $unit["unitname"]; ?></li>
<?php } ?>
</ul>
<?php } } ?>