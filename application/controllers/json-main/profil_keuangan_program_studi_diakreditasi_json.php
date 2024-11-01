<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class profil_keuangan_program_studi_diakreditasi_json extends CI_Controller {

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

		$this->load->model("base/ProfilKeuanganProgramStudiDiakreditasi");

		$set = new ProfilKeuanganProgramStudiDiakreditasi();

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
		$set->selectByParams($arrStatement, $rows, $offset, $statement . $statement_privacy, " ORDER BY profil_keuangan_prodi_id ASC ");
		// echo $set->query;exit;
		$i = 0;
		$items = array();
		while ($set->nextRow()) {
			$this->TREETABLE_COUNT++;
			
			$check =$set->getField("USER_BANTU");

			$row['id'] = coalesce($set->getField("KODE_SO"), $set->getField("set_ID"));
			$row['parentId'] = $set->getField("KODE_PARENT");
			$row['text'] = $set->getField("NAMA");
			$row['set_ID']	= $set->getField("profil_keuangan_prodi_id");
			$row['set_ID_PARENT']	= $set->getField("profil_keuangan_prodi_id_parent");
			$row['NAMA'] = $set->getField("NAMA");
			$idchild="'".$set->getField("profil_keuangan_prodi_id")."'";
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
		$this->load->model("ProfilKeuanganProgramStudiDiakreditasi");
		$set = new ProfilKeuanganProgramStudiDiakreditasi();

		$arrStatement = array("COALESCE(NULLIF(KODE_PARENT, ''), '0')" => $id);

		$rowCount = $set->getCountByParams($arrStatement, $statement . $statement_privacy);

		$tot_pengelolah_ts_2= 0;
		$tot_pengelolah_ts_1= 0;
		$tot_pengelolah_ts= 0;
		$tot_pengelolah_avg= 0;
		$tot_prodi_ts_2= 0;
		$tot_prodi_ts_1= 0;
		$tot_prodi_ts= 0;
		$tot_prodi_avg= 0;
		$tot_prodi_ts_2_persen= 0;
		$tot_prodi_ts_1_persen= 0;
		$tot_prodi_ts_persen= 0;
		$tot_prodi_lain_ts_2_persen= 0;
		$tot_prodi_lain_ts_1_persen= 0;
		$tot_prodi_lain_persen= 0;

		$set->selectByParams($arrStatement, $rows, $offset, $statement . $statement_privacy, " ORDER BY profil_keuangan_prodi_id ASC ");

		while ($set->nextRow()) {
			$tot_pengelolah_ts_2= $tot_pengelolah_ts_2+$set->getField('pengelolah_ts_2');
			$tot_pengelolah_ts_1= $tot_pengelolah_ts_1+$set->getField('pengelolah_ts_1');
			$tot_pengelolah_ts= $tot_pengelolah_ts+$set->getField('pengelolah_ts');
			$tot_prodi_ts_2= $tot_prodi_ts_2+$set->getField('prodi_ts_2');
			$tot_prodi_ts_1= $tot_prodi_ts_1+$set->getField('prodi_ts_1');
			$tot_prodi_ts= $tot_prodi_ts+$set->getField('prodi_ts');
		}

		$set->selectByParams($arrStatement, $rows, $offset, $statement . $statement_privacy, " ORDER BY profil_keuangan_prodi_id ASC ");
		// echo $set->query;exit;
		$i = 0;

		$items = array();
		while ($set->nextRow()) {
			$this->TREETABLE_COUNT++;
			$check =$set->getField("USER_BANTU");
			$row['id']				= coalesce($set->getField("KODE_SO"), $set->getField("set_ID"));
			$row['parentId']		= $set->getField("KODE_PARENT");
			$row['text']			= $set->getField("NAMA");
			$row['NAMA']			= $set->getField("NAMA");
			$id="'".$set->getField("profil_keuangan_prodi_id")."'";
			$idparent="'".$set->getField("profil_keuangan_prodi_id_parent")."'";
			$row['aksi']			= '
				<button class="btn btn-light-warning" onclick="updatechild( '.$idparent.','.$id.')"><i class="fa fa-pen" aria-hidden="true"></i></button>
				<button class="btn btn-light-danger" id="btnUbahData"><i class="fa fa-trash" aria-hidden="true"></i></button>
				';
			$row['pengelolah_ts_2']=numberToIna($set->getField('pengelolah_ts_2', false));
			$row['pengelolah_ts_1']=numberToIna($set->getField('pengelolah_ts_1',''));
			$row['pengelolah_ts']=numberToIna($set->getField('pengelolah_ts',''));
			$row['pengelolah_avg']=numberToIna($set->getField('pengelolah_avg',''));
			$row['prodi_ts_2']=numberToIna($set->getField('prodi_ts_2',''));
			$row['prodi_ts_1']=numberToIna($set->getField('prodi_ts_1',''));
			$row['prodi_ts']=numberToIna($set->getField('prodi_ts',''));
			$row['prodi_avg']=numberToIna($set->getField('prodi_avg',''));

			$prodi_ts_2_persen=($set->getField('pengelolah_ts_2')*100)/$tot_pengelolah_ts_2;
			$row['prodi_ts_2_persen']=number_format($prodi_ts_2_persen,2,",",".")." %";

			$prodi_ts_1_persen=($set->getField('pengelolah_ts_1')*100)/$tot_pengelolah_ts_1;
			$row['prodi_ts_1_persen']=number_format($prodi_ts_1_persen,2,",",".")." %";

			$prodi_ts_persen=($set->getField('pengelolah_ts')*100)/$tot_pengelolah_ts;
			$row['prodi_ts_persen']=number_format($prodi_ts_persen,2,",",".")." %";

			$prodi_lain_ts_2_persen=($set->getField('prodi_ts_2')*100)/$tot_prodi_ts_2;
			$row['prodi_lain_ts_2_persen']=number_format($prodi_lain_ts_2_persen,2,",",".")." %";

			$prodi_lain_ts_1_persen=($set->getField('prodi_ts_1')*100)/$tot_prodi_ts_1;
			$row['prodi_lain_ts_1_persen']=number_format($prodi_lain_ts_1_persen,2,",",".")." %";

			$prodi_lain_persen=($set->getField('prodi_ts')*100)/$tot_prodi_ts;
			$row['prodi_lain_persen']=number_format($prodi_lain_persen,2,",",".")." %";

			$state = $this->has_child($row['id']);


			$row['state'] 			= $state;
			if ($state)
				$row['children'] 		= $this->children($set->getField("KODE_SO"), $satkerId);

			$i++;
			array_push($items, $row);
			unset($row);
		}

			$row['NAMA']			= 'TOTAL';
			$row['pengelolah_ts_2']=numberToIna($tot_pengelolah_ts_2,'');
			$row['pengelolah_ts_1']=numberToIna($tot_pengelolah_ts_1,'');
			$row['pengelolah_ts']=numberToIna($tot_pengelolah_ts,'');
			$row['pengelolah_avg']=numberToIna($tot_pengelolah_avg,'');
			$row['prodi_ts_2']=numberToIna($tot_prodi_ts_2,'');
			$row['prodi_ts_1']=numberToIna($tot_prodi_ts_1,'');
			$row['prodi_ts']=numberToIna($tot_prodi_ts,'');
			$row['prodi_avg']=numberToIna($tot_prodi_avg,'');
			array_push($items, $row);
			unset($row);

		return $items;
	}

	function has_child($id)
	{
		$this->load->model("ProfilKeuanganProgramStudiDiakreditasi");
		$set = new ProfilKeuanganProgramStudiDiakreditasi();
		$adaData = $set->getCountByParams(array("COALESCE(NULLIF(KODE_PARENT, ''), '0')" => $id));
		return $adaData > 0 ? true : false;
	}

	function add()
	{
		$this->load->model("base/ProfilKeuanganProgramStudiDiakreditasi");

		$reqId= $this->input->post("reqId");
		$reqIdParent= $this->input->post("reqIdParent");

		$reqNama= $this->input->post("reqNama");
		$reqIdParent= $this->input->post("reqIdParent");
		if ($reqIdParent == ""){
			$reqIdParent= '0';
		}

		$reqPengelolahTS2= $this->input->post("reqPengelolahTS2");
		$reqPengelolahTS1= $this->input->post("reqPengelolahTS1");
		$reqPengelolahTS= $this->input->post("reqPengelolahTS");
		$reqProdiTS2= $this->input->post("reqProdiTS2");
		$reqProdiTS1= $this->input->post("reqProdiTS1");
		$reqProdiTS= $this->input->post("reqProdiTS");

		$set = new ProfilKeuanganProgramStudiDiakreditasi();
		$set->setField("KODE_SO", $reqId);
		$set->setField("KODE_PARENT", $reqIdParent);
		$set->setField("NAMA", $reqNama);
		$set->setField("profil_keuangan_prodi_id", $reqId);
		$set->setField("profil_keuangan_prodi_id_parent", $reqIdParent);

		$set->setField("pengelolah_ts_2", ValToNull($reqPengelolahTS2));
		$set->setField("pengelolah_ts_1", ValToNull($reqPengelolahTS1));
		$set->setField("pengelolah_ts", ValToNull($reqPengelolahTS));
		$set->setField("pengelolah_avg", ValToNull(($reqPengelolahTS2+$reqPengelolahTS1+$reqPengelolahTS)/3));
		$set->setField("prodi_ts_2", ValToNull($reqProdiTS2));
		$set->setField("prodi_ts_1", ValToNull($reqProdiTS1));
		$set->setField("prodi_ts", ValToNull($reqProdiTS));
		$set->setField("prodi_avg", ValToNull(($reqProdiTS2+$reqProdiTS1+$reqProdiTS)/3));

		if ($reqId == "")
		{
			$setMax = new ProfilKeuanganProgramStudiDiakreditasi();
			$setMax->selectByParamsMaxHead(array('profil_keuangan_prodi_id_parent'=>$reqIdParent));
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

			$set->setField("profil_keuangan_prodi_id", $reqId);
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