<?php

//session_start();

// require configuration file
//require 'config/database.php';
include_once '../config/database.php';
if(session_id() == '') {session_start();}
$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : "";
$action(); 
function getStoreForDropdown()
{	
	try
	{
		$store_id = $_REQUEST['store_id'];
		$database = new Database();
	    $conn = $database->getConnection(); 
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$qry =	"SELECT *from sun_stores where store_id=$store_id";		
		$st = $conn->prepare( $qry );	
		$st->execute();
		$data = array();
		$row = $st->fetchAll(PDO::FETCH_ASSOC);
		foreach ($row as $key => $value) {
			$data[$key] = $value;
			
		}	
		$conn = null;	
		ob_start("ob_gzhandler");
		//echo(json_encode($data));
		echo(json_encode($data));
	}
	catch (Exception $e) {
		$retresult['success'] = false;
		$retresult['errors']  = 'In getDataChangeDetails, Non PDO Exception - '.$e->getMessage();
		echo json_encode($retresult);
		$conn = null;
		return;
		
	}
	catch (PDOException $e) {
		$retresult['success'] = false;
		$retresult['errors']  = 'In getDataChangeDetails, PDO Exception - '.$e->getMessage();
		echo json_encode($retresult);
		$conn = null;
		return;
		
	}
}

function getDistrictDetailsForDropDown()
{	
	try
	{
		$database = new Database();
	    $conn = $database->getConnection(); 
		$qry =	"select
				sd.district_id as id,
				sd.district_name as name,
				sm.market_name as market_name,
				sm.market_id as market_id
				from 
				sun_district sd,
				sun_market sm
				where 
				sd.market_id = sm.market_id
				and sd.active='1'";
		$st = $conn->prepare( $qry );	
		$st->execute();
		$data = array();
		$row = $st->fetchAll(PDO::FETCH_ASSOC);
		foreach ($row as $key => $value) {
			$data[$key] = array_map('utf8_encode', $value);	
			
		}	
		$conn = null;
		ob_start("ob_gzhandler");
		echo(json_encode($data));
	}
	catch (PDOException $e) {
		trigger_error( "getDistrictDetails: Couldn't execute query" . $e->getMessage());
		$conn = null;
	}
}

function getOpeningChecklistView()
{	
	try
	{
		$record_id = $_REQUEST['record_id'];
		$database = new Database();
	    $conn = $database->getConnection(); 
		$qry =	"select scoq.question, (CASE WHEN scoq.type = 'textfield' THEN socrd.answer
				ELSE 
					CASE WHEN socrd.answer = 0 THEN 'NO'
					WHEN socrd.answer = 1 THEN 'YES'
					ELSE  'N/A'
					END
				END) as answer
				from sun_checklist_opening_q scoq,
				sun_opening_checklist_record_details socrd
				where scoq.active=1
				and socrd.record_id=$record_id
				and scoq.opening_id = socrd.question";
		$st = $conn->prepare( $qry );	
		$st->execute();
		$data = array();
		$row = $st->fetchAll(PDO::FETCH_ASSOC);
		foreach ($row as $key => $value) {
			$data[$key] = array_map('utf8_encode', $value);	
			
		}	
		$conn = null;
		ob_start("ob_gzhandler");
		echo(json_encode($data));
	}
	catch (PDOException $e) {
		trigger_error( "getOpeningChecklistView: Couldn't execute query" . $e->getMessage());
		$conn = null;
	}
}

function getClosingChecklistView()
{	
	try
	{
		$record_id = $_REQUEST['record_id'];
		$database = new Database();
	    $conn = $database->getConnection(); 
		$qry =	"select sccq.question,(CASE WHEN sccq.type = 'textfield' THEN sccrd.answer
				ELSE 
					CASE WHEN sccrd.answer = 0 THEN 'NO'
					WHEN sccrd.answer = 1 THEN 'YES'
					ELSE  'N/A'
					END
				END) as answer
				from sun_checklist_closing_q sccq,
				sun_closing_checklist_record_details sccrd
				where sccq.active=1
				and sccrd.record_id=$record_id
				and sccq.closing_id = sccrd.question";
		$st = $conn->prepare( $qry );	
		$st->execute();
		$data = array();
		$row = $st->fetchAll(PDO::FETCH_ASSOC);
		foreach ($row as $key => $value) {
			$data[$key] = array_map('utf8_encode', $value);	
			
		}	
		$conn = null;
		ob_start("ob_gzhandler");
		echo(json_encode($data));
	}
	catch (PDOException $e) {
		trigger_error( "getClosingChecklistView: Couldn't execute query" . $e->getMessage());
		$conn = null;
	}
}

function getStoreManagerForDropDown()
{	
	try
	{
		$database = new Database();
	    $conn = $database->getConnection(); 
		$qry =	"select u.name,u.uid 
		from users_roles ur, users u 
		where ur.rid='6' and 
		u.uid=ur.uid and 
		u.status=1 
		order by u.name";
		$st = $conn->prepare( $qry );	
		$st->execute();
		$data = array();
		$row = $st->fetchAll(PDO::FETCH_ASSOC);
		foreach ($row as $key => $value) {
			$data[$key] = array_map('utf8_encode', $value);	
			
		}	
		$conn = null;
		ob_start("ob_gzhandler");
		echo(json_encode($data));
	}
	catch (PDOException $e) {
		trigger_error( "getDistrictDetails: Couldn't execute query" . $e->getMessage());
		$conn = null;
	}
}

function getSMDMForDropDown()
{
	try
	{
		$store_id = $_REQUEST['store_id'];
		$database = new Database();
	    $conn = $database->getConnection(); 
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$qry =	"select u.name as RSM,u.uid as RSM_ID,u1.name as DM,u1.uid as DM_ID
					from users u,
					users u1,
					field_data_field_store_id fs,
					sun_stores ss,
					users_roles ur,
					role r
					where u.uid=fs.entity_id
					and fs.field_store_id_value=$store_id
					and ss.store_id=$store_id
					and ur.uid=fs.entity_id
					and r.rid=ur.rid
					and r.rid=6
					and u.status=1
					and u1.uid=ss.store_district_id limit 0,1";		
		$st = $conn->prepare( $qry );	
		$st->execute();
		$data = array();
		$row = $st->fetchAll(PDO::FETCH_ASSOC);
		foreach ($row as $key => $value) {
			$data[$key] = $value;
			
		}	
		$conn = null;	
		ob_start("ob_gzhandler");
		//echo(json_encode($data));
		echo(json_encode($data));
	}
	catch (Exception $e) {
		$retresult['success'] = false;
		$retresult['errors']  = 'In getDataChangeDetails, Non PDO Exception - '.$e->getMessage();
		echo json_encode($retresult);
		$conn = null;
		return;
		
	}
	catch (PDOException $e) {
		$retresult['success'] = false;
		$retresult['errors']  = 'In getDataChangeDetails, PDO Exception - '.$e->getMessage();
		echo json_encode($retresult);
		$conn = null;
		return;
		
	}	
}

?>