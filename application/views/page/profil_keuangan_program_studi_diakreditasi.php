<style type="text/css">
    .treegrid-container {
            overflow-x: auto;
        }
        .datagrid-body{
            overflow-x: scroll !important;
        }
        .datagrid-cell-group{
            width: 100% !important;
        }
</style>
<?php
$reqId= $this->input->get('reqId');

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"")
    , array("label"=>"Nama Dosen", "field"=> "NAMA", "display"=>"",  "width"=>"", "nowrap"=>"1")
    , array("label"=>"Status", "field"=> "status", "display"=>"",  "width"=>"")
    , array("label"=>"Jabatan", "field"=> "JABATAN_AKADEMIK", "display"=>"",  "width"=>"")
    , array("label"=>"Diploma", "field"=> "pendidikan_diploma", "display"=>"",  "width"=>"")
    , array("label"=>"Sarjana/ Sarjana Terapan", "field"=> "pendidikan_sarjana", "display"=>"",  "width"=>"")
    , array("label"=>"Magister/ Magister Terapan", "field"=> "PENDIDIKAN_MAGISTER", "display"=>"",  "width"=>"")
    , array("label"=>"Doktor/ Doktor Terapan", "field"=> "PENDIDIKAN_SPESIALIS", "display"=>"",  "width"=>"")
    , array("label"=>"Sertifikat  Kompetensi/ Profesi/Industri", "field"=> "sertifikat_lain", "display"=>"",  "width"=>"")

    , array("label"=>"Warna", "field"=> "WARNA", "display"=>"1",  "width"=>"")
    , array("label"=>"validasiid", "field"=> "TEMP_VALIDASI_HAPUS_ID", "display"=>"1", "width"=>"")
    , array("label"=>"validasihapusid", "field"=> "TEMP_VALIDASI_ID", "display"=>"1", "width"=>"")
    , array("label"=>"sorderdefault", "field"=> "SORDERDEFAULT", "display"=>"1", "width"=>"")
    , array("label"=>"fieldid", "field"=> "profil_dosen_kontribusi_intelektual_3_id", "display"=>"1", "width"=>"")
);
?>


<!-- SELECT2 -->
<link href="lib/select2totreemaster/src/select2totree.css" rel="stylesheet">
<script src="lib/select2/select2.min.js"></script>
<script src="lib/select2totreemaster/src/select2totree.js"></script>

<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container">

        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label">Tabel 5. Profil Tenaga Kependidikan</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <div class="dropdown dropdown-inline mr-2">
                        <?if ($this->adminusergroupid==1){?>
                            <button class="btn btn-light-warning" id="btnUbahData"><i class="fa fa-pen" aria-hidden="true"></i> Edit</button>
                            <button class="btn btn-light-danger" id="btnBack"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                        <?}?>   
                    </div>

                    <!-- <button class="btn btn-light-primary" onclick="myFunction()"><i class="fa fa-sitemap" aria-hidden="true"></i> Satker</button> -->
                </div>
            </div>

            <div class="card-body">
                <table id="treeSatker" class="easyui-treegrid" style="width:100%; height:600px" data-options="
                    url: '<?=base_url()?>json-main/profil_keuangan_program_studi_diakreditasi_json/treetable/',
                    pagination: true,            
                    pageSize: 50,
                    pageList: [50, 100],
                     fitColumns: false,
                    method: 'get',
                    idField: 'id',
                    treeField: 'NAMA',
                   onBeforeLoad: function(row,param){
                        if (!row) {    // load top level rows
                            param.id = 0;    // set id=0, indicate to load new page rows
                        }
                    },
                ">
                    <thead>
                        <tr>
                            <th rowspan="2" data-options="field:'NAMA'" >Jenis Sumber/Penggunaan</th>
                            <th colspan="4" height="100px">Unit Pengelola Program Studi <br>(dalam Jutaan Rupiah)</th>
                            <th colspan=4>Program Studi yang Di Akreditasi (Jt)</th>
                            <th colspan=3 style="width:210px">Program Studi yang di Akreditasi (%)</th>
                            <th colspan=3 style="width:240px">PS Lain di UPPS yang Tidak di Akreditasi (%)</th>
                        </tr>
                        <tr>
                            <th data-options="field:'pengelolah_ts_2'">TS-2</th>
                            <th data-options="field:'pengelolah_ts_1'">TS-1</th>
                            <th data-options="field:'pengelolah_ts'">TS</th>
                            <th data-options="field:'pengelolah_avg'">Rata-rata</th>
                            <th data-options="field:'prodi_ts_2'">TS-2</th>
                            <th data-options="field:'prodi_ts_1'">TS-1</th>
                            <th data-options="field:'prodi_ts'">TS</th>
                            <th data-options="field:'prodi_avg'">Rata-rata</th>
                            <th data-options="field:'prodi_ts_2_persen'" style="width:70px;">TS-2</th>
                            <th data-options="field:'prodi_ts_1_persen'" style="width:70px">TS-1</th>
                            <th data-options="field:'prodi_ts_persen'" style="width:70px">TS</th>
                            <th data-options="field:'prodi_lain_ts_2_persen'" style="width:80px">TS-2</th>
                            <th data-options="field:'prodi_lain_ts_1_persen'" style="width:80px">TS-1</th>
                            <th data-options="field:'prodi_lain_persen'" style="width:80px">TS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>
