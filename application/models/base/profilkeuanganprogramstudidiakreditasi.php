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
		$str = "
		INSERT INTO profil_keuangan_prodi
		(
			kode_so,
			kode_parent,
			nama,
			profil_keuangan_prodi_id,
			profil_keuangan_prodi_id_parent,
			pengelolah_ts_2,
			pengelolah_ts_1,
			pengelolah_ts,
			pengelolah_avg,
			prodi_ts_2,
			prodi_ts_1,
			prodi_ts,
			prodi_avg,
		)
		VALUES
		(
			'".$this->getField("kode_so")."'
			, '".$this->getField("kode_parent")."'
			, '".$this->getField("nama")."'
			, '".$this->getField("profil_keuangan_prodi_id")."'
			, '".$this->getField("profil_keuangan_prodi_id_parent")."'
			, ".$this->getField("pengelolah_ts_2")."
			, ".$this->getField("pengelolah_ts_1")."
			, ".$this->getField("pengelolah_ts")."
			, ".$this->getField("pengelolah_avg")."
			, ".$this->getField("prodi_ts_2")."
			, ".$this->getField("prodi_ts_1")."
			, ".$this->getField("prodi_ts")."
			, ".$this->getField("prodi_avg")."
		)";

		$this->id= $this->getField("profil_keuangan_prodi_id");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE profil_keuangan_prodi
		SET    
			nama= '".$this->getField("nama")."'
			, pengelolah_ts_2= ".$this->getField("pengelolah_ts_2")."
			, pengelolah_ts_1= ".$this->getField("pengelolah_ts_1")."
			, pengelolah_ts= ".$this->getField("pengelolah_ts")."
			, pengelolah_avg= ".$this->getField("pengelolah_avg")."
			, prodi_ts_2= ".$this->getField("prodi_ts_2")."
			, prodi_ts_1= ".$this->getField("prodi_ts_1")."
			, prodi_ts= ".$this->getField("prodi_ts")."
			, prodi_avg= ".$this->getField("prodi_avg")."
		WHERE profil_keuangan_prodi_id= '".$this->getField("profil_keuangan_prodi_id")."'
		and profil_keuangan_prodi_id_parent= '".$this->getField("profil_keuangan_prodi_id_parent")."'
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

    function selectByParamsMaxHead($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT max(profil_keuangan_prodi_id)  max
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
