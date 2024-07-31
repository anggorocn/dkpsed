<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class prestasi_mahasiswa_json extends CI_Controller {

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

	function json()
	{
		ini_set('memory_limit', '-1');
		$this->load->model("base/PrestasiMahasiswa");

		$set= new PrestasiMahasiswa();

		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = "true";
			}
		}
		$reqId = $this->input->get("reqId");
		$cekquery= $this->input->get("c");
		// print_r($columnsDefault);exit;

		$displaystart= -1;
		$displaylength= -1;

		$arrinfodata= [];

		$userpegawaimode= $this->userpegawaimode;
		$adminuserid= $this->adminuserid;

		// $sOrder = "";
		// $set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND (UPPER(B.GOL_RUANG) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(TEMPAT_LAHIR) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NIP_LAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NIP_BARU) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(AMBIL_FORMAT_NIP_BARU(NIP_BARU)) LIKE '%".strtoupper($_GET['sSearch'])."%' ) ", $sOrder);

		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement, $sOrder);
		
		if(!empty($cekquery)){
			echo $set->query;exit;
		}

		while ($set->nextRow()) 
		{
			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
				{
					$row[$valkey]= "1";
				}
				else if ($valkey == "nama")
				{
					$val="'app/loadurl/main/lihat_pdf_singel?reqId=".$set->getField('prestasi_id')."&reqFile=prestasi'";
					// $row[$valkey]= '<a href="app/index/lihat_pdf">'.$set->getField($valkey).'</a>';
					$row[$valkey]= '<a style="cursor: pointer" href="#" onclick="openAdd('.$val.');  return false;">'.strtoupper($set->getField($valkey)).'</a>';
				}
				else
				{	
					$row[$valkey]= strtoupper($set->getField($valkey));	
				}
			}
			array_push($arrinfodata, $row);
		}

		// get all raw data
		$alldata = $arrinfodata;
		// print_r($alldata);exit;

		$data = [];
		// internal use; filter selected columns only from raw data
		foreach ( $alldata as $d ) {
			// $data[] = filterArray( $d, $columnsDefault );
			$data[] = $d;
		}

		// count data
		$totalRecords = $totalDisplay = count( $data );

		// filter by general search keyword
		if ( isset( $_REQUEST['search'] ) ) {
			$data         = filterKeyword( $data, $_REQUEST['search'] );
			$totalDisplay = count( $data );
		}

		if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
			foreach ( $_REQUEST['columns'] as $column ) {
				if ( isset( $column['search'] ) ) {
					$data         = filterKeyword( $data, $column['search'], $column['data'] );
					$totalDisplay = count( $data );
				}
			}
		}

		// sort
		if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
			$column = $_REQUEST['order'][0]['column'];
			if(count($columnsDefault) - 2 == $column){}
			else
			{
				$dir    = $_REQUEST['order'][0]['dir'];
				usort( $data, function ( $a, $b ) use ( $column, $dir ) {
					$a = array_slice( $a, $column, 1 );
					$b = array_slice( $b, $column, 1 );
					$a = array_pop( $a );
					$b = array_pop( $b );

					if ( $dir === 'asc' ) {
						return $a > $b ? true : false;
					}

					return $a < $b ? true : false;
				} );
			}
		}

		// pagination length
		if ( isset( $_REQUEST['length'] ) ) {
			$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
		}

		// return array values only without the keys
		if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
			$tmp  = $data;
			$data = [];
			foreach ( $tmp as $d ) {
				$data[] = array_values( $d );
			}
		}

		$result = [
		    'recordsTotal'    => $totalRecords,
		    'recordsFiltered' => $totalDisplay,
		    'data'            => $data,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function add()
	{
		$this->load->model("base/ProfilDosenStatusKepegawaian");
		$this->load->model("base/Upload");

		$reqId= $this->input->post("reqId");
		$reqName= $this->input->post("reqName");

		$set = new ProfilDosenStatusKepegawaian();
		$set->setField("profil_dosen_status_kepegawaian_id", $reqId);
		$set->setField("NAMA", $reqName);

		$reqSimpan= "";
		if ($reqId == "")
		{

			if($set->insert())
			{
				$reqSimpan= 1;
			}

			$reqId= $set->id;

		}
		else
		{	
			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		if($reqSimpan==1){
			$reqKettable1= $this->input->post("reqKettable1");
			$reqFiletable1= $this->input->post("reqFiletable1");
			$reqFileExisttable1= $this->input->post("reqFileExisttable1");
			$reqidtable1= $this->input->post("reqidtable1");

			$reqKettable2= $this->input->post("reqKettable2");
			$reqFiletable2= $this->input->post("reqFiletable2");
			$reqFileExisttable2= $this->input->post("reqFileExisttable2");
			$reqidtable2= $this->input->post("reqidtable2");

			$reqKettable3= $this->input->post("reqKettable3");
			$reqFiletable3= $this->input->post("reqFiletable3");
			$reqFileExisttable3= $this->input->post("reqFileExisttable3");
			$reqidtable3= $this->input->post("reqidtable3");

			$reqKettable4= $this->input->post("reqKettable4");
			$reqFiletable4= $this->input->post("reqFiletable4");
			$reqFileExisttable4= $this->input->post("reqFileExisttable4");
			$reqidtable4= $this->input->post("reqidtable4");

			$reqKettable5= $this->input->post("reqKettable5");
			$reqFiletable5= $this->input->post("reqFiletable5");
			$reqFileExisttable5= $this->input->post("reqFileExisttable5");
			$reqidtable5= $this->input->post("reqidtable5");

			for($i=0;$i<count($reqKettable1);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable1[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable1[$i]);
				$setUpload->setField("TABLE_NAMA", 'profil_dosen_status_kepegawaian');
				$setUpload->setField("TABLE_FIELD", 'status');
				$setUpload->setField("TABLE_ID", $reqId);
				if ($reqidtable1[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}

			for($i=0;$i<count($reqKettable2);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable2[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable2[$i]);
				$setUpload->setField("TABLE_NAMA", 'profil_dosen_status_kepegawaian');
				$setUpload->setField("TABLE_FIELD", 'nidn');
				$setUpload->setField("TABLE_ID", $reqId);
				if ($reqidtable2[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}

			for($i=0;$i<count($reqKettable3);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable3[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable3[$i]);
				$setUpload->setField("TABLE_NAMA", 'profil_dosen_status_kepegawaian');
				$setUpload->setField("TABLE_FIELD", 'jabatan');
				$setUpload->setField("TABLE_ID", $reqId);
				if ($reqidtable3[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}

			for($i=0;$i<count($reqKettable4);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable4[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable4[$i]);
				$setUpload->setField("TABLE_NAMA", 'profil_dosen_status_kepegawaian');
				$setUpload->setField("TABLE_FIELD", 'status_akademis');
				$setUpload->setField("TABLE_ID", $reqId);
				if ($reqidtable4[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}

			for($i=0;$i<count($reqKettable5);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable5[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable5[$i]);
				$setUpload->setField("TABLE_NAMA", 'profil_dosen_status_kepegawaian');
				$setUpload->setField("TABLE_FIELD", 'perusahaan');
				$setUpload->setField("TABLE_ID", $reqId);
				if ($reqidtable5[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
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

	function delete()
	{
		$this->load->model("base/DaftarTabel");
		$set = new DaftarTabel();
		
		$reqRowId= $this->input->get('reqRowId');
		$reqMode= $this->input->get('reqMode');

		$set->setField("DIKLAT_FUNGSIONAL_ID", $reqRowId);
		$reqSimpan="";
		if($set->delete())
		{
			$reqSimpan=1;
		}

		if($reqSimpan == 1 )
		{
			echo json_response(200, 'Data berhasil dihapus');
		}
		else
		{
			echo json_response(400, 'Data gagal dihapus');
		}
	}
}
?>