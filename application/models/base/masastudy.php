<? 
include_once(APPPATH.'/models/Entity.php');

class MasaStudy extends Entity{ 

	var $query;

	function MasaStudy()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("lulusan_prodi_id", $this->getNextId("lulusan_prodi_id","lulusan_prodi"));

		$str = "
		INSERT INTO lulusan_prodi
		(
			lulusan_prodi_id, tahun, jumlah, jenjang, ts_6, ts_5, ts_4, ts_3, ts_2, ts_1
			, ts, jumlah_akhir_ts, avg, standart
		)
		VALUES
		(
			".$this->getField("lulusan_prodi_id")."
			, '".$this->getField("tahun")."'
			, '".$this->getField("jumlah")."'
			, '".$this->getField("jenjang")."'
			, ".$this->getField("ts_6")."
			, ".$this->getField("ts_5")."
			, ".$this->getField("ts_4")."
			, ".$this->getField("ts_3")."
			, ".$this->getField("ts_2")."
			, ".$this->getField("ts_1")."
			, ".$this->getField("ts")."
			, '".$this->getField("jumlah_akhir_ts")."'
			, '".$this->getField("avg")."'
			, '".$this->getField("standart")."'
		)";

		$this->id= $this->getField("lulusan_prodi_id");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE lulusan_prodi
		SET    
			tahun= '".$this->getField("tahun")."'
			, jumlah= '".$this->getField("jumlah")."'
			, jenjang= '".$this->getField("jenjang")."'
			, ts_6= ".$this->getField("ts_6")."
			, ts_5= ".$this->getField("ts_5")."
			, ts_4= ".$this->getField("ts_4")."
			, ts_3= ".$this->getField("ts_3")."
			, ts_2= ".$this->getField("ts_2")."
			, ts_1= ".$this->getField("ts_1")."
			, ts= ".$this->getField("ts")."
			, jumlah_akhir_ts= ".$this->getField("jumlah_akhir_ts")."
			, avg= ".$this->getField("avg")."
			, standart= '".$this->getField("standart")."'
		WHERE lulusan_prodi_id= '".$this->getField("lulusan_prodi_id")."'
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
			 ROW_NUMBER () OVER (ORDER BY lulusan_prodi_id) as NO
		FROM lulusan_prodi A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY lulusan_prodi_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>