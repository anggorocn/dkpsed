<? 
include_once(APPPATH.'/models/Entity.php');

class KepuasanPengguna extends Entity{ 

	var $query;

	function KepuasanPengguna()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("KEPUASAN_PENGGUNA_ID", $this->getNextId("KEPUASAN_PENGGUNA_ID","KEPUASAN_PENGGUNA"));

		$str = "
		INSERT INTO KEPUASAN_PENGGUNA
		(
			KEPUASAN_PENGGUNA_ID, TAHUN, JENIS, NILAI_A, NILAI_B, NILAI_C, NILAI_D, RENCANA
			, KETERANGAN
		)
		VALUES
		(
			".$this->getField("KEPUASAN_PENGGUNA_ID")."
			, '".$this->getField("TAHUN")."'
			, '".$this->getField("JENIS")."'
			, '".$this->getField("NILAI_A")."'
			, '".$this->getField("NILAI_B")."'
			, '".$this->getField("NILAI_C")."'
			, '".$this->getField("NILAI_D")."'
			, '".$this->getField("RENCANA")."'
			, '".$this->getField("KETERANGAN")."'
		)";

		$this->id= $this->getField("KEPUASAN_PENGGUNA_ID");
		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE KEPUASAN_PENGGUNA
		SET    
			TAHUN= '".$this->getField("TAHUN")."'
			, JENIS= '".$this->getField("JENIS")."'
			, NILAI_A= '".$this->getField("NILAI_A")."'
			, NILAI_B= '".$this->getField("NILAI_B")."'
			, NILAI_C= '".$this->getField("NILAI_C")."'
			, NILAI_D= '".$this->getField("NILAI_D")."'
			, RENCANA= '".$this->getField("RENCANA")."'
			, KETERANGAN= '".$this->getField("KETERANGAN")."'
		WHERE KEPUASAN_PENGGUNA_ID= '".$this->getField("KEPUASAN_PENGGUNA_ID")."'
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
			 ROW_NUMBER () OVER (ORDER BY kepuasan_pengguna_id desc) as NO
		FROM kepuasan_pengguna A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY kepuasan_pengguna_id desc";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>