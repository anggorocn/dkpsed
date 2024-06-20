<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class combo_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		//kauth
		if($this->session->userdata("userpegawaiId") == "")
		{
			redirect('login');
		}
		
		$this->pegawaiId= $this->session->userdata("userpegawaiId");
		$this->userpegawaiNama= $this->session->userdata("userpegawaiNama");
	}	
	
	function autocompletesatuankerja()
	{
		$this->load->model("base-validasi/SatuanKerja");

		$set= new SatuanKerja();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY A.SATKER_ID";
		$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("SATKER_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("SATKER_DETIL_NAMA");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function autocompletepejabatpenetap()
	{
		$this->load->model("base-validasi/PejabatPenetap");

		$set= new PejabatPenetap();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY NAMA ASC";
		$statement.= " AND UPPER(A.JABATAN) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("PEJABAT_PENETAP_ID");
			$arrdata["text"]= $set->getField("JABATAN");
			$arrdata["description"]= $set->getField("JABATAN");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function autocompletejurusan()
	{
		$this->load->model("base-validasi/JurusanPendidikan");

		$set= new JurusanPendidikan();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY NAMA";
		$statement.= " AND UPPER(NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("JURUSAN_PENDIDIKAN_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("NAMA");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function autocompleteinstansi()
	{
		$this->load->model("base-validasi/Instansi");

		$set= new Instansi();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY NAMA ASC";
		$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("INSTANSI_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("NAMA");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function autocompleteKategoriJabatan()
	{
		$this->load->model("base-personal/KategoriJabatan");

		$set= new KategoriJabatan();

		$q= $this->input->get('q');
		$page= $this->input->get('page');
		$reqJenisJabatanId= $this->input->get('reqJenisJabatanId');
		// echo $reqJenisJabatanId;exit;

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY A.TIPE_PEGAWAI_NEW_ID";

		$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";

		if (!empty($reqJenisJabatanId))
		{
			if ($reqJenisJabatanId == 4)
			{
				$statement.= " AND A.TIPE_PEGAWAI_NEW_ID_PARENT ='2'";
			}
			else if ($reqJenisJabatanId == 1)
			{
				$statement.= " AND TIPE_PEGAWAI_NEW_ID <> '16' AND A.TIPE_PEGAWAI_NEW_ID_PARENT ='".$reqJenisJabatanId."'";
			} 
			else
			{
				$statement.= " AND A.TIPE_PEGAWAI_NEW_ID_PARENT ='".$reqJenisJabatanId."'";
			}
			
		}
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("TIPE_PEGAWAI_NEW_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("NAMA");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function autocompletejabatannew()
	{
		$this->load->model("base-personal/JabatanNew");

		$set= new JabatanNew();

		$q= $this->input->get('q');
		$page= $this->input->get('page');
		$reqKategoriJabatanId= $this->input->get('reqKategoriJabatanId');
		$reqKategoriJabatanParentId = substr($reqKategoriJabatanId, 0, 1);

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$statement="";
		$jumlahdata= 0;
		$arrdetildata= [];
		if ($reqKategoriJabatanParentId == "2")
		{
			$sorder= "ORDER BY A.TIPE_PEGAWAI_NEW_ID";
			$statement.= " AND UPPER(B.NAMA) LIKE '%".strtoupper($search_term)."%' ";
			$statement.= " AND A.TIPE_PEGAWAI_NEW_ID ='".$reqKategoriJabatanId."'";
			$statement.= " AND B.JABATAN_FUNGSIONAL_NEW_ID_PARENT > '0'";
			$statement.= " AND B.ID_JABATAN IS NOT NULL";
			$jumlahdata= $set->getCountByParamsFungsional();
			$set->selectByParamsFungsional(array(), $limit, $from, $statement, $sorder);
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$arrdata= [];
				$arrdata["id"]= $set->getField("JABATAN_FUNGSIONAL_NEW_ID");
				$arrdata["text"]= $set->getField("JABATAN_FUNGSIONAL");
				$arrdata["description"]= $set->getField("JABATAN_FUNGSIONAL");
				$arrdata["bup"]= $set->getField("BUP");
				array_push($arrdetildata, $arrdata);
			}

		}
		else if ($reqKategoriJabatanParentId == "3")
		{
			$sorder= "ORDER BY A.TIPE_PEGAWAI_NEW_ID";
			$statement.= " AND UPPER(C.NAMA) LIKE '%".strtoupper($search_term)."%' ";
			$statement.= " AND A.TIPE_PEGAWAI_NEW_ID ='".$reqKategoriJabatanId."'";
			$statement.= " AND C.JABATAN_PELAKSANA_NEW_ID_PARENT > '0'";
			$statement.= " AND C.ID_JABATAN IS NOT NULL";
			$jumlahdata= $set->getCountByParamsPelaksana();
			$set->selectByParamsPelaksana(array(), $limit, $from, $statement, $sorder);
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$arrdata= [];
				$arrdata["id"]= $set->getField("JABATAN_PELAKSANA_NEW_ID");
				$arrdata["text"]= $set->getField("JABATAN_PELAKSANA");
				$arrdata["description"]= $set->getField("JABATAN_PELAKSANA");
				$arrdata["bup"]= $set->getField("BUP");
				$arrdata["kelas_jabatan"]= $set->getField("KELAS_JABATAN");
				array_push($arrdetildata, $arrdata);
			}
		}

		else if ($reqKategoriJabatanParentId == "1")
		{
			$sorder= "ORDER BY A.TIPE_PEGAWAI_NEW_ID";
			$statement.= " AND UPPER(B.NAMA) LIKE '%".strtoupper($search_term)."%' ";
			$statement.= " AND A.TIPE_PEGAWAI_NEW_ID ='".$reqKategoriJabatanId."'";
			// $statement.= " AND B.JABATAN_STRUKTURAL_NEW_ID_PARENT > '0'";
			$jumlahdata= $set->getCountByParamsStruktural();
			$set->selectByParamsStruktural(array(), $limit, $from, $statement, $sorder);
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$arrdata= [];
				$arrdata["id"]= $set->getField("JABATAN_STRUKTURAL_NEW_ID");
				$arrdata["text"]= $set->getField("JABATAN_STRUKTURAL");
				$arrdata["description"]= $set->getField("JABATAN_STRUKTURAL");
				$arrdata["bup"]= $set->getField("BUP");
				$arrdata["kelas_jabatan"]= $set->getField("KELAS_JABATAN");
				$arrdata["eselon_id"]= $set->getField("ESELON_ID");
				$arrdata["eselon_nama"]= $set->getField("ESELON_NAMA");
				array_push($arrdetildata, $arrdata);
			}
		}
		

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function tesform()
	{
		$reqSatuanKerjaNama= $this->input->post('reqSatuanKerjaNama');
		$reqAgamaId= $this->input->post('reqAgamaId');
		// echo $reqAgamaId."--";
		// echo $reqSatuanKerjaNama;

		// kalau berhasil simpan
		// echo json_response(200, 'working');

		// kalau gagal simpan
		echo json_response(400, 'working');
	}
	
	function autocompleteriwayatpendidikan()
	{
		$this->load->model("base-validasi/PegawaiPendidikan");

		$set= new PegawaiPendidikan();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY NAMA ASC";
		$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("PEGAWAI_PENDIDIKAN_ID");
			$arrdata["text"]= $set->getField("NAMA");
			$arrdata["description"]= $set->getField("NAMA");
			$arrdata["TINGKAT_PENDIDIKAN_ID"]= $set->getField("TINGKAT_PENDIDIKAN_ID");
			$arrdata["TINGKAT_PENDIDIKAN"]= $set->getField("TINGKAT_PENDIDIKAN");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function autocompleteunor()
	{
		$this->load->model("base-data/Unor");

		$set= new Unor();

		$q= $this->input->get('q');
		$page= $this->input->get('page');

		$search_term= !empty($q) ? $q : "";

		$limit= 30;
		if(empty($page))
		{
			$from= 0;
		}
		else
		{
			$from= 30*$page;
		}

		$jumlahdata= 0;
		$arrdetildata= [];
		$sorder= "ORDER BY SATKER ASC";
		$statement.= " AND UPPER(A.SATKER) LIKE '%".strtoupper($search_term)."%' ";
		$jumlahdata= $set->getCountByParams();
		$set->selectByParams(array(), $limit, $from, $statement, $sorder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["id"]= $set->getField("SATKER_ID");
			$arrdata["text"]= $set->getField("UNOR");
			$arrdata["description"]= $set->getField("UNOR");
			$arrdata["unor"]= $set->getField("UNOR");
			$arrdata["sub_unor"]= $set->getField("SATKER");
			array_push($arrdetildata, $arrdata);
		}

		$result = [
		    'total_count' => $jumlahdata,
		    'items' => $arrdetildata,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


}
?>