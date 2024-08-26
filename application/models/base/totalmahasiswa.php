<? 
include_once(APPPATH.'/models/Entity.php');

class TotalMahasiswa extends Entity{ 

    var $query;

    function TotalMahasiswa()
    {
        $this->Entity(); 
    }

    function insert()
    {
        $this->setField("TOTAL_MAHASISWA_ID", $this->getNextId("TOTAL_MAHASISWA_ID","TOTAL_MAHASISWA"));

        $str = "
        INSERT INTO TOTAL_MAHASISWA
        (
            TOTAL_MAHASISWA_ID, TAHUN, SEMESTER, TOTAL
        )
        VALUES
        (
            '".$this->getField('TOTAL_MAHASISWA_ID')."',
            '".$this->getField('TAHUN')."',
            '".$this->getField('SEMESTER')."',
            '".$this->getField('TOTAL')."'
        )";

        $this->id= $this->getField("TOTAL_MAHASISWA_ID");
        $this->query = $str;
        // echo $str;exit;

        return $this->execQuery($str);
    }

    function update()
    {
        $str = "
        UPDATE TOTAL_MAHASISWA
        SET    
            TAHUN='".$this->getField('TAHUN')."'
            ,SEMESTER='".$this->getField('SEMESTER')."'
            ,TOTAL='".$this->getField('TOTAL')."'
        WHERE TOTAL_MAHASISWA_ID= '".$this->getField("TOTAL_MAHASISWA_ID")."'
        "; 
        $this->query = $str;
        return $this->execQuery($str);
    }

    function delete()
    {
        $str = "
        DELETE FROM TOTAL_MAHASISWA
        WHERE 
        TOTAL_MAHASISWA_ID = '".$this->getField("TOTAL_MAHASISWA_ID")."'";
        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='')
    {
        $str = "
        SELECT
            *,
             ROW_NUMBER () OVER (ORDER BY total_mahasiswa_id asc) as NO
        FROM total_mahasiswa A
        WHERE 1=1 "; 
        
        while(list($key,$val) = each($paramsArray))
        {
            $str .= " AND $key = '$val' ";
        }
        
        $str .= $statement." ORDER BY total_mahasiswa_id ASC";
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