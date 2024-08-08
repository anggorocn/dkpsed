<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/WaktuTungguLulusan");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqRowId');
$reqPageBack= $this->input->get('reqId');

if(!empty($reqId))
{
	$set= new WaktuTungguLulusan();
	$set->selectByParams(array('waktu_tunggu_lulusan_id'=>$reqId));
	// echo $set->query;exit;
	$set->firstRow();
	$reqTahun= $set->getField('tahun');
	$reqJumlah= $set->getField('jumlah');
	$reqJumlahTerlacak= $set->getField('jumlah_terlacak');
	$reqJumlahDipesan= $set->getField('jumlah_dipesan');
	$reqWaktu11= $set->getField('waktu1_1');
	$reqWaktu12= $set->getField('waktu1_2');
	$reqWaktu13= $set->getField('waktu1_3');
	$reqStandar= $set->getField('standar');
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
	                    <h3 class="card-label">Tabel 12. Waktu Tunggu Lulusan (Khusus Program Diploma Tiga)</h3>
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
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah Lulusan</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqJumlah" class="form-control" value="<?=$reqJumlah?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah Lulusan Terlacak</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqJumlahTerlacak" class="form-control" value="<?=$reqJumlahTerlacak?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah Lulusan Yang Dipesan Sebelum Lulus</label>	
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqJumlahDipesan" class="form-control" value="<?=$reqJumlahDipesan?>">
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah Lulusan Terlacak dengan Waktu Tunggu Mendapatkan Pekerjaan</label>	
	        			<div class="col-lg-8 col-sm-12">
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">WT < 3 bulan</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqWaktu11" class="form-control" value="<?=$reqWaktu11?>">
			        			</div>
			        		</div>
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">3 ≤ WT ≤ 6 bulan</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqWaktu12" class="form-control" value="<?=$reqWaktu12?>">
			        			</div>
			        		</div>
			        		<div class="form-group row">
		        				<label class="col-form-label col-lg-2 col-sm-12">WT > 6 bulan</label>	
			        			<div class="col-lg-10 col-sm-12">
			        				<input type="text" name="reqWaktu13" class="form-control" value="<?=$reqWaktu13?>">
			        			</div>
			        		</div>
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
        				<input type="hidden" name="reqJenjang" value="d3">
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
		var formSubmitUrl = "json-main/waktu_tunggu_lulusan_json/add";
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
			        		document.location.href = "app/page/waktu_tunggu_lulusan_d3?reqId=<?=$reqPageBack?>";
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
		document.location.href = "app/page/waktu_tunggu_lulusan_d3?reqId=<?=$reqPageBack?>";
	}

</script>