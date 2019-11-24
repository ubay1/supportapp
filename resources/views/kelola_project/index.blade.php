@extends('header')
@section('content')
<!-- Main Section -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/view_admin.css') }} ">
<link href="https://fonts.googleapis.com/css?family=Hind+Guntur&display=swap" rel="stylesheet">

{{-- data table --}}
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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
            id="create-new-project">Add New</a><br><br>

        {{-- data table --}}
        <table id="user-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No</th>
                    <th>Nama Projet</th>
                    <th>Nama Teknikal Support</th>
                    <th>Status</th>
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
                        <label for="name" class="col-sm-12 control-label">Nama Project</label>
                        <span id="status"></span>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="nama_project" placeholder="Enter Name"
                                value="" maxlength="50" required="">
                        </div> <br>

                        <label for="name" class="col-sm-12 control-label">Pilih Teknikal Support</label>
                        <div class="col-sm-12">
                                <select name="tek_support_id" id="tek_support_id" class="form-control">
                                    <option selected> -- Select One --</option>
                                    @foreach ($t_support as $t_supports)
                                        <option value="{{ $t_supports->id }}">{{ $t_supports->nama }}</option>
                                    @endforeach
                                </select>
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
                        </div> <br>

                        <label for="name" class="col-sm-12 control-label">Pilih Teknikal Support</label>
                        <div class="col-sm-12">
                            <select name="tek_support_id2" id="tek_support_id2" class="form-control">
                                    @foreach ($t_support as $t_supports)
                                        <option value="{{ $t_supports->id }}">{{ $t_supports->nama }}</option>
                                    @endforeach
                            </select>
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
                url: "kelolaProject",
                type: 'GET',
            },
            columns: [
                {
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
                    data: 'nama_project',
                    name: 'nama_project'
                },
                {
                    data: 'tek_support.nama',
                    name: 'teknikal_support'
                },
                {
                    data: 'status',
                    name: 'status'
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
        $("#name").bind("keyup change", function () {

            var nama_project = $(this).val();

            $.ajax({
                url: apiurl+'admin/ceknamaproject',
                type: "POST",
                data: {
                    send: true,
                    nama_project: nama_project
                },
                success: function (data) {
                    $("#status").html(data.message);

                    if (data.statuscode == 0) {
                        $("#status").css('color', 'red');
                        $("#name").css('borderColor', 'red');
                        $("#btn-save").css('display', 'none');
                    } else {
                        $("#status").css('color', 'green');
                        $("#name").css('borderColor', 'green');
                        $("#btn-save").css('display', 'block');
                    }
                }
            });

        });

        /*  When user click add user button */
        $('#create-new-project').click(function () {
            $('#btn-save').val("create-user");
            $('#user_id').val('');
            $('#userForm').trigger("reset");
            $('#userCrudModal').html("Add New Project");
            $('#ajax-crud-modal').modal('show');
        });

        /* When click edit user */
        $('body').on('click', '.edit-user', function () {
            var user_id = $(this).data('id');
            console.log(user_id);
            $.get('kelolaProject/' + user_id + '/edit', function (data) {
                $('#name-error').hide();
                $('#email-error').hide();
                $('#userCrudeditModal').html("Edit Project");
                $('#btn-save2').val("edit-user");
                $('#ajax-crudedit-modal').modal('show');
                $('#user_id2').val(data.id);
                $('#name2').val(data.nama_project);
                $('#tek_support_id2 option[value="'+data.tek_support.id+'"]').prop('selected', true);
                $('#tek_support').html(data.tek_support.nama);
            })
        });


        $('body').on('click', '#delete-user', function () {

            var user_id = $(this).data("id");
            Swal.fire({
                    title: 'Anda yakin ingin menyelesaikan ?',
                    text: "data tidak bisa dikembalikan !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus!'
                    }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Finished!',
                            'Project telah selesai.',
                            'success'
                        );
                        $.ajax({
                            type: "get",
                            url: apiurl+"admin/hapusdataProject/" + user_id,
                            success: function (data) {
                                var oTable = $('#user-table').dataTable();
                                oTable.fnDraw(false);
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                    })


        });
    });

    if ($("#userForm").length > 0) {
        $("#userForm").validate({

            submitHandler: function (form) {

                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: apiurl+"admin/tambahProject",
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
                    url: apiurl+"admin/updatedataProject",
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
