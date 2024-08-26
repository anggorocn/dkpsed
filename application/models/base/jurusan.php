<? 
include_once(APPPATH.'/models/Entity.php');

class Jurusan extends Entity{ 

	var $query;

	function Jurusan()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("jurusan_id", $this->getNextId("jurusan_id","jurusan"));

		$str = "
		INSERT INTO jurusan
		(
			jurusan_id, nama
		)
		VALUES
		(
			'".$this->getField('jurusan_id')."',
			'".$this->getField('nama')."'
		)";

		$this->id= $this->getField("jurusan_id");
		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE jurusan
		SET    
			nama='".$this->getField('nama')."'
		WHERE jurusan_id= '".$this->getField("jurusan_id")."'
		"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function delete()
	{
        $str = "
        DELETE FROM jurusan
        WHERE 
        jurusan_id = '".$this->getField("jurusan_id")."'";
		$this->query = $str;
		// echo $str;exit;
        return $this->execQuery($str);
    }

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*,
			 ROW_NUMBER () OVER (ORDER BY jurusan_id asc) as NO
		FROM jurusan A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY jurusan_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }
    function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM diklat_fungsional A WHERE DIKLAT_FUNGSIONAL_ID IS NOT NULL ".$statement; 
				
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