@extends('layouts.template')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Level User</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/level/import') }}')" class="btn btn-info">Import Data</button>
            <a href="{{ url('/level/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Excel</a>
            <a href="{{ url('/level/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export PDF</a>
            <button onclick="modalAction('{{ url('/level/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>
    <div class="card-body">
        <!-- untuk Filter data -->
        <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group form-group-sm row text-sm mb-0">
                        <label for="filter_level" class="col-md-1 col-form-label">Filter</label>
                        <div class="col-md-3">
                            <select name="filter_level" class="form-control form-control-sm filter_level">
                                <option value="">- Semua -</option> 
                                {{-- @foreach($levels as $level)
                                    <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                                @endforeach --}}
                            </select>
                            <small class="form-text text-muted">Filter Level</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-sm table-striped table-hover" id="table-level">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Level</th>
                    <th>Nama Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
@endsection
@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }
    var tableLevel;
    $(document).ready(function() {
        tableLevel = $('#table-level').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('level/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    d.filter_level = $('.filter_level').val();
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "level_kode",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "level_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "text-left",
                    // width: "14%",
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $('#table-level_filter input').unbind().bind().on('keyup', function(e) {
            if (e.keyCode == 13) { // enter key
                tableLevel.search(this.value).draw();
            }
        });
        $('.filter_level').change(function() {
            tableLevel.draw();
        });
    });
</script>
@endpush