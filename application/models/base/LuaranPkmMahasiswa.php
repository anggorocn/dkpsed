<? 
include_once(APPPATH.'/models/Entity.php');

class LuaranPkmMahasiswa extends Entity{ 

	var $query;

	function LuaranPkmMahasiswa()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("PENELITIAN_DOSEN_ID", $this->getNextId("PENELITIAN_DOSEN_ID","PENELITIAN_DOSEN"));

		$str = "
		INSERT INTO PENELITIAN_DOSEN
		(
			PENELITIAN_DOSEN_ID, NAMA, TAHUN, KETERANGAN, SUMBER_DAYA_ID, JENIS_PUBLIKASI_ID, TIPE)
		VALUES
		(
			".$this->getField("PENELITIAN_DOSEN_ID")."
			, '".$this->getField("NAMA")."'
			, '".$this->getField("TAHUN")."'
			, '".$this->getField("KETERANGAN")."'
			, '".$this->getField("SUMBER_DAYA_ID")."'
			, '".$this->getField("JENIS_PUBLIKASI_ID")."'
			, '".$this->getField("TIPE")."'
		)";

		$this->id= $this->getField("PENELITIAN_DOSEN_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE PENELITIAN_DOSEN
		SET    
			NAMA= '".$this->getField("NAMA")."'
			, TAHUN= '".$this->getField("TAHUN")."'
			, KETERANGAN= '".$this->getField("KETERANGAN")."'
			, SUMBER_DAYA_ID= '".$this->getField("SUMBER_DAYA_ID")."'
			, JENIS_PUBLIKASI_ID= '".$this->getField("JENIS_PUBLIKASI_ID")."'
			, TIPE= '".$this->getField("TIPE")."'
		WHERE PENELITIAN_DOSEN_ID= '".$this->getField("PENELITIAN_DOSEN_ID")."'
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
			a.*,
			 ROW_NUMBER () OVER (ORDER BY luaran_penelitian_mahasiswa_id DESC) as NO
		FROM luaran_penelitian_mahasiswa A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY luaran_penelitian_mahasiswa_id DESC";
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }
} 
?>