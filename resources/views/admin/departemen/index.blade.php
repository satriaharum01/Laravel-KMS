@extends('template.header')
@section('content')

<div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb p-0">
            <li class="breadcrumb-item">
              <a href="{{route('admin.dashboard')}}">
                <span class="mdi mdi-home"></span>                
              </a>
            </li>
            <li class="breadcrumb-item">
              Main
            </li>
            <li class="breadcrumb-item" aria-current="page">{{$title}}</li>
          </ol>
        </nav>

</div>

<div class="row">
	<div class="col-12">
		<div class="card card-default">
			<div class="card-header card-header-border-bottom d-flex justify-content-between">
				<h2>{{$title}}</h2>
				<div>
				<button  class="btn btn-outline-primary text-uppercase btn-add">
					<i class="mdi mdi-plus-box mr-1"></i> Tambah Data
				</button>
				</div>
			</div>

			<div class="card-body">
				<div class="">
					<table id="basic-data-table" class="table" style="width:100%">
						<thead>
							<tr>
								<th style="text-align:center;" width="7%">No</th>
								<th style="text-align:center;">Nama Departemen</th>
								<th style="text-align:center;" width="">Aksi</th>
							</tr>
						</thead>
                        <tbody style="text-align:center;">
						</tbody>
                    </table>
                </div>
            </div>
        </div>
   </div>
</div>
<!-- Form Modal -->
<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form id="compose-form" action="#" method="POST">
                @csrf
			    <div class="modal-body">
					<div class="form-group">
						<label>Nama Departemen</label>
						<input name="nama" type="text" class="form-control" placeholder="Enter nama">
                    </div>
                </div>
			    <div class="modal-footer">
			    	<button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
			    	<button type="submit" class="btn btn-primary btn-pill btn-simpan">Simpan</button>
			    </div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('custom_script')
<script>
    $(function() {
        table = $('#basic-data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url("$page/json")}}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama'
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i> Edit</button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="data" href="<?= url($page.'/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i> Hapus</a> \
					    <form id="delete-form-' + data + '-data" action="<?= url($page.'/delete') ?>/' + data + '" \
                        method="GET" style="display: none;"> \
                        </form>'
                    }
                },
            ]
        });
    });
</script>
<script>
    
    //Button Trigger
    $("body").on("click",".btn-add",function(){
        kosongkan();
        jQuery("#compose-form").attr("action",'<?=url($page);?>/store');
        jQuery("#compose .modal-title").html("Tambah <?=$title;?>");
        jQuery("#compose").modal("toggle");  
    });

    $("body").on("click",".btn-edit",function(){
        var id = jQuery(this).attr("data-id");
                    
        $.ajax({
            url: "<?=url($page);?>/find/"+id,
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (dataResult) { 
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData,function(index,row){
                    jQuery("#compose-form input[name=nama]").val(row.nama);
                })
            }
        });
        jQuery("#compose-form").attr("action",'<?=url($page);?>/update/'+id);
        jQuery("#compose .modal-title").html("Update <?=$title?>");
        jQuery("#compose").modal("toggle");
    });
    
    $("body").on("click",".btn-simpan",function(){
        Swal.fire(
            'Data Disimpan!',
            '',
            'success'
            )
    });
        
    function kosongkan()
    {
      jQuery("#compose-form input[name=nama]").val("");
    }
</script>
@endsection