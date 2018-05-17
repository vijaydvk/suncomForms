<?php
//require '../config/database.php';
/* $mode = isset( $_REQUEST['mode'] ) ? $_REQUEST['mode'] : "";
$mode(); */

class storeHandoff
{
 public static function  add()
 {	 
	try
	{
		$store_id = $_POST['store_id'];
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//print_r($_POST);
/* 		$data_signature = $_POST["image_signature"];
		//$data = base64_decode($data_signature);
		$image_parts = explode(";base64,", $data_signature);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);
		$file = 'img/' . 'image1' . '.png';
		file_put_contents($file, $image_base64);
		$retresult['success'] = true;
		$retresult['msg'] = 'Data has been added successfully.'; */
		
		//Get the post values
		
		$handoff_id = $_POST['handoff_id'];
		$doh = $_POST['doh'];
		$doh = date('Y-m-d', strtotime(str_replace('-', '/', $doh)));
		$new_manager = $_POST['new_manager'];
		$current_manager = $_POST['current_manager']; 
		$district_manager = $_POST['district_manager'];
		$exp_variance = $_POST['exp_variance'];
		$departing_mgr_comment = $_POST['departing_mgr_comment'];
		$new_mgr_comment = $_POST['new_mgr_comment'];
		$store_fixtures_condition = $_POST['store_fixtures_condition'];
		$pos_station_condition = $_POST['pos_station_condition'];
		$current_mgr_signature_path = "img/".$current_manager.".png";
		$new_mgr_signature_path = "img/".$new_manager.".png";
		$dm_signature_path = "img/".$district_manager.".png";
		$current_mgr_date = $_POST['current_mgr_date'];
		$new_mgr_date = $_POST['new_mgr_date'];
		$dm_date = $_POST['dm_date'];
		$current_mgr_date = date('Y-m-d', strtotime(str_replace('-', '/', $current_mgr_date)));
		$new_mgr_date = date('Y-m-d', strtotime(str_replace('-', '/', $new_mgr_date)));
		$dm_date = date('Y-m-d', strtotime(str_replace('-', '/', $dm_date)));
		
/* 		$qry =	"select count(handoff_id) from sun_store_manager_handoff where handoff_store = $store_id";
		$st = $conn->prepare( $qry );	
		$st->execute();
		$number_of_rows = $st->fetchColumn(); 
		if($number_of_rows > 0)
		{
			$sql ="UPDATE `sun_store_manager_handoff`
				SET
				`handoff_date` = $doh,
				`handoff_store` = $store_id,
				`handoff_new_mgr` = $new_manager,
				`handoff_current_mgr` = $current_manager,
				`cashcount_variance` = '$exp_variance',
				`departing_mgr_comment` = '$departing_mgr_comment',
				`new_mgr_comment` = '$new_mgr_comment',
				`store_fixtures_condition` = '$store_fixtures_condition',
				`pos_station_condition` = '$pos_station_condition',
				`current_mgr_signature_path` = '$current_mgr_signature_path',
				`new_mgr_signature_path` = '$new_mgr_signature_path',
				`dm_signature_path` = '$dm_signature_path',
				`current_mgr_date` = '$current_mgr_date',
				`new_mgr_date` = '$new_mgr_date',
				`dm_date` = '$dm_date',
				`update_time` = now()
				WHERE `handoff_id` = $handoff_id";	
				$query = $conn->prepare($sql);
				$insert=$query->execute();
		}
		else
		{ */
 		$sql =	"INSERT INTO `sun_store_manager_handoff`
			(`handoff_id`,
			`handoff_date`,
			`handoff_store`,
			`handoff_new_mgr`,
			`handoff_current_mgr`,
			`cashcount_variance`,
			`departing_mgr_comment`,
			`new_mgr_comment`,
			`store_fixtures_condition`,
			`pos_station_condition`,
			`current_mgr_signature_path`,
			`new_mgr_signature_path`,
			`dm_signature_path`,
			`current_mgr_date`,
			`new_mgr_date`,
			`dm_date`,
			`submit_time`,
			`update_time`)
			VALUES
			(null,
			$doh,
			$store_id,
			$new_manager,
			$current_manager,
			'$exp_variance',
			'$departing_mgr_comment',
			'$new_mgr_comment',
			'$store_fixtures_condition',
			'$pos_station_condition',
			'$current_mgr_signature_path',
			'$new_mgr_signature_path',
			'$dm_signature_path',
			'$current_mgr_date',
			'$new_mgr_date',
			'$dm_date',
			now(),
			now())";

			$query = $conn->prepare($sql);
			$insert=$query->execute();	
			$id = $conn->lastInsertId();
			//put District manager Signature as image
			
			if(isset($_POST['dmgr_sig']))
			{
				$data_signature = $_POST["dmgr_sig"];
				//$data = base64_decode($data_signature);
				$image_parts = explode(";base64,", $data_signature);
				$image_type_aux = explode("image/", $image_parts[0]);
				$image_type = $image_type_aux[1];
				$image_base64 = base64_decode($image_parts[1]);
				file_put_contents($dm_signature_path, $image_base64);
			}
			
			//put current store manager Signature as image
			
			if(isset($_POST['oldmgr_sig']))
			{
				$data_signature = $_POST["oldmgr_sig"];
				//$data = base64_decode($data_signature);
				$image_parts = explode(";base64,", $data_signature);
				$image_type_aux = explode("image/", $image_parts[0]);
				$image_type = $image_type_aux[1];
				$image_base64 = base64_decode($image_parts[1]);
				file_put_contents($current_mgr_signature_path, $image_base64);
			}

			//put new store manager Signature as image

			if(isset($_POST['nmgr_sig']))
			{
				$data_signature = $_POST["nmgr_sig"];
				//$data = base64_decode($data_signature);
				$image_parts = explode(";base64,", $data_signature);
				$image_type_aux = explode("image/", $image_parts[0]);
				$image_type = $image_type_aux[1];
				$image_base64 = base64_decode($image_parts[1]);
				file_put_contents($new_mgr_signature_path, $image_base64);
			}

			//if(isset($_POST['hardcount_imei']) && isset($_POST['hardcount_reason']))
			//{
				
			//}
			//else
			//{
				//print_r($_POST['hardcount_imei']);
				//print_r($_POST['hardcount_reason']);
				$hard_count_number = $_POST['hard_count_number'];
				$hard_count_imei = $_POST['hardcount_imei'];
				$hard_count_reason = $_POST['hardcount_reason'];
				//echo $hard_count_imei;
				//echo $hard_count_reason;
				$hard_count_imeiArray = explode(',', $hard_count_imei);
				$hard_count_reasonArray = explode(',', $hard_count_reason);
				//echo $hard_count_imeiArray.length;
				$sql = "INSERT INTO `sun_store_manager_handoff_hardcount`
						(`hardcount_id`,
						`handoff_id`,
						`hardcount_sheet_no`,
						`hardcount_missing_ph_imei`,
						`hardcount_missing_ph_reason`)VALUES";
						
				for($i=0;$i<count($hard_count_imeiArray);$i++)
				{
				$sql .= "(null,$id,'$hard_count_number','$hard_count_imeiArray[$i]','$hard_count_reasonArray[$i]'),";
				}
				$sql = substr($sql, 0, -1);
				//echo $sql;
				$query = $conn->prepare($sql);
				$insert=$query->execute(); 	

				$clover_device_imei = $_POST['clover_device_imei'];
				$clover_device_reason = $_POST['clover_device_reason'];
				$clover_device_imeiArray = explode(',', $clover_device_imei);
				$clover_device_reasonArray = explode(',', $clover_device_reason);
				$sql = "INSERT INTO `sun_store_manager_handoff_cloverdevices`
						(`cloverdevice_id`,
						`handoff_id`,
						`cloverdevice_imei`,
						`cloverdevice_reason`)VALUES";	
				for($i=0;$i<count($clover_device_imeiArray);$i++)
				{
				$sql .= "(null,$id,'$clover_device_imeiArray[$i]','$clover_device_reasonArray[$i]'),";
				}
				$sql = substr($sql, 0, -1);
				//echo $sql;
				$query = $conn->prepare($sql);
				$insert=$query->execute(); 	

				$rma_imei = $_POST['rma_imei'];
				$rma_reason = $_POST['rma_reason'];
				$rma_imeiArray = explode(',', $rma_imei);
				$rma_reasonArray = explode(',', $rma_reason);
				$sql = "INSERT INTO `sun_store_manager_handoff_rma`
						(`rma_id`,
						`handoff_id`,
						`rma_imei`,
						`rma_reason`)VALUES";	
				for($i=0;$i<count($rma_imeiArray);$i++)
				{
				$sql .= "(null,$id,'$rma_imeiArray[$i]','$rma_reasonArray[$i]'),";
				}
				$sql = substr($sql, 0, -1);
				//echo $sql;
				$query = $conn->prepare($sql);
				$insert=$query->execute(); 

				$register_amt = $_POST['register_amt'];
				$register_comments = $_POST['register_comments'];
				$register_amtArray = explode(',', $register_amt);
				$register_commentsArray = explode(',', $register_comments);
				$sql = "INSERT INTO `sun_store_manager_handoff_cashcount`
						(`cashcount_id`,
						`handoff_id`,
						`cashcount_amt`,
						`cashcount_comments`)VALUES";	
				for($i=0;$i<count($register_amtArray);$i++)
				{
				$sql .= "(null,$id,'$register_amtArray[$i]','$register_commentsArray[$i]'),";
				}
				$sql = substr($sql, 0, -1);
				//echo $sql;
				$query = $conn->prepare($sql);
				$insert=$query->execute(); 	
				$deposite_card = $_POST['deposite_card'];
				$safe_combination = $_POST['safe_combination'];
				$alarm_code = $_POST['alarm_code'];
				$drop_safe_bin = $_POST['drop_safe_bin'];
				$key_prev_manager = $_POST['key_prev_manager'];
				$door_locks = $_POST['door_locks'];
				$verified_deposits = $_POST['verified_deposits'];
				$sql = "INSERT INTO `sun_store_manager_handoff_misc_items`
						(`misc_id`,
						`handoff_id`,
						`question`,
						`answer`)
						values(null,'$id','Did we take the deposit card from the previous manager',$deposite_card),
						(null,'$id','Was the safe combination changed',$safe_combination),
						(null,'$id','Was the alarm code changed',$alarm_code),
						(null,'$id','Do we have the Manager PIN for the Drop Safe',$drop_safe_bin),
						(null,'$id','Did we get all keys from the previous manager',$key_prev_manager),
						(null,'$id','Were the door locks changed/replaced',$door_locks),
						(null,'$id','Have all deposits been verified',$verified_deposits)";
				$query = $conn->prepare($sql);
				$insert=$query->execute(); 		
				
						
				
			//}
			
		//}
	}
	catch (PDOException $e)
    {

		$retresult['success'] = false;
		K18_utility::saveError("store_handoff_db_page - Add:" . 'PDO-Exception' . $e->getMessage());
		if (contains($e->getMessage(), '18KSoftec Error:'))
		{
			$retresult['errors']  = strstr($e->getMessage(), '18KSoftec Error:');
		}
		else
		{
			//$retresult['errors']  = $e->getMessage();
			$retresult['errors']  = "Submission is not successful";
		}
		echo json_encode($retresult);
		$conn = null;
		return;
	}
	catch (Exception $e)
    {

		$retresult['success'] = false;
		K18_utility::saveError("store_handoff_dbpage - Add:" . 'Non-PDO-Exception' . $e->getMessage());
		if (contains($e->getMessage(), '18KSoftec Error:'))
		{
			$retresult['errors']  = strstr($e->getMessage(), '18KSoftec Error:');
		}
		else
		{
			//$retresult['errors']  = $e->getMessage();
			$retresult['errors']  = "Submission is not successful";
		}
		echo json_encode($retresult);
		$conn = null;
		return;
	}
    $conn = null;
	
	echo json_encode($retresult);
	//return;
	//echo $data;

 }
}
?>
