<? 
include_once(APPPATH.'/models/Entity.php');

class DaftarTabel extends Entity{ 

	var $query;

	function DaftarTabel()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("DIKLAT_FUNGSIONAL_ID", $this->getNextId("DIKLAT_FUNGSIONAL_ID","diklat_fungsional"));

		$str = "
		INSERT INTO diklat_fungsional
		(
			DIKLAT_FUNGSIONAL_ID, PEGAWAI_ID, TEMPAT, PENYELENGGARA, TANGGAL_MULAI, TANGGAL_SELESAI, NO_STTPP, TANGGAL_STTPP
			, NAMA, ANGKATAN, TAHUN, JUMLAH_JAM
			, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_CREATE_SATKER
		)
		VALUES
		(
			".$this->getField("DIKLAT_FUNGSIONAL_ID")."
			, '".$this->getField("PEGAWAI_ID")."'
			, '".$this->getField("TEMPAT")."'
			, '".$this->getField("PENYELENGGARA")."'
			, ".$this->getField("TANGGAL_MULAI")."
			, ".$this->getField("TANGGAL_SELESAI")."
			, '".$this->getField("NO_STTPP")."'
			, ".$this->getField("TANGGAL_STTPP")."
			, '".$this->getField("NAMA")."'
			, ".$this->getField("ANGKATAN")."
			, ".$this->getField("TAHUN")."
			, ".$this->getField("JUMLAH_JAM")."
			, '".$this->getField("LAST_CREATE_USER")."'
			, ".$this->getField("LAST_CREATE_DATE")."
			, '".$this->getField("LAST_CREATE_SATKER")."'
		)";

		$this->id= $this->getField("DIKLAT_FUNGSIONAL_ID");
		$this->query = $str;
		// echo $str;exit;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi
		$this->setlogdata("diklat_fungsional", "INSERT", $str);

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE diklat_fungsional
		SET    
			PEGAWAI_ID= '".$this->getField("PEGAWAI_ID")."'
			, TEMPAT= '".$this->getField("TEMPAT")."'
			, PENYELENGGARA= '".$this->getField("PENYELENGGARA")."'
			, TANGGAL_MULAI= ".$this->getField("TANGGAL_MULAI")."
			, TANGGAL_SELESAI= ".$this->getField("TANGGAL_SELESAI")."
			, NO_STTPP= '".$this->getField("NO_STTPP")."'
			, TANGGAL_STTPP= ".$this->getField("TANGGAL_STTPP")."
			, NAMA= '".$this->getField("NAMA")."'
			, ANGKATAN= ".$this->getField("ANGKATAN")."
			, TAHUN= ".$this->getField("TAHUN")."
			, JUMLAH_JAM= ".$this->getField("JUMLAH_JAM")."
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
			, LAST_UPDATE_SATKER= '".$this->getField("LAST_UPDATE_SATKER")."'
		WHERE DIKLAT_FUNGSIONAL_ID= '".$this->getField("DIKLAT_FUNGSIONAL_ID")."'
		"; 
		$this->query = $str;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi
		$this->setlogdata("diklat_fungsional", "UPDATE", $str);

		return $this->execQuery($str);
    }

    function insertTabel()
	{
		$this->setField("daftar_tabel_id", $this->getNextId("daftar_tabel_id","daftar_tabel"));

		$str = "
		INSERT INTO daftar_tabel
		(
			daftar_tabel_id, NAMA, NAMA_SHEET, PAGE, D3, S1, S2, S3,STATUS
		)
		VALUES
		(
			".$this->getField("daftar_tabel_id")."
			, '".$this->getField("NAMA")."'
			, '".$this->getField("NAMA_SHEET")."'
			, '".$this->getField("PAGE")."'
			, '".$this->getField("D3")."'
			, '".$this->getField("S1")."'
			, '".$this->getField("S2")."'
			, '".$this->getField("S3")."'
			, '".$this->getField("STATUS")."'
		)";

		$this->id= $this->getField("daftar_tabel_id");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateTabel()
	{
		$str = "
		UPDATE daftar_tabel
		SET    
			NAMA= '".$this->getField("NAMA")."'
			, NAMA_SHEET= '".$this->getField("NAMA_SHEET")."'
			, PAGE= '".$this->getField("PAGE")."'
			, D3= '".$this->getField("D3")."'
			, S1= '".$this->getField("S1")."'
			, S2= '".$this->getField("S2")."'
			, S3= '".$this->getField("S3")."'
			, STATUS= '".$this->getField("STATUS")."'
		WHERE daftar_tabel_id= '".$this->getField("daftar_tabel_id")."'
		"; 
		$this->query = $str;

		return $this->execQuery($str);
    }

    function delete()
	{
        $str = "
        DELETE FROM diklat_fungsional
        WHERE 
        DIKLAT_FUNGSIONAL_ID = '".$this->getField("DIKLAT_FUNGSIONAL_ID")."'";
		$this->query = $str;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi
		$this->setlogdata("diklat_fungsional", "DELETE", $str);

        return $this->execQuery($str);
    }

    function deleteTabel()
	{
        $str = "
        DELETE FROM daftar_tabel
        WHERE 
        daftar_tabel_id = '".$this->getField("daftar_tabel_id")."'";
		$this->query = $str;
        return $this->execQuery($str);
    }

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*,
			 ROW_NUMBER () OVER (ORDER BY daftar_tabel_id) as NO
		FROM daftar_tabel A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY daftar_tabel_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsAdd($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			a.*,
			 ROW_NUMBER () OVER (ORDER BY b.dosen_id) as NO
		FROM dosen A
		inner join daftar_tabel_detil b on a.dosen_id=b.dosen_id
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY daftar_tabel_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function deleteTabelDosen()
	{
        $str = "
        DELETE FROM daftar_tabel_detil
        WHERE 
        daftar_tabel_id = '".$this->getField("daftar_tabel_id")."'";
		$this->query = $str;
		// echo $str; exit;

        return $this->execQuery($str);
    }

    function insertDosen()
	{
		$this->setField("daftar_tabel_detil_id", $this->getNextId("daftar_tabel_detil_id","daftar_tabel_detil"));

		$str = "
		INSERT INTO daftar_tabel_detil
		(
			daftar_tabel_detil_id, daftar_tabel_id, dosen_id
		)
		VALUES
		(
			".$this->getField("daftar_tabel_detil_id")."
			, '".$this->getField("daftar_tabel_id")."'
			, '".$this->getField("dosen_id")."'
		)";

		// echo $str; exit;

		$this->id= $this->getField("daftar_tabel_detil_id");
		$this->query = $str;

		return $this->execQuery($str);
    }

    function selectByParamsDetil1($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			a.*,
			 ROW_NUMBER () OVER (ORDER BY b.dosen_id) as NO
		FROM dosen A
		inner join daftar_tabel_detil b on a.dosen_id=b.dosen_id
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY daftar_tabel_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>