<?
include_once("functions/personal.func.php");
$this->load->library('globalfilepegawai');
$this->load->model("base/ProfilDosen");
$this->load->model("base/Upload");

$reqId= $this->input->get('reqId');

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
	                    <h3 class="card-label">Profil Dosen</h3>
	                </div>
	                <div class="card-toolbar">
	                    <div class="dropdown dropdown-inline mr-2">
	                        <button class="btn btn-light-danger" id="btnBack"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
	                    </div>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Nama Dosen</label>	
	        			<div class="col-lg-10 col-sm-12">
	        				<input type="text" name="reqName" class="form-control" value='<?=$reqName?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Status</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqStatus" class="form-control" value='<?=$reqStatus?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileStatus" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">NIDK/NIDN</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqNidn" class="form-control" value='<?=$reqNidn?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileNidn" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jabatan Akademi</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqJabatan" class="form-control" value='<?=$reqJabatan?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileJabatan" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Akademisi/Praktisi</label>	        
	        			<div class="col-lg-6 col-sm-12">
					 		<select class="form-control" name="reqStatusAkademik">
								<option value='1' <?if($reqMagister=='Akademis'){echo 'selected';}?>>Akademis</option>
								<option value='2' <?if($reqMagister=='Praktisi'){echo 'selected';}?>>Praktisi</option>
								<option value='3' <?if($reqMagister=='Akademis/Praktisi'){echo 'selected';}?>>Akademis/Praktisi</option>
							</select>
		        		</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileAkademisi" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Perusahaan</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqPerusahaan" class="form-control" value='<?=$reqPerusahaan?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileJabatan" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        	</div>
        	</div>
	        <br>
	        <div class="card card-custom">
	        	<div class="card-header">
	                <div class="card-title">
	                    <span class="card-icon">
	                        <i class="flaticon2-notepad text-primary"></i>
	                    </span>
	                    <h3 class="card-label">Pendidikan Dosen</h3>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Pendidikan Setara Magister</label>
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqMagister" class="form-control" value='<?=$reqMagister?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileMagister" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Pendidikan Setara Doktor</label>
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqDoktor" class="form-control" value='<?=$reqDoktor?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileDoktor" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Bidang Pendidikan</label>
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqBidang" class="form-control" value='<?=$reqBidang?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileBidang" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Sertifikat Pendidikan Profesional</label>
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="file" name="reqSertifikat" class="form-control" value='<?=$reqSertifikat?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">	
	        			<label class="col-form-label col-lg-2 col-sm-12">Sertifikat Lain</label>	        			
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=dosen&table_field=sertifikat_lain&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
		        			<a onclick="create_tr(1)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        			</div>
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
	        				
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
									$setTable->selectByParams(array('table_nama'=>'dosen','table_field'=>'sertifikat_lain','table_id'=>$reqId));
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
	        	</div>
	        </div>
	        <br>
	        <div class="card card-custom">
	        	<div class="card-header">
	                <div class="card-title">
	                    <span class="card-icon">
	                        <i class="flaticon2-notepad text-primary"></i>
	                    </span>
	                    <h3 class="card-label">Kontribusi Intelektual Pendidikan & Pengajaran</h3>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Mata Kuliah </label>		
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=dosen&table_field=mata_kuliah&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
		        			<a onclick="create_tr(2)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        			</div>
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
	        				
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
									$setTable->selectByParams(array('table_nama'=>'dosen','table_field'=>'mata_kuliah','table_id'=>$reqId));
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
	        			<label class="col-form-label col-lg-2 col-sm-12">Judul Bahan Ajar</label>		
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=dosen&table_field=judul&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
		        			<a onclick="create_tr(3)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        			</div>
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
	        				
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
									$setTable->selectByParams(array('table_nama'=>'dosen','table_field'=>'judul','table_id'=>$reqId));
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
	        			<label class="col-form-label col-lg-12 col-sm-12">Jumlah Mahasiswa Pada PS Akreditasi</label>
	        		</div>	        		
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">TS-2</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqTs2" class="form-control" value='<?=$reqTs2?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileTs2" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
   	        		<div class="form-group row">
						<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">TS-1</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqTs1" class="form-control" value='<?=$reqTs1?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileTs1" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
   	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">TS</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqTS" class="form-control" value='<?=$reqTS?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileTS" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
   	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">Rata rata</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqAvg" class="form-control" value='<?=$reqAvg?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileAvg" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
          		
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-12 col-sm-12">Jumlah Mahasiswa Pada PS Lain</label>
	        		</div>	        		
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">TS-2</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqTs2Lain" class="form-control" value='<?=$reqTs2Lain?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileTs2Lain" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
   	        		<div class="form-group row">
						<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">TS-1</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqTs1Lain" class="form-control" value='<?=$reqTs1Lain?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileTs1Lain" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
   	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">TS</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqTsLain" class="form-control" value='<?=$reqTsLain?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileTsLain" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
   	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">Rata rata</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqAvgLain" class="form-control" value='<?=$reqAvgLain?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileAvgLain" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>
          			
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Rata Rata Keseluruhan</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqTotalAvg" class="form-control" value='<?=$reqTotalAvg?>'>
	        			</div>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="file" name="reqFileTotalAvg" class="form-control" value='<?=$reqNama?>'>
	        			</div>
	        		</div>

	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Rekognisi Bidang Pendidikan</label>		
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=dosen&table_field=rekognisi_bidang&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
		        			<a onclick="create_tr(4)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        			</div>
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
	        				
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
									$setTable->selectByParams(array('table_nama'=>'dosen','table_field'=>'rekognisi_bidang','table_id'=>$reqId));
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<input type="text" name="reqKettable4[]" class="form-control" value='<?=$reqKeterangan?>'>	
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
	        	</div>
	        </div>
	        <br>
	        <div class="card card-custom">
	        	<div class="card-header">
	                <div class="card-title">
	                    <span class="card-icon">
	                        <i class="flaticon2-notepad text-primary"></i>
	                    </span>
	                    <h3 class="card-label">Kontribusi Intelektual Praktik & Profesional</h3>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Praktik dan Profesional</label>		
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=dosen&table_field=praktik_dan_profesional&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
		        			<a onclick="create_tr(5)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        			</div>
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
	        				
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
									$setTable->selectByParams(array('table_nama'=>'dosen','table_field'=>'praktik_dan_profesional','table_id'=>$reqId));
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
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Penelitian</label>		
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=dosen&table_field=penelitian&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
		        			<a onclick="create_tr(6)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        			</div>
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
	        				
			        		<table class='tableadd' >
			        			<thead>
				        			<tr>
				        				<th style="width:47%;">Keterangan</th>
				        				<th style="width:47%;">File</th>
				        				<th style="width:6%;"></th>
				        			</tr>
				        		</thead>
			        			<tbody id='table6'>
			        				<?
			        				$setTable= new Upload();
									$setTable->selectByParams(array('table_nama'=>'dosen','table_field'=>'penelitian','table_id'=>$reqId));
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<input type="text" name="reqKettable6[]" class="form-control" value='<?=$reqKeterangan?>'>	
									    	</td>
									    	<td>
									 			<input type="file" class="form-control" name="reqFiletable6[]" />
									 			<input type="hidden" class="form-control" name="reqFileExisttable6[]" />
									 			<input type="hidden" class="form-control" name="reqidtable6[]"  value='<?=$reqUploadId?>'/>
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
	        	</div>
	        </div>
	        <br>
	        <div class="card card-custom">
	        	<div class="card-header">
	                <div class="card-title">
	                    <span class="card-icon">
	                        <i class="flaticon2-notepad text-primary"></i>
	                    </span>
	                    <h3 class="card-label">Kontribusi Intelektual Sosial Masyarakat</h3>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Kontribusi Sosial Masyarakat</label>		
	        			<div class="col-lg-10 col-sm-12">
		        			<a class="btn btn-light-success" onclick="openAdd('app/loadurl/main/lihat_pdf?table_nama=dosen&table_field=kontribusi_sosial_masyarakat&table_id=<?=$reqId?>')"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Dokumen</a>
		        			<a onclick="create_tr(7)" class="btn btn-light-success"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Upload</a>
	        			</div>
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<div class="col-lg-10 col-sm-12">
	        				<br>
	        				
			        		<table class='tableadd' >
			        			<thead>
				        			<tr>
				        				<th style="width:47%;">Keterangan</th>
				        				<th style="width:47%;">File</th>
				        				<th style="width:6%;"></th>
				        			</tr>
				        		</thead>
			        			<tbody id='table7'>
			        				<?
			        				$setTable= new Upload();
									$setTable->selectByParams(array('table_nama'=>'dosen','table_field'=>'kontribusi_sosial_masyarakat','table_id'=>$reqId));
									// echo $setTable->query;exit;
									while($setTable->nextRow()){
										$reqKeterangan= $setTable->getField('KETERANGAN');
										$reqUploadId= $setTable->getField('UPLOAD_ID');
										?>
										
										<tr>
									    	<td>
									 			<input type="text" name="reqKettable7[]" class="form-control" value='<?=$reqKeterangan?>'>	
									    	</td>
									    	<td>
									 			<input type="file" class="form-control" name="reqFiletable7[]" />
									 			<input type="hidden" class="form-control" name="reqFileExisttable7[]" />
									 			<input type="hidden" class="form-control" name="reqidtable7[]"  value='<?=$reqUploadId?>'/>
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
	        	</div>
	        </div>
	        <br>
	        <div class="card card-custom">
	        	<div class="card-header">
	                <div class="card-title">
	                    <span class="card-icon">
	                        <i class="flaticon2-notepad text-primary"></i>
	                    </span>
	                    <h3 class="card-label">Ekuivalen Waktu Mengajar</h3>
	                </div>
	            </div>
	        	<div class="card-body">
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-12 col-sm-12">Pembelajaran dan Pembimbingan</label>
	        		</div>	        		
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">PS yang Diakreditasi</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqPSAkreditasi" class="form-control" value='<?=$reqPSAkreditasi?>'>
	        			</div>
	        		</div>
   	        		<div class="form-group row">
						<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">PS Lain di dalam PT</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqPSLainDalam" class="form-control" value='<?=$reqPSLainDalam?>'>
	        			</div>
	        		</div>
   	        		<div class="form-group row">
						<label class="col-form-label col-lg-2 col-sm-12"></label>
	        			<label class="col-form-label col-lg-2 col-sm-12">PS Lain di luar PT</label>
	        			<div class="col-lg-4 col-sm-12">
	        				<input type="text" name="reqPSLainLuar" class="form-control" value='<?=$reqPSLainLuar?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Penelitian</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqPenelitian" class="form-control" value='<?=$reqPenelitian?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">PKM</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqPKM" class="form-control" value='<?=$reqPKM?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Tugas Tambahan dan/atau Penunjang</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqPenunjang" class="form-control" value='<?=$reqPenunjang?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Jumlah (sks)</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqSKS" class="form-control" value='<?=$reqSKS?>'>
	        			</div>
	        		</div>
	        		<div class="form-group row">
	        			<label class="col-form-label col-lg-2 col-sm-12">Rata-rata per Semester (sks)</label>	
	        			<div class="col-lg-6 col-sm-12">
	        				<input type="text" name="reqAvgSKS" class="form-control" value='<?=$reqAvgSKS?>'>
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