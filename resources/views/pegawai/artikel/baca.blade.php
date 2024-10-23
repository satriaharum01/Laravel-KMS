@extends('template.SPA')
@section('content')

                        

<div class="container">
        <div class="row">

            <div class="col-lg-9 mb-3">
                @if(count($post) > 0)
                @foreach($post as $row)
                <div
                    class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                    <div class="row align-items-center">
                        <div class="col-md-10 mb-3 mb-sm-0">
                            <h5>
                                <a href="{{url('pegawai/artikel/show/'.$row->id)}}" class="text-primary">{{$row->judul}}</a>
                            </h5>
                            <p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">{{$row->tanggal}}</a> <span class="op-6">ago by</span> <a class="text-black"
                                    href="#">{{$row->author}}</a></p>
                        </div>
                        @if(count($lampiran) > 0)
                        <div class="col-md-2 op-7">
                            <div class="row text-center op-7">
                                <div class="col px-1">  
                                    <span class="d-block text-sm">Lampiran</span> 
                                </div>
                                <div class="col px-1">
                                    <a href="{{url('/public/archive/download/'.$row->id)}}"><i class="fa fa-download icon-1x"></i></a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row align-items-center">
                        <article>
                            {{$row->content}}
                        </article>
                    </div>
                </div>
                <div>
                    <h5>Response</h5>
                </div>
                @if($row->komentar > 0)
                @foreach($komentar as $cek)
                <div class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                    <div class="row align-items-center">
                        <div class="col-md-11 mb-3 mb-sm-0">
                            <p class="text-sm"><span class="op-6">Dikomentari</span> <a class="text-black" href="#">{{$cek->tanggal}}</a> <span class="op-6"> oleh</span> <a class="text-black"
                                    href="#">{{$cek->user}}</a></p>
                        </div>
                        @if($cek->user_id == Auth::user()->id)
                        <div class="col-md-1 op-7">
                            <div class="row text-center op-7">
                                <div class="col px-1">  
                                    <span role="button" class="d-block text-sm btn-edit text-success" data-id="{{$cek->id}}"><i class="fa fa-edit"></i></span> 
                                </div>
                                <div class="col px-1">
                                <span role="button" class="d-block text-sm btn-hapus text-danger" data-id="{{$cek->id}}" data-handler="data" href="<?= url($page.'/delete') ?>/{{$cek->id}}">
                                <i class="fa fa-trash"></i></span>
					            <form id="delete-form-{{$cek->id}}-data" action="<?= url($page.'/delete') ?>/{{$cek->id}}" 
                                method="GET" style="display: none;">
                                </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row align-items-center">
                        <article>
                            {{$cek->content}}
                        </article>
                    </div>
                </div>
                @endforeach
                @else
                <div
                    class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                    <div class="row align-items-center">
                        <h5>Belum ada komentar</h5>
                    </div>
                </div>
                @endif
                @endforeach
                @else
                    <div class="col">
                        <div class="alert alert-warning">
                            Artikel tidak ditemukan!
                        </div>
                    </div>
                @endif
            </div>

            @section('button')
            <a class="btn btn-lg btn-block btn-success rounded-0 py-4 mb-3 bg-op-6 roboto-bold btn-komentar" href="#">{{$side_title}}</a>
            @endsection
           
            @include('template.statcounter')
        </div>
    </div>
@endsection
@section('modal')

<!-- Form Modal -->
<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
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
						<label>Komentar</label>
						<input name="artikel_id" type="text" class="form-control" hidden readonly value="{{$artikel_id}}">
						<input name="url" type="text" class="form-control" hidden readonly value="{{url()->current()}}">
						<input name="content" type="text" class="form-control" placeholder="Tulis sesuatu..">
                    </div>
                </div>
			    <div class="modal-footer">
			    	<button type="button" class="btn btn-danger btn-pill" data-bs-dismiss="modal">Close</button>
			    	<button type="submit" class="btn btn-primary btn-pill btn-simpan">Simpan</button>
			    </div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('custom_script')
<script>
    $("body").on("click", ".btn-komentar", function() {
        kosongkan();
        jQuery("#compose-form").attr("action",'<?=url($page);?>/store');
        jQuery("#compose .modal-title").html("Tulis Komentar");
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
                    jQuery("#compose-form input[name=content]").val(row.content);
                })
            }
        });
        jQuery("#compose-form").attr("action",'<?=url($page);?>/update/'+id);
        jQuery("#compose .modal-title").html("Edit Komentar");
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
      jQuery("#compose-form input[name=content]").val("");
    }
</script>
@endsection