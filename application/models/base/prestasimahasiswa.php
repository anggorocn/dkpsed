<? 
include_once(APPPATH.'/models/Entity.php');

class PrestasiMahasiswa extends Entity{ 

	var $query;

	function PrestasiMahasiswa()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("prestasi_id", $this->getNextId("prestasi_id","prestasi"));

		$str = "
		INSERT INTO prestasi
		(
			prestasi_id, nama, jenis, tahun, tingkat, juara, standart
		)
		VALUES
		(
			".$this->getField("prestasi_id")."
			, '".$this->getField("nama")."'
			, '".$this->getField("jenis")."'
			, '".$this->getField("tahun")."'
			, '".$this->getField("tingkat")."'
			, '".$this->getField("juara")."'
			, '".$this->getField("standart")."'
		)";

		$this->id= $this->getField("prestasi_id");
		$this->query = $str;
		// echo $str; exit;

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE prestasi
		SET    
			nama= '".$this->getField("nama")."'
			, jenis= '".$this->getField("jenis")."'
			, tahun= '".$this->getField("tahun")."'
			, tingkat= '".$this->getField("tingkat")."'
			, juara= '".$this->getField("juara")."'
			, standart= '".$this->getField("standart")."'
		WHERE prestasi_id= '".$this->getField("prestasi_id")."'
		"; 
		$this->query = $str;
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
			*,
			 ROW_NUMBER () OVER (ORDER BY prestasi_id) as NO
		FROM prestasi A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY prestasi_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>