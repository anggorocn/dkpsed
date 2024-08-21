<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/DaftarTabel");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqId');

if(!empty($reqId))
{
    $set= new DaftarTabel();
    $set->selectByParams(array('daftar_tabel_id'=>$reqId));
    // echo $set->query;exit;
    $set->firstRow();
    $reqNama= $set->getField('NAMA');
    $reqSheet= $set->getField('NAMA_SHEET');
    $reqPage= $set->getField('PAGE');
    $reqD3= $set->getField('D3');
    $reqS1= $set->getField('S1');
    $reqS2= $set->getField('S2');
    $reqS3= $set->getField('S3');
    $reqStatus= $set->getField('STATUS');
}
?>

<link href="lib/bootstrap-3.3.7/docs/examples/navbar/navbar.css" rel="stylesheet">

<div class="d-flex flex-column-fluid">
    <div class="container">
        <form class="form" id="ktloginform" method="POST" enctype="multipart/form-data">
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-notepad text-primary"></i>
                        </span>
                        <h3 class="card-label">DAFTAR TABEL DOKUMEN KINERJA PROGRAM STUDI</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <a class="btn btn-light-danger" onclick="btnBack()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Nama</label>   
                        <div class="col-lg-8 col-sm-12">
                            <input type="text" name="reqNama" class="form-control" value='<?=$reqNama?>'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Nama Sheet</label>   
                        <div class="col-lg-8 col-sm-12">
                            <input type="text" name="reqSheet" class="form-control" value='<?=$reqSheet?>'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Halaman File</label>   
                        <div class="col-lg-8 col-sm-12">
                            <input type="text" name="reqPage" class="form-control" value='<?=$reqPage?>'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-12 col-sm-12">Status Tampil Pendidikan</label>
                    </div>                  
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12"></label>
                        <label class="col-form-label col-lg-4 col-sm-12">D3 / Diploma</label>
                        <div class="col-lg-1 col-sm-12">
                            <input type="checkbox" name="reqD3" <?if($reqD3=='1'){ echo "checked";}?> class="form-control" value='1'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12"></label>
                        <label class="col-form-label col-lg-4 col-sm-12">S1 / Sarjana / Sarjana Terapan</label>
                        <div class="col-lg-1 col-sm-12">
                            <input type="checkbox" name="reqS1" <?if($reqS1=='1'){ echo "checked";}?> class="form-control" value='1'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12"></label>
                        <label class="col-form-label col-lg-4 col-sm-12">S2 / Doktor/ Doktor Terapan</label>
                        <div class="col-lg-1 col-sm-12">
                            <input type="checkbox" name="reqS2" <?if($reqS2=='1'){ echo "checked";}?> class="form-control" value='1'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12"></label>
                        <label class="col-form-label col-lg-4 col-sm-12">S3 / Magister/ Magister Terapan</label>
                        <div class="col-lg-1 col-sm-12">
                            <input type="checkbox" name="reqS3"<?if($reqS3=='1'){ echo "checked";}?> class="form-control" value='1'>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2 col-sm-12">Status Buka</label>
                        <div class="col-lg-1 col-sm-12">
                            <input type="checkbox" name="reqStatus"<?if($reqStatus=='1'){ echo "checked";}?> class="form-control" value='1'>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-9">
                        <input type="hidden" name="reqMode" value="<?=$reqMode?>">
                        <input type="hidden" name="reqId" value="<?=$reqId?>">
                        <input type="hidden" name="reqIdParent" value="<?=$reqParent?>">
                        <input type="hidden" name="reqJurusan" value="<?=$reqJurusan?>">
                        <input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
                        <input type="hidden" name="reqTempValidasiId" value="<?=$reqTempValidasiId?>">
                        <button type="submit" id="ktloginformsubmitbutton" class="btn btn-light-success"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button>
                    </div>
                </div>
            </div>
            
        </form>
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
        var formSubmitUrl = "json-main/daftar_tabel_json/addTabel";
        var formSubmitButton = KTUtil.getById('ktloginformsubmitbutton');
        if (!form) {
            return;
        }
        FormValidation
        .formValidation(
            form,
            {
                fields: {
                    // reqGroup: {
                    //  validators: {
                    //      notEmpty: {
                    //          message: 'Group is required'
                    //      }
                    //  }
                    // },
                },
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
                            document.location.href = "app/index/daftar_tabel";
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

    function btnBack() {
        document.location.href = "app/index/daftar_tabel";
    }

</script>