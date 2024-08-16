<? 
include_once(APPPATH.'/models/Entity.php');

class JangkauanOperasiKerjaLulusan extends Entity{ 

	var $query;

	function JangkauanOperasiKerjaLulusan()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("jangkauan_operasi_wilayah_lulusan_id", $this->getNextId("jangkauan_operasi_wilayah_lulusan_id","jangkauan_operasi_wilayah_lulusan"));

		$str = "
		INSERT INTO jangkauan_operasi_wilayah_lulusan
		(
			jangkauan_operasi_wilayah_lulusan_id, tahun, jumlah, jumlah_terlacak, lokal, nasional, internasional, keterangan
		)
		VALUES
		(
			".$this->getField("jangkauan_operasi_wilayah_lulusan_id")."
			, '".$this->getField("tahun")."'
			, '".$this->getField("jumlah")."'
			, '".$this->getField("jumlah_terlacak")."'
			, '".$this->getField("lokal")."'
			, '".$this->getField("nasional")."'
			, '".$this->getField("internasional")."'
			, '".$this->getField("keterangan")."'
		)";

		$this->id= $this->getField("jangkauan_operasi_wilayah_lulusan_id");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE jangkauan_operasi_wilayah_lulusan
		SET    
			tahun= '".$this->getField("tahun")."'
			, jumlah= '".$this->getField("jumlah")."'
			, jumlah_terlacak= '".$this->getField("jumlah_terlacak")."'
			, lokal= '".$this->getField("lokal")."'
			, nasional= '".$this->getField("nasional")."'
			, internasional= '".$this->getField("internasional")."'
			, keterangan= '".$this->getField("keterangan")."'
		WHERE jangkauan_operasi_wilayah_lulusan_id= '".$this->getField("jangkauan_operasi_wilayah_lulusan_id")."'
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
			*,
			 ROW_NUMBER () OVER (ORDER BY jangkauan_operasi_wilayah_lulusan_id) as NO
		FROM jangkauan_operasi_wilayah_lulusan A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY jangkauan_operasi_wilayah_lulusan_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>