<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/DaftarTabel");
$this->load->model("base/ProfilDosen");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqId');

if(!empty($reqId))
{
    $set= new DaftarTabel();
    $set->selectByParams(array('daftar_tabel_id'=>$reqId));
    // echo $set->query;exit;
    $set->firstRow();
    $reqNama= $set->getField('NAMA');

    $set= new ProfilDosen();
    $stetement='and dosen_id not in (select dosen_id from daftar_tabel_detil where daftar_tabel_id='.$reqId.') ';
    $set->selectByParams(array(),-1,-1, $stetement);
    // echo $set->query;exit;
    $arrdropdown=array();
    while($set->nextRow()){
        $array=['dosen_id'=>$set->getField('DOSEN_ID'),'nama'=>$set->getField('nama')];
        array_push($arrdropdown,$array);
    }
    // print_r($arrdropdown);
}

?>

<link href="lib/bootstrap-3.3.7/docs/examples/navbar/navbar.css" rel="stylesheet">

<div class="d-flex flex-column-fluid">
    <div class="container">
        <!-- <div class="area-menu-fip">
            ffffj hai
        </div> -->
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label"> Setting <?=$reqNama?></h3>
                </div>
                <div class="card-toolbar">
                    <div class="dropdown dropdown-inline mr-2">
                        <button class="btn btn-light-danger"  onclick="window.history.go(-1); return false;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                    </div>
                </div>
            </div>
            <form class="form" id="ktloginform" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-2 col-sm-12">Dosen</label>
                        <div class="col-lg-10 col-sm-12">
                            <a onclick="create_tr(1)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
                            
                            <table class='tableadd' >
                                <thead>
                                    <tr>
                                        <th style="width:47%;">Dosen</th>
                                        <th style="width:6%;"></th>
                                    </tr>
                                </thead>
                                <tbody id='table1'>
                                    <?
                                    $set= new DaftarTabel();
                                    $stetement='and daftar_tabel_id='.$reqId;
                                    $set->selectByParamsDetil1(array(),-1,-1, $stetement);
                                    while($set->nextRow()){
                                        $dosen_id=$set->getField('DOSEN_ID');
                                        $dosen_nama=$set->getField('nama');
                                        ?>
                                        <tr>
                                            <td>
                                               <input type="hidden" value="<?=$dosen_id?>" name="reqDosenId[]">
                                               <input type="text" class="form-control" value="<?=$dosen_nama?>">
                                            </td>
                                            <td style="width:5px">
                                               <a class="btn btn-light-danger" onclick="remove_tr(this)"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>   
                                    <?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-9">
                                <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                                <input type="hidden" name="reqId" value="<?=$reqId?>">
                                <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
                                <input type="hidden" name="reqTempValidasiId" value="<?=$reqTempValidasiId?>">
                                <button type="submit" id="ktloginformsubmitbutton" class="btn btn-light-success"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(function () {
        $("[rel=tooltip]").tooltip({ placement: 'right'});
        // $('[data-toggle="tooltip"]').tooltip()
    })

    var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';
    jQuery(document).ready(function() {
        var form = KTUtil.getById('ktloginform');
        var formSubmitUrl = "json-main/daftar_tabel_json/addDosen";
        var formSubmitButton = KTUtil.getById('ktloginformsubmitbutton');
        if (!form) {
            return;
        }
        FormValidation
        .formValidation(
            form,
            {
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
            )
        .on('core.form.valid', function() {
                // Show loading state on button
                KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
                var formData = new FormData(document.querySelector('form'));
                $.ajax({
                    url: formSubmitUrl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        // console.log(response); return false;
                        // Swal.fire("Good job!", "You clicked the button!", "success");
                        Swal.fire({
                            text: response.message,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function() {
                            reqid=response.message.split('-');
                            document.location.href = "app/page/profil_dosen_status_kepegawaian_add?reqId="+reqid[0];
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
            })
        .on('core.form.invalid', function() {
            Swal.fire({
                text: "Maaf, isi semua form yang disediakan, silahkan coba lagi.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, saya mengerti",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-light-primary"
                }
            }).then(function() {
                KTUtil.scrollTop();
            });
        });
    });

    arrows= {leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>'};
    $('.kttanggal').datepicker({
        todayHighlight: true
        , autoclose: true
        , orientation: "bottom left"
        , clearBtn: true
        , format: 'dd-mm-yyyy'
        , templates: arrows
    });

    $("#reqGroup").select2({
        placeholder: "Pilih salah satu data",
        allowClear: true
    });

</script>

<script type="text/javascript">
     $("#btnBack").on("click", function () {
        varurl= "app/page/profil_dosen_status_kepegawaian";
        document.location.href = varurl;
    });

    function create_tr(table_id) {

        var scntDiv = document.getElementById('table'+table_id)
        array='';

        <?for($i=0; $i<count($arrdropdown); $i++){?>
            array=array+`<option value='<?=$arrdropdown[$i]['dosen_id']?>'><?=$arrdropdown[$i]['nama']?></option>`
        <?}?>

        keterangan=`
            <select class="form-control" name="reqDosenId[]">`+array+`</select>`;

        infodata= `
        <tr>
            <td>
                `+keterangan+`
            </td>
            <td style="width:5px">
               <a class="btn btn-light-danger" onclick="remove_tr(this)"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </td>
        </tr>   
        `;
        var elm = $(infodata).appendTo(scntDiv); 

    }


    function remove_tr(This) {
        This.closest('tr').remove();
    }
</script>