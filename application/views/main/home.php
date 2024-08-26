<?php
$reqId= $this->input->get('reqId');

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"")
    , array("label"=>"Uraian", "field"=> "Nama", "display"=>"",  "width"=>"", "nowrap"=>"1")
    , array("label"=>"Pendidikan ", "field"=> "pendidikan_dashbord", "display"=>"",  "width"=>"10px")
    , array("label"=>"Jabatan Akademik ", "field"=> "Jabatan_akademik", "display"=>"",  "width"=>"10px")

    , array("label"=>"Warna", "field"=> "WARNA", "display"=>"1",  "width"=>"")
    , array("label"=>"validasiid", "field"=> "TEMP_VALIDASI_HAPUS_ID", "display"=>"1", "width"=>"")
    , array("label"=>"validasihapusid", "field"=> "TEMP_VALIDASI_ID", "display"=>"1", "width"=>"")
    , array("label"=>"sorderdefault", "field"=> "SORDERDEFAULT", "display"=>"1", "width"=>"")
    , array("label"=>"fieldid", "field"=> "dosen_id", "display"=>"1", "width"=>"")
);

$arrtabledata2= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"")
    , array("label"=>"Tahun Ajaran", "field"=> "tahun", "display"=>"",  "width"=>"", "nowrap"=>"1")
    , array("label"=>"Jumlah", "field"=> "total", "display"=>"",  "width"=>"", "nowrap"=>"1")

    , array("label"=>"Warna", "field"=> "WARNA", "display"=>"1",  "width"=>"")
    , array("label"=>"validasiid", "field"=> "TEMP_VALIDASI_HAPUS_ID", "display"=>"1", "width"=>"")
    , array("label"=>"validasihapusid", "field"=> "TEMP_VALIDASI_ID", "display"=>"1", "width"=>"")
    , array("label"=>"sorderdefault", "field"=> "SORDERDEFAULT", "display"=>"1", "width"=>"")
    , array("label"=>"fieldid", "field"=> "dosen_id", "display"=>"1", "width"=>"")
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
                    <h3 class="card-label">Home </h3>
                </div>
            </div>


            <div class="card-body">
                <h1 class="card-label"><b>Data Dosen Homebase</b></h1>
                <br>
                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                    <thead>
                        <tr>
                            <?php
                            foreach($arrtabledata as $valkey => $valitem) 
                            {
                                echo "<th>".$valitem["label"]."</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="card-body">
                <h1 class="card-label"><b>Jumlah Mahasiswa </b></h1>
                <br>
                <table class="table table-bordered table-hover table-checkable" id="kt_datatable2" style="margin-top: 13px !important">
                    <thead>
                        <tr>
                            <?php
                            foreach($arrtabledata2 as $valkey => $valitem) 
                            {
                                echo "<th>".$valitem["label"]."</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>

<div style="height:0px;overflow:hidden">
    <form id="ktloginform" method="POST" enctype="multipart/form-data" autocomplete="off">
        <input type="file" id="reqLinkFileSk" name="reqLinkFileSk" accept=".pdf" onchange="submitForm();"/>
        <input type="file" id="reqLinkFileStlud" name="reqLinkFileStlud" accept=".pdf" onchange="submitForm();"/>
        <input type="hidden" id="reqDetilId" name="reqDetilId" />
        <input type="hidden" id="reqPegawaiId" name="reqPegawaiId" />
        <input type="hidden" id="reqRowId" name="reqRowId" />
        <input type="hidden" id="reqId" name="reqId" />
        <button type="submit" id="ktloginformsubmitbutton"  class="btn btn-primary font-weight-bold mr-2">Simpan</button>
    </form>
</div>


<script type="text/javascript">
    var datanewtable;
    var infotableid= "kt_datatable";
    var carijenis= "";
    var arrdata= <?php echo json_encode($arrtabledata); ?>;
    // console.log(arrdata);
    var indexfieldid= arrdata.length - 1;
    var indexvalidasiid= arrdata.length - 3;
    var indexvalidasihapusid= arrdata.length - 4;
    var valinfoid = '';
    var valinfovalidasiid = '';
    var valinfovalidasihapusid = '';
    var datainfopage = '5';

    jQuery(document).ready(function() {
        var jsonurl= "json-main/home_json/json";
        ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);

        var infoid= [];
        $('#'+infotableid+' tbody').on( 'click', 'tr', function () {
            // untuk pilih satu data, kalau untuk multi comman saja
            $('#'+infotableid+' tbody tr').removeClass('selected');

            var el= $(this);
            el.addClass('selected');

            var dataselected= datanewtable.DataTable().row(this).data();
            // console.log(dataselected);
            // console.log(Object.keys(dataselected).length);
            fieldinfoid= arrdata[indexfieldid]["field"]
            fieldvalidasiid= arrdata[indexvalidasiid]["field"]
            fieldvalidasihapusid= arrdata[indexvalidasihapusid]["field"]
            valinfoid= dataselected[fieldinfoid];
            valinfovalidasiid= dataselected[fieldvalidasiid];
            valinfovalidasihapusid= dataselected[fieldvalidasihapusid];
            if (valinfovalidasiid == null)
            {
                valinfovalidasiid = '';
            }
        });
    });

    var datanewtable2;
    var infotableid2= "kt_datatable2";
    var carijenis2= "";
    var arrdata2= <?php echo json_encode($arrtabledata2); ?>;
    // console.log(arrdata);
    var indexfieldid2= arrdata2.length - 1;
    var indexvalidasiid2= arrdata2.length - 3;
    var indexvalidasihapusid2= arrdata2.length - 4;
    var valinfoid2 = '';
    var valinfovalidasiid2 = '';
    var valinfovalidasihapusid2 = '';
    var datainfopage = '5';

    jQuery(document).ready(function() {
        var jsonurl2= "json-main/total_mahasiswa_json/json";
        ajaxserverselectsingle.init(infotableid2, jsonurl2, arrdata2);

        var infoid= [];
        $('#'+infotableid2+' tbody').on( 'click', 'tr', function () {
            // untuk pilih satu data, kalau untuk multi comman saja
            $('#'+infotableid2+' tbody tr').removeClass('selected');

            var el= $(this);
            el.addClass('selected');

            var dataselected2= datanewtable2.DataTable().row(this).data();
            // console.log(dataselected);
            // console.log(Object.keys(dataselected).length);
            fieldinfoid2= arrdata2[indexfieldid2]["field"]
            fieldvalidasiid2= arrdata2[indexvalidasiid2]["field"]
            fieldvalidasihapusid2= arrdata2[indexvalidasihapusid2]["field"]
            valinfoid2= dataselected2[fieldinfoid2];
            valinfovalidasiid2= dataselected2[fieldvalidasiid2];
            valinfovalidasihapusid2= dataselected2[fieldvalidasihapusid2];
            if (valinfovalidasiid2 == null)
            {
                valinfovalidasiid2 = '';
            }
        });    
    });
 
</script>