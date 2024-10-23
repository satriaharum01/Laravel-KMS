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
                <form action="{{$link}}" method="post" id="compose-form" class="row" enctype="multipart/form-data" >
                    @csrf
                    <div class="modal-body col-md-12 pb-0">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{$load->judul ?? ''}}" placeholder="Tulis Judul.." required>
                        </div>
                    </div>
                    <div class="modal-body col-md-6 pb-0">
                        <div class="form-group">
                            <label>Waktu</label>
                            <input name="tanggal" type="datetime-local"  class="form-control" value="{{$load->tanggal ?? ''}}">
                        </div>
                    </div>
                    <div class="modal-body col-md-6 pb-0">
                    </div>
                    <div class="modal-body col-md-6 pb-0">
                        <div class="form-group">
                            <label>Author</label>
                            <select name="author_id" id="author_id" class="form-control">
                                <option value="0">-- Pilih Author</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body col-md-6">
                        <div class="form-group">
                            <label>Departemen</label>
                            <select name="departemen_id" id="departemen_id" class="form-control" required>
                                <option value="0" selected disabled>-- Pilih Departemen</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body col-md-12">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" placeholder="Tulis isi artikel disini.." required>{{$load->keterangan ?? ''}}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('admin.artikel')}}" class="btn btn-danger">Kembali</a>
                        <button type="button" class="btn btn-primary btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
   </div>
</div>
@endsection
@section('custom_script')
<script>
    var id_author = {{$load->author_id ?? 0}};
    var id_departemen = {{$load->departemen_id ?? 0}};
    $(function(){
        $.ajax({
            url: "{{ url('/admin/departemen/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    if(id_departemen == row.id)
                    {
                        $('#departemen_id').append('<option value="' + row.id + '" selected>' + row.nama + '</option>');
                    }else{
                        $('#departemen_id').append('<option value="' + row.id + '">' + row.nama + '</option>');
                    }
                })
            }
        });

        $.ajax({
            url: "{{ url('/admin/user/json')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                    if(id_author == row.id)
                    {
                        $('#author_id').append('<option value="' + row.id + '" selected>' + row.name + '</option>');
                    }else{
                        $('#author_id').append('<option value="' + row.id + '">' + row.name + '</option>');
                    }
                })
            }
        });
    })

    $("body").on("click", ".btn-simpan", function() {
        var stat = '';
        var form = document.getElementById('compose-form');
        for(var i=0; i < form.elements.length; i++){
            if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){
                Swal.fire(
                'Cek Form!',
                'Pastikan Mengisi Semua Field yang ada',
                'warning'
                );
                stat = '';
                break;
            }else{
                stat = 'ready';
            }
        }
        if(stat === 'ready')
        {
            Swal.fire(
                    'Data Disimpan!',
                    '',
                    'success'
                );
            document.getElementById('compose-form').submit();
        }
    });
</script>
@endsection