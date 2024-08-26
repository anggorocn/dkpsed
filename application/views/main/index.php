<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-data/InfoData");
$this->load->library('globalmenu');

$adminusernama= $this->adminusernama;

$userpegawaimode= $this->userpegawaimode;
$adminuserid= $this->adminuserid;
$reqId= $this->input->get('reqId');

$reqPegawaiId= $this->userpegawaimode;

$formulaid= $this->input->get("formulaid");
$reqPegawaiHard= $this->input->get("reqPegawaiHard");
$rencanasuksesiid= $this->input->get("rencanasuksesiid");
$set= new InfoData();
$set->selectbyparamspegawai(array("A.PEGAWAI_ID"=>$reqPegawaiId),-1,-1);
$set->firstRow();
// echo $set->query; exit;
$reqNama= $set->getField('NAMA');
$reqSatker= $set->getField('NMSATKER');
$reqEmail= $set->getField('EMAIL');
$reqLogo= substr($reqNama, 0, 1);

// untuk kondisi file
$vfpeg= new globalmenu();

$index_set=0;
$arrMenu= [];
$arrparam= ["mode"=>"personal", "formulaid"=>$formulaid, "rencanasuksesiid"=>$rencanasuksesiid];
$arrMenu= $vfpeg->harcodemenu($arrparam);

$arrparam= ["pg"=>$pg, "arrMenu"=>$arrMenu];
$arrcarimenuparent= $vfpeg->cariparentmenu($arrparam);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?=base_url()?>">
        <meta charset="utf-8" />
        <title>Aplikasi DKPSED Online</title>
        <meta name="description" content="User profile block example" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/custom/jstree/jstree.bundle.css" rel="stylesheet" type="text/css" />

        <!-- FOnt Awesome -->
        <link rel="stylesheet" href="assets/css/css-beautify-minify.css" rel="stylesheet" type="text/css" >

        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

        <link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/brand/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/aside/light.css" rel="stylesheet" type="text/css" />

        <link rel="shortcut icon" href="assets/media/logos/favicon.png" />
        <link href="assets/css/new-style.css" rel="stylesheet" type="text/css" />
        <!-- easy ui -->
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>

    
        <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="assets/js/valsix-serverside.js"></script>
        <script src="assets/plugins/custom/jstree/jstree.bundle.js"></script>

        <script src="assets/emodal/eModal.min.js"></script>

        <link rel="stylesheet" type="text/css" href="lib/jquery-easyui-1.4.2/themes/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="lib/jquery-easyui-1.4.2/themes/icon.css">

        <script type="text/javascript" src="lib/jquery-easyui-1.4.2/jquery.easyui.min.js"></script>

        <script>
            function openAdd(pageUrl,judul) {
                eModal.iframe(pageUrl, 'Detil File')
            }
            function closePopup() {
                eModal.close();
            }

        </script>

        <!-- <script script type="text/javascript" src="js/highcharts.js"></script> -->
        <!-- <script src="lib/highcharts/jquery-3.1.1.min.js"></script> -->
        <script src="lib/highcharts/highcharts-spider.js"></script>
        <script src="lib/highcharts/highcharts-more.js"></script>
        <script src="lib/highcharts/exporting-spider.js"></script>
        <script src="lib/highcharts/export-data.js"></script>
        <script src="lib/highcharts/accessibility.js"></script>

        <style type="text/css">
            .brand {
                padding-left: 0px;
            }
            .card.card-custom {
              margin-top: 0%;
            }
            .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
             background-color: #EBEBE4;
            }
            .active{
                background-color: #c5dfb4 !important;
            }
            .active span{
                background-color: #c5dfb4 !important;
            }
            .activeFont{
                color: white !important;                
            }
            th {
              padding-top: 12px;
              padding-bottom: 12px;
              text-align: left;
              background-color: #3f9dff;
              color: white !important;
            }
        </style>

        <link rel="stylesheet" type="text/css" href="assets/css/gaya.css">       
        
    </head>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <?if($pg != "login"){?>
            <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
                <a href="app">
                    <img alt="Logo" src="images/logo.png" />
                </a>
                <div class="d-flex align-items-center">
                    <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
                        <span></span>
                    </button>
                    <a href="login/logout" class="btn btn-sm btn-light-primary " style="margin-left: 5px;">Sign Out</a>
                </div>
            </div>
        <?}?>

        <div class="d-flex flex-column flex-root">

            <div class="d-flex flex-row flex-column-fluid page">

                <?
                if($pg == "login"){}
                else 
                {
                ?>
                <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">

                    <div class="brand flex-column-auto" id="kt_brand">

                        <a href="app" class="brand-logo">
                            <!-- <img alt="Logo" src="images/logo-aplikasi.png" /> -->
                            <h2 style="margin: auto;" alt="Logo">DKPSED ONLINE</h2>
                        </a>
                    </div>
                    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

                        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500" style="border: 0px solid red; margin-top: 0px !important; margin-bottom: 0px !important;">
                            <!--begin::Menu Nav-->
                            <ul class="menu-nav">
                                <li class="menu-item menu-item-submenu  menu-item-here" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="app/index/home" class="menu-link menu-toggle <?if(Selectpage($pg,'home')!=null){ echo 'active';}?>" >
                                        <span class="menu-text" <?if(Selectpage($pg,'home')!=''){ echo 'activeFont';}?>>
                                            <i class="fa fa-home" aria-hidden="true" style="color: #FFFFFF;margin-right: 10px;"></i> Home
                                        </span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                </li>
                                <?if($this->adminusergroupid==1){?>
                                    <li class="menu-item menu-item-submenu menu-item-here" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="javascript:void(0);" class="menu-link menu-toggle <?if(Selectpage($pg,'pengaturan')!=''){ echo 'active';}?>">
                                            <span class="menu-text <?if(Selectpage($pg,'pengaturan')!=''){ echo 'activeFont';}?> "><i class="fa fa-gear <?if(Selectpage($pg,'pengaturan')!=''){ echo 'activeFont';}?>" aria-hidden="true" style="color: #FFFFFF;margin-right: 10px;"></i> Pengaturan</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu" <?if(Selectpage($pg,'pengaturan')!=''){?>style="display: block; overflow: hidden;<?}?>">
                                            <ul class="menu-subnav">
                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="app/index/pengguna" class="menu-link <?if($pg=='pengguna'||$pg=='pengguna_add'){ echo 'active';}?>">
                                                        <span class="menu-text <?if($pg=='pengguna'||$pg=='pengguna_add'){ echo 'activeFont';}?>" style="margin:auto;margin-right:10px;">Pengguna</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="app/index/profil_dosen" class="menu-link <?if($pg=='profil_dosen' || $pg=='profil_dosen_add'){ echo 'active';}?>">
                                                        <span class="menu-text <?if($pg=='profil_dosen' || $pg=='profil_dosen_add'){ echo 'activeFont';}?>" style="margin:auto;margin-right:10px;">Profil Dosen</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="app/index/jurusan" class="menu-link <?if($pg=='jurusan'||$pg=='jurusan_add'){ echo 'active';}?>">
                                                        <span class="menu-text <?if($pg=='jurusan'||$pg=='jurusan_add'){ echo 'activeFont';}?>" style="margin:auto;margin-right:10px;">Jurusan</span>
                                                    </a>
                                                </li>
                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="app/index/total_mahasiswa" class="menu-link <?if($pg=='total_mahasiswa'||$pg=='total_mahasiswa_add'){ echo 'active';}?>">
                                                        <span class="menu-text <?if($pg=='total_mahasiswa'||$pg=='total_mahasiswa_add'){ echo 'activeFont';}?>" style="margin:auto;margin-right:10px;">Total Mahasiswa</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                <?}
                                else{?>
                                    <li class="menu-item menu-item-submenu  menu-item-here" aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="app/index/identitas" class="menu-link menu-toggle <?if($pg=='identitas'){ echo 'active';}?>">
                                            <span class="menu-text">
                                                <i class="fa fa-folder" aria-hidden="true" style="color: #FFFFFF;margin-right: 10px;"></i> Identitas
                                            </span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                    </li>
                                <?}?>
                                <li class="menu-item menu-item-submenu  menu-item-here" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="app/index/daftar_tabel" class="menu-link menu-toggle <?if(Selectpage($pg,'daftar_tabel')!='' ){ echo 'active';}?>">
                                        <span class="menu-text">
                                            <i class="fa fa-table" aria-hidden="true" style="color: #FFFFFF;margin-right: 10px;"></i> Daftar Tabel
                                        </span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu  menu-item-here" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="app/index/evaluasi_diri" class="menu-link menu-toggle <?if(Selectpage($pg,'evaluasi_diri')!=''){ echo 'active';}?>">
                                        <span class="menu-text"><i class="fa fa-check-square" aria-hidden="true" style="color: #FFFFFF;margin-right: 10px;"></i> Evaluasi Diri <??></span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu  menu-item-here" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="app/index/penilaian" class="menu-link menu-toggle <?if(Selectpage($pg,'penilaian')!=''){ echo 'active';}?>">
                                        <span class="menu-text"><i class="fa fa-edit" aria-hidden="true" style="color: #FFFFFF;margin-right: 10px;"></i> Hasil Penilaian<??></span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                </li>
                                <li class="menu-item menu-item-submenu  menu-item-here" aria-haspopup="true" data-menu-toggle="hover">
                                    <a href="app/index/kurikulum" class="menu-link menu-toggle <?if(Selectpage($pg,'kurikulum')!=''){ echo 'active';}?>"  >
                                        <span class="menu-text"><i class="fa fa-edit" aria-hidden="true" style="color: #FFFFFF;margin-right: 10px;"></i> Kurikulum</span>
                                        <i class="menu-arrow"></i>
                                    </a>
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>
                <? 
                } 
                ?>

                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper" <? if($pg == "login"){ ?> style="padding-left: 0px;"<? } ?>>

                    <div id="kt_header" class="header header-fixed">
                        <div class="container-fluid d-flex align-items-stretch justify-content-between">
                            <!-- <div class="logo-header"><img src="images/logo-aplikasi-hide.png" height="70"></div> -->
                            <?
                            if($pg == "login"){} 
                            else 
                            { 
                            ?>
                            <? 
                            }
                            ?>

                            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                                <?
                                if($pg == "pegawai_data_fip")
                                {
                                ?>
                                <div class="area-menu-fip">
                                    <nav class="navbar navbar-default">
                                        <div class="container-fluid">
                                            <div class="navbar-header">
                                                <button type="button" class="navbar-toggle collapsed btn btn-warning" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i class="fa fa-id-card" aria-hidden="true"></i> <span>Menu&nbsp;FIP</span>
                                                    <span class="sr-only">Toggle navigation</span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                    <span class="icon-bar"></span>
                                                </button>
                                            </div>
                                            <div id="navbar" class="navbar-collapse collapse">

                                                <div class="panel-group" id="accordion">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">FIP 01</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapse1" class="panel-collapse collapse in">
                                                            <div class="panel-body">
                                                                <ul class="nav navbar-nav">
                                                                    <li><a href="#">Lokasi Kerja</a></li>
                                                                    <li><a href="#">Identitas Pegawai</a></li>
                                                                    <li><a href="#">Pengalaman Kerja</a></li>
                                                                    <li><a href="#">SK PNS</a></li>
                                                                    <li><a href="#">SK CPNS</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">FIP 02</a>
                                                            </h4>
                                                        </div>
                                                        <div id="collapse2" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <ul class="nav navbar-nav">
                                                                    <li><a href="#">Riwayat Pangkat</a></li>
                                                                    <li><a href="#">Riwayat Jabatan</a></li>
                                                                    <li><a href="#">Riwayat Tugas Tambahan</a></li>
                                                                    <li><a href="#">Riwayat Gaji</a></li>
                                                                    <li><a href="#">Pendidikan Umum</a></li>
                                                                    <li><a href="#">Pelatihan Kepemimpinan</a></li>
                                                                    <li><a href="#">Pelatihan Fungsional</a></li>
                                                                    <li><a href="#">Diklat Lpj</a></li>
                                                                    <li><a href="#">Pelatihan Teknis</a></li>
                                                                    <li><a href="#">Seminar/Workshop</a></li>
                                                                    <li><a href="#">Pelatihan Non Klasikal</a></li>
                                                                    <li><a href="#">Orang Tua</a></li>
                                                                    <li><a href="#">Mertua</a></li>
                                                                    <li><a href="#">Suami Istri</a></li>
                                                                    <li><a href="#">Anak</a></li>
                                                                    <li><a href="#">Saudara</a></li>
                                                                    <li><a href="#">Organisasi</a></li>
                                                                    <li><a href="#">Penghargaan</a></li>
                                                                    <li><a href="#">Penilaian Potensi Diri</a></li>
                                                                    <li><a href="#">Catatan Prestasi</a></li>
                                                                    <li><a href="#">Hukuman</a></li>
                                                                    <li><a href="#">Cuti</a></li>
                                                                    <li><a href="#">Tambahan Masa Kerja</a></li>
                                                                    <li><a href="#">Ijin Belajar</a></li>
                                                                    <li><a href="#">Sertifikat Pendidik</a></li>
                                                                    <li><a href="#">Sertifikat Profesi</a></li>
                                                                    <li><a href="#">P.A.K</a></li>
                                                                    <li><a href="#">SKP</a></li>
                                                                    <li><a href="#">Kinerja</a></li>
                                                                    <li><a href="#">Komparasi Data SIMPEG & SIASN</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </nav>    
                                </div>
                                <? 
                                }
                                ?>
                                <div class="header-menu header-menu-mobile header-menu-layout-default"></div>
                            </div>

                            <?
                            if($pg == "login"){}
                            else
                            { 
                            ?>
                            <div class="topbar" style="width: 84%; ">
                                <div class="row" style="width:100%;margin: auto;">
                                    <div class="col-md-9" style="line-height: 1.2;">
                                        <span>
                                            <b>
                                                AKREDITASI PROGRAM STUDI<br>
                                                LEMBAGA AKREDITASI MANDIRI -<span style="color: blue;"> EKONOMI, MANAJEMEN, AKUTANSI DAN BISNIS</span><br>
                                                UNIVERSITAS MUHAMMADIYAH JAKARTA
                                            </b>
                                        </span>
                                    </div>
                                    <div class="col-md-3" style="padding-left: 90px;">
                                        <div class="topbar-item">
                                            <div class="xxxtes btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" style="white-space: nowrap;">
                                                <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1"></span>
                                                <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?=$reqNama?></span>
                                                <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                                                    <span class="symbol-label font-size-h5 font-weight-bold" style="white-space: nowrap;width: 100%;">
                                                        <?=$this->adminusernama?> &nbsp; 
                                                        <i class="fa fa-user" aria-hidden="true" style="color: #feb607; font-size:30px ;"></i>
                                                    </span>
                                                </span>
                                                <a href="login/logout" class="btn btn-sm btn-light-primary " style="margin-left: 5px;">Sign Out</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <? 
                            }
                            ?>
                        </div>
                    </div>

                    <?
                    if($pg == "login"){?>
                        <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="background: url(images/bg-login.jpg); background-size: 100% 100%; padding: 0px;">
                            <?=$content?>
                        </div>
                    <?}
                    else 
                    {
                    ?>
                        <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="background: url(images/bg-login.jpg); background-size: 100% 100%; padding-bottom: 0px;background-color: #e9edf0;">
                            <?=$content?>
                        </div>
                    <?}?>

                    <?if($pg == "login"){?>

                    <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                        <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted font-weight-bold mr-2">© 2024</span>
                                <a class="text-dark-75 text-hover-primary">Created by Abdul Gofur Ahmad</a>
                            </div>
                        </div>
                    </div>
                    <?}?>
                </div>

                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Main-->

        <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
            <!--begin::Header-->
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
                <h3 class="font-weight-bold m-0">User Profile
                <small class="text-muted font-size-sm ml-2"></small></h3>
                <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="offcanvas-content pr-5 mr-n5">
                <!--begin::Header-->
                <div class="d-flex align-items-center mt-5">
                    <div class="symbol symbol-100 mr-5">
                        <? 
                        $file_name_direktori ='C:\xampp\htdocs\simpeg_v2\uploads\pegawai\FOTO_BLOB-'.$reqPegawaiId.'.jpg';
						$file_name_url= 'http://220.247.172.178:7179/simpeg_v2/uploads/pegawai/FOTO_BLOB-'.$reqPegawaiId.'.jpg';
                        if (file_exists($file_name_direktori)) 
                        {
                            ?>
                            <img src="\simpeg_v2\uploads\pegawai\FOTO_BLOB-<?=$reqPegawaiId?>.jpg" alt="image" />
                            <? 
                        }
                        else
                        {
                            ?>
                            <div class="symbol-label" style="background-image:url('assets/media/users/blank.png')"></div>
                            <?
                        }
                        ?>
                        <i class="symbol-badge bg-success"></i>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?=$adminusernama?></a>
                        <div class="text-muted mt-1"><?=$reqSatker?></div>
                        <div class="navi mt-2">
                            <a href="#" class="navi-item">
                                <span class="navi-link p-0 pb-2">
                                    <span class="navi-icon mr-1">
                                        <span class="svg-icon svg-icon-lg svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
                                                    <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <span class="navi-text text-muted text-hover-primary"><?=$reqEmail?></span>
                                </span>
                            </a>
                            <?
                            if(!empty($adminuserid))
                            {
                            ?>
                            <a href="login/logout" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
                            <?
                            }
                            else
                            {
                            ?>
                            <a href="javascript:void(0);" onclick="setkembali()" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Kembali</a>
                            <?  
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed mt-8 mb-5"></div>

                <div class="navi navi-spacer-x-0 p-0">

                    <a class="navi-item">
                        <div class="navi-link">
                            <div class="navi-text">
                                <div class="font-weight-bold">My Profile</div>
                                <div class="text-muted">Account settings and more
                            </div>
                        </div>
                    </a>
                    <!--end:Item-->
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Content-->
        </div>
        <!-- end::User Panel-->

    </body>
</html>