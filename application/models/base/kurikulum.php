<? 
include_once(APPPATH.'/models/Entity.php');

class Kurikulum extends Entity{ 

	var $query;

	function Kurikulum()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$str = "
		INSERT INTO KURIKULUM
		(
			KODE_SO, KODE_PARENT, NAMA, KURIKULUM_ID, KURIKULUM_ID_PARENT, SKS, KETERANGAN, KODE,JURUSAN_ID
		)
		VALUES
		(
			'".$this->getField("KODE_SO")."'
			, '".$this->getField("KODE_PARENT")."'
			, '".$this->getField("NAMA")."'
			, '".$this->getField("KURIKULUM_ID")."'
			, '".$this->getField("KURIKULUM_ID_PARENT")."'
			, '".$this->getField("SKS")."'
			, '".$this->getField("KETERANGAN")."'
			, '".$this->getField("KODE")."'
			, '".$this->getField("JURUSAN_ID")."'
		)";

		$this->id= $this->getField("KURIKULUM_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE KURIKULUM
		SET    
			NAMA= '".$this->getField("NAMA")."'
			, SKS= '".$this->getField("SKS")."'
			, KETERANGAN= '".$this->getField("KETERANGAN")."'
			, KODE= '".$this->getField("KODE")."'
			, JURUSAN_ID= '".$this->getField("JURUSAN_ID")."'
		WHERE KURIKULUM_ID= '".$this->getField("KURIKULUM_ID")."'
		and KURIKULUM_ID_PARENT= '".$this->getField("KURIKULUM_ID_PARENT")."'
		"; 
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function delete()
	{
        $str = "
        DELETE FROM kurikulum
        WHERE 
        kurikulum_id = '".$this->getField("kurikulum_id")."'";
		$this->query = $str;
        return $this->execQuery($str);
    }

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT 
					*
				FROM kurikulum
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
				SELECT max(kurikulum_id)  max
				FROM kurikulum
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

    function selectByParamsJurusan($paramsArray=array(),$limit=-1,$from=-1,$statement="", $order="")
	{
		$str = "
				SELECT *
				FROM jurusan
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
		$str = "SELECT COUNT(kurikulum_id) AS ROWCOUNT FROM kurikulum WHERE 1 = 1 ".$statement; 
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
