<? 
include_once(APPPATH.'/models/Entity.php');

class WaktuTungguLulusan extends Entity{ 

	var $query;

	function WaktuTungguLulusan()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("waktu_tunggu_lulusan_id", $this->getNextId("waktu_tunggu_lulusan_id","waktu_tunggu_lulusan"));

		$str = "
		INSERT INTO waktu_tunggu_lulusan
		(
			waktu_tunggu_lulusan_id, tahun, jumlah, jumlah_terlacak, jumlah_dipesan
			, waktu1_1, waktu1_2, waktu1_3
			, waktu2_1, waktu2_2, waktu2_3
			, waktu3_1, waktu3_2, waktu3_3
			, standar, tingkatan
		)
		VALUES
		(
			".$this->getField("waktu_tunggu_lulusan_id")."
			, '".$this->getField("tahun")."'
			, '".$this->getField("jumlah")."'
			, '".$this->getField("jumlah_terlacak")."'
			, '".$this->getField("jumlah_dipesan")."'
			, '".$this->getField("waktu1_1")."'
			, '".$this->getField("waktu1_2")."'
			, '".$this->getField("waktu1_3")."'
			, '".$this->getField("waktu2_1")."'
			, '".$this->getField("waktu2_2")."'
			, '".$this->getField("waktu2_3")."'
			, '".$this->getField("waktu3_1")."'
			, '".$this->getField("waktu3_2")."'
			, '".$this->getField("waktu3_3")."'
			, '".$this->getField("standar")."'
			, '".$this->getField("tingkatan")."'
		)";

		$this->id= $this->getField("waktu_tunggu_lulusan_id");
		$this->query = $str;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE waktu_tunggu_lulusan
		SET    
			tahun= '".$this->getField("tahun")."'
			, jumlah= '".$this->getField("jumlah")."'
			, jumlah_terlacak= '".$this->getField("jumlah_terlacak")."'
			, jumlah_dipesan= '".$this->getField("jumlah_dipesan")."'
			, waktu1_1= '".$this->getField("waktu1_1")."'
			, waktu1_2= '".$this->getField("waktu1_2")."'
			, waktu1_3= '".$this->getField("waktu1_3")."'
			, waktu2_1= '".$this->getField("waktu2_1")."'
			, waktu2_2= '".$this->getField("waktu2_2")."'
			, waktu2_3= '".$this->getField("waktu2_3")."'
			, waktu3_1= '".$this->getField("waktu3_1")."'
			, waktu3_2= '".$this->getField("waktu3_2")."'
			, waktu3_3= '".$this->getField("waktu3_3")."'
			, standar= '".$this->getField("standar")."'
			, tingkatan= '".$this->getField("tingkatan")."'
		WHERE waktu_tunggu_lulusan_id= '".$this->getField("waktu_tunggu_lulusan_id")."'
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
			 ROW_NUMBER () OVER (ORDER BY waktu_tunggu_lulusan_id) as NO
		FROM waktu_tunggu_lulusan A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY waktu_tunggu_lulusan_id ASC";
		$this->query = $str;
		// echo $statement;exit;
				
		return $this->selectLimit($str,$limit,$from); 
    }


} 
?>