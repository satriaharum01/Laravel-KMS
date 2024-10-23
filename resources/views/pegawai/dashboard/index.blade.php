@extends('template.header')
@section('content')
        <div class="row">
          <div class="col-xl-3 col-sm-6">
            <div class="card card-mini mb-4">
              <div class="card-body">
                <h2 class="mb-1">{{$c_artikel}}</h2>
                <p>Post</p>
                <div class="chartjs-wrapper">
                  <canvas id="barChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card card-mini  mb-4">
              <div class="card-body">
                <h2 class="mb-1">{{$c_komentar}}</h2>
                <p>Komentar</p>
                <div class="chartjs-wrapper">
                  <canvas id="dual-line"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card card-mini mb-4">
              <div class="card-body">
                <h2 class="mb-1">{{$c_notulen}}</h2>
                <p>Notulensi</p>
                <div class="chartjs-wrapper">
                  <canvas id="area-chart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card card-mini mb-4">
              <div class="card-body">
                <h2 class="mb-1">{{$c_viewer}}</h2>
                <p>Viewer</p>
                <div class="chartjs-wrapper">
                  <canvas id="line"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
	    </div>
@endsection