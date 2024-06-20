<? 
include_once(APPPATH.'/models/Entity.php');

class Identitas extends Entity{ 

	var $query;

	function Identitas()
	{
		$this->Entity(); 
	}

	function selectByParamsProgram($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			distinct(a.program_id) id, b.nama nama
		FROM riwayat_pendidikan A
		left join master_program b on a.program_id=b.master_program_id
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." group by b.nama, a.program_id ORDER BY a.program_id ASC";
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsProdi($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			distinct(a.program_id) id, b.nama nama
		FROM riwayat_pendidikan A
		left join master_program b on a.program_id=b.master_program_id
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." group by b.nama, a.program_id ORDER BY a.program_id ASC";
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsIdentitas($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			a.*, k.nama nama_kota, km.nama nama_kampus, ps.nama nama_studi
		FROM riwayat_pendidikan A
		left join kota k on a.kota_id=k.kota_id
		left join kampus km on a.kampus_id=km.kampus_id
		left join program_studi_detil ps on ps.program_studi_detil_id=a.program_studi_detil_id
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement."ORDER BY a.riwayat_pendidikan_id DESC";
		$this->query = $str;
		// echo $str;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountProgram($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		from riwayat_pendidikan where 1=1".$statement; 
				
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