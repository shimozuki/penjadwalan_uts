@extends('template_backend.home')
@section('heading', 'Data Dosen')
@section('page')
<li class="breadcrumb-item active">Data Dosen</li>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">
                    <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Dosen
                </button>
                <a href="{{ route('guru.export_excel') }}" class="btn btn-success btn-sm my-3" target="_blank"><i class="nav-icon fas fa-file-export"></i> &nbsp; EXPORT EXCEL</a>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importExcel">
                    <i class="nav-icon fas fa-file-import"></i> &nbsp; IMPORT EXCEL
                </button>
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#dropTable">
                    <i class="nav-icon fas fa-minus-circle"></i> &nbsp; Drop
                </button>
            </h3>
        </div>
        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" action="{{ route('guru.import_excel') }}" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h5 class="modal-title">Petunjuk :</h5>
                                </div>
                                <div class="card-body">
                                    <ul>
                                        <li>rows 1 = nama Dosen</li>
                                        <li>rows 2 = nip Dosen</li>
                                        <li>rows 3 = jenis kelamin</li>
                                        <li>rows 4 = mata pelajaran</li>
                                    </ul>
                                </div>
                            </div>
                            <label>Pilih file excel</label>
                            <div class="form-group">
                                <input type="file" name="file" required="required">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="dropTable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="post" action="{{ route('guru.deleteAll') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Sure you drop all data?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cencel</button>
                            <button type="submit" class="btn btn-danger">Drop</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="col-md-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>NIDN</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guru as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_guru }}</td>
                                <td>{{ $data->nip }}</td>
                                <td>
                                    <a href="{{ asset($data->foto) }}" data-toggle="lightbox" data-title="Foto {{ $data->nama_guru }}" data-gallery="gallery" data-footer='<a href="{{ route('guru.ubah-foto', Crypt::encrypt($data->id)) }}" id="linkFotoGuru" class="btn btn-link btn-block btn-light"><i class="nav-icon fas fa-file-upload"></i> &nbsp; Ubah Foto</a>'>
                                        <img src="{{ asset($data->foto) }}" width="130px" class="img-fluid mb-2">
                                    </a>
                                    {{-- https://siakad.didev.id/guru/ubah-foto/{{$data->id}} --}}
                                </td>
                                <td>
                                    <form action="{{ route('guru.destroy', $data->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <a href="{{ route('guru.show', Crypt::encrypt($data->id)) }}" class="btn btn-info btn-sm mt-2"><i class="nav-icon fas fa-id-card"></i> &nbsp; Detail</a>
                                        <a href="{{ route('guru.edit', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm mt-2"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                                        <button class="btn btn-danger btn-sm mt-2"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Dosen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('guru.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_guru">Nama Dosen</label>
                                <input type="text" id="nama_guru" name="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label for="tmp_lahir">Tempat Lahir</label>
                                <input type="text" id="tmp_lahir" name="tmp_lahir" class="form-control @error('tmp_lahir') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label for="jk">Jenis Kelamin</label>
                                <select id="jk" name="jk" class="select2bs4 form-control @error('jk') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip">NIDN</label>
                                <input type="text" id="nip" name="nip" onkeypress="return inputAngka(event)" class="form-control @error('nip') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label for="mapel_id">Matakuliah</label>
                                <select id="mapel_id" name="mapel_id" class="select2bs4 form-control @error('mapel_id') is-invalid @enderror">
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach ($mapel as $data)
                                    <option value="{{ $data->id }}">{{ $data->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                            $kode = $max+1;
                            if (strlen($kode) == 1) {
                            $id_card = "0000".$kode;
                            } else if(strlen($kode) == 2) {
                            $id_card = "000".$kode;
                            } else if(strlen($kode) == 3) {
                            $id_card = "00".$kode;
                            } else if(strlen($kode) == 4) {
                            $id_card = "0".$kode;
                            } else {
                            $id_card = $kode;
                            }
                            @endphp
                            <div class="form-group">
                                <input type="hidden" id="id_card" name="id_card" maxlength="5" onkeypress="return inputAngka(event)" value="{{ $id_card }}" class="form-control @error('id_card') is-invalid @enderror" readonly>
                            </div>
                            <div class="form-group">
                            <label for="telp">Nomor Telpon/HP</label>
                                <input type="text" id="telp" name="telp" onkeypress="return inputAngka(event)" class="form-control @error('telp') is-invalid @enderror">
                            </div>
                            <div class="form-group">
                                <label for="foto">File input</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="foto" class="custom-file-input @error('foto') is-invalid @enderror" id="foto">
                                        <label class="custom-file-label" for="foto">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class='nav-icon fas fa-arrow-left'></i> &nbsp; Kembali</button>
                <button type="submit" class="btn btn-primary"><i class="nav-icon fas fa-save"></i> &nbsp; Tambahkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DataGuru").addClass("active");
</script>
@endsection