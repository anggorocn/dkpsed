<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/ProfilDosenStatusKepegawaian");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqId');

if(!empty($reqId))
{
	$set= new ProfilDosenStatusKepegawaian();
	$set->selectByParams(array('profil_dosen_status_kepegawaian_ID'=>$reqId));
	// echo $set->query;exit;
	$set->firstRow();
	$reqNama= $set->getField('NAMA');
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
                    <h3 class="card-label">Profil Dosen Status Kepegawaian</h3>
                </div>
                <div class="card-toolbar">
                    <div class="dropdown dropdown-inline mr-2">
                        <button class="btn btn-light-danger" id="btnBack"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                    </div>
                </div>
            </div>
            <form class="form" id="ktloginform" method="POST" enctype="multipart/form-data">
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">Nama Dosen</label>	        			
	        			<div class="col-lg-10 col-sm-12">
	        				<input type="text" name="reqName" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">Status</label>	        			
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=profil_dosen_status_kepegawaian&table_field=status&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
	        			</div>
	        			<label class="col-form-label text-right col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
			        		<label style="margin-right:10px ;">Upload File</label>
		        			<a onclick="create_tr(1)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        				
			        		<table class='tableadd' >
			        			<thead>
				        			<tr>
				        				<th style="width:47%;">Keterangan</th>
				        				<th style="width:47%;">File</th>
				        				<th style="width:6%;"></th>
				        			</tr>
				        		</thead>
			        			<tbody id='table1'>
			        				<?
			        				$setTable= new Upload();
									$setTable->selectByParams(array('table_nama'=>'profil_dosen_status_kepegawaian','table_field'=>'status','table_id'=>$reqId));
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<select class="form-control" name="reqKettable1[]">
													<option value='1' <?if($reqKeterangan==1){echo 'selected';}?>>Tetap</option>
													<option value='0' <?if($reqKeterangan==0){echo 'selected';}?>>Tidak Tetap</option>
												</select>
									    	</td>
									    	<td>
									 			<input type="file" class="form-control" name="reqFiletable1[]" />
									 			<input type="hidden" class="form-control" name="reqFileExisttable1[]" />
									 			<input type="hidden" class="form-control" name="reqidtable1[]"  value='<?=$reqUploadId?>'/>
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
	        		<div class="form-group row">
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">NIDK/NIDN</label>	        			
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=profil_dosen_status_kepegawaian&table_field=nidn&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
	        			</div>
	        			<label class="col-form-label text-right col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
			        		<label style="margin-right:10px ;">Upload File</label>
		        			<a onclick="create_tr(2)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        				
			        		<table class='tableadd' >
			        			<thead>
				        			<tr>
				        				<th style="width:47%;">Keterangan</th>
				        				<th style="width:47%;">File</th>
				        				<th style="width:6%;"></th>
				        			</tr>
				        		</thead>
			        			<tbody id='table2'>
			        				<?
			        				$setTable= new Upload();
									$setTable->selectByParams(array('table_nama'=>'profil_dosen_status_kepegawaian','table_field'=>'nidn','table_id'=>$reqId));
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<input type="text" name="reqKettable2[]" class="form-control" value='<?=$reqKeterangan?>'>	
									    	</td>
									    	<td>
									 			<input type="file" class="form-control" name="reqFiletable2[]" />
									 			<input type="hidden" class="form-control" name="reqFileExisttable2[]" />
									 			<input type="hidden" class="form-control" name="reqidtable2[]"  value='<?=$reqUploadId?>'/>
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
	        		<div class="form-group row">
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">Jabatan</label>	        			
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=profil_dosen_status_kepegawaian&table_field=jabatan&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
	        			</div>
	        			<label class="col-form-label text-right col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
			        		<label style="margin-right:10px ;">Upload File</label>
		        			<a onclick="create_tr(3)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        				
			        		<table class='tableadd' >
			        			<thead>
				        			<tr>
				        				<th style="width:47%;">Keterangan</th>
				        				<th style="width:47%;">File</th>
				        				<th style="width:6%;"></th>
				        			</tr>
				        		</thead>
			        			<tbody id='table3'>
			        				<?
			        				$setTable= new Upload();
									$setTable->selectByParams(array('table_nama'=>'profil_dosen_status_kepegawaian','table_field'=>'jabatan','table_id'=>$reqId));
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<input type="text" name="reqKettable3[]" class="form-control" value='<?=$reqKeterangan?>'>	
									    	</td>
									    	<td>
									 			<input type="file" class="form-control" name="reqFiletable3[]" />
									 			<input type="hidden" class="form-control" name="reqFileExisttable3[]" />
									 			<input type="hidden" class="form-control" name="reqidtable3[]"  value='<?=$reqUploadId?>'/>
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
	        		<div class="form-group row">
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">Akademisi/Praktisi</label>	        			
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=profil_dosen_status_kepegawaian&table_field=jabatan&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
	        			</div>
	        			<label class="col-form-label text-right col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
		        			<br>
			        		<label style="margin-right:10px ;">Upload File</label>
		        			<a onclick="create_tr(4)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        				
			        		<table class='tableadd' >
			        			<thead>
				        			<tr>
				        				<th style="width:47%;">Keterangan</th>
				        				<th style="width:47%;">File</th>
				        				<th style="width:6%;"></th>
				        			</tr>
				        		</thead>
			        			<tbody id='table4'>
			        				<?
			        				$setTable= new Upload();
									$setTable->selectByParams(array('table_nama'=>'profil_dosen_status_kepegawaian','table_field'=>'jabatan','table_id'=>$reqId));
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<select class="form-control" name="reqKettable4[]">
													<option value='1' <?if($reqKeterangan==1){echo 'selected';}?>>Akademis</option>
													<option value='2' <?if($reqKeterangan==2){echo 'selected';}?>>Praktisi</option>
													<option value='3' <?if($reqKeterangan==3){echo 'selected';}?>>Akademis/Praktisi</option>
												</select>
									    	</td>
									    	<td>
									 			<input type="file" class="form-control" name="reqFiletable4[]" />
									 			<input type="hidden" class="form-control" name="reqFileExisttable4[]" />
									 			<input type="hidden" class="form-control" name="reqidtable4[]"  value='<?=$reqUploadId?>'/>
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
	        		<div class="form-group row">
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">Perusahaan</label>	        			
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=profil_dosen_status_kepegawaian&table_field=perusahaan&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
	        			</div>
	        			<label class="col-form-label text-right col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
			        		<label style="margin-right:10px ;">Upload File</label>
		        			<a onclick="create_tr(5)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        				
			        		<table class='tableadd' >
			        			<thead>
				        			<tr>
				        				<th style="width:47%;">Keterangan</th>
				        				<th style="width:47%;">File</th>
				        				<th style="width:6%;"></th>
				        			</tr>
				        		</thead>
			        			<tbody id='table5'>
			        				<?
			        				$setTable= new Upload();
									$setTable->selectByParams(array('table_nama'=>'profil_dosen_status_kepegawaian','table_field'=>'perusahaan','table_id'=>$reqId));
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<input type="text" name="reqKettable5[]" class="form-control" value='<?=$reqKeterangan?>'>	
									    	</td>
									    	<td>
									 			<input type="file" class="form-control" name="reqFiletable5[]" />
									 			<input type="hidden" class="form-control" name="reqFileExisttable5[]" />
									 			<input type="hidden" class="form-control" name="reqidtable5[]"  value='<?=$reqUploadId?>'/>
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
		var formSubmitUrl = "json-main/profil_dosen_status_kepegawaian_json/add";
		var formSubmitButton = KTUtil.getById('ktloginformsubmitbutton');
		if (!form) {
			return;
		}
		FormValidation
		.formValidation(
			form,
			{
				fields: {
					reqNama: {
						validators: {
							notEmpty: {
								message: 'Nama is required'
							}
						}
					},
					reqUser: {
						validators: {
							notEmpty: {
								message: 'User Login is required'
							}
						}
					},
					reqPass: {
						validators: {
							notEmpty: {
								message: 'Password is required'
							}
						}
					},
					reqGroup: {
						validators: {
							notEmpty: {
								message: 'Group is required'
							}
						}
					},
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
     	if (table_id==1){
		    keterangan=
		    `
			<select class="form-control" name="reqKettable`+table_id+`[]">
				<option value='1'>Tetap</option>
				<option value='0'>Tidak Tetap</option>
			</select>
			`;
     	}
     	else if(table_id==4){
		    keterangan=
		    `
			<select class="form-control" name="reqKettable`+table_id+`[]">
				<option value='1'>Akademis</option>
				<option value='2'>Praktisi</option>
				<option value='3'>Akademis/Praktisi</option>
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
	 			<input type="file" class="form-control" name="reqFiletable`+table_id+`[]"" />
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


	function remove_tr(This) {
	    This.closest('tr').remove();
	}
</script>