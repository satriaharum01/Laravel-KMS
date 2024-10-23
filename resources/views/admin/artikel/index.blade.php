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
								<th style="text-align:center;" width="">Artikel</th>
								<th style="text-align:center;" width="15%">Aksi</th>
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
                        return '<h4>'+data[1]+'</h4><br><div><i class="fa fa-user"></i> Dipost oleh '+data[0]+' <i class="fa fa-comment"></i> '+data[3]+' <i class="fa fa-eye"></i> '+data[2]+'  <i class="fa fa-calendar"></i> '+data[4]+'</div>';
                    }
                },
                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return '<button type="button" class="btn btn-success btn-edit" data-id="' + data + '"><i class="fa fa-edit"></i></button>\
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
    
    $("body").on("click", ".btn-add", function() {
        window.location.href = "{{url($page.'/tambah')}}";
    });

    $("body").on("click", ".btn-edit", function() {
        var id = jQuery(this).attr("data-id");
        window.location.href = "{{url($page.'/edit')}}/"+id;
    });
</script>
@endsection