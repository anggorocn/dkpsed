<? 
include_once(APPPATH.'/models/Entity.php');

class PublikasiIlmiahMahasiswa extends Entity{ 

	var $query;

	function PublikasiIlmiahMahasiswa()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("PUBLIKASI_MAHASISWA_ID", $this->getNextId("PUBLIKASI_MAHASISWA_ID","PUBLIKASI_MAHASISWA"));

		$str = "
		INSERT INTO PUBLIKASI_MAHASISWA
		(
			PUBLIKASI_MAHASISWA_ID, NAMA, TS_2, TS_1, TS, JUMLAH, STANDAR, GOLONGAN		)
		VALUES
		(
			".$this->getField("PUBLIKASI_MAHASISWA_ID")."
			, '".$this->getField("NAMA")."'
			, '".$this->getField("TS_2")."'
			, '".$this->getField("TS_1")."'
			, '".$this->getField("TS")."'
			, '".$this->getField("JUMLAH")."'
			, '".$this->getField("STANDAR")."'
			, '".$this->getField("GOLONGAN")."'
		)";

		$this->id= $this->getField("PUBLIKASI_MAHASISWA_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE PUBLIKASI_MAHASISWA
		SET    
			NAMA= '".$this->getField("NAMA")."'
			, TS_2= '".$this->getField("TS_2")."'
			, TS_1= '".$this->getField("TS_1")."'
			, TS= '".$this->getField("TS")."'
			, JUMLAH= '".$this->getField("JUMLAH")."'
			, STANDAR= '".$this->getField("STANDAR")."'
			, GOLONGAN= '".$this->getField("GOLONGAN")."'
		WHERE PUBLIKASI_MAHASISWA_ID= '".$this->getField("PUBLIKASI_MAHASISWA_ID")."'
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

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*,
			 ROW_NUMBER () OVER (ORDER BY publikasi_mahasiswa_id DESC) as NO
		FROM publikasi_mahasiswa A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY publikasi_mahasiswa_id DESC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>