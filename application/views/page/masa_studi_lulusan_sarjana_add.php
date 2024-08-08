<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/MasaStudy");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqRowId');
$reqPageBack= $this->input->get('reqId');

if(!empty($reqId))
{
	$set= new MasaStudy();
	$set->selectByParams(array('lulusan_prodi_id'=>$reqId));
	// echo $set->query;exit;
	$set->firstRow();
	$reqTahun= $set->getField('tahun');
	$reqJumlah= $set->getField('jumlah');
	$reqTs6= $set->getField('ts_6');
	$reqTs5= $set->getField('ts_5');
	$reqTs4= $set->getField('ts_4');
	$reqTs3= $set->getField('ts_3');
	$reqTs2= $set->getField('ts_2');
	$reqTs1= $set->getField('ts_1');
	$reqTs= $set->getField('ts');
	$reqJumlahAhirTs= $set->getField('jumlah_akhir_ts');
	$reqAvg= $set->getField('avg');
	$reqStandar= $set->getField('standart');
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
	                    <h3 class="card-label">Tabel 9. Masa Studi Lulusan Program Studi (Program Sarjana & Sarjana Terapan)</h3>
	                </div>
	                <div class="card-toolbar">
	                    <div class="dropdown dropdown-inline mr-2">
	                        <a class="btn btn-light-danger" onclick="btnBack()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
	                    </div>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Tahun Masuk</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqTahun" class="form-control" value="<?=$reqTahun?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah Mahasiswa Diterima</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqJumlah" class="form-control" value="<?=$reqJumlah?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah Mahasiswa Lulus</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS-6</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTs6" class="form-control" value="<?=$reqTs4?>">
			        			</div>
			        		</div>
	        				<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS-5</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTs5" class="form-control" value="<?=$reqTs4?>">
			        			</div>
			        		</div>
	        				<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS-4</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTs4" class="form-control" value="<?=$reqTs4?>">
			        			</div>
			        		</div>
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS-3</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTs3" class="form-control" value="<?=$reqTs3?>">
			        			</div>
			        		</div>
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS-2</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTs2" class="form-control" value="<?=$reqTs2?>">
			        			</div>
			        		</div>
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS-1</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTs1" class="form-control" value="<?=$reqTs1?>">
			        			</div>
			        		</div>
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">TS</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqTs" class="form-control" value="<?=$reqTs?>">
			        			</div>
			        		</div>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah Lulusan s/d Akhir TS</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqJumlahAhirTs" class="form-control" value="<?=$reqJumlahAhirTs?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Rata Rata Masa Study</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqAvg" class="form-control" value="<?=$reqAvg?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Standar yang ditetapkan</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<textarea name="reqStandar" class="form-control"><?=$reqStandar?></textarea>
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
        				<input type="hidden" name="reqJenjang" value="s1">
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
		var formSubmitUrl = "json-main/masa_studi_lulusan_json/add";
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
			        		document.location.href = "app/page/masa_studi_lulusan_sarjana?reqId=<?=$reqPageBack?>";
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
		document.location.href = "app/page/masa_studi_lulusan_sarjana?reqId=<?=$reqPageBack?>";
	}

</script>