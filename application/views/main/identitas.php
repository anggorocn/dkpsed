<?
include_once("functions/personal.func.php");

$this->load->model("base/Identitas");

$arrProgram=array();
$set= new Identitas();
$set->selectByParamsProgram(array());
while ($set->nextRow()) {
    array_push($arrProgram,array("id"=>$set->getField("ID") , "text"=>$set->getField("NAMA")));
}

// $arrProdi=array();
// $set= new Identitas();
// $set->selectByParamsProgram(array());
// while ($set->nextRow()) {
//     array_push($arrProdi,array("id"=>$set->getField("ID") , "text"=>$set->getField("NAMA")));
// }

$set= new Identitas();
$set->selectByParamsIdentitas(array());
$set->firstRow();
$reqAlamat=$set->getField("ALAMAT");
$reqKadaluarsa=dateFormatBulanNama($set->getField("KADALUARSA"));
$reqKota=$set->getField("NAMA_KOTA");
$reqNamaPengelolah=$set->getField("NAMA_PENGELOLAH");
$reqTelpon=$set->getField("TELPON");
$reqNamaKampus=$set->getField("NAMA_KAMPUS");
$reqEmail=$set->getField("EMAIL");
$reqNamaDosen=$set->getField("NAMA_DOSEN");
$reqWebsite=$set->getField("WEBSITE");
$reqTanggal=dateFormatBulanNama($set->getField("TANGGAL"));
$reqHp=$set->getField("HP");
$reqTsAwal=$set->getField("TS_AWAL");
$reqTsAkhir=$set->getField("TS_AKHIR");
$reqProgramStudy=$set->getField("nama_studi");
// print_r(count($arrProgram));exit;
?>

<!-- Bootstrap core CSS -->
<link href="lib/bootstrap-3.3.7/docs/examples/navbar/navbar.css" rel="stylesheet">

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label">Identitas</h3>
                </div>
            </div>
            <form class="form" id="ktloginform" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Program</label>
                        <!-- <?if(count($arrProgram)==1){?>
                            <span class="col-form-label col-lg-4 col-sm-12"><?=$arrProgram[0]['text']?></span>
                        <?}
                        else{?>
                            <div class="col-lg-4 col-sm-12">
                                <select class="form-control">
                                    <option>Strata Satu (S1) – Sarjana</option>
                                    <option>Strata Satu (S1) – Sarjana Terapan</option>
                                    <option>Strata Dua (S2) – Magister</option>
                                    <option>Strata Dua (S2) – Magister Terapan</option>
                                    <option>Strata Tiga (S3) – Doktor </option>
                                    <option>Strata Tiga (S3) – Doktor Terapan </option>
                                </select>
                            </div>
                        <?}?> -->
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$arrProgram[0]['text']?></span>

                        <label class="col-form-label text-right col-lg-2 col-sm-12"></label>
                        <span class="col-form-label col-lg-4 col-sm-12"></span>
                    
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Nama Program Studi</label>
                        <!-- <div class="col-lg-4 col-sm-12">
                            <select class="form-control">
                                <option>xxxxxxxx</option>
                            </select>
                        </div> -->
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqProgramStudy?></span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Alamat</label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqAlamat?></span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Tanggal Kadaluarsa</label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqKadaluarsa?></span>

                        <label class="col-form-label text-right col-lg-2 col-sm-12">Kota/Kabupaten </label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqKota?>  </span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Nama Unit Pengelola </label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqNamaPengelolah?></span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">No Telepon </label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqTelpon?></span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Perguruan Tinggi </label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqNamaKampus?></span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Alamat Email </label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqEmail?></span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Nama Narahubung</label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqNamaDosen?></span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Website</label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqWebsite?></span>
                        
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Tanggal</label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqTanggal?></span>
                        
                        <label class="col-form-label text-right col-lg-6 col-sm-12"></label>

                        <label class="col-form-label text-right col-lg-2 col-sm-12">Telepon Seluler</label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqHp?></span>

                        <label class="col-form-label text-right col-lg-2 col-sm-12">TS</label>
                        <span class="col-form-label col-lg-4 col-sm-12"><?=$reqTsAwal?> / <?=$reqTsAkhir?></span>

                        <label class="col-form-label text-right col-lg-7 col-sm-12"></label>
                        <span class="col-form-label col-lg-5 col-sm-12" style="color: red; font-size: 1rem;">*TS = Tahun Akademik penuh terakhir saat pengajuan akreditasi</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
