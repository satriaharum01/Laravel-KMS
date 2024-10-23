@extends('template.header')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-default">
			<div class="card-header card-header-border-bottom d-flex justify-content-between">
				<h2>{{$title}}</h2>
                @if($title != 'Tambah Artikel')
                <div class="pull-right">Viewer <i class="fa fa-eye"></i> {{$load->viewer ?? '0'}}</div>
                @endif
			</div>
			<div class="card-body">
                <form action="{{$link}}" method="post" id="compose-form" class="row" enctype="multipart/form-data" >
                    @csrf
                    <div class="modal-body col-md-12 pb-0">
                        <div class="form-group">
                            <label>Judul</label><span class="text-sm text-danger"> (Wajib)</span>
                            <input type="text" name="judul" class="form-control" value="{{$load->judul ?? ''}}" placeholder="Tulis Judul.." required>
                        </div>
                    </div>
                    <div class="modal-body col-md-6 pb-0 pt-0">
                        <div class="form-group">
                            <label>Author</label><span class="text-sm text-danger"> (Wajib)</span>
                            <select name="author_id" id="author_id" class="form-control">
                                <option value="{{Auth::user()->id}}" selected>{{Auth::user()->name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body col-md-6 pb-0 pt-0">
                        <div class="form-group">
                            <label>Departemen</label><span class="text-sm text-danger"> (Wajib)</span>
                            <select name="departemen_id" id="departemen_id" class="form-control">
                                <option value="0">-- Pilih Departemen</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body col-md-12 pt-0">
                        <div class="form-group">
                            <label>Isi</label><span class="text-sm text-danger"> (Wajib)</span>
                            <textarea name="content" class="form-control" placeholder="Tulis isi artikel disini.." required>{{$load->content ?? ''}}</textarea>
                        </div>
					    <div class="form-group">
					    	<label>Lampiran </label><span class="text-sm"> (Opsional)</span>
					    	<input name="berkas" class="col-md-12" type="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{route('pegawai.artikel')}}" class="btn btn-danger">Kembali</a>
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