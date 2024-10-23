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
			</div>

			<div class="card-body">
				<div class="">
					<table id="basic-data-table" class="table" style="width:100%">
						<thead>
							<tr>
								<th style="text-align:center;" width="7%">No</th>
								<th style="text-align:center;">Author</th>
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
<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" enctype='multipart/form-data' aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form id="compose-form" action="#" method="POST">
                @csrf
			    <div class="modal-body">
					<div class="form-group">
						<label>Artikel</label>
						<input name="artikel" type="text" class="form-control" readonly>
                    </div>
					<div class="form-group">
						<label>Author</label>
						<input name="author" type="text" class="form-control" readonly>
                    </div>
					<div class="form-group">
						<label>Berkas</label>
						<input name="berkas" class="col-md-12" type="file">
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
                    data: 'fill', className:'text-left',render: function(data){
                        return '<i class="fa fa-calendar"></i> '+data[2]+'<br><h4>'+data[0]+'</h4><br><div class="text-justify"><i class="fa fa-user"></i> Dipost oleh '+data[1]+'</div>';
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-primary btn-download" data-id="' + data + '"><i class="fa fa-download"></i> </button>\
                        <button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i></button>\
                        <a class="btn btn-danger btn-hapus" data-id="' + data + '" data-handler="data" href="<?= url($page.'/delete') ?>/' + data + '">\
                        <i class="fa fa-trash"></i></a> \
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
    $("body").on("click",".btn-download",function(){
        var id = jQuery(this).attr("data-id");
        window.open('<?=url($page."/download/");?>/'+id+'', '_blank');
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
                    jQuery("#compose-form input[name=artikel]").val(row.artikel);
                    jQuery("#compose-form input[name=author]").val(row.author);
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
</script>
@endsection