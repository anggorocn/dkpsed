<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/Pengguna");

$reqId= $this->input->get('reqId');

if(!empty($reqId))
{
	$set= new Pengguna();
	$set->selectByParams(array('USER_APP_ID'=>$reqId));
	// echo $set->query;exit;
	$set->firstRow();
	$reqNama= $set->getField('NAMA');
	$reqUser= $set->getField('user_login');
	$reqPass= $set->getField('user_pass');
	$reqGroup= $set->getField('user_group_id');
}

// $statement="";
// $sOrder=" ORDER BY COALESCE(PANGKAT_MINIMAL,0)";
// $set= new Core();
// $arrpendidikan= [];
// $set->selectByParamsPendidikan(array(), -1,-1,$statement,$sOrder);
// // echo $set->query;exit;
// while($set->nextRow())
// {
// 	$arrdata= [];
// 	$arrdata["id"]= $set->getField("PENDIDIKAN_ID");
// 	$arrdata["text"]= $set->getField("NAMA");
// 	array_push($arrpendidikan, $arrdata);
// }
// unset($set);
// $readonly = "readonly";

// // untuk kondisi file
// $vfpeg= new globalfilepegawai();
// $riwayattable= "ANAK";
// $reqDokumenKategoriFileId= "0"; // ambil dari table KATEGORI_FILE, cek sesuai mode
// $arrsetriwayatfield= $vfpeg->setriwayatfield($riwayattable);
// // print_r($arrsetriwayatfield);exit;

// $arrparam= array("reqId"=>$reqId, "reqRowId"=>$reqRowId, "riwayattable"=>$riwayattable, "lihatquery"=>"");
// $arrambilfile= $vfpeg->ambilfile($arrparam);
// // print_r($arrambilfile);exit;

// $keycari= $riwayattable.";".$reqRowId;

// $infofile= 0;
// if(!empty($arrambilfile))
// {
// 	$infofile= count(in_array_column($keycari, "vkey", $arrambilfile));
// }
// // echo $infofile;exit;

$set= new Pengguna();
$set->selectByParamsComboGroup(array());

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
                    <h3 class="card-label">Perubahan Pengguna</h3>
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
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">Nama</label>
	        			<div class="col-lg-10 col-sm-12">
	        				<input type="text" class="form-control" name="reqNama" id="reqNama" value="<?=$reqNama?>" />
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">User Login</label>
	        			<div class="col-lg-10 col-sm-12">
	        				<input type="text" class="form-control" name="reqUser" id="reqUser" value="<?=$reqUser?>" 
	        				<? if($reqUser!=''){ echo "readOnly"; }?> />
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label text-right col-lg-2 col-sm-12">Password</label>
	        			<div class="col-lg-10 col-sm-12">
	        				<?if($reqPass==''){?>
		        				<input type="text" class="form-control" name="reqPass" id="reqPass" value="<?=$reqPass?>" />
		        			<?}
		        			else{?>
		        				<input type="password" class="form-control" name="reqPass" id="reqPass" value="<?=$reqPass?>" readOnly />
		        			<?}?>
	        			</div>
	        		</div>
	        		<div class="form-group row">
		    			<label class="col-form-label text-right col-lg-2 col-sm-12">Group</label>
		    			<div class="col-lg-4 col-sm-12">
		    				<select class="form-control" id='reqGroup' name='reqGroup'>
		    					<option ></option>
		    					<?while ($set->nextRow()) {?>
		    						<option value="<?=$set->getField('user_group_id')?>" <?if ($reqGroup==$set->getField('user_group_id')){echo "selected";}?>><?=$set->getField('nama');?></option>
		    					<?}?>
		    				</select>
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
		var formSubmitUrl = "json-main/pengguna_json/add";
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
			        		document.location.href = "app/index/pengguna_add?reqId="+reqid[0];
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
        varurl= "app/index/pengguna";
        document.location.href = varurl;
    });
</script>