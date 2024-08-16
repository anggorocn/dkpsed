<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/ProfilDosen");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqRowId');
$reqPageBack= $this->input->get('reqId');
$reqTipe= $this->input->get('reqTipe');

if(!empty($reqId))
{
	$set= new ProfilDosen();
	$set->selectByParams(array('dosen_id'=>$reqId));
	// echo $set->query;exit;
	$set->firstRow();
	$reqName= $set->getField('nama');
	$reqStatus= $set->getField('status');
	$reqNidn= $set->getField('nidn');
	$reqJabatan= $set->getField('jabatan_akademik');
	$reqStatusAkademik= $set->getField('status_akademisi');
	$reqPerusahaan= $set->getField('perusahaan');
	$reqMagister= $set->getField('pendidikan_magister');
	$reqDoktor= $set->getField('pendidikan_spesialis');
	$reqDiploma= $set->getField('pendidikan_diploma');
	$reqSarjana= $set->getField('pendidikan_sarjana');
	$reqBidang= $set->getField('bidang_keahlian');
	$reqSertifikat= $set->getField('sertifikat_pendidikan');
	$reqTs2= $set->getField('ts_2');
	$reqTs1= $set->getField('ts_1');
	$reqTS= $set->getField('ts');
	$reqAvg= $set->getField('avg');
	$reqTs2Lain= $set->getField('ts_2_lain');
	$reqTs1Lain= $set->getField('ts_1_lain');
	$reqTsLain= $set->getField('ts_lain');
	$reqAvgLain= $set->getField('avg_lain');
	$reqTotalAvg= $set->getField('avg_total');
	$reqPSAkreditasi= $set->getField('ps_diakreditasi');
	$reqPSLainDalam= $set->getField('ps_lain_dalam');
	$reqPSLainLuar= $set->getField('ps_lain_luar');
	$reqPenelitian= $set->getField('penelitian');
	$reqPKM= $set->getField('pkm');
	$reqPenunjang= $set->getField('penunjang');
	$reqSKS= $set->getField('sks');
	$reqAvgSKS= $set->getField('avg_sks');
	$reqGoogleSchollar= $set->getField('GOOGLE_SCHOLAR');
}
?>

<link href="lib/bootstrap-3.3.7/docs/examples/navbar/navbar.css" rel="stylesheet">

<div class="d-flex flex-column-fluid">
    <div class="container">
    	<!-- <div class="area-menu-fip">
    		ffffj hai
    	</div> -->
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
	        			<label class="col-form-label col-lg-2 col-sm-12">Judul Luaran Penelitian/PkM</label>
	        			<div class="col-lg-8 col-sm-12">
	        				<input type="text" name="reqMagister" class="form-control" value='<?=$reqMagister?>'>
	        			</div>
	        			<? 
						$targetFilePath = "uploads/".$reqId.'/magister.pdf';
	        			if (file_exists($targetFilePath)) {?>
		        			<div class="col-lg-2 col-sm-12">
		        				<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf_singel?reqId=<?=$reqId?>&reqFile=magister','File Terupload')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Lihat DOkumen</a>
		        			</div>
	        			<?}?>
	        		</div>
	        		<div class="form-group row">	
	        			<label class="col-form-label col-lg-2 col-sm-12">Detail Sertifikat</label>	        			
	        			<div class="col-lg-10 col-sm-12">
		        			<a onclick="create_tr(1)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        			</div>
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
	        				
			        		<table class='tableadd' >
			        			<thead>
				        			<tr>
				        				<th style="">Keterangan</th>
				        				<th style="">File</th>
				        				<th style="width:6%;"></th>
				        			</tr>
				        		</thead>
			        			<tbody id='table1'>
			        				<?
			        				$setTable= new Upload();
									$setTable->selectByParams(array('table_nama'=>'dosen','table_field'=>'sertifikat_lain','dosen_id'=>$reqId));
									// echo $setTable->query;exit;
									$i=0;
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<input type="text" name="reqKettable1[]" class="form-control" value='<?=$reqKeterangan?>'>	
									    	</td>
									    	<td>
									    		<div class="row">
										 			<input type="file" accept=".pdf" class="form-control" name="reqFiletable1[]" style="width:80%;"/>
										 			<? 
													$targetFilePath = "uploads/".$reqId.'/sertifikat_lain_'.$i.'.pdf';
								        			if (file_exists($targetFilePath)) {?>
									        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf_singel?reqId=<?=$reqId?>&reqFile=sertifikat_lain_<?=$i?>','File Terupload')"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
								        			<?}?>
										 			<input type="hidden" class="form-control" name="reqFileExisttable1[]" />
										 			<input type="hidden" class="form-control" name="reqidtable1[]"  value='<?=$reqUploadId?>'/>
										 		</div>
									    	</td>
									    	<td style="width:5px">
									           <a class="btn btn-light-danger" onclick="remove_tr(this)"><i class="fa fa-trash" aria-hidden="true"></i></a>
									    	</td>
									    </tr>	
									<?
									$i++;
									}?>
				        		</tbody>
			        		</table>
	        			</div>
	        		</div>

	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Standar Pendidikan Tinggi yang ditetapkan oleh Perguruan Tinggi</label>
	        			<div class="col-lg-6 col-sm-12">
	        				<textarea name="reqDiploma" class="form-control"> </textarea>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" accept=".pdf" name="reqFileMagister" class="form-control">
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
        				<!-- <button type="submit" id="ktloginformsubmitbutton" class="btn btn-light-success"><i class="fa fa-save" aria-hidden="true"></i> Simpan</button> -->
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
		var formSubmitUrl = "json-main/profil_dosen_json/add";
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
			        		// document.location.href = "app/page/dosen_add?reqId="+reqid[0];
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
        varurl= "app/page/profil_dosen";
        document.location.href = varurl;
    });

    function create_tr(table_id) {
     	if (table_id==99){
		    keterangan=
		    `
			<select class="form-control" name="reqKettable`+table_id+`[]">
				<option value='1'>Tetap</option>
				<option value='0'>Tidak Tetap</option>
			</select>
			`;
     	}
     	else{
		    keterangan=
		    `
			<input type="input" class="form-control" name="reqKettable`+table_id+`[]"" />
			`;
     	}
	    var scntDiv = document.getElementById('table'+table_id)
	    infodata= `
	    <tr>
	    	<td>
	 			`+keterangan+`
	    	</td>
	    	<td>
	 			<input type="file" accept=".pdf" class="form-control" name="reqFiletable`+table_id+`[]"" />
	 			<input type="hidden" class="form-control" name="reqFileExisttable`+table_id+`[]"" />
	 			<input type="hidden" class="form-control" name="reqidtable`+table_id+`[]"" />
	    	</td>
	    	<td style="width:5px">
	           <a class="btn btn-light-danger" onclick="remove_tr(this)"><i class="fa fa-trash" aria-hidden="true"></i></a>
	    	</td>
	    </tr>	
	    `;
	    var elm = $(infodata).appendTo(scntDiv); 

	}

	function create_tr_praktik_profesional(table_id) {
 	
     	var scntDiv = document.getElementById('table_praktik_profesional')
	    infodata= `
	    <tr>
	    	<td>
	 			<input type="text" class="form-control" name="reqPraktikProfesionalNama[]" />
	    	</td>
	    	<td>
	 			<input type="text" class="form-control" name="reqPraktikProfesionalDesc[]" />
	    	</td>
	    	<td>
	 			<input type="text" class="form-control" name="reqPraktikProfesionalOrg[]" />
	    	</td>
	    	<td>
	 			<input type="text" class="form-control" name="reqPraktikProfesionalRekognisi[]" />
	    	</td>
	    	<td>
	 			<input type="file" accept=".pdf" class="form-control" name="reqPraktikProfesionalFile[]" style="width:80%; margin-right: 20px;" />
	 			<input type="hidden" class="form-control" name="reqPraktikProfesionalId[]" />
	    	</td>
	    	<td style="width:5px">
	           <a class="btn btn-light-danger" onclick="remove_tr(this)"><i class="fa fa-trash" aria-hidden="true"></i></a>
	    	</td>
	    </tr>	
	    `;
	    var elm = $(infodata).appendTo(scntDiv); 

	}

	function create_tr_penelitian() {
     	var scntDiv = document.getElementById('table_penelitian')
	    infodata= `
	    <tr>
	    	<td>
	 			<input type="text" class="form-control" name="reqPenelitianJudul[]" />
	    	</td>
	    	<td>
	 			<input type="text" class="form-control" name="reqPenelitianSitasi[]" />
	    	</td>
	    	<td>
	 			<input type="text" class="form-control" name="reqPenelitianRekognisi[]" />
	    	</td>
	    	<td>
	 			<input type="file" accept=".pdf" class="form-control" name="reqPenelitianFile[]" style="width:80%; margin-right: 20px;" />
	 			<input type="hidden" class="form-control" name="reqPenelitianId[]" />
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