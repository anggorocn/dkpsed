<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/PublikasiIlmiahMahasiswa");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqRowId');
$reqPageBack= $this->input->get('reqId');

if(!empty($reqId))
{
	$set= new PublikasiIlmiahMahasiswa();
	$set->selectByParams(array('PUBLIKASI_MAHASISWA_ID'=>$reqId));
	// echo $set->query;exit;
	$set->firstRow();
	$reqNama= $set->getField('NAMA');
	$reqTS2= $set->getField('TS_2');
	$reqTS1= $set->getField('TS_1');
	$reqTS= $set->getField('TS');
	$reqJumlah= $set->getField('JUMLAH');
	$reqStandar= $set->getField('STANDAR');
	$reqGolongan= $set->getField('GOLONGAN');
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
                    	<h3 class="card-label">Tabel 19 Pagelaran/Pameran/Presentasi/Publikasi Ilmiah Mahasiswa <br>(Khusus Program Sarjana Terapan/Magister Terapan/Doktor Terapan)</h3>
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
	        				<input type="text" name="reqNama" class="form-control" value="<?=$reqNama?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah Judul</label>	
	        			<div class="col-lg-8 col-sm-12">
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS-2</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTS2" class="form-control" value="<?=$reqTS2?>">
			        			</div>
			        		</div>
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS-1</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTS1" class="form-control" value="<?=$reqTS1?>">
			        			</div>
			        		</div>
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTS" class="form-control" value="<?=$reqTS?>">
			        			</div>
			        		</div>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah</label>	
	        			<div class="col-lg-8 col-sm-12">
			        		<input type="text" name="reqJumlah" class="form-control" value="<?=$reqJumlah?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Standar Pendidikan Tinggi yang ditetapkan oleh Perguruan Tinggi</label>	
	        			<div class="col-lg-8 col-sm-12">
			        		<input type="text" name="reqStandar" class="form-control" value="<?=$reqStandar?>">
	        			</div>
	        		</div>
	        	</div>
        	</div>
    		<div class="card-footer">
        		<div class="row">
        			<div class="col-lg-9">
        				<input type="hidden" name="reqMode" value="<?=$reqMode?>">
        				<input type="hidden" name="reqId" value="<?=$reqId?>">
        				<input type="hidden" name="reqRowId" value="<?=$reqRowId?>">
        				<input type="hidden" name="reqGolongan" value="TERAPAN">
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
		var formSubmitUrl = "json-main/publikasi_ilmiah_mahasiswa_json/add";
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
					// 	validators: {
					// 		notEmpty: {
					// 			message: 'Group is required'
					// 		}
					// 	}
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
			        		document.location.href = "app/page/publikasi_ilmiah_mahasiswa_terapan?reqId=<?=$reqPageBack?>";
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
		document.location.href = "app/page/publikasi_ilmiah_mahasiswa_terapan?reqId=<?=$reqPageBack?>";
	}

</script>