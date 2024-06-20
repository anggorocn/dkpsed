<?
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>
<!-- Bootstrap core CSS -->
<link href="lib/bootstrap-3.3.7/docs/examples/navbar/navbar.css" rel="stylesheet">

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label">DOKUMEN AVALUASI DIRI 
                    <!-- <br><span style="font-size: 20px;">Prof. Dr. Gofur Ahmad, ST., MM.</span> -->
                    </h3>
                </div>
                <div class="card-toolbar">
                    <div class="dropdown dropdown-inline mr-2">
                        <button class="btn btn-light-danger" id="btnBack"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                    </div>
                </div>
            </div>
            <form class="form" id="ktloginform" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <iframe src="uploads/sample.pdf" style="width:100%; height:70vh;" frameborder="0"></iframe>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
     $("#btnBack").on("click", function () {
        varurl= "<?=$previous?>";
        document.location.href = varurl;
    });
</script>