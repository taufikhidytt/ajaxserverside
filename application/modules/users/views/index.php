<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css" rel="stylesheet">

    <title>Ajax serverside</title>
</head>

<body>
    <div class="container mt-5">
        <h1>ajax serverside</h1><br>


        <div id="flashSuccess" data-success="<?= $this->session->flashdata('success'); ?>"></div>
        <div id="flashWarning" data-warning="<?= $this->session->flashdata('warning'); ?>"></div>
        <div id="flashError" data-error="<?= $this->session->flashdata('error'); ?>"></div>


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">
            Add
        </button><br><br>
        <table class="table table-bordered table-striped table-responsive text-center" id="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data->result() as $dt) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $dt->nama_lengkap ?></td>
                        <td><?= $dt->username ?></td>
                        <td><?= $dt->jenis_kelamin ?></td>
                        <td><?= $dt->alamat ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm" data-id="<?= $dt->id_users ?>" data-nama_lengkap="<?= $dt->nama_lengkap ?>" data-username="<?= $dt->username ?>" data-password="<?= $dt->password ?>" data-jenis_kelamin="<?= $dt->jenis_kelamin ?>" data-alamat="<?= $dt->alamat ?>">
                                Update
                            </button> |
                            <form action="<?= base_url('users/delete') ?>" method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?= $dt->id_users ?>">
                                <button class="btn btn-sm btn-danger" id="form-delete">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formUsers">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" id="url">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap :</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control">
                            <div id="error-nama_lengkap" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="username">Username :</label>
                            <input type="text" name="username" id="username" class="form-control">
                            <div id="error-username" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password :</label>
                            <input type="text" name="password" id="password" class="form-control">
                            <div id="error-password" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin :</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                <option value="">-- Select Jenis Kelamin --</option>
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                            <div id="error-jenis_kelamin" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat :</label>
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
                            <div id="error-alamat" class="invalid-feedback"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();

            var flashsuccess = $('#flashSuccess').data('success');
            var flashwarning = $('#flashWarning').data('warning');
            var flasherror = $('#flashError').data('error');

            if (flashsuccess) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: flashsuccess,
                })
            }

            if (flashwarning) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: flashwarning,
                })
            }

            if (flasherror) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: flasherror,
                })
            }

            // $('#modalAdd').on('hidden.bs.modal', function() {
            //     $('[name="nama_lengkap"]').removeClass('is-invalid');
            //     $('[name="' + response.input[i] + '"]').next().remove().text(response.message_error[i]);
            //     $(this).find('form').trigger('reset');
            //     $('input, select, textarea').removeClass('is-invalid')
            // });

            $("#modalForm").on("show.bs.modal", function(event) {

                const ddata_id = $(event.relatedTarget);
                const id = ddata_id.data("id");
                console.log(id)

                clearForm();

                $('#formUsers')[0].reset();
                if (id == undefined || id == null || id == "") {
                    $('#btnSubmit').text('Simpan');
                    $('.modal-title').text('Tambah Data');
                    $('#url').val('<?php echo site_url('users/add'); ?>');
                } else {
                    $('#btnSubmit').text('Ubah');
                    $('#url').val('<?php echo site_url('users/update'); ?>');
                    $('.modal-title').text('Ubah Data');

                    const id = ddata_id.data("id");
                    const nama_lengkap = ddata_id.data("nama_lengkap");
                    const username = ddata_id.data("username");
                    const password = ddata_id.data("password");
                    const jenis_kelamin = ddata_id.data("jenis_kelamin");
                    const alamat = ddata_id.data("alamat");

                    $('#id').val(id);
                    $('#nama_lengkap').val(nama_lengkap);
                    $('#username').val(username);
                    $('#password').val(password);
                    $('#jenis_kelamin').val(jenis_kelamin);
                    $('#alamat').val(alamat);
                }

            });

            $("#btnSubmit").click(function() {

                $('#btnSubmit').attr('disabled', true);

                const id = $('#id').val();
                let url = $('#url').val();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure you saved the data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'No!, Cancel',
                    confirmButtonText: 'Yess!, Save Data'
                }).then((result) => {
                    if (result.value) {
                        // alert(result.value);
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: $('#formUsers').serialize(),
                            dataType: "JSON",
                            success: function(res) {
                                if (res.success) {

                                    $('#modalForm').modal('hide');
                                    $('#btnSubmit').attr('disabled', false);
                                    Swal.fire({
                                        title: 'Success',
                                        text: res.message,
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Ok'
                                    }).then((result) => {
                                        location.reload();
                                    });

                                } else {
                                    $('#btnSubmit').attr('disabled', false);
                                    const resMsg = res.result;
                                    // console.log(resMsg)
                                    for (msg in resMsg) {
                                        console.log(resMsg[msg])
                                        if (resMsg[msg] != "") {
                                            $("input[name=" + msg + "]").addClass("is-invalid");
                                            $("#error-" + msg).html(resMsg[msg]);
                                            $("#error-" + msg).css('display', 'block');
                                            // display: block;
                                        } else {
                                            $("input[name=" + msg + "]").removeClass("is-invalid");
                                            $("#error-" + msg).html("");
                                            $("#error-" + msg).css('display', 'none');
                                        }

                                    }
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    title: 'Warning',
                                    text: 'Error adding / update data',
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok'
                                }).then((result) => {
                                    location.reload();
                                });
                                // alert('Error adding / update data');
                                // $('#modalForm').modal('hide');
                            }
                        });
                    } else {
                        $('#btnSubmit').attr('disabled', false);
                    }
                });

            });

            $(document).on('click', '#form-delete', function(e) {
                e.preventDefault();
                var link = $(this).parent('form');
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Ingin Menghapus Data Ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Hapus Data Ini!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        link.submit();
                    }
                })
            });
        });

        function clearForm() {
            $('#nama_lengkap').val("");
            $('#username').val("");
            $('#password').val("");
            $('#jenis_kelamin').val("");
            $('#alamat').val("");

            // $("div.form-group-name").removeClass("has-danger");
            $("input[name=nama_lengkap]").removeClass("is-invalid");
            $("#error-nama_lengkap").html("");

            // $("div.form-group-venue").removeClass("has-danger");
            $("input[name=username]").removeClass("is-invalid");
            $("#error-username").html("");

            // $("div.form-group-datetime").removeClass("has-danger");
            $("input[name=password]").removeClass("is-invalid");
            $("#error-password").html("");

            $("input[name=jenis_kelamin]").removeClass("is-invalid");
            $("#error-jenis_kelamin").html("");

            $("input[name=alamat]").removeClass("is-invalid");
            $("#error-alamat").html("");
        }

        function message(icon, text) {
            Swal.fire({
                position: 'center',
                icon: icon,
                test: text,
                showConfirmButton: true,
            })
        }

        // function add() {
        //     $.ajax({
        //         type: "post",
        //         url: "<?= base_url('users/add') ?>",
        //         data: $('#fromAdd').serialize(),
        //         dataType: "json",
        //         success: function(response) {
        //             if (response.status == 'success') {
        //                 message(response.icon, response.text);
        //             } else {
        //                 for (var i = 0; i < response.input.length; i++) {
        //                     $('[name="' + response.input[i] + '"]').addClass('is-invalid');
        //                     $('[name="' + response.input[i] + '"]').next().text(response.message_error[i]);
        //                 }
        //             }
        //         }
        //     });
        // }
    </script>
</body>

</html>