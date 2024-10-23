@extends('template.header')
@section('content')
        <div class="row">
          <div class="col-xl-3 col-sm-6">
            <div class="card card-mini mb-4">
              <div class="card-body">
                <h2 class="mb-1">{{$c_departemen}}</h2>
                <p>Departemen</p>
                <div class="chartjs-wrapper">
                  <canvas id="barChart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card card-mini  mb-4">
              <div class="card-body">
                <h2 class="mb-1">{{$c_users}}</h2>
                <p>Users</p>
                <div class="chartjs-wrapper">
                  <canvas id="dual-line"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card card-mini mb-4">
              <div class="card-body">
                <h2 class="mb-1">{{$c_post}}</h2>
                <p>Post</p>
                <div class="chartjs-wrapper">
                  <canvas id="area-chart"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card card-mini mb-4">
              <div class="card-body">
                <h2 class="mb-1">{{$c_berkas}}</h2>
                <p>Berkas</p>
                <div class="chartjs-wrapper">
                  <canvas id="line"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
	    </div>
@endsection