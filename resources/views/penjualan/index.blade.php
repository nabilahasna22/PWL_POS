@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                aria-controls="pills-home" aria-selected="true">Transaksi Penjualan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                aria-controls="pills-profile" aria-selected="false">Detail Penjualan</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $page->title }}</h3>
                    <div class="card-tools">
                        <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import
                            Data</button>
                        <a href="{{ url('/penjualan/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>Export Excel</a>
                        <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i>Export PDF</a>
                        <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Data(Ajax)</button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="user_id" name="user_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->user_id }}">{{ $item->username }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">user</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-penjualan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Penjualan</th>
                                <th>Pembeli</th>
                                <th>User ID</th>
                                <th>Tanggal Penjualan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <Tbody></Tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $page->title }}</h3>
                    <div class="card-tools">
                        <button onclick="modalAction('{{ url('/detail/import') }}')" class="btn btn-info">Import
                            Detail</button>
                        <a href="{{ url('/detail/export_excel') }}" class="btn btn-primary"><i
                                class="fa fa-file-excel"></i>
                            Export Detail</a>
                        <a href="{{ url('/detail/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i>
                            Export
                            Detail</a>
                        <button onclick="modalAction('{{ url('/detail/create_ajax') }}')" class="btn btn-success">Tambah
                            Data
                            (Ajax)</button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="barang_id" name="barang_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($barang as $item)
                                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">barang</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-detail">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Penjualan ID</th>
                                <th>Barang ID</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <Tbody></Tbody>
                    </table>
                </div>
            </div>
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
        var tablePenjualan;
        $(document).ready(function() {
            tablePenjualan = $('#table-penjualan').DataTable({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.user_id = $('#user_id').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "penjualan_kode",
                    className: "",
                    width: "20%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "pembeli",
                    className: "",
                    width: "27%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "user.user_id",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "penjualan_tanggal",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#user_id').on('change', function() {
                tablePenjualan.ajax.reload();
            });
        });
        var tableDetail;
        $(document).ready(function() {
            tableDetail = $('#table-detail').DataTable({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('detail/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.barang_id = $('#barang_id').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "penjualan_id",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "barang.barang_id",
                    className: "",
                    width: "37%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "harga",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "jumlah",
                    className: "",
                    width: "14%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "aksi",
                    className: "",
                    width: "14%",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#barang_id').on('change', function() {
                tableDetail.ajax.reload();
            });
        });
    </script>
@endpush