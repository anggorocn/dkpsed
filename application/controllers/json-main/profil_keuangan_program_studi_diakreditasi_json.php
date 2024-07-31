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
			$row['set_ID']	= $set->getField("set_ID");
			$row['set_ID_PARENT']	= $set->getField("set_ID_PARENT");
			$row['NAMA'] = $set->getField("NAMA");
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
		$set->selectByParams($arrStatement, $rows, $offset, $statement . $statement_privacy, " ORDER BY profil_keuangan_prodi_id ASC ");
		// echo $set->query;exit;
		$i = 0;
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

		$items = array();
		while ($set->nextRow()) {
			$this->TREETABLE_COUNT++;
			$check =$set->getField("USER_BANTU");
			$row['id']				= coalesce($set->getField("KODE_SO"), $set->getField("set_ID"));
			$row['parentId']		= $set->getField("KODE_PARENT");
			$row['text']			= $set->getField("NAMA");
			$row['NAMA']			= $set->getField("NAMA");
			$row['pengelolah_ts_2']=numberToIna($set->getField('pengelolah_ts_2', false));
			$row['pengelolah_ts_1']=numberToIna($set->getField('pengelolah_ts_1',''));
			$row['pengelolah_ts']=numberToIna($set->getField('pengelolah_ts',''));
			$row['pengelolah_avg']=numberToIna($set->getField('pengelolah_avg',''));
			$row['prodi_ts_2']=numberToIna($set->getField('prodi_ts_2',''));
			$row['prodi_ts_1']=numberToIna($set->getField('prodi_ts_1',''));
			$row['prodi_ts']=numberToIna($set->getField('prodi_ts',''));
			$row['prodi_avg']=numberToIna($set->getField('prodi_avg',''));
			$row['prodi_ts_2_persen']=numberToIna($set->getField('prodi_ts_2_persen',''));
			$row['prodi_ts_1_persen']=numberToIna($set->getField('prodi_ts_1_persen',''));
			$row['prodi_ts_persen']=numberToIna($set->getField('prodi_ts_persen',''));
			$row['prodi_lain_ts_2_persen']=numberToIna($set->getField('prodi_lain_ts_2_persen',''));
			$row['prodi_lain_ts_1_persen']=numberToIna($set->getField('prodi_lain_ts_1_persen',''));
			$row['prodi_lain_persen']=numberToIna($set->getField('prodi_lain_persen',''));

			$state = $this->has_child($row['id']);


			$row['state'] 			= $state;
			if ($state)
				$row['children'] 		= $this->children($set->getField("KODE_SO"), $satkerId);

			$i++;
			$tot_pengelolah_ts_2= $tot_pengelolah_ts_2+ coalesce($set->getField('pengelolah_ts_2'),0);
			$tot_pengelolah_ts_1= $tot_pengelolah_ts_1+ coalesce($set->getField('pengelolah_ts_1'),0);
			$tot_pengelolah_ts= $tot_pengelolah_ts+ coalesce($set->getField('pengelolah_ts'),0);
			$tot_pengelolah_avg= $tot_pengelolah_avg+ coalesce($set->getField('pengelolah_avg'),0);
			$tot_prodi_ts_2= $tot_prodi_ts_2+ coalesce($set->getField('prodi_ts_2'),0);
			$tot_prodi_ts_1= $tot_prodi_ts_1+ coalesce($set->getField('prodi_ts_1'),0);
			$tot_prodi_ts= $tot_prodi_ts+ coalesce($set->getField('prodi_ts'),0);
			$tot_prodi_avg= $tot_prodi_avg+ coalesce($set->getField('prodi_avg'),0);
			$tot_prodi_ts_2_persen= $tot_prodi_ts_2_persen+ coalesce($set->getField('prodi_ts_2_persen'),0);
			$tot_prodi_ts_1_persen= $tot_prodi_ts_1_persen+ coalesce($set->getField('prodi_ts_1_persen'),0);
			$tot_prodi_ts_persen= $tot_prodi_ts_persen+ coalesce($set->getField('prodi_ts_persen'),0);
			$tot_prodi_lain_ts_2_persen= $tot_prodi_lain_ts_2_persen+ coalesce($set->getField('prodi_lain_ts_2_persen'),0);
			$tot_prodi_lain_ts_1_persen= $tot_prodi_lain_ts_1_persen+ coalesce($set->getField('prodi_lain_ts_1_persen'),0);
			$tot_prodi_lain_persen= $tot_prodi_lain_persen+ coalesce($set->getField('prodi_lain_persen'),0);

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
			$row['prodi_ts_2_persen']=numberToIna($tot_prodi_ts_2_persen,'');
			$row['prodi_ts_1_persen']=numberToIna($tot_prodi_ts_1_persen,'');
			$row['prodi_ts_persen']=numberToIna($tot_prodi_ts_persen,'');
			$row['prodi_lain_ts_2_persen']=numberToIna($tot_prodi_lain_ts_2_persen,'');
			$row['prodi_lain_ts_1_persen']=numberToIna($tot_prodi_lain_ts_1_persen,'');
			$row['prodi_lain_persen']=numberToIna($tot_prodi_lain_persen,'');
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
}
?>