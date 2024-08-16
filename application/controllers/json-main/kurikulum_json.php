<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class kurikulum_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		//kauth

		$CI =& get_instance();
		$configdata= $CI->config;
        $configvlxsessfolder= $configdata->config["vlxsessfolder"];

        $redirectlogin= "";
        if(!empty($this->session->userdata("adminuserid".$configvlxsessfolder)))
        {
        	$redirectlogin= $this->session->userdata("adminuserid".$configvlxsessfolder);
        }

        if(empty($redirectlogin))
		{
			redirect('login');
		}

		$this->adminuserid= $this->session->userdata("adminuserid".$configvlxsessfolder);
		$this->adminuserloginnama= $this->session->userdata("adminuserloginnama".$configvlxsessfolder);
		$this->adminsatkerid= $this->session->userdata("adminsatkerid".$configvlxsessfolder);
	}

	function treetable()
	{
		$reqUnitKerjaId = $this->input->get("reqUnitKerjaId");

		if ($reqUnitKerjaId == "")
			$reqUnitKerjaId = $this->CABANG_ID;

		// echo $reqUnitKerjaId;exit;

		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 50;
		$id   = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$offset = ($page - 1) * $rows;

		$reqPencarian = trim($this->input->get("reqPencarian"));
		$reqMode = $this->input->get("reqMode");

		$this->load->model("base/Kurikulum");

		$set = new Kurikulum();

		if ($reqPencarian == "")
		{
			$arrStatement = array("COALESCE(NULLIF(KODE_PARENT, ''), '0')" => 0);
			// $arrStatement = array("COALESCE(NULLIF(KODE_PARENT, ''), '0')" => $reqUnitKerjaId, "NOT set_ID_PARENT" => "SATKER", "set_ID_PARENT" => $reqUnitKerjaId, "STATUS_AKTIF" => '1');
		}
		else {
			// $arrStatement = array("NOT set_ID_PARENT" => "SATKER", "set_ID_PARENT" => $reqUnitKerjaId, "STATUS_AKTIF" => '1');
			$statement = " AND (UPPER(NAMA) LIKE '%" . strtoupper($reqPencarian) . "%' OR UPPER(JABATAN) LIKE '%" . strtoupper($reqPencarian) . "%' OR UPPER(NAMA_PEGAWAI) LIKE '%" . strtoupper($reqPencarian) . "%' OR UPPER(NIP) LIKE '%" . strtoupper($reqPencarian) . "%') ";
		}


		$rowCount = $set->getCountByParams($arrStatement, $statement . $statement_privacy);
		$set->selectByParams($arrStatement, $rows, $offset, $statement . $statement_privacy, " ORDER BY kurikulum_id ASC ");
		// echo $set->query;exit;
		$i = 0;
		$items = array();
		while ($set->nextRow()) {
			$this->TREETABLE_COUNT++;
			
			$check =$set->getField("USER_BANTU");

			$row['id'] = coalesce($set->getField("KODE_SO"), $set->getField("KURIKULUM_ID"));
			$row['parentId'] = $set->getField("KODE_PARENT");
			$row['text'] = $set->getField("NAMA");
			$row['set_ID']	= $set->getField("KURIKULUM_ID");
			$row['set_ID_PARENT']	= $set->getField("KURIKULUM_ID_PARENT");
			$row['nama'] = '<b>'.$set->getField("NAMA").'</b>';
			$idchild="'".$set->getField("KURIKULUM_ID")."'";
			$id="''";
			$row['aksi'] = '
			<button class="btn btn-light-primary" onclick="addchild('.$idchild.')"><i class="fa fa-plus" aria-hidden="true"></i></button>
			<button class="btn btn-light-warning" onclick="updatechild( 0,'.$idchild.')"><i class="fa fa-pen" aria-hidden="true"></i></button>
			';
			if(!empty($check))
			{
				$row['NAMA_SATKER']	= $set->getField("NAMA").' - '.' Ada User Bantu';
			}
			else
			{
				$row['NAMA_SATKER']	= $set->getField("NAMA");
			}
			
			$row['NAMA_PEGAWAI'] = $set->getField("NAMA_PEGAWAI")." (".$set->getField("NIP").")";
			$row['JABATAN'] = $set->getField("JABATAN");
			$row['JABATAN_INFO'] = $set->getField("JABATAN");
			$row['NIP'] = $set->getField("NIP");
			$row['KODE_SURAT'] = $set->getField("KODE_SURAT");
			$row['KELOMPOK_JABATAN'] = $set->getField("KELOMPOK_JABATAN");
			$row['STATUS_AKTIF']= $set->getField("STATUS_AKTIF");
			$row['STATUS_AKTIF_DESC']= $set->getField("STATUS_AKTIF_DESC");
			$row['LINK_URL']= $set->getField("LINK_URL");
			$row['LINK_URL_PEGAWAI']= $set->getField("LINK_URL_PEGAWAI");

			if (trim($reqPencarian) == "") {
				$row['state'] = $this->has_child($row['id']);
				$row['children'] = $this->children($set->getField("KODE_SO"), $set->getField("set_ID_PARENT"));
			}
			$i++;
			array_push($items, $row);
			unset($row);

		}

		$result["rows"] = $items;
		$result["total"] = $this->TREETABLE_COUNT;

		echo json_encode($result);
	}

	function children($id, $satkerId)
	{
		$this->load->model("Kurikulum");
		$set = new Kurikulum();
		$tot_sks=0;

		$arrStatement = array("COALESCE(NULLIF(KODE_PARENT, ''), '0')" => $id);

		$rowCount = $set->getCountByParams($arrStatement, $statement . $statement_privacy);
		$set->selectByParams($arrStatement, $rows, $offset, $statement . $statement_privacy, " ORDER BY kurikulum_id ASC ");
		// echo $set->query;exit;
		$i = 0;

		$items = array();
		while ($set->nextRow()) {
			$this->TREETABLE_COUNT++;
			$check =$set->getField("USER_BANTU");
			$row['id']				= coalesce($set->getField("KODE_SO"), $set->getField("set_ID"));
			$row['parentId']		= $set->getField("KODE_PARENT");
			$row['text']			= $set->getField("NAMA");
			$row['no']			= $i+1;
			$row['nama']			= $set->getField("NAMA");
			$row['kode']			= $set->getField("kode");
			$row['sks']			= $set->getField("sks");

			$id="'".$set->getField("KURIKULUM_ID")."'";
			$idparent="'".$set->getField("KURIKULUM_ID_PARENT")."'";
			$row['aksi']			= '
				<button class="btn btn-light-warning" onclick="updatechild( '.$idparent.','.$id.')"><i class="fa fa-pen" aria-hidden="true"></i></button>
					<button class="btn btn-light-danger" id="btnUbahData"><i class="fa fa-trash" aria-hidden="true"></i></button>
				';
			$row['keterangan']			= $set->getField("keterangan");
			$state = $this->has_child($row['id']);


			$row['state'] 			= $state;
			if ($state)
				$row['children'] 		= $this->children($set->getField("KODE_SO"), $satkerId);

			$i++;
			$tot_sks= $tot_sks+ coalesce($set->getField('sks'),0);
			array_push($items, $row);
			unset($row);
		}

			$row['nama']			= 'TOTAL';
			$row['sks']=$tot_sks;
			array_push($items, $row);
			unset($row);

		return $items;
	}

	function has_child($id)
	{
		$this->load->model("Kurikulum");
		$set = new Kurikulum();
		$adaData = $set->getCountByParams(array("COALESCE(NULLIF(KODE_PARENT, ''), '0')" => $id));
		return $adaData > 0 ? true : false;
	}

	function add()
	{
		$this->load->model("base/Kurikulum");

		$reqId= $this->input->post("reqId");
		$reqIdParent= $this->input->post("reqIdParent");

		$reqNama= $this->input->post("reqNama");
		$reqSks= $this->input->post("reqSks");
		$reqKeterangan= $this->input->post("reqKeterangan");
		$reqKode= $this->input->post("reqKode");
		$reqIdParent= $this->input->post("reqIdParent");
		if ($reqIdParent == ""){
			$reqIdParent= '0';
		}

		$set = new Kurikulum();
		$set->setField("KODE_SO", $reqId);
		$set->setField("KODE_PARENT", $reqIdParent);
		$set->setField("NAMA", $reqNama);
		$set->setField("KURIKULUM_ID", $reqId);
		$set->setField("KURIKULUM_ID_PARENT", $reqIdParent);
		$set->setField("SKS", $reqSks);
		$set->setField("KETERANGAN", $reqKeterangan);
		$set->setField("KODE", $reqKode);
		if ($reqId == "")
		{
			$setMax = new Kurikulum();
			$setMax->selectByParamsMaxHead(array('kurikulum_id_parent'=>$reqIdParent));
			$setMax->firstRow();
			$rowCount= $setMax->getField('max');

			if($rowCount==''){
				$rowCount=0;
			}

			if($reqIdParent=='0'){
				$reqId=sprintf("%02d", $rowCount+1);		
			}
			else{
				$rowCount=substr($rowCount,2);
				$reqId=$reqIdParent.sprintf("%02d", $rowCount+1);		
			}

			$set->setField("KURIKULUM_ID", $reqId);
			$set->setField("KODE_SO", $reqId);
			
			if($set->insert())
			{
				$reqSimpan= 1;
			}
		}
		else
		{	
			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		if($reqSimpan == 1)
		{
			echo json_response(200, $reqId."-Data berhasil disimpan.");
		}
		else
		{
			echo json_response(400, "Data gagal disimpan");
		}
				
	}
}
?>