@extends('template_backend.home')
@section('heading', 'Data Matkul')
@section('page')
<li class="breadcrumb-item active">Data Matkul</li>
@endsection
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".tambah-mapel">
          <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Data Matkul
        </button>
      </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Kode Matkul</th>
            <th>Nama Matkul</th>
            <th>Paket</th>
            <th>Kelompok</th>
            <th>Semester</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mapel as $result => $data)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->code_mk }}</td>
            <td>{{ $data->nama_mapel }}</td>
            @if ( $data->paket_id == 9 )
            <td>{{ 'Semua' }}</td>
            @else
            <td>{{ $data->paket->ket }}</td>
            @endif
            <td>{{ $data->kelompok }}</td>
            <td>{{ $data->semester}}</td>
            <td>
              @if(Auth::user()->role == 'Dosen') 
              <form action="{{ route('pilih') }}" method="post">
              @csrf
                <input type="text" value="{{Auth::user()->id}}" name="id_dosen" hidden>
                <input type="text" value="{{$data->id}}" name="id"hidden>
                <button type="submit" class="btn btn-info btn-sm"><i class="nav-icon fas fa-check"></i> &nbsp; Ambil Matakuliah</button>
              </form> 
              @endif
              @if(Auth::user()->role != 'Dosen') 
              <form action="{{ route('mapel.destroy', $data->id) }}" method="post">
                @csrf
                @method('delete')
                @if(Auth::user()->role == 'Dosen')
                <input id="dosen" type="text" value="{{Auth::user()->id}}" name="id_dosen" hidden>
                <input id="matkul" type="text" value="{{$data->id}}" hidden>
                <button type="button" id="update" class="btn btn-info btn-sm"><i class="nav-icon fas fa-check"></i> &nbsp; Ambil</button>
                @endif
                <a href="{{ route('mapel.edit', Crypt::encrypt($data->id)) }}" class="btn btn-success btn-sm"><i class="nav-icon fas fa-edit"></i> &nbsp; Edit</a>
                <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
              </form>
              @endif
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
<!-- /.col -->

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-md tambah-mapel" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Data Matakuliah</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('mapel.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="code_mk">Kode Matakuliah</label>
                <input type="text" id="code_mk" name="code_mk" class="form-control @error('code_mk') is-invalid @enderror" placeholder="{{ __('Kode Matakuliah') }}">
              </div>
              <div class="form-group">
                <label for="nama_mapel">Nama Matakuliah</label>
                <input type="text" id="nama_mapel" name="nama_mapel" class="form-control @error('nama_mapel') is-invalid @enderror" placeholder="{{ __('Nama Mata Kuliah') }}">
              </div>
              <div class="form-group">
                <label for="paket_id">Semester</label>
                <select id="semester" name="semester" class="form-control @error('paket_id') is-invalid @enderror select2bs4">
                  <option value="">-- Pilih Semester --</option>
                  <option value="1">I</option>
                  <option value="2">II</option>
                  <option value="3">III</option>
                  <option value="4">IV</option>
                  <option value="5">V</option>
                  <option value="6">VI</option>
                  <option value="7">VII</option>
                  <option value="8">VIII</option>
                </select>
              </div>
              <div class="form-group">
                <label for="paket_id">Paket</label>
                <select id="paket_id" name="paket_id" class="form-control @error('paket_id') is-invalid @enderror select2bs4">
                  <option value="">-- Pilih Paket Matakuliah --</option>
                  <option value="9">Semua</option>
                  @foreach ($paket as $data)
                  <option value="{{ $data->id }}">{{ $data->ket }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="kelompok">Kelompok</label>
                <select id="kelompok" name="kelompok" class="select2bs4 form-control @error('kelompok') is-invalid @enderror">
                  <option value="">-- Pilih Kelompok Matakuliah --</option>
                  <option value="A">Pelajaran Umum</option>
                  <option value="B">Pelajaran Khusus</option>
                  <option value="C">Pelajaran Keahlian</option>
                </select>
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
  $("#DataMapel").addClass("active");
</script>
<script>
  $('#update').on('click', function () {
    e.preventDefault();

    //define variable
    let dosen = $('#dosen').val();
    let matkul = $('#matkul').val();

    //ajax
    $.ajax({

      url: `http://localhost:8000/pilih`,
      type: "get",
      cache: false,
      data: {
        "id_dosen": dosen,
        "id": matkul,
      },
    });

  });
</script>
@endsection