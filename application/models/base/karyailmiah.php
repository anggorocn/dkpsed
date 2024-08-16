<? 
include_once(APPPATH.'/models/Entity.php');

class KaryaIlmiah extends Entity{ 

	var $query;

	function KaryaIlmiah()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("KARYA_ILMIAH_ID", $this->getNextId("KARYA_ILMIAH_ID","KARYA_ILMIAH"));

		$str = "
		INSERT INTO KARYA_ILMIAH
		(
			KARYA_ILMIAH_ID, NAMA, JUDUL, JUMLAH, STANDAR, GOLONGAN, DESKRIPSI)
		VALUES
		(
			".$this->getField("KARYA_ILMIAH_ID")."
			, '".$this->getField("NAMA")."'
			, '".$this->getField("JUDUL")."'
			, '".$this->getField("JUMLAH")."'
			, '".$this->getField("STANDAR")."'
			, '".$this->getField("GOLONGAN")."'
			, '".$this->getField("DESKRIPSI")."'
		)";

		$this->id= $this->getField("KARYA_ILMIAH_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE KARYA_ILMIAH
		SET    
			NAMA= '".$this->getField("NAMA")."'
			, JUDUL= '".$this->getField("JUDUL")."'
			, JUMLAH= '".$this->getField("JUMLAH")."'
			, STANDAR= '".$this->getField("STANDAR")."'
			, GOLONGAN= '".$this->getField("GOLONGAN")."'
			, DESKRIPSI= '".$this->getField("DESKRIPSI")."'
		WHERE KARYA_ILMIAH_ID= '".$this->getField("KARYA_ILMIAH_ID")."'
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
			 ROW_NUMBER () OVER (ORDER BY KARYA_ILMIAH_ID DESC) as NO
		FROM KARYA_ILMIAH A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY KARYA_ILMIAH_ID DESC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>