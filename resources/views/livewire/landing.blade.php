@extends('landing.header')
@section('content')
<main id="main">
    <section id="post">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div>
                        <div class="card mb-3 aos-init aos-animate" data-aos="fade-up">
                              <div class="card-header fw-bold">
                                    Populer
                              </div>
                              @foreach($populer as $row)
                              <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 w-25">
                                              <img src="{{asset('assets/img/')}}/{{$row->file}}" alt="[IMG]" class="img-thumbnail">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                              <a href="{{url('landing/acara/')}}{{$row->title}}">
                                                    <h6 class="mt-0">{{$row->nama_acara}}</h6>
                                              </a>
                                              <small class="text-muted">
                                                    <i class="bi bi-calendar-event"></i>
                                                    {{$row->hari}}, {{$row->tanggal}}
                                              </small>
                                        </div>
                                    </div>
                              </div>
                              @endforeach
                        </div>
                        <div class="card mb-3 aos-init aos-animate" data-aos="fade-up">
                            <div class="card-header fw-bold">
                                <div class="d-flex">
                                      <div class="flex-grow-1">Visitor</div>
                                </div>
                            </div>
                            <div class="card-body">
                        	    <div class="fs-5 fw-bold">
                                    <span class="statcounter" id="sc_counter_12738517">11  Views</span> 
                                </div>
                        	</div>
                        </div>
                    </div>
                    <!-- Livewire Component wire-end:IoZ6yflsFsiLGP3TnpIh -->
                </div>
                <div class="col-md-8 aos-init aos-animate" data-aos="fade-up">
                    <div>
                        <div class="row mb-5">
                            <div class="col">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" wire:model="searchTerm" placeholder="Cari..." maxlength="30">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                </div>
                            </div>
                        </div>
                        @foreach($acara as $row)
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="{{asset('assets/img/')}}/{{$row->file}}">
                                    <img src="{{asset('assets/img/')}}/{{$row->file}}" alt="[IMG]" class="rounded img-fluid w-100">
                                </a>
                            </div>
                            <div class="col-md-9 mb-3">
                                <h5 class="fw-bolder text-capitalize my-0">
                                    <a href="{{url('landing/acara/')}}{{$row->title}}">{{$row->nama_acara}}</a>
                                </h5>
                                <small class="form-text text-muted">
                                    <i class="bi bi-calendar-event"></i>
                                    {{$row->hari}}, {{$row->tanggal}}
                                    | <i class="bi bi-clock"></i> {{$row->mulai}} s/d {{$row->selesai}}
                                </small>
                                <div class="my-3">{{$row->deskripsi}}</div>
                                <hr>
                            </div>'
                        </div>
                        @endforeach
                        <div class="row mt-5">
                            <!--<div class="d-flex justify-content-center justify-content-lg-end"> -->
                            <div class="d-flex justify-content-center">
                                <div>
                                    {{ $acara->links('landing.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Livewire Component wire-end:VLs7wAQleVdiMKud3YN3 -->
                </div>
            </div>
        </div>
    </section>
</main>
@endsection