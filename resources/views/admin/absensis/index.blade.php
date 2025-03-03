@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('Data Absensi') }}</h1>
                </div><!-- /.col --> 
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card p-4">
                        <form action="{{ route('admin.absensis.index') }}" method="get">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select class="form-control" name="bulan" id="bulan">
                                            <option value="#">-- Pilih Bulan --</option>
                                            @foreach (range(1, 12) as $i)
                                                <option value="{{ $i }}" {{ request()->get('bulan') == $i ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <select class="form-control" name="tahun" id="tahun">
                                            <option value="#">-- Pilih Tahun --</option>
                                            @php
                                                $last = date('Y') - 5;
                                                $now = date('Y');
                                            @endphp
                                            @for ($i = $now; $i >= $last; $i--)
                                                <option value="{{ $i }}" {{ request()->get('tahun') == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>

            @if(request()->get('bulan') === null && request()->get('tahun') === null )
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            Menampilkan data kehadiran karyawan bulan <span class="text-bold">{{ date('m') }}</span> tahun <span class="text-bold">{{ date('Y') }}</span>
                        </div>
                    </div>
                </div>
            @else 
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success">
                            Menampilkan data kehadiran karyawan bulan 
                            <span class="text-bold">{{ request()->get('bulan') }}</span> tahun <span class="text-bold">{{ request()->get('tahun') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nik</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Jabatan</th>
                                            <th>Hadir</th>
                                            <th>Izin</th>
                                            <th>Alpha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($absensis as $absensi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $absensi->user->nik }}</td>
                                            <td>{{ $absensi->user->nama }}</td>
                                            <td>{{ $absensi->user->jenis_kelamin }}</td>
                                            <td>{{ $absensi->user->jabatan->nama }}</td>
                                            <td>{{ $absensi->hadir }}</td>
                                            <td>{{ $absensi->izin }}</td>
                                            <td>{{ $absensi->alpha }}</td>
                                        </tr>
                                    @empty 
                                        <tr>
                                            <td colspan="8" class="text-center">Data Kosong</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
