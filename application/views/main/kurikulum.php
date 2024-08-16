<?php
$reqId= $this->input->get('reqId');
?>

<style type="text/css">
    .datagrid-cell{
        font-size: 20px;
    }
</style>
<!-- SELECT2 -->
<link href="lib/select2totreemaster/src/select2totree.css" rel="stylesheet">
<script src="lib/select2/select2.min.js"></script>
<script src="lib/select2totreemaster/src/select2totree.js"></script>

<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container">

        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-notepad text-primary"></i>
                    </span>
                    <h3 class="card-label">Kurikulum</h3>
                </div>
                <div class="card-toolbar">
                    <div class="dropdown dropdown-inline mr-2">
                        <?if ($this->adminusergroupid==1){?>
                            <button class="btn btn-light-primary" id="btnAdd"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</button>
                        <?}?>   
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table id="treeSatker" class="easyui-treegrid" style="width:100%; height:600px" data-options="
                    url: '<?=base_url()?>json-main/kurikulum_json/treetable/',
                    pagination: true,            
                    pageSize: 50,
                    pageList: [50, 100],
                    method: 'get',
                    idField: 'id',
                    treeField: 'NAMA',
                   onBeforeLoad: function(row,param){
                        if (!row) {    // load top level rows
                            param.id = 0;    // set id=0, indicate to load new page rows
                        }
                    },
                ">
                    <thead>
                        <tr>
                            <th data-options="field:'no'">No</th>
                            <th data-options="field:'nama',width:400">Mata Kuliah</th>
                            <th data-options="field:'kode'">Kode</th>
                            <th data-options="field:'sks'">SKS</th>
                            <th data-options="field:'keterangan'">Keterangan</th>
                            <th data-options="field:'aksi', align:'right'"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    $("#btnAdd").on("click", function () {
        varurl= "app/index/kurikulum_add?";
        
        document.location.href = varurl;
    }); 

    function addchild(reqParent, reqId) {
        varurl= "app/index/kurikulum_add?reqParent="+reqParent;
        
        document.location.href = varurl;
    }

    function updatechild(reqParent, reqId) {
        varurl= "app/index/kurikulum_add?reqParent="+reqParent+"&reqId="+reqId;
        
        document.location.href = varurl;
    }
</script>