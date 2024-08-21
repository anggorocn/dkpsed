<? 
include_once(APPPATH.'/models/Entity.php');

class ProfilDosen extends Entity{ 

	var $query;

	function ProfilDosen()
	{
		$this->Entity(); 
	}

	function insert()
	{
		$this->setField("dosen_id", $this->getNextId("dosen_id","dosen"));

		$str = "
		INSERT INTO dosen
		(
			dosen_id, nama, status, nidn, jabatan_akademik, status_akademisi, perusahaan, pendidikan_magister,
			pendidikan_spesialis, bidang_keahlian, sertifikat_pendidikan, ts_2, ts_1, ts, avg,
			ts_2_lain, ts_1_lain, ts_lain, avg_lain, avg_total, ps_diakreditasi, ps_lain_dalam, ps_lain_luar,
			penelitian, pkm, penunjang, sks, avg_sks,google_scholar,pendidikan_diploma,pendidikan_sarjana
		)
		VALUES
		(
			'".$this->getField('dosen_id')."',
			'".$this->getField('nama')."',
			'".$this->getField('status')."',
			'".$this->getField('nidn')."',
			'".$this->getField('jabatan_akademik')."',
			'".$this->getField('status_akademisi')."',
			'".$this->getField('perusahaan')."',
			'".$this->getField('pendidikan_magister')."',
			'".$this->getField('pendidikan_spesialis')."',
			'".$this->getField('bidang_keahlian')."',
			'".$this->getField('sertifikat_pendidikan')."',
			'".$this->getField('ts_2')."',
			'".$this->getField('ts_1')."',
			'".$this->getField('ts')."',
			'".$this->getField('avg')."',
			'".$this->getField('ts_2_lain')."',
			'".$this->getField('ts_1_lain')."',
			'".$this->getField('ts_lain')."',
			'".$this->getField('avg_lain')."',
			'".$this->getField('avg_total')."',
			'".$this->getField('ps_diakreditasi')."',
			'".$this->getField('ps_lain_dalam')."',
			'".$this->getField('ps_lain_luar')."',
			'".$this->getField('penelitian')."',
			'".$this->getField('pkm')."',
			'".$this->getField('penunjang')."',
			'".$this->getField('sks')."',
			'".$this->getField('avg_sks')."',
			'".$this->getField('google_scholar')."',
			'".$this->getField('pendidikan_diploma')."',
			'".$this->getField('pendidikan_sarjana')."'
		)";

		$this->id= $this->getField("dosen_id");
		$this->query = $str;
		// echo $str;exit;

		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
		UPDATE dosen
		SET    
			nama='".$this->getField('nama')."',
			status='".$this->getField('status')."',
			nidn='".$this->getField('nidn')."',
			jabatan_akademik='".$this->getField('jabatan_akademik')."',
			status_akademisi='".$this->getField('status_akademisi')."',
			perusahaan = '".$this->getField('perusahaan')."',
			pendidikan_magister = '".$this->getField('pendidikan_magister')."',
			pendidikan_spesialis = '".$this->getField('pendidikan_spesialis')."',
			bidang_keahlian = '".$this->getField('bidang_keahlian')."',
			sertifikat_pendidikan = '".$this->getField('sertifikat_pendidikan')."',
			ts_2 = '".$this->getField('ts_2')."',
			ts_1 = '".$this->getField('ts_1')."',
			ts = '".$this->getField('ts')."',
			avg = '".$this->getField('avg')."',
			ts_2_lain = '".$this->getField('ts_2_lain')."',
			ts_1_lain = '".$this->getField('ts_1_lain')."',
			ts_lain = '".$this->getField('ts_lain')."',
			avg_lain = '".$this->getField('avg_lain')."',
			avg_total = '".$this->getField('avg_total')."',
			ps_diakreditasi = '".$this->getField('ps_diakreditasi')."',
			ps_lain_dalam = '".$this->getField('ps_lain_dalam')."',
			ps_lain_luar = '".$this->getField('ps_lain_luar')."',
			penelitian = '".$this->getField('penelitian')."',
			pkm = '".$this->getField('pkm')."',
			penunjang = '".$this->getField('penunjang')."',
			sks = '".$this->getField('sks')."',
			avg_sks = '".$this->getField('avg_sks')."',
			google_scholar = '".$this->getField('google_scholar')."',
			pendidikan_diploma = '".$this->getField('pendidikan_diploma')."',
			pendidikan_sarjana = '".$this->getField('pendidikan_sarjana')."'
		WHERE dosen_id= '".$this->getField("dosen_id")."'
		"; 
		$this->query = $str;
		return $this->execQuery($str);
    }

    function delete()
	{
        $str = "
        DELETE FROM DOSEN
        WHERE 
        DOSEN_ID = '".$this->getField("DOSEN_ID")."'";
		$this->query = $str;
		// echo $str;exit;
        return $this->execQuery($str);
    }

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='')
	{
		$str = "
		SELECT
			*,
			 ROW_NUMBER () OVER (ORDER BY dosen_id asc) as NO
		FROM dosen A
		WHERE 1=1 "; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ORDER BY dosen_id ASC";
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