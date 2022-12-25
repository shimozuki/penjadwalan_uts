@extends('template_backend.home')
@section('heading', 'Dashboard')
@section('page')
<li class="breadcrumb-item active">Admin</li>
<li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')
<div class="col-lg-4 col-6">
    <div class="small-box bg-info">
        <div class="inner">
            <h3>{{ $jadwal }}</h3>
            <p>Jadwal</p>
        </div>
        <div class="icon">
            <i class="fas fa-calendar-alt nav-icon"></i>
        </div>
        <a href="{{ route('jadwal.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<div class="col-lg-4 col-6">
    <div class="small-box bg-warning">
        <div class="inner" style="color: #FFFFFF;">
            <h3>{{ $dosen }}</h3>
            <p>Dosen</p>
        </div>
        <div class="icon">
            <i class="fas fa-id-card nav-icon"></i>
        </div>
        <a href="{{ route('guru.index') }}" style="color: #FFFFFF !important;" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<div class="col-lg-4 col-6">
    <div class="small-box bg-success">
        <div class="inner">
            <h3>{{ $siswa }}</h3>
            <p>Mahasiswa</p>
        </div>
        <div class="icon">
            <i class="fas fa-id-card nav-icon"></i>
        </div>
        <a href="{{ route('siswa.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<div class="col-lg-4 col-6">
    <div class="small-box bg-danger">
        <div class="inner">
            <h3>{{ $class }}</h3>
            <p>Kelas</p>
        </div>
        <div class="icon">
            <i class="fas fa-home nav-icon"></i>
        </div>
        <a href="{{ route('kelas.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<div class="col-lg-4 col-6">
    <div class="small-box bg-primary">
        <div class="inner">
            <h3>{{ $mapel }}</h3>
            <p>Matakuliah</p>
        </div>
        <div class="icon">
            <i class="fas fa-book nav-icon"></i>
        </div>
        <a href="{{ route('mapel.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<div class="col-lg-4 col-6">
    <div class="small-box bg-secondary">
        <div class="inner">
            <h3>{{ $user }}</h3>
            <p>User Registrations</p>
        </div>
        <div class="icon">
            <i class="fas fa-user-plus nav-icon"></i>
        </div>
        <a href="{{ route('user.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <p class="d-flex flex-column">
                    <span class="text-bold text-lg">Jadwal </span>
                </p>
                <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                        <i class="fas fa-arrow-up"></i>
                    </span>
                </p>
            </div>
            <div class="position-relative mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="chart-responsive">
                            <canvas id="pieChartPaket" height="150"></canvas>
                        </div>
                    </div>
                    <div class="card-body" style="margin-buttom: -15%;">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kelas</th>
                                <th>Lihat Jadwal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_kelas }}</td>
                                <td>
                                    <a href="{{ route('jadwal.show', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm"><i class="nav-icon fas fa-search-plus"></i> &nbsp; Ditails</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        'use strict'

        var pieChartCanvasGuru = $('#pieChartGuru').get(0).getContext('2d')
        var pieDataGuru = {
            labels: [
                'Laki-laki',
                'Perempuan',
            ],
            datasets: [{
                data: [{
                    {
                        $gurulk
                    }
                }, {
                    {
                        $gurupr
                    }
                }],
                backgroundColor: ['#007BFF', '#DC3545'],
            }]
        }
        var pieOptions = {
            legend: {
                display: false
            }
        }
        var pieChart = new Chart(pieChartCanvasGuru, {
            type: 'doughnut',
            data: pieDataGuru,
            options: pieOptions
        })

        var pieChartCanvasSiswa = $('#pieChartSiswa').get(0).getContext('2d')
        var pieDataSiswa = {
            labels: [
                'Laki-laki',
                'Perempuan',
            ],
            datasets: [{
                data: [{
                    {
                        $siswalk
                    }
                }, {
                    {
                        $siswapr
                    }
                }],
                backgroundColor: ['#007BFF', '#DC3545'],
            }]
        }
        var pieOptions = {
            legend: {
                display: false
            }
        }
        var pieChart = new Chart(pieChartCanvasSiswa, {
            type: 'doughnut',
            data: pieDataSiswa,
            options: pieOptions
        })


        var pieChartCanvasPaket = $('#pieChartPaket').get(0).getContext('2d')
        var pieDataPaket = {
            labels: [
                'Bisnis kontruksi dan Properti',
                'Desain Permodelan dan Informasi Bangunan',
                'Elektronika Industri',
                'Otomasi Industri',
                'Teknik dan Bisnis Sepeda Motor',
                'Rekayasa Perangkat Lunak',
                'Teknik Pemesinan',
                'Teknik Pengelasan',
            ],
            datasets: [{
                data: [{
                    {
                        $bkp
                    }
                }, {
                    {
                        $dpib
                    }
                }, {
                    {
                        $ei
                    }
                }, {
                    {
                        $oi
                    }
                }, {
                    {
                        $tbsm
                    }
                }, {
                    {
                        $rpl
                    }
                }, {
                    {
                        $tpm
                    }
                }, {
                    {
                        $las
                    }
                }],
                backgroundColor: ['#d4c148', '#ba6906', '#ff990a', '#00a352', '#2cabe6', '#999999', '#0b2e75', '#7980f7'],
            }]
        }
        var pieOptions = {
            legend: {
                display: false
            }
        }
        var pieChart = new Chart(pieChartCanvasPaket, {
            type: 'doughnut',
            data: pieDataPaket,
            options: pieOptions
        })
    })

    $("#Dashboard").addClass("active");
    $("#liDashboard").addClass("menu-open");
    $("#AdminHome").addClass("active");
</script>
@endsection