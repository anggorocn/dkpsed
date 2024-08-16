<?php
$reqId= $this->input->get('reqId');
$reqTipe= 2;

$arrtabledata= array(
    array("label"=>"No", "field"=> "NO", "display"=>"",  "width"=>"")
    , array("label"=>"Nama Mahasiswa", "field"=> "nama", "display"=>"",  "width"=>"", "nowrap"=>"1")
    , array("label"=>"Judul Artikel yang Disitasi (Jurnal/Buku, Volume, Tahun, Nomor, Halaman)", "field"=> "judul", "display"=>"",  "width"=>"10px")
    , array("label"=>"Jumlah Sitasi", "field"=> "jumlah", "display"=>"",  "width"=>"10px")
    , array("label"=>"Standar Pendidikan Tinggi yang ditetapkan oleh Perguruan Tinggi", "field"=> "standar", "display"=>"",  "width"=>"10px")

    , array("label"=>"Warna", "field"=> "WARNA", "display"=>"1",  "width"=>"")
    , array("label"=>"validasiid", "field"=> "TEMP_VALIDASI_HAPUS_ID", "display"=>"1", "width"=>"")
    , array("label"=>"validasihapusid", "field"=> "TEMP_VALIDASI_ID", "display"=>"1", "width"=>"")
    , array("label"=>"sorderdefault", "field"=> "SORDERDEFAULT", "display"=>"1", "width"=>"")
    , array("label"=>"fieldid", "field"=> "karya_ilmiah_id", "display"=>"1", "width"=>"")
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
                    <h3 class="card-label">Tabel 20. Karya Ilmiah Mahasiswa yang Disitasi (Khusus Progam Magister dan Doktor)</h3>
                </div>
                <div class="card-toolbar">
                    <!--begin::Dropdown-->
                    <div class="dropdown dropdown-inline mr-2">
                        <?if ($this->adminusergroupid==1){?>
                            <button class="btn btn-light-success" id="btnAdd"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
                    		<button class="btn btn-light-warning" id="btnUbahData"><i class="fa fa-pen" aria-hidden="true"></i> Edit</button>
                            <button class="btn btn-light-danger" id="btnBack"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                        <?}?>	
                    </div>

                    <!-- <button class="btn btn-light-primary" onclick="myFunction()"><i class="fa fa-sitemap" aria-hidden="true"></i> Satker</button> -->
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                    <thead>
                        <tr> 
                            <?
                            foreach($arrtabledata as $valkey => $valitem) 
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
    var jsonurl= "json-main/karya_ilmiah_mahasiswa_disitasi_magister_json/json?reqTipe=UMUM";
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

    $('#btnDelete').on('click', function (e) {
        if(valinfoid == "")
        {
            Swal.fire({
                text: "Pilih salah satu data Riwayat terlebih dahulu.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            });
        }
        else
        {
            urlAjax= "json-main/daftar_tabel_json/delete?reqRowId="+valinfoid;
            swal.fire({
                title: 'Apakah anda yakin untuk hapus data?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then(function(result) { 
                if (result.value) {
                    $.ajax({
                        url : urlAjax,
                        type : 'DELETE',
                        dataType:'json',
                        beforeSend: function() {
                            swal.fire({
                                title: 'Please Wait..!',
                                text: 'Is working..',
                                onOpen: function() {
                                    swal.showLoading()
                                }
                            })
                        },
                        success : function(data) { 
                            swal.fire({
                                // position: 'top-right',
                                icon: "success",
                                type: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function() {
                                document.location.href = "app/index/pelatihan_fungsional?reqId=<?=$reqId?>";
                            });
                        },
                        complete: function() {
                            swal.hideLoading();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.hideLoading();
                            var err = JSON.parse(jqXHR.responseText);
                            Swal.fire("Error", err.message, "error");
                        }
                    });
                }
            });
        }
    });

    $('#'+infotableid+' tbody').on( 'dblclick', 'tr', function () {
      $("#btnUbahData").click();    
    });

    $("#btnAdd, #btnUbahData").on("click", function () {
        btnid= $(this).attr('id');

        if(valinfoid == "" && btnid == "btnUbahData")
        {
            Swal.fire({
                text: "Pilih salah satu data terlebih dahulu.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            });
            return false;
        }

        if(btnid == "btnUbahData")
            vpilihid= valinfoid;
        else
            vpilihid= "";

        varurl= "app/page/karya_ilmiah_mahasiswa_disitasi_magister_add?reqId=<?=$reqId?>&reqRowId="+vpilihid;
        
        document.location.href = varurl;
    });

    $("#btnBack").on("click", function () {
        varurl= "app/index/daftar_tabel";
        document.location.href = varurl;
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

function submitForm() {
   $("#ktloginformsubmitbutton").click(); 
}

var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

jQuery(document).ready(function(){
    jQuery('#ktloginform').submit(function(event){ 
        event.preventDefault();
           var formData = new FormData(document.querySelector('form'));
           var form = KTUtil.getById('ktloginform');
           var formSubmitButton = KTUtil.getById('ktloginformsubmitbutton');
                KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
               $.ajax({
                url: 'json-data/info_data_json/jsondiklatteknisupload', 
                dataType: 'json', 
                cache: false,
                contentType: false,
                processData: false,
                data: formData,                         
                type: 'POST',
                beforeSend: function() {
                    swal.fire({
                        title: 'Mohon tunggu sebentar..',
                        text: 'File sedang dalam proses upload..',
                        onOpen: function() {
                            swal.showLoading()
                        }
                    })
                },
                success: function (response) {
                // console.log(response); return false;
                Swal.fire({
                    text: response.message,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn font-weight-bold btn-light-primary"
                    }
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    Swal.fire("Error", err.message, "error");
                   
                },
                complete: function () {
                    KTUtil.btnRelease(formSubmitButton);
                }
            });   
       }); 
});

function btnUploadSk(reqPegawaiId,reqRowId)
{
    $("#reqLinkFileSk").click();
    $('#reqPegawaiId').val(reqPegawaiId);
    $('#reqRowId').val(reqRowId);
}

function btnUploadStlud(reqPegawaiId,reqRowId)
{
    $("#reqLinkFileStlud").click();
    $('#reqPegawaiId').val(reqPegawaiId);
    $('#reqRowId').val(reqRowId);
}


function btnDeleteFile (fileid,reqPegawaiId,reqRowId,reqMode) {
    if(fileid !== "")
    {
        urlAjax= "json-data/info_data_json/jsondiklatteknisdeletefile?reqFileId="+fileid+"&reqPegawaiId="+reqPegawaiId+"&reqRowId="+reqRowId+"&reqMode="+reqMode;
        swal.fire({
            title: 'Apakah anda yakin untuk hapus file?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then(function(result) { 
            if (result.value) {
                $.ajax({
                    url : urlAjax,
                    type : 'DELETE',
                    dataType:'json',
                    beforeSend: function() {
                        swal.fire({
                            title: 'Please Wait..!',
                            text: 'Is working..',
                            onOpen: function() {
                                swal.showLoading()
                            }
                        })
                    },
                    success : function(data) { 
                        swal.fire({
                            position: 'center',
                            icon: "success",
                            type: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function() {
                            location.reload();
                        });
                    },
                    complete: function() {
                        swal.hideLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swal.hideLoading();
                        var err = JSON.parse(jqXHR.responseText);
                        Swal.fire("Error", err.message, "error");
                    }
                });
            }
        });
    }
}

$("#filter,#reqStatusHukuman").change(function() { 
    setCariInfo()
})

function calltreeid(id, nama)
{   
    $("#reqId").val(id);
    $("#bagian").text(nama);
    setCariInfo()
}
function setCariInfo(){
    $('#vlsxloading').show();
     jsonurl= "json-main/pegawai_json/json?reqStatusHukuman=" + $("#reqStatusHukuman").val() + "&reqSearch=" + $("#filter").val() + "&reqId="+$("#reqId").val();
    // jsonurl= "json-admin/export_json/jsonpegawaidiklat?reqBulan="+reqBulan+"&reqTahun="+reqTahun;
    datanewtable.DataTable().ajax.url(jsonurl).load();
    $('#vlsxloading').hide();
} 
</script>publikasi_ilmiah_mahasiswa