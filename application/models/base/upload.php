<? 
include_once(APPPATH.'/models/Entity.php');

class Upload extends Entity{ 

	var $query;

	function Upload()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("UPLOAD_ID", $this->getNextId("UPLOAD_ID","UPLOAD"));

		$str = "
		INSERT INTO UPLOAD
		(
			UPLOAD_ID, TABLE_ID, TABLE_NAMA,TABLE_FIELD, FILE, KETERANGAN
		)
		VALUES
		(
			".$this->getField("UPLOAD_ID")."
			, '".$this->getField("TABLE_ID")."'
			, '".$this->getField("TABLE_NAMA")."'
			, '".$this->getField("TABLE_FIELD")."'
			, '".$this->getField("FILE")."'
			, '".$this->getField("KETERANGAN")."'
		)";

		$this->query = $str;
		// echo $str;exit;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi

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

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*
		FROM upload A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY upload_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM diklat_fungsional A WHERE DIKLAT_FUNGSIONAL_ID IS NOT NULL ".$statement; 
				
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		// echo $str;exit;
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
    }
} 
?>