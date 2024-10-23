                        

    <div class="container">
        <div class="row">

            <div class="col-lg-9 mb-3">
                <div class="row text-left mb-5">
                    <div class="col-lg-12 mb-3 mb-sm-0">
                        <div class=" bg-white text-sm w-lg-50"
                            style="width: 100%;">
                            <input type="text" class="form-control form-control-lg bg-white bg-op-9 text-sm w-lg-50" wire:model="searchTerm" placeholder="Cari..." maxlength="30">
                        </div>
                    </div>
                </div>

                @if(count($post) > 0)
                @foreach($post as $row)
                <div
                    class="card row-hover pos-relative py-3 px-3 mb-3 border-warning border-top-0 border-right-0 border-bottom-0 rounded-0">
                    <div class="row align-items-center">
                        <div class="col-md-9 mb-3 mb-sm-0">
                            <h5>
                                <a href="#" class="text-primary">{{$row->tanggal}}</a>
                            </h5>
                            <p class="text-sm"><span class="op-6"></span>{{$row->author}} <a class="text-black"
                                    href="#">{{$row->action}}</a> <span class="op-6"></span></p>
                        </div>
                        <div class="col-md-3 op-7">
                            <div class="row text-center op-7">
                                <div class="col px-1"> <i class="ion-ios-clock icon-1x"></i> <span
                                        class="d-block text-sm">{{$row->time}}</span> </div>
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
            @include('template.statcounter')
        </div>
    </div>