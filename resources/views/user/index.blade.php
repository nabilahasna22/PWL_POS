@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" 
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info">Import Data </button> 
                  <a href="{{ url('/user/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Excel</a> 
                <a href="{{ url('/user/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export PDF</a> 
                <button onclick="modalAction('{{ url('user/create_ajax')}}')" class="btn btn-success">Tambah Data (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class= id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($level as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Level Pengguna</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
<script> 
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
    var dataUser;
    $(document).ready(function() {
        dataUser = $('#table_user').DataTable({
            // serverSide: true, jika ingin menggunakan server side processing
            serverSide: true,
            ajax: {
                "url": "{{ url('user/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d){
                    d.level_id=$('#level_id').val();
                }
            },
            columns: [{
                // nomor urut dari laravel datatable addIndexColumn()
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            }, {
                data: "username",
                className: "",
                // orderable: true, jika ingin kolom ini bisa diurutkan
                orderable: true,
                // searchable: true, jika ingin kolom ini bisa dicari
                searchable: true
            }, {
                data: "nama",
                className: "",
                width: "25%",
                orderable: true,
                searchable: true
            }, {
                // mengambil data level hasil dari ORM berelasi
                data: "level.level_nama",
                className: "",
                width: "14%",
                orderable: true,
                searchable: false
            }, {
                data: "foto",
                className: "",
                width: "14%",
                orderable: false,
                searchable: false,
                "render": function(data) {
                    // Check if data exists
                    if (data) {
                        // Construct the image URL using Blade syntax
                        return '<img src="{{ asset('') }}/' + data + '" width="50px" alt="User Photo"/>';
                    }
                    return 'Foto Kosong'; // Return empty if no data
                }
            }, {
                data: "aksi",
                className: "",
                orderable: false,
                searchable: false
            }]
        });
        $('#level_id').on('change', function(){
          dataUser.ajax.reload();
        });
    });
</script>
@endpush