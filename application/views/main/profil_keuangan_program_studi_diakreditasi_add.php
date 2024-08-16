<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/ProfilKeuanganProgramStudiDiakreditasi");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqId');
$reqParent= $this->input->get('reqParent');

if(!empty($reqId))
{
	$set= new ProfilKeuanganProgramStudiDiakreditasi();
	$set->selectByParams(array('profil_keuangan_prodi_id'=>$reqId,'profil_keuangan_prodi_id_parent'=>$reqParent));
	// echo $set->query;exit;
	$set->firstRow();
	$reqNama= $set->getField('nama');
	$reqPengelolahTS2= $set->getField('pengelolah_ts_2');
	$reqPengelolahTS1= $set->getField('pengelolah_ts_1');
	$reqPengelolahTS= $set->getField('pengelolah_ts');
	$reqProdiTS2= $set->getField('prodi_ts_2');
	$reqProdiTS1= $set->getField('prodi_ts_1');
	$reqProdiTS= $set->getField('prodi_ts');
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
	                    <h3 class="card-label">Tabel 5. Profil Tenaga Kependidikan</h3>
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
		        	<?if($reqParent!='' && $reqParent!='0'){?>
	        			<div class="form-group row">
		        			<label class="col-form-label col-lg-2 col-sm-12">Unit Pengelola Program Studi (dalam Jutaan Rupiah)</label>	
		        			<div class="col-lg-8 col-sm-12">
		        				<div class="form-group row">
			        				<label class="col-form-label col-lg-2 col-sm-12">TS-2</label>	
				        			<div class="col-lg-10 col-sm-12">
				        				<input type="text" name="reqPengelolahTS2" class="form-control" value='<?=$reqPengelolahTS2?>'>
				        			</div>
				        		</div>
		        				<div class="form-group row">
			        				<label class="col-form-label col-lg-2 col-sm-12">TS-1</label>	
				        			<div class="col-lg-10 col-sm-12">
				        				<input type="text" name="reqPengelolahTS1" class="form-control" value='<?=$reqPengelolahTS1?>'>
				        			</div>
				        		</div>
		        				<div class="form-group row">
			        				<label class="col-form-label col-lg-2 col-sm-12">TS</label>	
				        			<div class="col-lg-10 col-sm-12">
				        				<input type="text" name="reqPengelolahTS" class="form-control" value='<?=$reqPengelolahTS?>'>
				        			</div>
				        		</div>
		        			</div>
		        		</div>
		        		<div class="form-group row">
		        			<label class="col-form-label col-lg-2 col-sm-12">Program Studi  yang Di Akreditasi (dalam Jutaan Rupiah)</label>	
		        			<div class="col-lg-8 col-sm-12">
		        				<div class="form-group row">
			        				<label class="col-form-label col-lg-2 col-sm-12">TS-2</label>	
				        			<div class="col-lg-10 col-sm-12">
				        				<input type="text" name="reqProdiTS2" class="form-control" value='<?=$reqProdiTS2?>'>
				        			</div>
				        		</div>
		        				<div class="form-group row">
			        				<label class="col-form-label col-lg-2 col-sm-12">TS-1</label>	
				        			<div class="col-lg-10 col-sm-12">
				        				<input type="text" name="reqProdiTS1" class="form-control" value='<?=$reqProdiTS1?>'>
				        			</div>
				        		</div>
		        				<div class="form-group row">
			        				<label class="col-form-label col-lg-2 col-sm-12">TS</label>	
				        			<div class="col-lg-10 col-sm-12">
				        				<input type="text" name="reqProdiTS" class="form-control" value='<?=$reqProdiTS?>'>
				        			</div>
				        		</div>
		        			</div>
		        		</div>
		        	<?}?>
		        </div>
	        </div>
    		<div class="card-footer">
        		<div class="row">
        			<div class="col-lg-9">
        				<input type="hidden" name="reqMode" value="<?=$reqMode?>">
        				<input type="hidden" name="reqId" value="<?=$reqId?>">
        				<input type="hidden" name="reqIdParent" value="<?=$reqParent?>">
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
		var formSubmitUrl = "json-main/profil_keuangan_program_studi_diakreditasi_json/add";
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
			        		document.location.href = "app/page/profil_keuangan_program_studi_diakreditasi?";
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
		document.location.href = "app/page/daftar_tabel?reqId=8";
	}

</script>