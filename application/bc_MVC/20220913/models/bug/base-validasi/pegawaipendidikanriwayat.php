<? 
  include_once(APPPATH.'/models/Entity.php');

  class PegawaiPendidikanRiwayat extends Entity{ 

	var $query;

    function PegawaiPendidikanRiwayat()
	{
      $this->Entity(); 
    }

    function insert()
	{
		$this->setField("TEMP_VALIDASI_ID", $this->getNextId("TEMP_VALIDASI_ID","validasi.PEGAWAI_PENDIDIKAN_RIWAYAT")); 
		
		$str = "INSERT INTO validasi.PEGAWAI_PENDIDIKAN_RIWAYAT (
				   PEGAWAI_PENDIDIKAN_RIWAYAT_ID, PEGAWAI_ID, PEGAWAI_PENDIDIKAN_ID, 
				   TINGKAT_PENDIDIKAN_ID, TANGGAL_LULUS, TAHUN_LULUS, 
				   NOMOR_IJAZAH, NAMA_SEKOLAH, GELAR_DEPAN, GELAR_BELAKANG, PENDIDIKAN_CPNS, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_CREATE_SATKER, TEMP_VALIDASI_ID)
				VALUES (
				  ".$this->getField("PEGAWAI_PENDIDIKAN_RIWAYAT_ID").",
				  ".$this->getField("PEGAWAI_ID").",
				  ".$this->getField("PEGAWAI_PENDIDIKAN_ID").",
				  ".$this->getField("TINGKAT_PENDIDIKAN_ID").",
				  ".$this->getField("TANGGAL_LULUS").",
				  ".$this->getField("TAHUN_LULUS").",
				  '".$this->getField("NOMOR_IJAZAH")."',
				  '".$this->getField("NAMA_SEKOLAH")."',
				  '".$this->getField("GELAR_DEPAN")."',
				  '".$this->getField("GELAR_BELAKANG")."',
				  ".$this->getField("PENDIDIKAN_CPNS").",
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("LAST_CREATE_SATKER")."',
				  ".$this->getField("TEMP_VALIDASI_ID")."
				)"; 
				
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function insertupload()
	{
		$this->setField("PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID", $this->getNextId("PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID","PEGAWAI_PENDIDIKAN_RIWAYAT_FILE")); 
		
		$str = "INSERT INTO PEGAWAI_PENDIDIKAN_RIWAYAT_FILE(
	            PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID, PEGAWAI_PENDIDIKAN_RIWAYAT_ID,  PEGAWAI_ID, TEMP_VALIDASI_ID, 
	            NAMA_FILE, LINK_FILE, TIPE_FILE, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_CREATE_SATKER)
				VALUES (
				  ".$this->getField("PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID").",
				  ".$this->getField("PEGAWAI_PENDIDIKAN_RIWAYAT_ID").",
				  '".$this->getField("PEGAWAI_ID")."',
				  ".$this->getField("TEMP_VALIDASI_ID").",
				  '".$this->getField("NAMA_FILE")."',
				  '".$this->getField("LINK_FILE")."',
				  '".$this->getField("TIPE_FILE")."',
				  '".$this->getField("LAST_CREATE_USER")."',
				  ".$this->getField("LAST_CREATE_DATE").",
				  '".$this->getField("LAST_CREATE_SATKER")."'
				)"; 
				
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "
				UPDATE validasi.PEGAWAI_PENDIDIKAN_RIWAYAT
				SET    
					   PEGAWAI_PENDIDIKAN_RIWAYAT_ID= ".$this->getField("PEGAWAI_PENDIDIKAN_RIWAYAT_ID").",
					   PEGAWAI_ID= ".$this->getField("PEGAWAI_ID").",
					   PEGAWAI_PENDIDIKAN_ID= ".$this->getField("PEGAWAI_PENDIDIKAN_ID").",
					   TINGKAT_PENDIDIKAN_ID= ".$this->getField("TINGKAT_PENDIDIKAN_ID").",
					   TANGGAL_LULUS= ".$this->getField("TANGGAL_LULUS").",
					   TAHUN_LULUS= ".$this->getField("TAHUN_LULUS").",
					   NOMOR_IJAZAH= '".$this->getField("NOMOR_IJAZAH")."',
					   NAMA_SEKOLAH= '".$this->getField("NAMA_SEKOLAH")."',
					   GELAR_DEPAN= '".$this->getField("GELAR_DEPAN")."',
					   GELAR_BELAKANG= '".$this->getField("GELAR_BELAKANG")."',
					   PENDIDIKAN_CPNS= ".$this->getField("PENDIDIKAN_CPNS").",
					  LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."',
					  LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE").",
					  LAST_UPDATE_SATKER= '".$this->getField("LAST_UPDATE_SATKER")."'
				WHERE TEMP_VALIDASI_ID=".$this->getField("TEMP_VALIDASI_ID")."
				"; 
				$this->query = $str;
				// echo $str;exit;
		return $this->execQuery($str);
    }

    function updatevalidasi()
	{
		$str = "
				UPDATE validasi.PEGAWAI_PENDIDIKAN_RIWAYAT
				SET    
					PEGAWAI_ID= ".$this->getField("PEGAWAI_ID").",
					PEGAWAI_PENDIDIKAN_ID= ".$this->getField("PEGAWAI_PENDIDIKAN_ID").",
					TINGKAT_PENDIDIKAN_ID= ".$this->getField("TINGKAT_PENDIDIKAN_ID").",
					TANGGAL_LULUS= ".$this->getField("TANGGAL_LULUS").",
					TAHUN_LULUS= ".$this->getField("TAHUN_LULUS").",
					NOMOR_IJAZAH= '".$this->getField("NOMOR_IJAZAH")."',
					NAMA_SEKOLAH= '".$this->getField("NAMA_SEKOLAH")."',
					GELAR_DEPAN= '".$this->getField("GELAR_DEPAN")."',
					GELAR_BELAKANG= '".$this->getField("GELAR_BELAKANG")."',
					PENDIDIKAN_CPNS= ".$this->getField("PENDIDIKAN_CPNS").",
					VALIDASI	= ".$this->getField("VALIDASI").",
					LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."',
					LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE").",
					LAST_UPDATE_SATKER= '".$this->getField("LAST_UPDATE_SATKER")."',
					TANGGAL_VALIDASI= NOW()
				WHERE TEMP_VALIDASI_ID= ".$this->getField("TEMP_VALIDASI_ID")."
				"; 
				$this->query = $str;
				// echo $str;exit;
		return $this->execQuery($str);
    }


    function delete()
	{
        $str = "DELETE FROM validasi.PEGAWAI_PENDIDIKAN_RIWAYAT
                WHERE 
                  PEGAWAI_PENDIDIKAN_RIWAYAT_ID= '".$this->getField("PEGAWAI_PENDIDIKAN_RIWAYAT_ID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    function deletefile()
	{
        $str = "DELETE FROM PEGAWAI_PENDIDIKAN_RIWAYAT_FILE
                  WHERE 
                  PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID= ".$this->getField("PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID")."
                  AND PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
                  "; 
				  
		$this->query = $str;
		// echo($str);exit;
        return $this->execQuery($str);
    }
    
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT A.PEGAWAI_PENDIDIKAN_RIWAYAT_ID, A.PEGAWAI_ID, A.PEGAWAI_PENDIDIKAN_ID, 
		A.TINGKAT_PENDIDIKAN_ID, A.TANGGAL_LULUS, A.TAHUN_LULUS, A.NOMOR_IJAZAH, 
		A.NAMA_SEKOLAH,A.GELAR_DEPAN, A.GELAR_BELAKANG, A.PENDIDIKAN_CPNS,B.NAMA PEGAWAI_PENDIDIKAN,C.NAMA TINGKAT_PENDIDIKAN, A.TEMP_VALIDASI_ID, VALIDASI, VALIDATOR, PERUBAHAN_DATA, TIPE_PERUBAHAN_DATA, TANGGAL_VALIDASI,COALESCE(PJ.PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID,PA.PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID)PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID,COALESCE(PJ.LINK_FILE,PA.LINK_FILE)LINK_FILE
		FROM validasi.VALIDASI_PENDIDIKAN_RIWAYAT A
		LEFT JOIN PEGAWAI_PENDIDIKAN B ON B.PEGAWAI_PENDIDIKAN_ID = A.PEGAWAI_PENDIDIKAN_ID
		LEFT JOIN TINGKAT_PENDIDIKAN C ON C.KODE = A.TINGKAT_PENDIDIKAN_ID
		LEFT JOIN PEGAWAI_PENDIDIKAN_RIWAYAT_FILE PJ ON PJ.TEMP_VALIDASI_ID = A.TEMP_VALIDASI_ID
		LEFT JOIN PEGAWAI_PENDIDIKAN_RIWAYAT_FILE PA ON PA.PEGAWAI_PENDIDIKAN_RIWAYAT_ID = A.PEGAWAI_PENDIDIKAN_RIWAYAT_ID
		WHERE 1=1

		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

     function selectByParamsCheckPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="")
	{
		$str = "
		SELECT A.PEGAWAI_ID,A.NIP_BARU 
		FROM PEGAWAI A
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }


    function selectByParamsUpload($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID")
	{
		$str = "
		SELECT A.PEGAWAI_PENDIDIKAN_RIWAYAT_FILE_ID, A.PEGAWAI_PENDIDIKAN_RIWAYAT_ID,  A.PEGAWAI_ID, A.TEMP_VALIDASI_ID, 
		A.NAMA_FILE, A.LINK_FILE, A.TIPE_FILE
		FROM PEGAWAI_PENDIDIKAN_RIWAYAT_FILE A
		LEFT JOIN validasi.PEGAWAI_PENDIDIKAN_RIWAYAT B ON A.TEMP_VALIDASI_ID = B.TEMP_VALIDASI_ID
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }

    function selectByParamsServer($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder=" ORDER BY LINK_SERVER_ID")
	{
		$str = "
		SELECT LINK_SERVER_ID, LINK_SERVER, FOLDER, JENIS
		FROM LINK_SERVER
		WHERE 1=1
		"; 
		
		while(list($key,$val) = each($paramsArray))
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$sOrder;
		$this->query = $str;
				
		return $this->selectLimit($str,$limit,$from); 
    }
        
  } 
?>