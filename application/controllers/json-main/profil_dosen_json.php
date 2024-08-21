
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class profil_dosen_json extends CI_Controller {

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
		$this->load->model("base/ProfilDosen");

		$set= new ProfilDosen();

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
				else if ($valkey == "NAMA_SHEET")
				{
					if($set->getField('STATUS')==1){
						// $icon='<i class="fa fa-folder" style="color:orange; font-size:18pt"></i>';
						$icon='<a href="app/page/'.$set->getField('PAGE').'"><i class="fa fa-folder" style="color:orange; font-size:18pt"></i></a>';
					}
					else{
						$icon='<i class="fa fa-close" style="color:red; font-size:18pt"></i>';
					}
					$row[$valkey]= 
					'<div class="row">
						<div class="col-md-8">
							'.$set->getField('NAMA_SHEET').'
						</div>
						<div class="col-md-4">
							'.$icon.'
						</div>
					</div>';
				}
				else
				{
					$row[$valkey]= $set->getField($valkey);
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
		$this->load->model("base/ProfilDosen");
		$this->load->model("base/Upload");

		$reqId= $this->input->post('reqId');
		$reqName= $this->input->post('reqName');
		$reqStatus= $this->input->post('reqStatus');
		$reqNidn= $this->input->post('reqNidn');
		$reqJabatan= $this->input->post('reqJabatan');
		$reqStatusAkademik= $this->input->post('reqStatusAkademik');
		$reqPerusahaan= $this->input->post('reqPerusahaan');
		$reqMagister= $this->input->post('reqMagister');
		$reqDoktor= $this->input->post('reqDoktor');
		$reqBidang= $this->input->post('reqBidang');
		$reqSertifikat= $this->input->post('reqSertifikat');
		$reqTs2= $this->input->post('reqTs2');
		$reqTs1= $this->input->post('reqTs1');
		$reqTS= $this->input->post('reqTS');
		$reqAvg= $this->input->post('reqAvg');
		$reqTs2Lain= $this->input->post('reqTs2Lain');
		$reqTs1Lain= $this->input->post('reqTs1Lain');
		$reqTsLain= $this->input->post('reqTsLain');
		$reqAvgLain= $this->input->post('reqAvgLain');
		$reqTotalAvg= $this->input->post('reqTotalAvg');
		$reqPSAkreditasi= $this->input->post('reqPSAkreditasi');
		$reqPSLainDalam= $this->input->post('reqPSLainDalam');
		$reqPSLainLuar= $this->input->post('reqPSLainLuar');
		$reqPenelitian= $this->input->post('reqPenelitian');
		$reqPKM= $this->input->post('reqPKM');
		$reqPenunjang= $this->input->post('reqPenunjang');
		$reqSKS= $this->input->post('reqSKS');
		$reqAvgSKS= $this->input->post('reqAvgSKS');
		$reqGoogleSchollar= $this->input->post('reqGoogleSchollar');
		$reqDiploma= $this->input->post('reqDiploma');
		$reqSarjana= $this->input->post('reqSarjana');

		$set = new ProfilDosen();
		$set->setField('dosen_id', $reqId);
		$set->setField('nama', $reqName);
		$set->setField('status', $reqStatus);
		$set->setField('nidn', $reqNidn);
		$set->setField('jabatan_akademik', $reqJabatan);
		$set->setField('status_akademisi', $reqStatusAkademik);
		$set->setField('perusahaan', $reqPerusahaan);
		$set->setField('pendidikan_magister', $reqMagister);
		$set->setField('pendidikan_spesialis', $reqDoktor);
		$set->setField('pendidikan_diploma', $reqDiploma);
		$set->setField('pendidikan_sarjana', $reqSarjana);
		$set->setField('bidang_keahlian', $reqBidang);
		$set->setField('sertifikat_pendidikan', $reqSertifikat);
		$set->setField('ts_2', $reqTs2);
		$set->setField('ts_1', $reqTs1);
		$set->setField('ts', $reqTS);
		$set->setField('avg', $reqAvg);
		$set->setField('ts_2_lain', $reqTs2Lain);
		$set->setField('ts_1_lain', $reqTs1Lain);
		$set->setField('ts_lain', $reqTsLain);
		$set->setField('avg_lain', $reqAvgLain);
		$set->setField('avg_total', $reqTotalAvg);
		$set->setField('ps_diakreditasi', $reqPSAkreditasi);
		$set->setField('ps_lain_dalam', $reqPSLainDalam);
		$set->setField('ps_lain_luar', $reqPSLainLuar);
		$set->setField('penelitian', $reqPenelitian);
		$set->setField('pkm', $reqPKM);
		$set->setField('penunjang', $reqPenunjang);
		$set->setField('sks', $reqSKS);
		$set->setField('avg_sks', $reqAvgSKS);
		$set->setField('google_scholar', $reqGoogleSchollar);
		
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

		if($reqSimpan==1){
			$folderPath = "uploads/".$reqId;

			// Cek apakah folder sudah ada atau belum
			if (!file_exists($folderPath)) {
			    // Membuat folder jika belum ada
			    mkdir($folderPath, 0777, true);
			}
			// print_r($_FILES["reqFileStatus"]);exit;

			if (!empty($_FILES["reqFileStatus"]["type"])) {
				uploaddata($reqId,'status',$_FILES["reqFileStatus"]);
			}

			if (!empty($_FILES["reqFileNidn"]["type"])) {
				uploaddata($reqId,'nidn',$_FILES["reqFileNidn"]);
			}

			if (!empty($_FILES["reqFileJabatan"]["type"])) {
				uploaddata($reqId,'jabatan',$_FILES["reqFileJabatan"]);
			}

			if (!empty($_FILES["reqFileAkademisi"]["type"])) {
				uploaddata($reqId,'akademisi',$_FILES["reqFileAkademisi"]);
			}

			if (!empty($_FILES["reqFilePerusahaan"]["type"])) {
				uploaddata($reqId,'perusahaan',$_FILES["reqFilePerusahaan"]);
			}

			if (!empty($_FILES["reqFileMagister"]["type"])) {
				uploaddata($reqId,'magister',$_FILES["reqFileMagister"]);
			}

			if (!empty($_FILES["reqFileDoktor"]["type"])) {
				uploaddata($reqId,'doktor',$_FILES["reqFileDoktor"]);
			}

			if (!empty($_FILES["reqFileDiploma"]["type"])) {
				uploaddata($reqId,'diploma',$_FILES["reqFileDiploma"]);
			}

			if (!empty($_FILES["reqFileSarjana"]["type"])) {
				uploaddata($reqId,'sarjana',$_FILES["reqFileSarjana"]);
			}

			if (!empty($_FILES["reqFileBidang"]["type"])) {
				uploaddata($reqId,'bidang',$_FILES["reqFileBidang"]);
			}

			if (!empty($_FILES["reqFileSertifikat"]["type"])) {
				uploaddata($reqId,'sertifikat',$_FILES["reqFileSertifikat"]);
			}

			if (!empty($_FILES["reqFileTs2"]["type"])) {
				uploaddata($reqId,'ts2',$_FILES["reqFileTs2"]);
			}

			if (!empty($_FILES["reqFileTs1"]["type"])) {
				uploaddata($reqId,'ts1',$_FILES["reqFileTs1"]);
			}

			if (!empty($_FILES["reqFileTS"]["type"])) {
				uploaddata($reqId,'ts',$_FILES["reqFileTS"]);
			}

			if (!empty($_FILES["reqFileAvg"]["type"])) {
				uploaddata($reqId,'rataratats',$_FILES["reqFileAvg"]);
			}

			if (!empty($_FILES["reqFileTs2Lain"]["type"])) {
				uploaddata($reqId,'ts2lain',$_FILES["reqFileTs2Lain"]);
			}

			if (!empty($_FILES["reqFileTs1Lain"]["type"])) {
				uploaddata($reqId,'ts1lain',$_FILES["reqFileTs1Lain"]);
			}

			if (!empty($_FILES["reqFileTsLain"]["type"])) {
				uploaddata($reqId,'tslain',$_FILES["reqFileTsLain"]);
			}

			if (!empty($_FILES["reqFileAvgLain"]["type"])) {
				uploaddata($reqId,'rataratatslain',$_FILES["reqFileAvgLain"]);
			}

			if (!empty($_FILES["reqFileTotalAvg"]["type"])) {
				uploaddata($reqId,'totalrataratats',$_FILES["reqFileTotalAvg"]);
			}

			$reqKettable1= $this->input->post("reqKettable1");
			$reqFiletable1= $this->input->post("reqFiletable1");
			$reqidtable1= $this->input->post("reqidtable1");

			for($i=0;$i<count($reqKettable1);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable1[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable1[$i]);
				$setUpload->setField("TABLE_NAMA", 'dosen');
				$setUpload->setField("TABLE_FIELD", 'sertifikat_lain');
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqidtable1[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}
			uploaddataarray($reqId,'sertifikat_lain',$_FILES["reqFiletable1"]);


			$reqKettable2= $this->input->post("reqKettable2");
			$reqFiletable2= $this->input->post("reqFiletable2");
			$reqFileExisttable2= $this->input->post("reqFileExisttable2");
			$reqidtable2= $this->input->post("reqidtable2");

			for($i=0;$i<count($reqKettable2);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable2[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable2[$i]);
				$setUpload->setField("TABLE_NAMA", 'dosen');
				$setUpload->setField("TABLE_FIELD", 'mata_kuliah');
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqidtable2[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}
			uploaddataarray($reqId,'mata_kuliah',$_FILES["reqFiletable2"]);

			$reqKettable3= $this->input->post("reqKettable3");
			$reqFiletable3= $this->input->post("reqFiletable3");
			$reqFileExisttable3= $this->input->post("reqFileExisttable3");
			$reqidtable3= $this->input->post("reqidtable3");

			for($i=0;$i<count($reqKettable3);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable3[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable3[$i]);
				$setUpload->setField("TABLE_NAMA", 'dosen');
				$setUpload->setField("TABLE_FIELD", 'judul');
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqidtable3[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}
			uploaddataarray($reqId,'judul',$_FILES["reqFiletable3"]);

			$reqKettable4= $this->input->post("reqKettable4");
			$reqFiletable4= $this->input->post("reqFiletable4");
			$reqFileExisttable4= $this->input->post("reqFileExisttable4");
			$reqidtable4= $this->input->post("reqidtable4");

			for($i=0;$i<count($reqKettable4);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable4[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable4[$i]);
				$setUpload->setField("TABLE_NAMA", 'dosen');
				$setUpload->setField("TABLE_FIELD", 'rekognisi_bidang');
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqidtable4[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}
			uploaddataarray($reqId,'rekognisi_bidang',$_FILES["reqFiletable4"]);

			$reqPraktikProfesionalNama= $this->input->post("reqPraktikProfesionalNama");
			$reqPraktikProfesionalDesc= $this->input->post("reqPraktikProfesionalDesc");
			$reqPraktikProfesionalOrg= $this->input->post("reqPraktikProfesionalOrg");
			$reqPraktikProfesionalRekognisi= $this->input->post("reqPraktikProfesionalRekognisi");
			$reqPraktikProfesionalId= $this->input->post("reqPraktikProfesionalId");

			for($i=0;$i<count($reqPraktikProfesionalId);$i++){
				$setUpload = new Upload();
				$setUpload->setField("praktik_profesional_id", $reqPraktikProfesionalId[$i]);
				$setUpload->setField("nama", $reqPraktikProfesionalNama[$i]);
				$setUpload->setField("deskripsi", $reqPraktikProfesionalDesc[$i]);
				$setUpload->setField("organisasi_lain", $reqPraktikProfesionalOrg[$i]);
				$setUpload->setField("rekognisi", $reqPraktikProfesionalRekognisi[$i]);
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqPraktikProfesionalId[$i] == "")
				{
					$setUpload->insertPraktikProfesional();
				}
				else
				{	
					$setUpload->updatePraktikProfesional();
				}
			}
			uploaddataarray($reqId,'praktik_dan_profesional',$_FILES["reqPraktikProfesionalFile"]);

			$reqPenelitianJudul= $this->input->post("reqPenelitianJudul");
			$reqPenelitianSitasi= $this->input->post("reqPenelitianSitasi");
			$reqPenelitianRekognisi= $this->input->post("reqPenelitianRekognisi");
			$reqPenelitianId= $this->input->post("reqPenelitianId");

			for($i=0;$i<count($reqPenelitianId);$i++){
				$setUpload = new Upload();
				$setUpload->setField("PENELITIAN_ID", $reqPenelitianId[$i]);
				$setUpload->setField("JUDUL", $reqPenelitianJudul[$i]);
				$setUpload->setField("SITASI", $reqPenelitianSitasi[$i]);
				$setUpload->setField("REKOGNISI", $reqPenelitianRekognisi[$i]);
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqPenelitianId[$i] == "")
				{
					$setUpload->insertPenelitian();
				}
				else
				{	
					$setUpload->updatePenelitian();
				}
			}
			uploaddataarray($reqId,'penelitian',$_FILES["reqPenelitianFile"]);

			$reqKettable7= $this->input->post("reqKettable7");
			$reqFiletable7= $this->input->post("reqFiletable7");
			$reqFileExisttable7= $this->input->post("reqFileExisttable7");
			$reqidtable7= $this->input->post("reqidtable7");

			for($i=0;$i<count($reqKettable7);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable7[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable7[$i]);
				$setUpload->setField("TABLE_NAMA", 'dosen');
				$setUpload->setField("TABLE_FIELD", 'kegiatan_pkm_mandiri');
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqidtable7[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}
			uploaddataarray($reqId,'kegiatan_pkm_mandiri',$_FILES["reqFiletable7"]);

			$reqKettable8= $this->input->post("reqKettable8");
			$reqFiletable8= $this->input->post("reqFiletable8");
			$reqFileExisttable8= $this->input->post("reqFileExisttable8");
			$reqidtable8= $this->input->post("reqidtable8");

			for($i=0;$i<count($reqKettable8);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable8[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable8[$i]);
				$setUpload->setField("TABLE_NAMA", 'dosen');
				$setUpload->setField("TABLE_FIELD", 'mata_kuliah_lain');
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqidtable8[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}
			uploaddataarray($reqId,'mata_kuliah_lain',$_FILES["reqFiletable8"]);

			$reqKettable9= $this->input->post("reqKettable9");
			$reqFiletable9= $this->input->post("reqFiletable9");
			$reqFileExisttable9= $this->input->post("reqFileExisttable9");
			$reqidtable9= $this->input->post("reqidtable9");

			for($i=0;$i<count($reqKettable9);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable9[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable9[$i]);
				$setUpload->setField("TABLE_NAMA", 'dosen');
				$setUpload->setField("TABLE_FIELD", 'organisasi_diluar_ps');
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqidtable9[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}
			uploaddataarray($reqId,'organisasi_diluar_ps',$_FILES["reqFiletable9"]);

			$reqKettable10= $this->input->post("reqKettable10");
			$reqFiletable10= $this->input->post("reqFiletable10");
			$reqFileExisttable10= $this->input->post("reqFileExisttable10");
			$reqidtable10= $this->input->post("reqidtable10");

			for($i=0;$i<count($reqKettable10);$i++){
				$setUpload = new Upload();
				$setUpload->setField("upload_id", $reqidtable10[$i]);
				$setUpload->setField("KETERANGAN", $reqKettable10[$i]);
				$setUpload->setField("TABLE_NAMA", 'dosen');
				$setUpload->setField("TABLE_FIELD", 'rekognisi_bidang_pkm');
				$setUpload->setField("DOSEN_ID", $reqId);
				if ($reqidtable10[$i] == "")
				{
					$setUpload->insert();
				}
				else
				{	
					$setUpload->update();
				}
			}
			uploaddataarray($reqId,'rekognisi_bidang_pkm',$_FILES["reqFiletable10"]);

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
		$this->load->model("base/ProfilDosen");
		$set = new ProfilDosen();
		
		$reqRowId= $this->input->get('reqRowId');
		$reqMode= $this->input->get('reqMode');

		$set->setField("DOSEN_ID", $reqRowId);
		$reqSimpan="";
		if($set->delete())
		{
			$reqSimpan=1;
		}

		$folderPath = "uploads/".$reqRowId;
		    // echo $folderPath;exit;

		// Cek apakah folder sudah ada atau belum
		if (file_exists($folderPath)) {
			rmdir($folderPath);
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