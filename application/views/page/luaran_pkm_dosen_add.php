<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/LuaranPkmDosen");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqRowId');
$reqPageBack= $this->input->get('reqId');
$reqTipe= $this->input->get('reqTipe');
if($reqTipe=='a'){
	$reqHalDetil=1;
}
else{
	$reqHalDetil=2;
}

if(!empty($reqId))
{
	$set= new LuaranPkmDosen();
	$set->selectByParams(array('PENELITIAN_DOSEN_ID'=>$reqId));
	// echo $set->query;exit;
	$set->firstRow();
	$reqNama= $set->getField('Nama');
	$reqTahun= $set->getField('TAHUN');
	$reqKeterangan= $set->getField('keterangan');
	$reqSumber= $set->getField('sumber_daya_id');
	$reqJenis= $set->getField('jenis_publikasi_id');
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
	                    <h3 class="card-label">Tabel 23a. Luaran Penelitian/PkM yang Dihasilkan oleh Dosen</h3>
                    </div>
	                <div class="card-toolbar">
	                    <div class="dropdown dropdown-inline mr-2">
	                        <a class="btn btn-light-danger" onclick="btnBack()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
	                    </div>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Luaran Penelitian</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqNama" class="form-control" value="<?=$reqNama?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Tahun</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqTahun" class="form-control" value="<?=$reqTahun?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Keterangan</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<textarea name="reqKeterangan" class="form-control"><?=$reqKeterangan?></textarea>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Sumber Pembiayaan</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<select name="reqSumber" class="form-control">
	        					<?
	        					$setCombo= new LuaranPkmDosen();
								$setCombo->selectByParamsComboSumber(array());
								// echo $setCombo->query;exit;
								while($setCombo->nextRow())
								{
									$reqComboId= $setCombo->getField('sumber_daya_id');
									$reqComboNama= $setCombo->getField('nama');?>
									<option value="<?=$reqComboId?>" <?if($reqComboId==$reqSumber){echo "selected";}?>><?=$reqComboNama?></option>
								<?
								}
								?>
	        				</select>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jenis Publikasi</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<select name="reqJenis" class="form-control">
	        					<?
	        					$setCombo= new LuaranPkmDosen();
								$setCombo->selectByParamsComboJenis(array());
								// echo $setCombo->query;exit;
								while($setCombo->nextRow())
								{
									$reqComboId= $setCombo->getField('jenis_publikasi_id');
									$reqComboNama= $setCombo->getField('nama');?>
									<option value="<?=$reqComboId?>" <?if($reqComboId==$reqJenis){echo "selected";}?>><?=$reqComboNama?></option>
								<?
								}
								?>
	        				</select>
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
        				<input type="hidden" name="reqTipe" value="<?=$reqTipe?>">
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
		var formSubmitUrl = "json-main/luaran_pkm_dosen_json/add";
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
			        		document.location.href = "app/page/luaran_pkm_dosen_<?=$reqHalDetil?>?reqId=<?=$reqPageBack?>";
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
		document.location.href = "app/page/luaran_pkm_dosen_<?=$reqHalDetil?>?reqId=<?=$reqPageBack?>";
	}

</script>