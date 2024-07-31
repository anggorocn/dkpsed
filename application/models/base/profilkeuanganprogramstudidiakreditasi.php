<? 
include_once(APPPATH.'/models/Entity.php');

class ProfilKeuanganProgramStudiDiakreditasi extends Entity{ 

	var $query;

	function ProfilKeuanganProgramStudiDiakreditasi()
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

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
					*
				FROM profil_keuangan_prodi
				WHERE 1 = 1
			"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParams($paramsArray=array(), $statement="")
	{
		$str = "SELECT COUNT(profil_keuangan_prodi_id) AS ROWCOUNT FROM profil_keuangan_prodi WHERE 1 = 1 ".$statement; 
		while(list($key,$val)=each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
} 
?>
