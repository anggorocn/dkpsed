<?php
$reqId= $this->input->get('reqId');

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"")
    , array("label"=>"Bidang", "field"=> "NAMA", "display"=>"",  "width"=>"10px")
   
    , array("label"=>"Warna", "field"=> "WARNA", "display"=>"1",  "width"=>"")
    , array("label"=>"validasiid", "field"=> "TEMP_VALIDASI_HAPUS_ID", "display"=>"1", "width"=>"")
    , array("label"=>"validasihapusid", "field"=> "TEMP_VALIDASI_ID", "display"=>"1", "width"=>"")
    , array("label"=>"sorderdefault", "field"=> "SORDERDEFAULT", "display"=>"1", "width"=>"")
    , array("label"=>"fieldid", "field"=> "BIDANG_ID", "display"=>"1", "width"=>"")
);

$arrtabledata1= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"")
    , array("label"=>"Perguruan Tinggi ", "field"=> "kampus_nama", "display"=>"",  "width"=>"10px")
    , array("label"=>"Fakultas", "field"=> "fakultas_nama", "display"=>"",  "width"=>"10px")
    , array("label"=>"Program", "field"=> "master_program_nama", "display"=>"",  "width"=>"10px")
    , array("label"=>"Program Studi", "field"=> "NAMA", "display"=>"",  "width"=>"10px")
    , array("label"=>"LAM", "field"=> "nama_lam", "display"=>"",  "width"=>"10px")

    , array("label"=>"Warna", "field"=> "WARNA", "display"=>"1",  "width"=>"")
    , array("label"=>"validasiid", "field"=> "TEMP_VALIDASI_HAPUS_ID", "display"=>"1", "width"=>"")
    , array("label"=>"validasihapusid", "field"=> "TEMP_VALIDASI_ID", "display"=>"1", "width"=>"")
    , array("label"=>"sorderdefault", "field"=> "SORDERDEFAULT", "display"=>"1", "width"=>"")
    , array("label"=>"fieldid", "field"=> "PROGRAM_STUDI_ID", "display"=>"1", "width"=>"")
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
                    <h3 class="card-label">Pengaturan</h3>
                </div>
            </div>

            <div class="card-header">
                <div class="card-title">
                    <h2>Master Lembaga Akreditasi Mandiri</h2>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <div class="dropdown dropdown-inline mr-2">
                        <?if ($this->adminusergroupid==1){?>
                            <button class="btn btn-light-primary" id="btnAdd"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
                            <button class="btn btn-light-warning" id="btnUbahData"><i class="fa fa-pen" aria-hidden="true"></i> Edit</button>
                        <?}?>   
                    </div>
                </div>
            </div>

            <div class="card-body">
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
            <br>
            <br>
            <div class="card-header">
                <div class="card-title">
                    <h2>Master Program Prodi</h2>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <div class="dropdown dropdown-inline mr-2">
                        <?if ($this->adminusergroupid==1){?>
                            <button class="btn btn-light-primary" id="btnAdd"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
                            <button class="btn btn-light-warning" id="btnUbahData"><i class="fa fa-pen" aria-hidden="true"></i> Edit</button>
                        <?}?>   
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-hover table-checkable" id="kt_datatable1" style="margin-top: 13px !important">
                    <thead>
                        <tr>
                            <?php
                            foreach($arrtabledata1 as $valkey => $valitem) 
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


<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>
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

    jQuery(document).ready(function() {
        var jsonurl= "json-main/bidang_json/json";
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

        $("#buttoncaridetil").on("click", function () {
            carijenis= "2";
            calltriggercari();
        });
        $("#triggercari").on("click", function () {

            if(carijenis == "1")
            {
                pencarian= $('#'+infotableid+'_filter input').val();
                datanewtable.DataTable().search( pencarian ).draw();
            }
            else
            {
                
            }
        });

    });

    function calltriggercari()
    {
        $(document).ready( function () {
          $("#triggercari").click();      
        });
    }
</script>

<script type="text/javascript">
    var datanewtable1;
    var infotableid1= "kt_datatable1";
    var carijenis1= "";
    var arrdata1= <?php echo json_encode($arrtabledata1); ?>;
    // console.log(arrdata);
    var indexfieldid1= arrdata1.length - 1;
    var indexvalidasiid1= arrdata1.length - 3;
    var indexvalidasihapusid1= arrdata1.length - 4;
    var valinfoid1 = '';
    var valinfovalidasiid1 = '';
    var valinfovalidasihapusid1 = '';

    jQuery(document).ready(function() {
        var jsonurl= "json-main/prodi_json/json";
        ajaxserverselectsingle.init(infotableid1, jsonurl, arrdata1);

        var infoid= [];
        $('#'+infotableid+' tbody').on( 'click', 'tr', function () {
            // untuk pilih satu data, kalau untuk multi comman saja
            $('#'+infotableid+' tbody tr').removeClass('selected');

            var el= $(this);
            el.addClass('selected');

            var dataselected= datanewtable1.DataTable().row(this).data();
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

        $("#buttoncaridetil").on("click", function () {
            carijenis= "2";
            calltriggercari1();
        });
        $("#triggercari1").on("click", function () {

            if(carijenis == "1")
            {
                pencarian= $('#'+infotableid+'_filter input').val();
                datanewtable1.DataTable().search( pencarian ).draw();
            }
            else
            {
                
            }
        });

    });

    function calltriggercari1()
    {
        $(document).ready( function () {
          $("#triggercari1").click();      
        });
    }

</script>