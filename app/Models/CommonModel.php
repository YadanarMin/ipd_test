<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
class CommonModel extends Model
{

	function GetBranch(){
	  $query = "SELECT * FROM tb_branch ORDER BY bid";
	  $data = DB::select($query);
	  return json_decode(json_encode($data),true);
	}
	
	function GetPartner(){
	  $query = "SELECT * FROM tb_partner WHERE bid = (SELECT bid FROM tb_branch ORDER BY bid limit 1)";
	  $data = DB::select($query);
	  return json_decode(json_encode($data),true);
	}
	
	function GetShiageData(){
	  $query = "SELECT s.* FROM tb_shiage as s WHERE s.docID = (SELECT id FROM tb_document ORDER BY id DESC limit 1) ORDER BY s.roomid";
	  $data = DB::select($query);
	  return json_decode(json_encode($data),true);
	  
	}
	
	function GetAllstoreProjectCode(){
	  $query = "SELECT a_pj_code as pj_code, 
					  ( CASE 
					  WHEN b_tmp_pj_name != '' THEN b_tmp_pj_name 
					  WHEN b_pj_name != '' AND b_pj_name NOT LIKE '%と同じ%' THEN  b_pj_name
					  ELSE a_pj_name END ) as pj_name FROM tb_allstore_info";
	  $data = DB::select($query);
	  return json_decode(json_encode($data),true);
	}
	
	function SavePageDescriptionInfo($fileNames,$description1,$description2,$pageName,$overWrite){
	  try{
		
		  if($overWrite == 1){
			//delete from local folder
			$this->DeleteImageFromLocalFolder($pageName);
			//delete from db
			$deleteQuery = "DELETE FROM tb_page_description WHERE page_name='$pageName'";
			DB::delete($deleteQuery);
			$deleteQuery = "DELETE FROM tb_description_image WHERE page_name='$pageName'";
			DB::delete($deleteQuery);
		  
		  }

		  $updateQuery = "INSERT INTO tb_page_description (id,page_name,description1,description2)
						  SELECT MAX(id)+1,'$pageName','$description1','$description2' FROM tb_page_description
						  ON DUPLICATE KEY UPDATE  
						  description1='$description1',description2='$description2'";
		  DB::update($updateQuery);
			
		  foreach($fileNames as $image_name){
			$path = "/iPD/public/DescriptionImage/".$pageName."-".$image_name;
			$newPath = "/var/www/html/iPD/public/DescriptionImage/".$pageName."-".$image_name;
			$image = "/var/www/html/iPD/public/Upload/".$image_name;
			if(file_exists($image)){
			  copy($image,$newPath);
			}
			$query = "INSERT IGNORE INTO tb_description_image (id,page_name,image_name,image_path)
					  SELECT MAX(id)+1,'$pageName','$image_name','$path' FROM tb_description_image";

			DB::insert($query);
		  }
		
		$tempUploadPath = "/var/www/html/iPD/public/Upload/*";
		$files = glob($tempUploadPath); // get all file names
		foreach($files as $file){ // iterate files
		  if(is_file($file)) {
		  unlink($file); // delete file
		}
	  }
	  
	  return "success";
	  }catch(Exception $e){
		$e->getMessage();
	  }
	  
	}
	
	function DeleteImage($pageName,$imagePath){
		$file = "/var/www/html".$imagePath;
		if(is_file($file)) {
		  unlink($file); // delete file
		}
		$query = "DELETE FROM tb_description_image WHERE page_name='$pageName' and image_path='$imagePath'";
		DB::delete($query);
		return "success";
	}
	
	function GetPageDescriptionInfo($pageName){
	  $query = "SELECT tp.*,td.* FROM tb_page_description tp
				LEFT JOIN tb_description_image as td  ON td.page_name = tp.page_name
				WHERE tp.page_name = '$pageName'
				ORDER BY td.id ASC";
	  $data = DB::select($query);
	  return json_decode(json_encode($data),true);
	}
	
	function DeleteImageFromLocalFolder($pageName){
	  $query = "SELECT * FROM tb_description_image WHERE page_name='$pageName'";
	  $data = DB::select($query);
	  $result = json_decode(json_encode($data),true);
	  foreach($result as $row){
		$file = "/var/www/html".$row["image_path"];
		if(is_file($file)) {
		  unlink($file); // delete file
		}
	  }
	}
	
	
	function SaveProjectReportInformation($save_info){
	  // try{ 
	  //     $query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date)
	  //               SELECT MAX(id)+1,'$projectCode','$projectName',curdate() FROM tb_project_report
	  //               ON DUPLICATE KEY UPDATE  
	  //               save_date = curdate()";
	  //     DB::insert($query); 
		  
	  //     //save report history 
	  //     $hashtag_str = "";
	  //     if($hashtags != ""){
	  //       $hashtag_str = implode(",",$hashtags);
	  //     }
	  //     $report_html_code = addslashes($report_html_code);
	  //     $query = "INSERT INTO tb_project_report_history (id,project_code,report,hashtag_report,hashtag_items,save_date)
	  //               SELECT MAX(id)+1,'$projectCode','$report','$report_html_code','$hashtag_str',curdate() FROM tb_project_report_history
	  //               ON DUPLICATE KEY UPDATE  
	  //               report = '$report',
	  //               hashtag_report = '$report_html_code',
	  //               hashtag_items = '$hashtag_str'";
	  //     DB::insert($query); 
		 
	  //     return "success";
	  // }catch(Exception $e){
	  //   return $e->getMessage();
	  // }
	  
	  // try{ 
		 // $save_info = json_decode(json_encode($save_info), true);//convert stdclass to array
		 // $projectName = $save_info["projectName"];
		 // $projectCode = $save_info["projectCode"];
		 // $report = $save_info["report"];
		 // $leader_meeting_ipd_part1 = $save_info["leader_meeting_ipd_part1"];
		 // $leader_meeting_ipd_part2 = $save_info["leader_meeting_ipd_part2"];
		 // $leader_meeting_ipd_part3 = $save_info["leader_meeting_ipd_part3"];
		 // $leader_meeting_techno_dept = $save_info["leader_meeting_techno_dept"];
		 // $architecture_leader_meeting_ipd_part1 = $save_info["architecture_leader_meeting_ipd_part1"];
		 // $architecture_leader_meeting_ipd_part2 = $save_info["architecture_leader_meeting_ipd_part2"];
		 // $architecture_leader_meeting_ipd_part3 = $save_info["architecture_leader_meeting_ipd_part3"];
		 // $leader_meeting_civil_engineer = $save_info["leader_meeting_civil_engineer"];
		 // $structure_design_report = $save_info["structure_design_report"];
		 // $design_report =$save_info["design_report"];
		 // $estimation_report =$save_info["estimation_report"];
		 // $renewal_report =$save_info["renewal_report"];
		 // $equipment_design_report =$save_info["equipment_design_report"];
		 // $quality_control_report =$save_info["quality_control_report"];
		 // $construction_report =$save_info["construction_report"];
		 // $production_engineer_report =$save_info["production_engineer_report"];
		 // $production_design_report =$save_info["production_design_report"];
		 // $construction_office_report =$save_info["construction_office_report"];
		 // $construction_equipment_report =$save_info["construction_equipment_report"];
		 // $hashtags = $save_info["hashtag_list"];
		 // $report_html_code = $save_info["report_html_code"];
		 // $loginUser = session('login_user_id');
		 
		 // $query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date)
			// 		SELECT MAX(id)+1,'$projectCode','$projectName',curdate() FROM tb_project_report
			// 		ON DUPLICATE KEY UPDATE  
			// 		save_date = curdate()";
		 // DB::insert($query); 
		  
		 // //save report history 
		 //  $hashtag_str = "";
		 //  if($hashtags != ""){
			//  $hashtag_str = implode(",",$hashtags);
		 //  }
		 //  $report_html_code = addslashes($report_html_code);
		 //  $query = "INSERT INTO tb_project_report_history (id,project_code,report,
			// 		leader_meeting_ipd_part1,leader_meeting_ipd_part2,leader_meeting_ipd_part3,leader_meeting_techno_dept,
			// 		architecture_leader_meeting_ipd_part1,architecture_leader_meeting_ipd_part2,architecture_leader_meeting_ipd_part3,leader_meeting_civil_engineer,
			// 		 structure_design_report,design_report,estimation_report,renewal_report,equipment_design_report,quality_control_report,construction_report,
			// 		 production_engineer_report,production_design_report,construction_office_report,construction_equipment_report,
			// 		 hashtag_report,hashtag_items,save_date,save_user)
			// 		SELECT MAX(id)+1,'$projectCode','$report',
			// 		'$leader_meeting_ipd_part1','$leader_meeting_ipd_part2','$leader_meeting_ipd_part3','$leader_meeting_techno_dept',
			// 		'$architecture_leader_meeting_ipd_part1','$architecture_leader_meeting_ipd_part2','$architecture_leader_meeting_ipd_part3','$leader_meeting_civil_engineer',
			// 		'$structure_design_report','$design_report','$estimation_report','$renewal_report','$equipment_design_report','$quality_control_report','$construction_report',
			// 		'$production_engineer_report','$production_design_report','$construction_office_report','$construction_equipment_report',
			// 		'$report_html_code','$hashtag_str',curdate(),'$loginUser' FROM tb_project_report_history
			// 		ON DUPLICATE KEY UPDATE  
			// 		report = '$report',
			// 		leader_meeting_ipd_part1 = '$leader_meeting_ipd_part1',
			// 		leader_meeting_ipd_part2 = '$leader_meeting_ipd_part2',
			// 		leader_meeting_ipd_part3 = '$leader_meeting_ipd_part3',
			// 		leader_meeting_techno_dept = '$leader_meeting_techno_dept',
			// 		architecture_leader_meeting_ipd_part1 = '$architecture_leader_meeting_ipd_part1',
			// 		architecture_leader_meeting_ipd_part2 = '$architecture_leader_meeting_ipd_part2',
			// 		architecture_leader_meeting_ipd_part3 = '$architecture_leader_meeting_ipd_part3',
			// 		leader_meeting_civil_engineer = '$leader_meeting_civil_engineer',
			// 		structure_design_report ='$structure_design_report',
			// 		design_report = '$design_report',
			// 		estimation_report = '$estimation_report',
			// 		renewal_report = '$renewal_report',
			// 		equipment_design_report = '$equipment_design_report',
			// 		quality_control_report = '$quality_control_report',
			// 		construction_report = '$construction_report',
			// 		production_engineer_report = '$production_engineer_report',
			// 		production_design_report = '$production_design_report',
			// 		construction_office_report = '$construction_office_report',
			// 		construction_equipment_report = '$construction_equipment_report',
			// 		hashtag_report = '$report_html_code',
			// 		save_user = '$loginUser',
			// 		hashtag_items = '$hashtag_str'";
				   
		 //  DB::insert($query); 
		 
		 // return "success";
	  // }catch(Exception $e){
		 //return $e->getMessage();
	  // }
	  
	  try{ 
	// foreach($hashtags as $hashtag){
	// 	$q = "INSERT INTO tb_hashtags(id,name,used_count)
	// 		SELECT MAX(id)+1,'$hashtag',1 FROM tb_hashtags";
	// 		DB::insert($q); 
	// }
	// return "success";
		  $save_info = json_decode(json_encode($save_info), true);//convert stdclass to array
			  
		  $projectName = $save_info["projectName"];
		  $projectCode = $save_info["projectCode"];
		  $save_report_list = $save_info["save_report_list"];

		  $query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date)
					SELECT MAX(id)+1,'$projectCode','$projectName',curdate() FROM tb_project_report
					ON DUPLICATE KEY UPDATE  
					save_date = curdate()";
		  DB::insert($query); 
		  
		 $hashtag_save_list = array(); 
		 foreach($save_report_list as $tblName=>$report){
		 	$tblName = "tb_".$tblName."_history";
		 	$hashtag_save_list = $this->SaveReportHistory($tblName,$projectCode,$report,$hashtag_save_list);
		 }
		//return $hashtag_save_list;
		
		if(sizeof($hashtag_save_list) > 0){
			foreach($hashtag_save_list as $hashtag=>$used_count){
				$hashtag = trim($hashtag);
				$query = "INSERT INTO tb_hashtags (id,name,used_count)
				SELECT MAX(id)+1,'$hashtag',$used_count FROM tb_hashtags
				ON DUPLICATE KEY UPDATE 
				used_count = used_count+$used_count";
				DB::insert($query);
			}
			
		}
		
		//get saved report category info for rebind dislpay table;
		
		$reload_data = $this->GetCurrentWeekReports($projectCode,array_keys($save_report_list));
			
		  return array("message"=>"success","reload_data"=>$reload_data);
	   }catch(Exception $e){
		 return $e->getMessage();
	   }
	}
	
	
	function SaveProjectReportInformationTemp($save_info){
	   try{ 
	// foreach($hashtags as $hashtag){
	// 	$q = "INSERT INTO tb_hashtags(id,name,used_count)
	// 		SELECT MAX(id)+1,'$hashtag',1 FROM tb_hashtags";
	// 		DB::insert($q); 
	// }
	// return "success";
		  $save_info = json_decode(json_encode($save_info), true);//convert stdclass to array
			  
		  $projectName = $save_info["projectName"];
		  $projectCode = $save_info["projectCode"];
		  $save_report_list = $save_info["save_report_list"];

		  $query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date)
					SELECT MAX(id)+1,'$projectCode','$projectName',curdate() FROM tb_project_report
					ON DUPLICATE KEY UPDATE  
					save_date = curdate()";
		  DB::insert($query); 
		  
		 $hashtag_save_list = array(); 
		 foreach($save_report_list as $tblName=>$report){
		 	$tblName = "tb_".$tblName."_history";
		 	$hashtag_save_list = $this->SaveReportHistory($tblName,$projectCode,$report,$hashtag_save_list);
		 }
		//return $hashtag_save_list;
		
		if(sizeof($hashtag_save_list) > 0){
			foreach($hashtag_save_list as $hashtag=>$used_count){
				$query = "INSERT INTO tb_hashtags (id,name,used_count)
				SELECT MAX(id)+1,'$hashtag',$used_count FROM tb_hashtags
				ON DUPLICATE KEY UPDATE 
				used_count = used_count+$used_count";
				DB::insert($query);
			}
			
		}
		
		//get saved report category info for rebind dislpay table;
		
		$reload_data = $this->GetCurrentWeekReports($projectCode,array_keys($save_report_list));
			
		  return array("message"=>"success","reload_data"=>$reload_data);
	   }catch(Exception $e){
		 return $e->getMessage();
	   }
	}
	
	function SaveReportHistory($tblName,$projectCode,$report_list,$hashtag_save_list){
		$loginUserId = session('login_user_id'); 
		$date_time = date("Y-m-d H:i:s");
		  //save report history 
			foreach ($report_list as $data) {

			 $save_user_id = $data["saved_user_id"];
			 $report = $data["report"];
			 $report_with_style = addslashes($data["report_with_style"]);//AddSlashes
			 
			 $hashtag_str = $data["hashtags"] != "" ? implode(",",$data["hashtags"]) : "";

			 $query = "INSERT INTO ".$tblName." (id,project_code,report,report_with_style,hashtags,saved_user_id,saved_date)
					SELECT MAX(id)+1,'$projectCode','$report','$report_with_style','$hashtag_str',$loginUserId,'$date_time' FROM ".$tblName."
					ON DUPLICATE KEY UPDATE  
					report = '$report',
					hashtags ='$hashtag_str',
					saved_date = '$date_time'";
					//return $query;
			   DB::insert($query); 
			   
			   foreach($data["hashtags"] as $ht){

				 	if(array_key_exists($ht,$hashtag_save_list)){
						$hashtag_save_list[$ht] = $hashtag_save_list[$ht]+1;
				 	}else{
				 		$hashtag_save_list[$ht] = 1;
				 	}
				 }
			}

			return $hashtag_save_list;
	}
	
	function UpdateReportProjectStates($projectCode,$projectName,$chk_ji,$chk_ki,$chk_hou,$chk_tou,$chk_special,$txtHai){
		try{
		  $query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date,execution_plan,held_meeting,report_avaliable,bim360_report,special_feature,assigned_person)
					SELECT MAX(id)+1,'$projectCode','$projectName',curdate(),$chk_ji,$chk_ki,$chk_hou,$chk_tou,$chk_special,'$txtHai' FROM tb_project_report
					ON DUPLICATE KEY UPDATE 
					execution_plan = $chk_ji,
					held_meeting = $chk_ki,
					report_avaliable = $chk_hou,
					bim360_report = $chk_tou,
					special_feature = $chk_special,
					assigned_person = '$txtHai'";
  
		  DB::insert($query);
		  return "success";
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	function SaveReportSepcialFeature($projectCode,$projectName,$sepcial_feature_info){
		try{
		  $query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date,special_feature_info)
					SELECT MAX(id)+1,'$projectCode','$projectName',curdate(),'$sepcial_feature_info' FROM tb_project_report
					ON DUPLICATE KEY UPDATE 
					special_feature_info = '$sepcial_feature_info'";
  
		  DB::insert($query);
		  return "success";
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	//アクセスログ画面
	public function InsertAccessLog($loginUser,$funName,$curDateTime){
	  try{
		DB::insert("insert into tb_accesslog (loginUser, funName, curDateTime) values (?,?,?)", [$loginUser,$funName,$curDateTime]);
		return "success";
	  }catch(Exception $e){
		return $e->getMessage();
	  }
	}
	
	//アクセスログ画面
	public function GetAccessLog(){
	  $query = "SELECT * from tb_accesslog ORDER BY curDateTime DESC";
	  $data = DB::select($query);
	  return $data;
	  
	}
	//アクセスログ画面
	function SearchAccessLog($name,$startDate,$endDate){
	  $condition ="";
	  if($name != ""){
		$condition .= " loginUser LIKE '%$name%'";
	  }
	  if($startDate != "" && $endDate != ""){
			if($condition == "")
				$condition .= " curDateTime >= CAST('$startDate' AS DATETIME) AND curDateTime <= CAST('$endDate' AS DATETIME)";
			 else
				$condition .= "AND curDateTime >= CAST('$startDate' AS DATETIME) AND curDateTime <= CAST('$endDate' AS DATETIME)";
	  }
	   try{
			if($condition == ""){
				$query = "SELECT * FROM tb_accesslog ORDER BY curDateTime DESC";
			}
			else{
				$query = "SELECT * FROM tb_accesslog  WHERE".$condition ." ORDER BY curDateTime DESC";
			}
			$data = DB::select($query);
			return $data;
			

		}catch(Exception $e)
		{
			$conn->roolback();
			echo $e->getMessage();
		}
	}
	
	
	public function GetProjectReportByName($projectCode){
		
		$query = "SELECT allstore.a_pj_code,
				( CASE 
					  WHEN allstore.b_tmp_pj_name != '' THEN allstore.b_tmp_pj_name 
					  WHEN allstore.b_pj_name != '' AND b_pj_name NOT LIKE '%と同じ%' THEN  allstore.b_pj_name
					  ELSE allstore.a_pj_name END ) as pj_name,
				  allstore.b_hattyuusya as hattyuusya,
				  IF(allstore.b_sekkeisya1 IS NULL OR allstore.b_sekkeisya1='',allstore.a_sekkei,allstore.b_sekkeisya1) as sekkeisya,
				  IF(allstore.b_shiten IS NULL OR allstore.b_shiten='',allstore.a_shiten,allstore.b_shiten) as shiten,
				  IF(allstore.b_tijo IS NULL OR allstore.b_tijo='',allstore.a_tijo,allstore.b_tijo) as tijo,
				  IF(allstore.b_tika IS NULL OR allstore.b_tika='',allstore.a_tika,allstore.b_tika) as tika,
				  IF(allstore.b_nobe_menseki IS NULL OR allstore.b_nobe_menseki='',allstore.a_nobe_menseki,allstore.b_nobe_menseki) as nobe_menseki,
				  IF(allstore.b_kouzou IS NULL OR allstore.b_kouzou='',allstore.a_kouzou,allstore.b_kouzou) as kouzou,
				  allstore.b_sekou_syozoku as sekou_syozoku,
				  allstore.b_koutei_sekkei_model_start,
				  allstore.b_koutei_sekkei_model_end,
				  allstore.b_koutei_kakunin_sinsei_start,
				  allstore.b_koutei_kakunin_sinsei_end,
				  allstore.b_koutei_sekisan_model_tougou_start,
				  allstore.b_koutei_sekisan_model_tougou_end,
				  allstore.b_koutei_kouji_juujisya_kettei_start,
				  allstore.b_koutei_kouji_juujisya_kettei_end,
				  allstore.b_koutei_genba_koutei_kettei_start,
				  allstore.b_koutei_genba_koutei_kettei_end,
				  allstore.b_koutei_kouji_start,
				  allstore.b_koutei_kouji_end,
				  pr.*,prh.*
				  
				FROM tb_allstore_info as allstore
				LEFT JOIN tb_project_report as pr ON pr.project_code = allstore.a_pj_code
				LEFT JOIN (SELECT * 
					FROM tb_ipd_report_history 
					WHERE project_code = '$projectCode' 
					AND YEARWEEK(saved_date) = YEARWEEK(now())
					GROUP BY saved_user_id
					ORDER BY saved_date DESC) as prh
				ON prh.project_code = allstore.a_pj_code
				WHERE allstore.a_pj_code = '$projectCode'";
		$data = DB::select($query);     
		$currentWeekData = json_decode(json_encode($data),true);
		
		$reports = $this->GetCurrentWeekReports($projectCode);
		
		
						  //(SELECT hashtag_items FROM tb_project_report_history WHERE project_code = allstore.a_pj_code ORDER BY save_date DESC LIMIT 1) as hashtag_items,
		//$prevWeekData = $this->GetProjectReportOfPreviousWeek($projectCode);
		
		return(array("currentWeekData"=>$currentWeekData,"currentWeekReport"=>$reports));//,"prevWeekData"=>$prevWeekData
	}
	
	public function GetProjectReportByNameTemp($projectCode){
		
		$query = "SELECT allstore.a_pj_code,
				( CASE 
					  WHEN allstore.b_tmp_pj_name != '' THEN allstore.b_tmp_pj_name 
					  WHEN allstore.b_pj_name != '' AND b_pj_name NOT LIKE '%と同じ%' THEN  allstore.b_pj_name
					  ELSE allstore.a_pj_name END ) as pj_name,
				  allstore.b_hattyuusya as hattyuusya,
				  IF(allstore.b_sekkeisya1 IS NULL OR allstore.b_sekkeisya1='',allstore.a_sekkei,allstore.b_sekkeisya1) as sekkeisya,
				  IF(allstore.b_shiten IS NULL OR allstore.b_shiten='',allstore.a_shiten,allstore.b_shiten) as shiten,
				  IF(allstore.b_tijo IS NULL OR allstore.b_tijo='',allstore.a_tijo,allstore.b_tijo) as tijo,
				  IF(allstore.b_tika IS NULL OR allstore.b_tika='',allstore.a_tika,allstore.b_tika) as tika,
				  IF(allstore.b_nobe_menseki IS NULL OR allstore.b_nobe_menseki='',allstore.a_nobe_menseki,allstore.b_nobe_menseki) as nobe_menseki,
				  IF(allstore.b_kouzou IS NULL OR allstore.b_kouzou='',allstore.a_kouzou,allstore.b_kouzou) as kouzou,
				  allstore.b_sekou_syozoku as sekou_syozoku,
				  allstore.b_koutei_sekkei_model_start,
				  allstore.b_koutei_sekkei_model_end,
				  allstore.b_koutei_kakunin_sinsei_start,
				  allstore.b_koutei_kakunin_sinsei_end,
				  allstore.b_koutei_sekisan_model_tougou_start,
				  allstore.b_koutei_sekisan_model_tougou_end,
				  allstore.b_koutei_kouji_juujisya_kettei_start,
				  allstore.b_koutei_kouji_juujisya_kettei_end,
				  allstore.b_koutei_genba_koutei_kettei_start,
				  allstore.b_koutei_genba_koutei_kettei_end,
				  allstore.b_koutei_kouji_start,
				  allstore.b_koutei_kouji_end,
				  pr.*,prh.*
				  
				FROM tb_allstore_info as allstore
				LEFT JOIN tb_project_report as pr ON pr.project_code = allstore.a_pj_code
				LEFT JOIN (SELECT * 
					FROM tb_ipd_report_history 
					WHERE project_code = '$projectCode' 
					AND YEARWEEK(saved_date) = YEARWEEK(now())
					GROUP BY saved_user_id
					ORDER BY saved_date DESC) as prh
				ON prh.project_code = allstore.a_pj_code
				WHERE allstore.a_pj_code = '$projectCode'";
		$data = DB::select($query);     
		$currentWeekData = json_decode(json_encode($data),true);
		
		$reports = $this->GetCurrentWeekReports($projectCode);
		
		
						  //(SELECT hashtag_items FROM tb_project_report_history WHERE project_code = allstore.a_pj_code ORDER BY save_date DESC LIMIT 1) as hashtag_items,
		//$prevWeekData = $this->GetProjectReportOfPreviousWeek($projectCode);
		
		return(array("currentWeekData"=>$currentWeekData,"currentWeekReport"=>$reports));//,"prevWeekData"=>$prevWeekData
	}
	
	function GetCurrentWeekReports($projectCode){
		// $tbl_list = array("tb_ipd_report_history","tb_bukachoukai_1bu_history","tb_bukachoukai_2bu_history","tb_bukachoukai_3bu_history","tb_bukachoukai_gijutsukanribu_history",
		// 				"tb_bukachoukai_setsubi_shinkou_1bu_history","tb_bukachoukai_setsubi_shinkou_2bu_history","tb_bukachoukai_setsubi_shinkou_3bu_history","tb_bukachoukai_doboku_shinkou_history","tb_kouzousekkei_history",
		// 				"tb_ishousekkei_history","tb_mitsumori_sekisanbu_history","tb_renewal_history","tb_setsubisekkei_history","tb_hinshitsukanribu_history",
		// 				"tb_koujibu_history","tb_seisan_gijutsubu_history","tb_seisan_sekkeibu_history","tb_kouji_jimusho_history","tb_kouji_jimusho_setsubi_history");
		$report_category = $this->GetReportCategory();				
		$result = array();					
		foreach($report_category as $row){
			$tblName = "tb_".$row["default_name"]."_history";
			$reportSelect= "SELECT *,
								(SELECT saved_date
								FROM ".$tblName."
								WHERE YEARWEEK(saved_date) = YEARWEEK(result.saved_date,0) 
								AND project_code = '$projectCode' 
								AND saved_user_id = result.saved_user_id 
								ORDER BY saved_date LIMIT 1) as firstly_saved_date
							FROM
								(SELECT * 
									FROM
										(SELECT *, 
											(SELECT CONCAT(first_name,last_name) FROM tb_personal WHERE id = saved_user_id)as saved_user_name
										FROM ".$tblName." 
										WHERE project_code = '$projectCode' AND saved_user_id != 0 ".
										//AND YEARWEEK(saved_date) = YEARWEEK(now()
										" ORDER BY saved_date DESC)
									temp
									GROUP BY temp.saved_user_id) 
							result
							ORDER BY firstly_saved_date";//AND YEARWEEK(saved_date) = YEARWEEK(now()),AND report != '' 
		// return $reportSelect;
			$report = DB::select($reportSelect);     
			$res = json_decode(json_encode($report),true);
			
			$report_key = str_replace("tb_", "", $tblName);
			$report_key = str_replace("_history", "", $report_key);
			$result[$report_key] = $res;
		}
	
		
		return $result;
		
	}
	
	
	function GetCurrentWeekReportHistory($projectCode,$tblName,$order){
		try{
		  $order_str = '';
		  if(!empty($order)){
		  	$order_str=implode(",",$order);;
		  }
		  $query = "SELECT *,(SELECT CONCAT(first_name,last_name) FROM tb_personal WHERE id = temp.saved_user_id) as name
					FROM 
					(SELECT *
						FROM ".$tblName." 
						WHERE project_code = '$projectCode' 
						AND YEARWEEK(saved_date) = YEARWEEK(now())
						ORDER BY field(saved_user_id,".$order_str."),saved_date DESC)temp";
  
		  $data = DB::select($query);
		  return json_decode(json_encode($data),true);
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}

	function GetAllProjectReport($order_status){
	  //allstore.a_pj_name,allstore.b_pj_name,allstore.b_tmp_pj_name,
	  $order = "";
	  if($order_status == "降順")
		$order = " ORDER BY temp.tantousha DESC ,temp.pj_name ASC ";
	  else if($order_status == "branch_order")
		$order = " ORDER BY FIELD(temp.branch,'台湾支店','札幌支店','神戸支店','九州支店','広島支店','四国支店','神戸支店','京都支店','名古屋支店','大阪本店','東京本店')DESC ,temp.pj_name ASC ";
	  else
		$order = " ORDER BY temp.tantousha ,temp.pj_name ASC ";

	  $query = "SELECT temp.* FROM 
					(SELECT rep.*,
					( CASE 
					  WHEN allstore.b_tmp_pj_name != '' THEN allstore.b_tmp_pj_name 
					  WHEN allstore.b_pj_name != '' AND b_pj_name NOT LIKE '%と同じ%' THEN  allstore.b_pj_name
					  ELSE allstore.a_pj_name END ) as pj_name,
					allstore.a_pj_code,allstore.a_kouji_type,
					IF(allstore.a_shiten IS NULL,allstore.b_shiten,allstore.a_shiten) as branch,
					IF(allstore.a_sekou_basyo IS NULL,allstore.b_sekou_basyo,allstore.a_sekou_basyo) as address,
					b_ipd_center_tantou as tantousha
					FROM tb_allstore_info as allstore
					LEFT JOIN tb_project_report rep ON rep.project_code = allstore.a_pj_code
					WHERE allstore.display_report_flag = 1) as temp
				  ".$order;

	  $data = DB::select($query);
	  return json_decode(json_encode($data),true);
	}
	
	
	function GetProjectSpecialFeature($projectCode){
	   try{
		  $query = "SELECT special_feature_info FROM tb_project_report WHERE project_code = '$projectCode'";
  
		  $data = DB::select($query);
		  return json_decode(json_encode($data),true);
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	function GetFileLink($projectCode){
	   try{
		  $query = "SELECT execution_plan_file_link,held_meeting_file_link,report_avaliable_file_link,bim360_report_file_link FROM tb_project_report WHERE project_code = '$projectCode'";
  
		  $data = DB::select($query);
		  return json_decode(json_encode($data),true);
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	function GetHashtags(){
		try{
		  $query = "SELECT * FROM tb_hashtags ORDER BY used_count DESC";
  
		  $data = DB::select($query);
		  return json_decode(json_encode($data),true);
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	function SaveReportFileLink($projectCode,$projectName,$icon_name,$file_link){
	  try{
		
		  $query = "";
		  if($icon_name == "実"){
			$query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date,execution_plan_file_link)
					SELECT MAX(id)+1,'$projectCode','$projectName',curdate(),'$file_link' FROM tb_project_report
					ON DUPLICATE KEY UPDATE 
					execution_plan_file_link = '$file_link'";
		  }else if($icon_name == "キ"){
			 $query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date,held_meeting_file_link)
					SELECT MAX(id)+1,'$projectCode','$projectName',curdate(),'$file_link' FROM tb_project_report
					ON DUPLICATE KEY UPDATE 
					held_meeting_file_link = '$file_link'";
		  }else if($icon_name == "報"){
			 $query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date,report_avaliable_file_link)
					SELECT MAX(id)+1,'$projectCode','$projectName',curdate(),'$file_link' FROM tb_project_report
					ON DUPLICATE KEY UPDATE 
					report_avaliable_file_link = '$file_link'";
		  }else if($icon_name == "登"){
			$query = "INSERT INTO tb_project_report (id,project_code,project_name,save_date,bim360_report_file_link)
					SELECT MAX(id)+1,'$projectCode','$projectName',curdate(),'$file_link' FROM tb_project_report
					ON DUPLICATE KEY UPDATE 
					bim360_report_file_link = '$file_link'";
		  }
		  
  
		  DB::insert($query);
		  return "success";
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	function UpdateImageType($projectCode,$elementId,$selectedType){
	   try{
		   $query = "";
		   if($elementId == "img1_type"){
			   $query = "UPDATE tb_project_report SET img1_type = '$selectedType' WHERE project_code = '$projectCode'";
		   }
		   
		   if($elementId == "img2_type"){
			   $query = "UPDATE tb_project_report SET img2_type = '$selectedType' WHERE project_code = '$projectCode'";
		   }
		   
		   if($elementId == "img3_type"){
			   $query = "UPDATE tb_project_report SET img3_type = '$selectedType' WHERE project_code = '$projectCode'";
		   }

		  $data = DB::update($query);
		  return "success";
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	function UpdateReportisShowFlag($param_id,$flag,$tblName){
	   try{
		  $query = "UPDATE $tblName SET isShow = $flag WHERE id = $param_id";
		  $data = DB::update($query);
		  return "success";
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	function AddReportCategory($newReportCategory){
		try{

			 $selectQuery = "SELECT MAX(id) as id FROM tb_report_category";
	         $data = DB::select($selectQuery);

			 $result = json_decode(json_encode($data),true);
			 //return $data;
			 $last_category_number = 0;
			 if(!empty($result))
			  $last_category_number = $result[0]['id']+1;
			  
			$default_tbl_name = "tb_report_category".$last_category_number."_history";
			$val = DB::select("SHOW tables LIKE '".$default_tbl_name."'");//check table exist
			// return $val;
			if(empty($val))
			{
				Schema::create($default_tbl_name, function (Blueprint $table) {
		            $table->bigInteger('id')->autoIncrement();
		            $table->string('project_code', 255)->default(null);
		            $table->text('report')->default(null);
		            $table->text('report_with_style')->default(null);
		            $table->string('hashtags',1000)->default(null);
		            $table->integer('saved_user_id')->default(null);
		            $table->dateTime('saved_date')->default(null);
		            $table->tinyInteger('isShow')->default(1);
		            $table->engine = 'InnoDB';
		            $table->charset = 'utf8';
		            $table->collation = 'utf8_general_ci';
	        	});
			}
			
	        
	        $loginUserId = session('login_user_id'); 
			$date_time = date("Y-m-d H:i:s");
		    $default_name = "report_category".$last_category_number;
	        $insertQuery = "INSERT INTO tb_report_category(id,name,default_name,saved_user_id,saved_date)
	        			SELECT COALESCE(MAX(id),0)+1,'$newReportCategory','$default_name',$loginUserId,'$date_time' FROM tb_report_category";
	        DB::insert($insertQuery);			
	        
	         return "success";
		}catch(Exception $e){
			return $e->getMessage();
		}
		
	
	}
	
	function GetReportCategory(){
		try{
		  $query = "SELECT * FROM tb_report_category";
  
		  $data = DB::select($query);
		  return json_decode(json_encode($data),true);
		}catch(Exception $e){
		  return $e->getMessage();
		}
	}
	
	
}
