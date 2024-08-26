<? 
include_once(APPPATH.'/models/Entity.php');

class Penilaian extends Entity{ 

	var $query;

	function Penilaian()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("penilaian_id", $this->getNextId("penilaian_id","penilaian"));

		$str = "
		INSERT INTO penilaian
		(
			penilaian_id, NAMA, BERITA_ACARA, SKOR
		)
		VALUES
		(
			".$this->getField("penilaian_id")."
			, '".$this->getField("NAMA")."'
			, '".$this->getField("BERITA_ACARA")."'
			, '".$this->getField("SKOR")."'
		)";

		$this->id= $this->getField("penilaian_id");
		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE penilaian
		SET    
			NAMA= '".$this->getField("NAMA")."'
			, BERITA_ACARA= '".$this->getField("BERITA_ACARA")."'
			, SKOR= '".$this->getField("SKOR")."'
		WHERE penilaian_id= '".$this->getField("penilaian_id")."'
		"; 
		$this->query = $str;

		return $this->execQuery($str);
    }

    function delete()
	{
        $str = "
        DELETE FROM penilaian
        WHERE 
        penilaian_id = '".$this->getField("penilaian_id")."'";
		$this->query = $str;

        return $this->execQuery($str);
    }

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*,
			 ROW_NUMBER () OVER (ORDER BY penilaian_id asc) as NO
		FROM penilaian A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY penilaian_id ASC";
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