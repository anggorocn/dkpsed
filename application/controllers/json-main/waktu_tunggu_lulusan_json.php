<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class waktu_tunggu_lulusan_json extends CI_Controller {

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
		$this->load->model("base/WaktuTungguLulusan");

		$set= new WaktuTungguLulusan();

		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = "true";
			}
		}
		
		$cekquery= $this->input->get("c");
		$reqId= $this->input->get('reqId');
		$reqTipe= $this->input->get('reqTipe');
		// print_r($columnsDefault);exit;

		$displaystart= -1;
		$displaylength= -1;

		$arrinfodata= [];

		$userpegawaimode= $this->userpegawaimode;
		$adminuserid= $this->adminuserid;

		// $sOrder = "";
		// $set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement." AND (UPPER(B.GOL_RUANG) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(TEMPAT_LAHIR) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NIP_LAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NIP_BARU) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(AMBIL_FORMAT_NIP_BARU(NIP_BARU)) LIKE '%".strtoupper($_GET['sSearch'])."%' ) ", $sOrder);

		$statement="and tingkatan='".$reqTipe."'";
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
				else if ($valkey == "ts_1"||$valkey == "ts_2"||$valkey == "ts_3"||$valkey == "ts_4"||$valkey == "ts_5"||$valkey == "ts_6"||$valkey == "ts" )
				{
					if($set->getField($valkey)==''||$set->getField($valkey)=='0'){
						$row[$valkey]= '<i class="fa fa-close" aria-hidden="true" style="color:red"></i>';
					}else{
						$row[$valkey]= strtoupper($set->getField($valkey));
					}
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
		$this->load->model("base/WaktuTungguLulusan");

		$reqId= $this->input->post("reqId");
		$reqRowId= $this->input->post("reqRowId");
		$reqMode= $this->input->post("reqMode");

		$reqTahun= $this->input->post("reqTahun");
		$reqJumlah= $this->input->post("reqJumlah");
		$reqJumlahTerlacak= $this->input->post("reqJumlahTerlacak");
		$reqJumlahDipesan= $this->input->post("reqJumlahDipesan");
		$reqWaktu11= $this->input->post("reqWaktu11");
		$reqWaktu12= $this->input->post("reqWaktu12");
		$reqWaktu13= $this->input->post("reqWaktu13");
		$reqWaktu21= $this->input->post("reqWaktu21");
		$reqWaktu22= $this->input->post("reqWaktu22");
		$reqWaktu23= $this->input->post("reqWaktu23");
		$reqWaktu31= $this->input->post("reqWaktu31");
		$reqWaktu32= $this->input->post("reqWaktu32");
		$reqWaktu33= $this->input->post("reqWaktu33");
		$reqStandar= $this->input->post("reqStandar");
		$reqJenjang= $this->input->post("reqJenjang");
		
		$set = new WaktuTungguLulusan();
		$set->setField("waktu_tunggu_lulusan_id", $reqId);

		$set->setField("tahun", $reqTahun);
		$set->setField("jumlah", $reqJumlah);
		$set->setField("jumlah_terlacak", $reqJumlahTerlacak);
		$set->setField("jumlah_dipesan", $reqJumlahDipesan);
		$set->setField("waktu1_1", $reqWaktu11);
		$set->setField("waktu1_2", $reqWaktu12);
		$set->setField("waktu1_3", $reqWaktu13);
		$set->setField("waktu2_1", $reqWaktu21);
		$set->setField("waktu2_2", $reqWaktu22);
		$set->setField("waktu2_3", $reqWaktu23);
		$set->setField("waktu3_1", $reqWaktu31);
		$set->setField("waktu3_2", $reqWaktu32);
		$set->setField("waktu3_3", $reqWaktu33);
		$set->setField("standar", $reqStandar);
		$set->setField("tingkatan", $reqJenjang);

		$adminusernama= $this->adminuserloginnama;
		$userSatkerId= $this->adminsatkerid;

		$reqSimpan= "";
		if ($reqId == "")
		{
			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId= $set->id;
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