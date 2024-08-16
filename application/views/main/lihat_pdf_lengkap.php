<?php

$this->load->model("base/Upload");

$table_nama= $this->input->get('table_nama');
$table_field= $this->input->get('table_field');
$dosen_id= $this->input->get('dosen_id');

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

        <!-- FOnt Awesome -->
        <link rel="stylesheet" href="assets/css/css-beautify-minify.css" rel="stylesheet" type="text/css" >

        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

        <link rel="shortcut icon" href="assets/media/logos/favicon.png" />
        <script src="assets/plugins/global/plugins.bundle.js"></script>

        <script type="text/javascript" src="lib/jquery-easyui-1.4.2/jquery.easyui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/gaya.css">
        <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
    </head>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper" style="padding-left: 0px;padding-top: 0px;">
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="background: url(images/bg-login.jpg); background-size: 100% 100%; background-color: #e9edf0;padding: 0px;">
                        <div class="d-flex flex-column-fluid">
                            <div class="container" style="padding: 0px; margin: 0px auto; height: 100%">
                                <div class="card card-custom" style="margin-top: 3%;">
                                    <div class="row">
                                        <div class="col-md-6" style="padding: 25px;">
                                            <table id="tabel-data" class="display" style="width:100%;padding: 25px !important;">
                                                <thead>
                                                    <?
                                                    if($table_field=='praktik_professional'){?>
                                                        <tr>
                                                            <th>Produk</th>
                                                            <th>Lihat</th>
                                                        </tr>
                                                    <?}
                                                    else if($table_field=='penelitian'){?>
                                                        <tr>
                                                            <th>Judul Artikel</th>
                                                            <th>Lihat</th>
                                                        </tr>
                                                    <?}
                                                    else if($table_field=='luaran'){?>
                                                        <tr>
                                                            <th>Judul</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    <?}?>
                                                </thead>
                                                <tbody>
                                                    <?
                                                    if($table_field=='praktik_professional'){
                                                        $set= new Upload();
                                                        $set->selectByParamsPraktikProfesional(array('dosen_id'=>$dosen_id));
                                                        // echo $setTable->query;exit;
                                                        $i=0;
                                                        while($set->nextRow()){
                                                            $reqNama= $set->getField('NAMA');
                                                            $reqDesc= $set->getField('DESKRIPSI');
                                                            $reqOrg= $set->getField('ORGANISASI_LAIN');
                                                            $reqRekog= $set->getField('REKOGNISI');
                                                            $reqId= $set->getField('praktik_profesional_id');
                                                            ?>
                                                            <tr>
                                                                <input type="hidden" id='reqNama<?=$reqId?>' value="<?=$reqNama?>">
                                                                <input type="hidden" id='reqDesc<?=$reqId?>' value="<?=$reqDesc?>">
                                                                <input type="hidden" id='reqOrg<?=$reqId?>' value="<?=$reqOrg?>">
                                                                <input type="hidden" id='reqRekog<?=$reqId?>' value="<?=$reqRekog?>">
                                                                <td>
                                                                   <?=$reqDesc?>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-light-success" onclick="muncul(<?=$reqId?>,<?=$i?>)"></i> Lihat PDF</a>
                                                                </td>
                                                            </tr>        
                                                        <?
                                                        $i++;
                                                        }
                                                    }
                                                    else if($table_field=='penelitian'){
                                                        $set= new Upload();
                                                        $set->selectByParamsPenelitian(array('dosen_id'=>$dosen_id));
                                                        // echo $setTable->query;exit;
                                                        $i=0;
                                                        while($set->nextRow()){
                                                            $reqJudul= $set->getField('JUDUL');
                                                            $reqSitasi= $set->getField('Sitasi');
                                                            $reqRekognisi= $set->getField('REKOGNISI');
                                                            $reqId= $set->getField('penelitian_id');
                                                            ?>
                                                            <tr>
                                                                <input type="hidden" id='reqJudul<?=$reqId?>' value="<?=$reqJudul?>">
                                                                <input type="hidden" id='reqSitasi<?=$reqId?>' value="<?=$reqSitasi?>">
                                                                <input type="hidden" id='reqRekognisi<?=$reqId?>' value="<?=$reqRekognisi?>">
                                                                <td>
                                                                   <?=$reqJudul?>
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-light-success" onclick="muncul(<?=$reqId?>,<?=$i?>)"></i> Lihat PDF</a>
                                                                </td>
                                                            </tr>        
                                                        <?
                                                        $i++;
                                                        }
                                                    }else if($table_field=='luaran'){
                                                        $set= new Upload();
                                                        $set->selectByParamsLuaran(array('luaran_penelitian_mahasiswa_id'=>$dosen_id));
                                                        // echo $setTable->query;exit;
                                                        $i=0;
                                                        while($set->nextRow()){
                                                            $reqJudul= $set->getField('JUDUL');
                                                            $reqTahun= $set->getField('Tahun');
                                                            $reqKeterangan= $set->getField('Keterangan');
                                                            $reqSitasi= $set->getField('TAHUN');
                                                            $reqId= $set->getField('luaran_penelitian_mahasiswa_detail_id');
                                                            ?>
                                                            <tr>
                                                                <input type="hidden" id='reqJudul<?=$reqId?>' value="<?=$reqJudul?>">
                                                                <input type="hidden" id='reqSitasi<?=$reqId?>' value="<?=$reqTahun?>">
                                                                <input type="hidden" id='reqRekognisi<?=$reqId?>' value="<?=$reqKeterangan?>">
                                                                <td>
                                                                   <?=$reqJudul?><br>(<?=$reqTahun?>)
                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-light-success" onclick="muncul(<?=$reqId?>,<?=$i?>)"></i> Lihat PDF</a>
                                                                </td>
                                                            </tr>        
                                                        <?
                                                        $i++;
                                                        }
                                                    }?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6" style="display:none" id='pdfdetil'>
                                            <?
                                            if($table_field=='praktik_professional'){?>
                                                Nama Produk/Jasa : <span id='reqNamaTemp'></span><br>
                                                Deskripsi Produk/Jasa : <span id='reqDescTemp'></span><br>
                                                Keterlibatan Organisasi diluar PS : <span id='reqOrgTemp'></span><br>
                                                Rekognisi Bidang Praktik dan Profesional : <span id='reqRekogTemp'></span><br>
                                            <?}
                                            else if($table_field=='penelitian'){?>
                                                Judul Artikel yang Disitasi : <span id='reqJudulTemp'></span><br>
                                                Jumlah Sitasi : <span id='reqSitasiTemp'></span><br>
                                                Rekognisi Bidang Penelitian : <span id='reqRekognisiTemp'></span><br>
                                            <?}
                                            else if($table_field=='luaran'){?>
                                                Judul : <span id='reqJudulTemp'></span><br>
                                                Tahun : <span id='reqSitasiTemp'></span><br>
                                                Keterangan : <span id='reqRekognisiTemp'></span><br>
                                            <?}?>
                                            <iframe id='pdfViewer' src="uploads/sample.pdf" style="width:100%; height:90vh;" frameborder="0"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>

    </body>
</html>

<script>
    $(document).ready(function(){
        $('#tabel-data').DataTable({
            "pageLength": 5,
            "lengthMenu": [5,10,20] 
        });
    });

    function muncul(arg,id) {
        $('#pdfdetil').show();
        <?if($table_field=='praktik_professional'){?>
            $('#reqNamaTemp').html($('#reqNama'+arg).val());
            $('#reqDescTemp').html($('#reqDesc'+arg).val());
            $('#reqOrgTemp').html($('#reqOrg'+arg).val());
            $('#reqRekogTemp').html($('#reqRekog'+arg).val());
            $('#pdfViewer').attr('src', 'uploads/<?=$dosen_id?>/praktik_dan_profesional_'+id+'.pdf');
        <?}
        else if($table_field=='penelitian'||$table_field=='luaran'){?>
            $('#reqJudulTemp').html($('#reqJudul'+arg).val());
            $('#reqSitasiTemp').html($('#reqSitasi'+arg).val());
            $('#reqRekognisiTemp').html($('#reqRekognisi'+arg).val());
            $('#pdfViewer').attr('src', 'uploads/<?=$dosen_id?>/penelitian_'+id+'.pdf');
        <?}?>
}
</script>