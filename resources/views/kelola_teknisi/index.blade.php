@extends('header')
@section('content')
<!-- Main Section -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/view_admin.css') }} ">
<link href="https://fonts.googleapis.com/css?family=Blinker&display=swap" rel="stylesheet">

{{-- data table --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<section class="main-section">
    <style>
        .alert-response,
        .alert-response2,
        .alert-response3,
        .alert-response4,
        .alert-response7,
        .alert-response8 {
            display: none;
        }

        .loader,
        .loader2,
        .loader4 {
            position: absolute;
            z-index: 1000;
            left: 40%;
            top: 30%;
            height: 100px;
            display: none;
        }

        .loader3 {
            position: absolute;
            z-index: 1000;
            left: 40%;
            top: 30%;
            height: 50px;
            display: none;
        }

        #user-table_wrapper {
            margin-top: 50px;
            margin-bottom: 50px;
        }

    </style>

    <div id="content">
        @if(\Session::has('alert-sukses'))
        <div class="alert alert-info">
            <div>{{Session::get('alert-sukses')}}</div>
        </div>
        @endif

        <a href="javascript:void(0)" style="position:relative; top:10px; border-radius:10px;" class="btn btn-info ml-3"
            id="create-new-user">Add New</a><br><br>

        {{-- data table --}}
        <table id="user-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Created_at</th>
                    <th>Update_at</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

</section>

<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="nama" placeholder="Enter Name"
                                value="" maxlength="50" required="">
                        </div>
                    </div>

                    {{-- <div ></div> --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <span id="status"></span>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                                value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" id="label-password">Password</label>
                        <div class="col-sm-12">
                            <input type="password" minlength="6" class="form-control" id="password" name="password"
                                placeholder="Enter password" value="" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

{{-- modal edit --}}
<div class="modal fade" id="ajax-crudedit-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCrudeditModal"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm2" name="userForm2" class="form-horizontal">
                    <input type="hidden" name="user_id2" id="user_id2">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name2" name="nama2" placeholder="Enter Name"
                                value="" maxlength="50" required="">
                        </div>
                    </div>

                    {{-- <div ></div> --}}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email</label>
                        <span id="status"></span>
                        <div class="col-sm-12">
                            <input type="email" class="form-control" id="email2" name="email2" placeholder="Enter Email"
                                value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" id="label-password">Password</label>
                        <div class="col-sm-12">
                            <input type="password" minlength="6" class="form-control" id="password2" name="password2"
                                placeholder="Enter password" value="" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save2" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<script>
    // var SITEURL = '{{URL::to('')}}';
    var apiurl = "{{env('API_URL')}}";
    console.log(apiurl);
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "kelolaTeknisi",
                type: 'GET',
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    'visible': false
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'password',
                    name: 'password'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });


        //   cek email
        $("#email").bind("keyup change", function () {

            var email = $(this).val();

            $.ajax({
                url: apiurl+'admin/cekemail_teknisi',
                type: "POST",
                data: {
                    send: true,
                    email: email
                },
                success: function (data) {
                    $("#status").html(data.message);

                    if (data.statuscode == 0) {
                        $("#status").css('color', 'red');
                        $("#email").css('borderColor', 'red');
                        $("#btn-save").css('display', 'none');
                    } else {
                        $("#status").css('color', 'green');
                        $("#email").css('borderColor', 'green');
                        $("#btn-save").css('display', 'block');
                    }
                }
            });

        });

        /*  When user click add user button */
        $('#create-new-user').click(function () {
            $('#btn-save').val("create-user");
            $('#user_id').val('');
            $('#userForm').trigger("reset");
            $('#userCrudModal').html("Add New User");
            $('#ajax-crud-modal').modal('show');
        });

        /* When click edit user */
        $('body').on('click', '.edit-user', function () {
            var user_id = $(this).data('id');
            $.get('kelolaTeknisi/' + user_id + '/edit', function (data) {
                $('#name-error').hide();
                $('#email-error').hide();
                $('#userCrudeditModal').html("Edit User");
                $('#btn-save2').val("edit-user");
                $('#ajax-crudedit-modal').modal('show');
                $('#user_id2').val(data.id);
                $('#name2').val(data.nama);
                $('#email2').val(data.email);
                $('#password2').val(data.password);
            })
        });


        $('body').on('click', '#delete-user', function () {

            var user_id = $(this).data("id");
            if(!confirm("Anda serius ingin hapus ? data yang telah dihapus tidak bisa dikembalikan !")){
                return false;
            }

            $.ajax({
                type: "get",
                url: apiurl+"admin/hapusdataTeknisi/" + user_id,
                success: function (data) {
                    var oTable = $('#user-table').dataTable();
                    oTable.fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });

    if ($("#userForm").length > 0) {
        $("#userForm").validate({

            submitHandler: function (form) {

                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: apiurl+"admin/tambahTeknisi",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#userForm').trigger("reset");
                        $('#ajax-crud-modal').modal('hide');
                        $('#btn-save').html('Save Changes');
                        var oTable = $('#user-table').dataTable();
                        oTable.fnDraw(false);

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save Changes');
                    }
                });
            }
        })
    }

    if ($("#userForm2").length > 0) {
        $("#userForm2").validate({

            submitHandler: function (form) {

                var actionType = $('#btn-save2').val();
                $('#btn-save2').html('Sending..');

                $.ajax({
                    data: $('#userForm2').serialize(),
                    url: apiurl+"admin/updatedataTeknisi",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#userForm2').trigger("reset");
                        $('#ajax-crudedit-modal').modal('hide');
                        $('#btn-save2').html('Save Changes');
                        var oTable = $('#user-table').dataTable();
                        oTable.fnDraw(false);

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#btn-save2').html('Save Changes');
                    }
                });
            }
        })
    }

</script>


<script type="text/javascript" src="{{ asset('assets/css/view.js') }}"></script>


<!-- /.main-section -->


@endsection
