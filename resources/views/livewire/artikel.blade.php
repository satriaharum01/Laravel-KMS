                        

    <div class="container">
        <div class="row">

            <div class="col-lg-9 mb-3">
                <div class="row text-left mb-5">
                    <div class="col-lg-6 mb-3 mb-sm-0">
                        <div class=" bg-white text-sm w-lg-50"
                            style="width: 100%;">
                            <input type="text" class="form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50" wire:model="searchTerm" placeholder="Cari..." maxlength="30">
                        </div>
                    </div>
                    <div class="col-lg-6 text-lg-right">
                        <div class=" bg-white text-sm w-lg-50"
                            style="width: 100%;">
                            <select wire:model="selectcat" class="form-control form-control-lg bg-white bg-op-9 ml-auto text-sm w-lg-50"
                                data-toggle="select" tabindex="-98">
                                <option value="" selected> Semua Departemen </option>
                                @foreach($departemen as $row)
                                <option value="{{$row->id}}"> {{$row->nama}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if(count($post) > 0)
                @foreach($post as $row)
                <div
                    class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                    <div class="row align-items-center">
                        <div class="col-md-7 mb-3 mb-sm-0">
                            <h5>
                                <a href="{{url('pegawai/artikel/show/'.$row->id)}}" class="text-primary">{{$row->judul}}</a>
                            </h5>
                            <p class="text-sm"><span class="op-6">Posted</span> <a class="text-black" href="#">{{$row->tanggal}}</a> <span class="op-6"> by</span> <a class="text-black"
                                    href="#">{{$row->author}}</a></p>
                        </div>
                        <div class="col-md-5 op-7">
                            <div class="row text-center op-7">
                                <div class="col px-1"> <i class="ion-ios-briefcase-outline icon-1x"></i> <span
                                        class="d-block text-sm">{{$row->cari_departemen->nama}}</span> </div>
                                <div class="col px-1"> <i class="ion-ios-chatboxes-outline icon-1x"></i> <span
                                        class="d-block text-sm"></span> {{$row->komentar}} Komentar</div>
                                <div class="col px-1"> <i class="ion-ios-eye-outline icon-1x"></i> <span
                                        class="d-block text-sm"></span> {{$row->viewer}} Viewer</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <div class="col">
                        <div class="alert alert-warning">
                            Data yang anda cari tidak ditemukan!
                        </div>
                    </div>
                @endif
                <div class="row mt-5">
                    <!--<div class="d-flex justify-content-center justify-content-lg-end"> -->
                    <div class="d-flex justify-content-center">
                        <div>
                            {{ $post->links('livewire.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
                
            @section('button')
            <a class="btn btn-lg btn-block btn-success rounded-0 py-4 mb-1 bg-op-6 roboto-bold" href="{{route('pegawai.artikel.new')}}">{{$side_title}}</a>
            <a class="btn btn-lg btn-block btn-primary rounded-0 py-2 mb-3 bg-op-6 roboto-bold" href="{{route('pegawai.artikel.list')}}">Artikel Saya</a>
            @endsection
            @include('template.statcounter')
        </div>
    </div>