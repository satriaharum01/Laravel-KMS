<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--<link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}"> --}}
	{{--<link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}"> --}}
	<link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <title>{{$sub_title}}</title>
</head>
<body>
    <div id="printableArea">
        <page size="A4">
			<div class="">
				<div class="panel-body">
					<h4 class="text-center"> {{strtoupper($sub_title)}}</h4>
					<br/>
					<div class="row">
					<div class="table-responsive">
                        <table class="table table-bordered table-striped table" width="100%">
                            <thead>
                            <tr class="row-tr">
							    <th style="text-align:center;" width="7%">No</th>
							    <th style="text-align:center;" width="20%">Jenis Pengurusan</th>
							    <th style="text-align:center;">Tanggal Pengajuan</th>
							    <th style="text-align:center;" width="25%">Client</th>
							    <th style="text-align:center;" width="25%">Status</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                $no = 1;
                                $total = 0;
                                foreach($load as $row) {
                                    $p = 1;
                                    echo '<tr>';
                                    echo '<td rowspan="' . $row['count'] . '">' . $no . '</td>';
                                    echo '<td rowspan="' . $row['count'] . '">' . $row['akta'][0] . '</td>';
                                    echo '<td rowspan="' . $row['count'] . '">' . $row['tanggal'] . '</td>';
                                    echo '<td rowspan="' . $row['count'] . '">' . $row['name'][0] . '</td>';
                                    echo '<td rowspan="' . $row['count'] . '">Permohonan ' . $row['status'][0] . '</td>';
                                    echo '</tr>';
                                    $no++;
                                }?>
                            </tbody>
                        </table>
		            </div>
					</div>
				</div>
			</div>
        </page>
    </div>
  </body>
</html>