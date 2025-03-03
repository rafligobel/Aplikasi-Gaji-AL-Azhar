@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('Data Gaji') }}</h1>
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
                        <form action="{{ route('admin.gaji.index') }}" method="get">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="bulan">Bulan</label>
                                        <select class="form-control" name="bulan" id="bulan">
                                            <option value="#">-- Pilih Bulan --</option>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tahun">Tahun</label>
                                        <select class="form-control" name="tahun" id="tahun">
                                        <option value="#">-- Pilih Tahun --</option>
                                        {{ $last= date('Y')-5 }}
                                        {{ $now = date('Y') }}

                                        @for ($i = $now; $i >= $last; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary">Filter</button>
                            @if(request()->get('bulan') === null && request()->get('tahun') === null )
                                <a href="{{ route('admin.gaji.cetak',[ltrim(date('m'), '0'),date('Y')]) }}" class="btn btn-info"> Cetak <i class="fa fa-print"></i> </a>
                            @else 
                                <a href="{{ route('admin.gaji.cetak',[request()->get('bulan'),request()->get('tahun')]) }}" class="btn btn-info"> Cetak <i class="fa fa-print"></i> </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            @if(request()->get('bulan') === null && request()->get('tahun') === null )
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success }}">
                            Menampilkan data kehadiran karyawan bulan <span class="text-bold">{{ date('m') }}</span> tahun <span class="text-bold">{{ date('Y') }}</span>
                        </div>
                    </div>
                </div>
            @else 
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger }}">
                            Pilih Bulan dan Tahun Terlebih Dahulu! 
                            {{-- <span class="text-bold">{{ request()->get('bulan') }}</span> tahun <span class="text-bold">{{ request()->get('tahun') }}</span> --}}
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
                                            <th>Gaji Pokok</th>
                                            <th>Transportasi</th>
                                            <th>Uang Makan</th>
                                            <th>Potongan</th>
                                            <th>Total Gaji</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->jenis_kelamin }}</td>
                                            <td>{{ $item->nama_jabatan }}</td>
                                            <td>Rp. {{ number_format($item->gaji_pokok,0,'','.') }}</td>
                                            <td>Rp. {{ number_format($item->transportasi,0,'','.') }}</td>
                                            <td>Rp. {{ number_format($item->uang_makan,0,'','.') }}</td>
                                            @php 
    $potongan_gaji_alpha = isset($potongan_alpha[0]) ? $potongan_alpha[0]->jumlah_potongan : 0;
    $potongan_gaji_izin = isset($potongan_izin[0]) ? $potongan_izin[0]->jumlah_potongan : 0;
    $total_potongan = $potongan_gaji_alpha * $item->alpha + $potongan_gaji_izin * $item->izin;
    $total_gaji = ($item->gaji_pokok + $item->transportasi + $item->uang_makan) - $total_potongan;
@endphp


                                            <td>Rp. {{ number_format($total_potongan, 0,'','.') }}</td>
                                            <td>Rp. {{ number_format($total_gaji,0,'','.') }}</td>
                                        </tr>
                                    @empty 
                                        <tr>
                                            <td colspan="9" class="text-center">Data Kosong</td>
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