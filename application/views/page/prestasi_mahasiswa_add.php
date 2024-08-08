<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/PrestasiMahasiswa");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqRowId');
$reqPageBack= $this->input->get('reqId');

if(!empty($reqId))
{
	$set= new PrestasiMahasiswa();
	$set->selectByParams(array('prestasi_id'=>$reqId));
	// echo $set->query;exit;
	$set->firstRow();
	$reqNama= $set->getField('nama');
	$reqStatus= $set->getField('jenis');
	$reqTahun= $set->getField('tahun');
	$reqTingkat= $set->getField('tingkat');
	$reqJuara= $set->getField('juara');
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
	                    <h3 class="card-label">Prestasi Akademik dan Non-Akademik Mahasiswa</h3>
	                </div>
	                <div class="card-toolbar">
	                    <div class="dropdown dropdown-inline mr-2">
	                        <a class="btn btn-light-danger" onclick="btnBack()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
	                    </div>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Nama Kegiatan</label>	
	        			<div class="col-lg-5 col-sm-12">
	        				<input type="text" name="reqNama" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        			<div class="col-lg-3 col-sm-12">
	        				<input type="file" accept=".pdf" name="reqFile" class="form-control" >
	        			</div>
	        			<? 
						$targetFilePath = "uploads/prestasi/prestasi_".$reqId.".pdf";
	        			if (file_exists($targetFilePath)) {?>
		        			<div class="col-lg-2 col-sm-12">
		        				<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf_singel?reqId=<?=$reqId?>&reqFile=prestasi','File Terupload')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Lihat DOkumen</a>
		        			</div>
	        			<?}?>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Status Kegiatan</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<select name="reqStatus" class="form-control">
	        					<option <?if($reqStatus==''){?>selected<?}?> disabled>Pilih Salah Satu</option>
	        					<option <?if($reqStatus=='Akademik'){?>selected<?}?> value="Akademik">Akademik</option>
	        					<option <?if($reqStatus=='Non-Akademik'){?>selected<?}?> value="Non-akademik">Non-akademik</option>
	        				</select>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Tahun</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqTahun" class="form-control" value="<?=$reqTahun?>">
	        			</div>
	        		</div>

	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Tingkat Kegiatan</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<select name="reqTingkat" class="form-control">
	        					<option <?if($reqTingkat==''){?>selected<?}?> disabled>Pilih Tingkat</option>
	        					<option <?if($reqTingkat=='internasional'){?>selected<?}?> value="internasional">internasional</option>
	        					<option <?if($reqTingkat=='nasional'){?>selected<?}?> value="nasional">Nasional</option>
	        					<option <?if($reqTingkat=='lokal'){?>selected<?}?> value="lokal">Lokal</option>
	        				</select>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Prestasi yang dicapai</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqJuara" class="form-control" value="<?=$reqJuara?>">
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
		var formSubmitUrl = "json-main/prestasi_mahasiswa_json/add";
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
			        		document.location.href = "app/page/prestasi_mahasiswa_add?reqId="+reqid[0];
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
		document.location.href = "app/page/prestasi_mahasiswa?reqId=<?=$reqPageBack?>";
	}

</script>