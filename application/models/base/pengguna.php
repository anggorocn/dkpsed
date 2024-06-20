<? 
include_once(APPPATH.'/models/Entity.php');

class Pengguna extends Entity{ 

	var $query;

	function Pengguna()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("user_app_id", $this->getNextId("user_app_id","user_app"));

		$str = "
		INSERT INTO user_app
		(
			user_app_id, user_group_id, user_login, user_pass, nama
		)
		VALUES
		(
			".$this->getField("user_app_id")."
			, ".$this->getField("user_group_id")."
			, '".$this->getField("user_login")."'
			, md5('".$this->getField("user_pass")."')
			, '".$this->getField("nama")."'
		)";

		$this->id= $this->getField("user_app_id");
		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE user_app
		SET    
			nama= '".$this->getField("nama")."'
			, user_group_id= '".$this->getField("user_group_id")."'
		WHERE user_app_id= '".$this->getField("user_app_id")."'
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
			*, a.nama nama, b.nama user_group_nama,
			 ROW_NUMBER () OVER (ORDER BY USER_LOGIN asc) as NO
		FROM user_app A
		left join user_group b on a.USER_GROUP_ID=b.USER_GROUP_ID
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY USER_LOGIN ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsComboGroup($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*
		FROM user_group A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY user_group_id ASC";
		$this->query = $str;
		// echo $str;exit;
				
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