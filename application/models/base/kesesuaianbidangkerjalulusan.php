<? 
include_once(APPPATH.'/models/Entity.php');

class KesesuaianBidangKerjaLulusan extends Entity{ 

	var $query;

	function KesesuaianBidangKerjaLulusan()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("kesesuaian_bidang_kerja_lulusan_id", $this->getNextId("kesesuaian_bidang_kerja_lulusan_id","kesesuaian_bidang_kerja_lulusan"));

		$str = "
		INSERT INTO kesesuaian_bidang_kerja_lulusan
		(
			kesesuaian_bidang_kerja_lulusan_id, tahun, jumlah, jumlah_terlacak, sesuai, tidak_sesuai, keterangan
		)
		VALUES
		(
			".$this->getField("kesesuaian_bidang_kerja_lulusan_id")."
			, '".$this->getField("tahun")."'
			, '".$this->getField("jumlah")."'
			, '".$this->getField("jumlah_terlacak")."'
			, '".$this->getField("sesuai")."'
			, '".$this->getField("tidak_sesuai")."'
			, '".$this->getField("keterangan")."'
		)";

		$this->id= $this->getField("kesesuaian_bidang_kerja_lulusan_id");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE kesesuaian_bidang_kerja_lulusan
		SET    
			tahun= '".$this->getField("tahun")."'
			, jumlah= '".$this->getField("jumlah")."'
			, jumlah_terlacak= '".$this->getField("jumlah_terlacak")."'
			, sesuai= '".$this->getField("sesuai")."'
			, tidak_sesuai= '".$this->getField("tidak_sesuai")."'
			, keterangan= '".$this->getField("keterangan")."'
		WHERE kesesuaian_bidang_kerja_lulusan_id= '".$this->getField("kesesuaian_bidang_kerja_lulusan_id")."'
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
			 ROW_NUMBER () OVER (ORDER BY kesesuaian_bidang_kerja_lulusan_id) as NO
		FROM kesesuaian_bidang_kerja_lulusan A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY kesesuaian_bidang_kerja_lulusan_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>