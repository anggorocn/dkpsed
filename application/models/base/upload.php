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
			UPLOAD_ID, DOSEN_ID, TABLE_NAMA,TABLE_FIELD, FILE, KETERANGAN
		)
		VALUES
		(
			".$this->getField("UPLOAD_ID")."
			, '".$this->getField("dosen_id")."'
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
		UPDATE UPLOAD
		SET    
			TABLE_ID= '".$this->getField("TABLE_ID")."'
			, TABLE_NAMA= '".$this->getField("TABLE_NAMA")."'
			, TABLE_FIELD= '".$this->getField("TABLE_FIELD")."'
			, FILE= '".$this->getField("FILE")."'
			, KETERANGAN= '".$this->getField("KETERANGAN")."'
		WHERE UPLOAD_ID= '".$this->getField("UPLOAD_ID")."'
		"; 
		$this->query = $str;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi
		// echo $str;exit;

		return $this->execQuery($str);
    }

    function insertPraktikProfesional()
	{
		$this->setField("PRAKTIK_PROFESIONAL_ID", $this->getNextId("PRAKTIK_PROFESIONAL_ID","PRAKTIK_PROFESIONAL"));
		$str = "
		INSERT INTO PRAKTIK_PROFESIONAL
		(
			PRAKTIK_PROFESIONAL_ID, DOSEN_ID, NAMA,DESKRIPSI, ORGANISASI_LAIN, REKOGNISI
		)
		VALUES
		(
			".$this->getField("PRAKTIK_PROFESIONAL_ID")."
			, '".$this->getField("DOSEN_ID")."'
			, '".$this->getField("NAMA")."'
			, '".$this->getField("DESKRIPSI")."'
			, '".$this->getField("ORGANISASI_LAIN")."'
			, '".$this->getField("REKOGNISI")."'
		)";

		$this->query = $str;
		// echo $str;exit;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi

		return $this->execQuery($str);
    }

    function updatePraktikProfesional()
	{
		$str = "
		UPDATE PRAKTIK_PROFESIONAL
		SET    
			DOSEN_ID= '".$this->getField("DOSEN_ID")."'
			, NAMA= '".$this->getField("NAMA")."'
			, DESKRIPSI= '".$this->getField("DESKRIPSI")."'
			, ORGANISASI_LAIN= '".$this->getField("ORGANISASI_LAIN")."'
			, REKOGNISI= '".$this->getField("REKOGNISI")."'
		WHERE PRAKTIK_PROFESIONAL_ID= '".$this->getField("PRAKTIK_PROFESIONAL_ID")."'
		"; 
		$this->query = $str;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi
		// echo $str;exit;

		return $this->execQuery($str);
    }

    function insertPenelitian()
	{
		$this->setField("PENELITIAN_ID", $this->getNextId("PENELITIAN_ID","PENELITIAN"));
		$str = "
		INSERT INTO PENELITIAN
		(
			PENELITIAN_ID, DOSEN_ID, JUDUL, SITASI, REKOGNISI
		)
		VALUES
		(
			".$this->getField("PENELITIAN_ID")."
			, '".$this->getField("DOSEN_ID")."'
			, '".$this->getField("JUDUL")."'
			, '".$this->getField("SITASI")."'
			, '".$this->getField("REKOGNISI")."'
		)";

		$this->query = $str;
		// echo $str;exit;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi

		return $this->execQuery($str);
    }

    function updatePenelitian()
	{
		$str = "
		UPDATE PENELITIAN
		SET    
			DOSEN_ID= '".$this->getField("DOSEN_ID")."'
			, JUDUL= '".$this->getField("JUDUL")."'
			, SITASI= '".$this->getField("SITASI")."'
			, REKOGNISI= '".$this->getField("REKOGNISI")."'
		WHERE PENELITIAN_ID= '".$this->getField("PENELITIAN_ID")."'
		"; 
		$this->query = $str;

		// untuk buat log data
		// parse pertama sesuai nama table
		// parse ke dua sesuai aksi
		// echo $str;exit;

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

    function selectByParamsPraktikProfesional($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*
		FROM PRAKTIK_PROFESIONAL A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY PRAKTIK_PROFESIONAL_ID ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsPenelitian($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*
		FROM PENELITIAN A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY PENELITIAN_ID ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsLuaran($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			a.*,
			 ROW_NUMBER () OVER (ORDER BY luaran_penelitian_mahasiswa_Detail_id DESC) as NO
		FROM luaran_penelitian_mahasiswa_Detail A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY luaran_penelitian_mahasiswa_Detail_id DESC";
		$this->query = $str;
		// echo $str;exit;
				
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