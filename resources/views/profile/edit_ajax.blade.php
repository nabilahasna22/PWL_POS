<!-- Form Edit Profile -->
<form action="{{ url('/profile/' . session('user_id') . '/update_ajax') }}" method="POST" id="form-edit" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Level Pengguna</label>
                    <select name="level_id" id="level_id" class="form-control" required>
                        <option value="">- Pilih Level -</option>
                        @foreach ($level as $l)
                            <option {{ $l->level_id == $user->level_id ? 'selected' : '' }}
                                value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-level_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input value="{{ $user->username }}" type="text" name="username" id="username" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input value="{{ $user->nama }}" type="text" name="nama" id="nama" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input value="" type="password" name="password" id="password" class="form-control">
                    <small class="form-text text-muted">Abaikan jika tidak ingin ubah password</small>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="button" class="btn btn-primary" id="btn-konfirmasi">Simpan</button>
            </div>
        </div>
    </div>
</form>

<!-- Modal Konfirmasi -->
<div id="modal-konfirmasi" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Edit Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Apakah Anda yakin ingin menyimpan perubahan?</h5>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Level Pengguna:</th>
                        <td id="confirm-level"></td>
                    </tr>
                    <tr>
                        <th>Username:</th>
                        <td id="confirm-username"></td>
                    </tr>
                    <tr>
                        <th>Nama:</th>
                        <td id="confirm-nama"></td>
                    </tr>
                    <tr>
                        <th>Password:</th>
                        <td id="confirm-password"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-simpan">Ya, Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Saat tombol "Simpan" ditekan, tampilkan modal konfirmasi
        $('#btn-konfirmasi').on('click', function() {
            $('#confirm-level').text($('#level_id option:selected').text());
            $('#confirm-username').text($('#username').val());
            $('#confirm-nama').text($('#nama').val());
            $('#confirm-password').text($('#password').val() ? '********' : '(tidak diubah)');
            $('#modal-konfirmasi').modal('show');
        });

        // Validasi dan submit form
        $("#form-edit").validate({
            rules: {
                level_id: {
                    required: true,
                    number: true
                },
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 20
                },
                nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                password: {
                    minlength: 6,
                    maxlength: 20
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false, 
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Submit form saat pengguna menekan "Ya, Simpan" di modal konfirmasi
        $('#btn-simpan').on('click', function() {
            $('#form-edit').submit();
        });
    });
</script>
