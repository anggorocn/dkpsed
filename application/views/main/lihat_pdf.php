
<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base/Upload");
$this->load->library('globalmenu');
$table_nama= $this->input->get('table_nama');
$table_field= $this->input->get('table_field');
$dosen_id= $this->input->get('dosen_id');

$setTable= new Upload();
$setTable->selectByParams(array('table_field'=>$table_field,'dosen_id'=>$dosen_id));
// echo $setTable->query;exit;
$arrPDF=array();
while($setTable->nextRow()){
    $arrdata= [];
    $arrdata["keterangan"]= $setTable->getField('KETERANGAN');
    array_push($arrPDF, $arrdata);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="<?=base_url()?>">
        <meta charset="utf-8" />
        <title>Aplikasi DKPSED Online</title>
        <meta name="description" content="User profile block example" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/custom/jstree/jstree.bundle.css" rel="stylesheet" type="text/css" />

        <!-- FOnt Awesome -->
        <link rel="stylesheet" href="assets/css/css-beautify-minify.css" rel="stylesheet" type="text/css" >

        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

        <link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/brand/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/aside/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/w3.css" rel="stylesheet" type="text/css" />

        <link rel="shortcut icon" href="assets/media/logos/favicon.png" />
        <link href="assets/css/new-style.css" rel="stylesheet" type="text/css" />
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>

    
        <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="assets/js/valsix-serverside.js"></script>
        <script src="assets/plugins/custom/jstree/jstree.bundle.js"></script>

        <script src="assets/emodal/eModal.min.js"></script>

        <link rel="stylesheet" type="text/css" href="lib/jquery-easyui-1.4.2/themes/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="lib/jquery-easyui-1.4.2/themes/icon.css">

        <script type="text/javascript" src="lib/jquery-easyui-1.4.2/jquery.easyui.min.js"></script>
        <script src="lib/highcharts/highcharts-spider.js"></script>
        <script src="lib/highcharts/highcharts-more.js"></script>
        <script src="lib/highcharts/exporting-spider.js"></script>
        <script src="lib/highcharts/export-data.js"></script>
        <script src="lib/highcharts/accessibility.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/gaya.css">
    </head>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-row flex-column-fluid page">
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper" style="padding-left: 0px;padding-top: 0px;">
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content" style="background: url(images/bg-login.jpg); background-size: 100% 100%; background-color: #e9edf0;padding: 0px;">
                        <link href="lib/bootstrap-3.3.7/docs/examples/navbar/navbar.css" rel="stylesheet">
                        
                        <div class="d-flex flex-column-fluid">
                            <div class="container">
                                <div class="card card-custom" style="margin-top: 0px;">
                                    <form class="form" id="ktloginform" method="POST" enctype="multipart/form-data">
                                        <div class="w3-bar w3-black">
                                            <?for($i=0;$i<count($arrPDF); $i++){?> 
                                                <a class="w3-bar-item w3-button tablink <?if($i==0){echo 'w3-red';}?>" id="buttontable<?=$i?>" onclick="openCity(event,'table<?=$i?>')"> <?=$arrPDF[$i]['keterangan']?></a>
                                            <?}?>
                                        </div>

                                        <?for($i=0;$i<count($arrPDF); $i++){?> 
                                            <div id="table<?=$i?>" class="w3-container w3-border city" <?if($i!=0){echo 'style="display:none"';}?>>
                                                <?
                                                if (file_exists("uploads/".$dosen_id."/".$table_field."_".$i.".pdf")) {?>
                                                    <div class="card-body">
                                                        <iframe src="uploads/<?=$dosen_id?>/<?=$table_field?>_<?=$i?>.pdf" style="width:100%; height:75vh;" frameborder="0"></iframe>
                                                    </div>
                                                <?}
                                                else{?>
                                                    <div class="card-body" style="text-align: center;">
                                                        Data Belum Diupload
                                                    </div>
                                                <?}?>
                                            </div>
                                        <?}?>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>

    </body>
</html>

<script>
function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " w3-red";
}
</script>

