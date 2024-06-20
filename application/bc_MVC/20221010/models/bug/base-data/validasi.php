<? 
  include_once(APPPATH.'/models/Entity.php');

  class Validasi extends Entity{ 

    var $query;
    function Validasi()
    {
      $this->Entity(); 
    }

    function selectByParamsMonitoring($paramsArray=array(),$limit=-1,$from=-1, $statement='', $sOrder="ORDER BY A.PEGAWAI_ID, A.FORM_FIP ASC")
  {
    $str= "
    SELECT
    A.PEGAWAI_ID, A.SATKER_ID, A.VALIDASI, CASE WHEN A.VALIDASI = 0 THEN 'DITOLAK' WHEN A.VALIDASI = 1 THEN 'VALIDASI' ELSE 'BELUM VALIDASI' END VALIDASI_INFO, A.NIP_BARU_VIEW, A.GROUP_NAMA, 
    A.SATKER, A.FORM_FIP, A.TIPE_PERUBAHAN_DATA, A.TANGGAL_PROSES, A.TANGGAL_VALIDASI
    FROM
    (
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Anak' FORM_FIP,
      CASE WHEN  A.ANAK_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.ANAK A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Anak' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN ANAK B ON A.TEMP_VALIDASI_ID = B.ANAK_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'ANAK'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Penguasaan Bahasa' FORM_FIP,
      CASE WHEN  A.BAHASA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.BAHASA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Penguasaan Bahasa' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN BAHASA B ON A.TEMP_VALIDASI_ID = B.BAHASA_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'BAHASA'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Cuti' FORM_FIP,
      CASE WHEN  A.CUTI_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.CUTI A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Cuti' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN CUTI B ON A.TEMP_VALIDASI_ID = B.CUTI_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'CUTI'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Diklat Fungsional' FORM_FIP,
      CASE WHEN  A.DIKLAT_FUNGSIONAL_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.DIKLAT_FUNGSIONAL A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Diklat Fungsional' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN DIKLAT_FUNGSIONAL B ON A.TEMP_VALIDASI_ID = B.DIKLAT_FUNGSIONAL_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'DIKLAT_FUNGSIONAL'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Diklat Struktural' FORM_FIP,
      CASE WHEN  A.DIKLAT_STRUKTURAL_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.DIKLAT_STRUKTURAL A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Diklat Struktural' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN DIKLAT_STRUKTURAL B ON A.TEMP_VALIDASI_ID = B.DIKLAT_STRUKTURAL_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'DIKLAT_STRUKTURAL'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Diklat Teknis' FORM_FIP,
      CASE WHEN  A.DIKLAT_TEKNIS_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.DIKLAT_TEKNIS A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Diklat Teknis' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN DIKLAT_TEKNIS B ON A.TEMP_VALIDASI_ID = B.DIKLAT_TEKNIS_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'DIKLAT_TEKNIS'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Riwayat Gaji' FORM_FIP,
      CASE WHEN  A.GAJI_RIWAYAT_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.GAJI_RIWAYAT A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Riwayat Gaji' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN GAJI_RIWAYAT B ON A.TEMP_VALIDASI_ID = B.GAJI_RIWAYAT_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'GAJI_RIWAYAT'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Hukuman' FORM_FIP,
      CASE WHEN  A.HUKUMAN_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HUKUMAN A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Hukuman' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN HUKUMAN B ON A.TEMP_VALIDASI_ID = B.HUKUMAN_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'HUKUMAN'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Riwayat Jabatan' FORM_FIP,
      CASE WHEN  A.JABATAN_RIWAYAT_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.JABATAN_RIWAYAT A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Riwayat Jabatan' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN JABATAN_RIWAYAT B ON A.TEMP_VALIDASI_ID = B.JABATAN_RIWAYAT_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'JABATAN_RIWAYAT'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Kursus' FORM_FIP,
      CASE WHEN  A.KURSUS_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.KURSUS A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Kursus' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN KURSUS B ON A.TEMP_VALIDASI_ID = B.KURSUS_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'KURSUS'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Organisasi' FORM_FIP,
      CASE WHEN  A.ORGANISASI_RIWAYAT_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.ORGANISASI_RIWAYAT A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Organisasi' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN ORGANISASI_RIWAYAT B ON A.TEMP_VALIDASI_ID = B.ORGANISASI_RIWAYAT_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'ORGANISASI_RIWAYAT'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Riwayat Pangkat' FORM_FIP,
      CASE WHEN  A.PANGKAT_RIWAYAT_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PANGKAT_RIWAYAT A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Riwayat Pangkat' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN PANGKAT_RIWAYAT B ON A.TEMP_VALIDASI_ID = B.PANGKAT_RIWAYAT_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'PANGKAT_RIWAYAT'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Penataran' FORM_FIP,
      CASE WHEN  A.PENATARAN_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PENATARAN A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Penataran' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN PENATARAN B ON A.TEMP_VALIDASI_ID = B.PENATARAN_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'PENATARAN'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Pendidikan Umum' FORM_FIP,
      CASE WHEN  A.PENDIDIKAN_RIWAYAT_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PENDIDIKAN_RIWAYAT A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Pendidikan Umum' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN PENDIDIKAN_RIWAYAT B ON A.TEMP_VALIDASI_ID = B.PENDIDIKAN_RIWAYAT_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'PENDIDIKAN_RIWAYAT'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 01, Pengalaman Kerja' FORM_FIP,
      CASE WHEN  A.PENGALAMAN_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PENGALAMAN A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 01, Pengalaman Kerja' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN PENGALAMAN B ON A.TEMP_VALIDASI_ID = B.PENGALAMAN_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'PENGALAMAN'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Penghargaan' FORM_FIP,
      CASE WHEN  A.PENGHARGAAN_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PENGHARGAAN A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Penghargaan' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN PENGHARGAAN B ON A.TEMP_VALIDASI_ID = B.PENGHARGAAN_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'PENGHARGAAN'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Penilaian DP-3' FORM_FIP,
      CASE WHEN  A.PENILAIAN_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PENILAIAN A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Penilaian DP-3' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN PENILAIAN B ON A.TEMP_VALIDASI_ID = B.PENILAIAN_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'PENILAIAN'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Penilaian Potensi Diri' FORM_FIP,
      CASE WHEN  A.POTENSI_DIRI_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.POTENSI_DIRI A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Penilaian Potensi Diri' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN POTENSI_DIRI B ON A.TEMP_VALIDASI_ID = B.POTENSI_DIRI_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'POTENSI_DIRI'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Catatan Prestasi' FORM_FIP,
      CASE WHEN  A.PRESTASI_KERJA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PRESTASI_KERJA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Catatan Prestasi' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN PRESTASI_KERJA B ON A.TEMP_VALIDASI_ID = B.PRESTASI_KERJA_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'PRESTASI_KERJA'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Saudara' FORM_FIP,
      CASE WHEN  A.SAUDARA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.SAUDARA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Saudara' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN SAUDARA B ON A.TEMP_VALIDASI_ID = B.SAUDARA_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'SAUDARA'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Seminar' FORM_FIP,
      CASE WHEN  A.SEMINAR_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.SEMINAR A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Seminar' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN SEMINAR B ON A.TEMP_VALIDASI_ID = B.SEMINAR_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'SEMINAR'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Riwayat Penugasan' FORM_FIP,
      CASE WHEN  A.TUGAS_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.TUGAS A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'FIP - 02, Riwayat Penugasan' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN TUGAS B ON A.TEMP_VALIDASI_ID = B.TUGAS_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'TUGAS'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'Lain-lain, Penilaian Prestasi Kerja (SKP)' FORM_FIP,
      CASE WHEN  A.PENILAIAN_KERJA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PENILAIAN_KERJA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      UNION ALL
      SELECT B.PEGAWAI_ID, C.SATKER_ID, A.VALIDASI,
      C.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(C.NIP_BARU),'') || ' - ' || C.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(C.SATKER_ID) SATKER,
      'Lain-lain, Penilaian Prestasi Kerja (SKP)' FORM_FIP,
      'HAPUS DATA' TIPE_PERUBAHAN_DATA,
      A.LAST_CREATE_DATE TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.HAPUS_DATA A
      INNER JOIN PENILAIAN_KERJA B ON A.TEMP_VALIDASI_ID = B.PENILAIAN_KERJA_ID
      INNER JOIN PEGAWAI C ON C.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE A.HAPUS_NAMA = 'PENILAIAN_KERJA'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 01, SK CPNS' FORM_FIP,
      CASE WHEN  A.SK_CPNS_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.SK_CPNS A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      AND CASE WHEN A.SK_CPNS_ID IS NULL THEN 1 ELSE (SELECT 1 FROM SK_CPNS X WHERE X.SK_CPNS_ID = A.SK_CPNS_ID) END = 1
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 01, SK PNS' FORM_FIP,
      CASE WHEN  A.SK_PNS_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.SK_PNS A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Tambahkan Masa Kerja' FORM_FIP,
      CASE WHEN  A.TAMBAHAN_MASA_KERJA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.TAMBAHAN_MASA_KERJA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Suami Istri' FORM_FIP,
      CASE WHEN  A.SUAMI_ISTRI_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.SUAMI_ISTRI A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
      AND CASE WHEN A.SUAMI_ISTRI_ID IS NULL THEN 1 ELSE (SELECT 1 FROM SUAMI_ISTRI X WHERE X.SUAMI_ISTRI_ID = A.SUAMI_ISTRI_ID) END = 1
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Orang Tua Laki - Laki' FORM_FIP,
      CASE WHEN  A.ORANG_TUA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.ORANG_TUA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1 AND A.JENIS_KELAMIN = 'L'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Orang Tua Perempuan' FORM_FIP,
      CASE WHEN  A.ORANG_TUA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.ORANG_TUA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1 AND A.JENIS_KELAMIN = 'P'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Mertua Laki - Laki' FORM_FIP,
      CASE WHEN  A.MERTUA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.MERTUA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1 AND A.JENIS_KELAMIN = 'L'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 02, Mertua Perempuan' FORM_FIP,
      CASE WHEN  A.MERTUA_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.MERTUA A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1 AND A.JENIS_KELAMIN = 'P'
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP - 01, Identitas Pegawai' FORM_FIP,
      CASE WHEN  A.PEGAWAI_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PEGAWAI A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
    UNION ALL
      SELECT A.PEGAWAI_ID, B.SATKER_ID, A.VALIDASI,
      B.NIP_BARU NIP_BARU_VIEW,
      COALESCE(AMBIL_FORMAT_NIP_BARU(B.NIP_BARU),'') || ' - ' || B.NAMA GROUP_NAMA,
      AMBIL_SATKER_NAMA(B.SATKER_ID) SATKER,
      'FIP , Diklat' FORM_FIP,
      CASE WHEN  A.PEGAWAI_ID IS NULL THEN 'TAMBAH DATA' ELSE 'UBAH DATA' END TIPE_PERUBAHAN_DATA,
      COALESCE(A.LAST_UPDATE_DATE, A.LAST_CREATE_DATE) TANGGAL_PROSES, 
      A.TANGGAL_VALIDASI
      FROM VALIDASI.PEGAWAI_DIKLAT A
      INNER JOIN PEGAWAI B ON A.PEGAWAI_ID = B.PEGAWAI_ID
      WHERE 1=1
    ) A
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