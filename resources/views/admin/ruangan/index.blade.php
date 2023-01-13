@extends('template_backend.home')
@section('heading', 'Data Ruangan')
@section('page')
<li class="breadcrumb-item active">Data Ruangan</li>
@endsection
@section('content')
<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        <button type="button" class="btn btn-primary btn-sm" onclick="getCreateKelas()" data-toggle="modal" data-target="#form-kelas">
          <i class="nav-icon fas fa-folder-plus"></i> &nbsp; Tambah Ruangan
        </button>
      </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No.</th>
            <th>Kelas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $row)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->nama_ruang }}</td>
            <td>
              <form action="{{ route('ruangan.kill', $row->id) }}" method="post">
                @csrf
                @method('delete')
                <button type="button" class="btn btn-success btn-sm" onclick="getEditRuang({{$row->id}})" data-toggle="modal" data-target="#form-kelas">
                  <i class="nav-icon fas fa-edit"></i> &nbsp; Edit
                </button>
                <button class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash-alt"></i> &nbsp; Hapus</button>
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
<!-- /.col -->

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-md" id="form-kelas" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judul"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('ruangan.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" id="id" name="id">
              <div class="form-group" id="form_nama"></div>
              <div class="form-group" id="form_paket"></div>
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

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-lg view-siswa" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judul-siswa">View Siswa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover" width="100%">
                <thead>
                  <tr>
                    <th>No Induk Siswa</th>
                    <th>Nama Siswa</th>
                    <th>L/P</th>
                    <th>Foto Siswa</th>
                  </tr>
                </thead>
                <tbody id="data-siswa">
                </tbody>
                <tfoot>
                  <tr>
                    <th>No Induk Siswa</th>
                    <th>Nama Siswa</th>
                    <th>L/P</th>
                    <th>Foto Siswa</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</button>
          <a id="link-siswa" href="#" class="btn btn-primary"><i class="nav-icon fas fa-download"></i> &nbsp; Download PDF</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Extra large modal -->
<div class="modal fade bd-example-modal-xl view-jadwal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="judul-jadwal">View Jadwal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover" width="100%">
                <thead>
                  <tr>
                    <th>Hari</th>
                    <th>Jadwal</th>
                    <th>Jam Pelajaran</th>
                    <th>Ruang Kelas</th>
                  </tr>
                </thead>
                <tbody id="data-jadwal">
                </tbody>
                <tfoot>
                  <tr>
                    <th>Hari</th>
                    <th>Jadwal</th>
                    <th>Jam Pelajaran</th>
                    <th>Ruang Kelas</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.col -->
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="nav-icon fas fa-arrow-left"></i> &nbsp; Kembali</button>
          <a id="link-jadwal" href="#" class="btn btn-primary"><i class="nav-icon fas fa-download"></i> &nbsp; Download PDF</a>
        </div>
      </div>
    </div>
  </div>
  @endsection
  @section('script')
  <script>
    function getCreateKelas() {
      $("#judul").text('Tambah Data Ruangan');
      $('#id').val('');
      $('#form_nama').html(`
        <label for="nama_ruang">Nama Ruangan</label>
        <input type='text' id="nama_ruang" onkeyup="this.value = this.value.toUpperCase()" name='nama_ruang' class="form-control @error('nama_ruang') is-invalid @enderror" placeholder="{{ __('Nama Ruangan') }}">
      `);
      $('#nama_ruang').val('');
    }

    function getEditRuang(id) {
      var parent = id;
      var form_paket = (`
        <input type="hidden" id="id_ruang" onkeyup="this.value = this.value.toUpperCase()" name='nama_ruang' class="form-control @error('nama_ruang') is-invalid @enderror">
        <label for="nama_ruang">Nama Ruangan</label>
        <input type='text' id="nama_ruang" onkeyup="this.value = this.value.toUpperCase()" name='nama_ruang' class="form-control @error('nama_ruang') is-invalid @enderror" placeholder="{{ __('Nama Ruangan') }}">
      `);
      $.ajax({
        type: "GET",
        data: "id=" + parent,
        dataType: "JSON",
        url: "{{ url('/ruangan/edit/json') }}",
        success: function(result) {
          console.log(result);
          if (result) {
            $.each(result, function(index, val) {
              $("#judul").text('Edit Data Ruangan ' + val.nama_ruangan);
              $('#form_nama').html('');
              $('#form_paket').html('');
              $("#form_paket").append(form_paket);
              $('#nama_ruang').val(val.nama_ruangan);
              $('#id').val(val.id);
            });
          }
        },
        error: function() {
          toastr.error("Errors 404!");
        },
        complete: function() {}
      });
    }

    $("#MasterData").addClass("active");
    $("#liMasterData").addClass("menu-open");
    $("#DatRuangan").addClass("active");
  </script>
  @endsection