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

        .modal-dialog-tambahdata,
        .modal-dialog-editdata {
            max-width: 100%;
            margin: 20px;
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
                    <th>Nama Project</th>
                    <th>Masalah</th>
                    <th>Created_at</th>
                    <th>Update_at</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

</section>

<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-tambahdata">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="tambahdata" name="userForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="user_id">

                    <!-- pilih_project -->
                    <div class="form-group">
                        <label class="col-form-label" for="project_id">Pilih project</label> <br>
                        <select required name="project_id" id="project_id" class="form-control">
                        </select>
                    </div>
                    {{-- end pilih_project --}}

                    <!-- masalah -->
                    <div class="form-group">
                        <label class="col-form-label" for="masalah">Masalah</label>
                        <textarea name="masalah" class="form-control " id="masalah" required placeholder="tulis masalah"
                            rows="5"> </textarea>
                    </div>
                    {{-- end masalah --}}

                    <!-- solusi -->
                    <div class="form-group">
                        <label class="col-form-label" for="solusi">solusi</label>
                        <textarea name="solusi" class="form-control " id="solusi" required placeholder="tulis solusi"
                            rows="5"> </textarea>
                    </div>
                    {{-- end solusi --}}

                    <!-- gambar masalah -->
                    <div class="form-group">
                        <label class="col-form-label" for="picture">picture</label>
                        <input required type="file" name="picture" id="picture" class="form-control">
                    </div>
                    {{-- end gambar masalah --}}

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
                        </button>
                        <button type="button" class="btn btn-secondary " data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Cancel</button>
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
    <div class="modal-dialog modal-dialog-editdata">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCrudeditModal"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm2" name="userForm2" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="id_masalah" id="id_masalah">

                    <div class="alert alert-success alert-response3"></div>
                    <div class="alert alert-danger alert-response4"></div>

                    <!-- pilih_project -->
                    <div class="form-group">
                        <label class="col-form-label" for="project_id2">Pilih project</label> <br>
                        <input required name="project_id2" id="project_id2" disabled class="form-control">
                    </div>
                    {{-- end pilih_project --}}

                    <!-- masalah -->
                    <div class="form-group">
                        <label class="col-form-label" for="isi_masalah">Masalah</label>
                        <textarea name="isi_masalah" class="form-control " id="isi_masalah" required
                            placeholder="tulis masalah" rows="5"> </textarea>
                    </div>
                    {{-- end masalah --}}

                    <!-- solusi -->
                    <div class="form-group">
                        <label class="col-form-label" for="isi_solusi">solusi</label>
                        <textarea name="isi_solusi" class="form-control " id="isi_solusi" required
                            placeholder="tulis solusi" rows="5"> </textarea>
                    </div>
                    {{-- end solusi --}}


                    <input type="hidden" name="isi_picturelama" id="isi_picturelama" class="form-control">

                    {{-- gambar baru --}}
                    <div class="form-group">

                        <label class="col-form-label" for="gambarlama">gambar lama</label> <br>
                        <img id="view-gambarlama" height="100"> <br><br>

                        <label class="col-form-label" for="isi_picturebaru">gambar baru</label>
                        <input type="file" name="isi_picturebaru" id="isi_picturebaru" class="form-control"> <br>
                    </div>
                    {{-- end gambar baru --}}

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
                        </button>
                        <button type="button" class="btn btn-secondary " data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Cancel</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>


{{-- detail masalah --}}
<div class="modal fade" id="ajax-cruddetail-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-editdata">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCruddetailModal"></h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="picturedetailmasalah" height="200"> <hr>
                </div>
                <b>Nama Project :</b> <p id="nama_projectdetail"></p>
                <b>Masalah :</b> <p id="isi_masalahdetail"></p>
                <b>Solusi  :</b> <p id="isi_solusidetail"></p>
            </div>
        </div>
    </div>
</div>

<script>
    // var SITEURL = '{{URL::to('')}}';
    var apiurl = "{{env('API_URL')}}";
    var appurl = "{{env('APP_URL')}}";
    console.log(apiurl);
    console.log(appurl);
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
                url: "kelolaMasalah",
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
                    data: 'project.nama_project',
                    name: 'project',
                    // 'visible': false
                },
                {
                    data: 'masalah',
                    name: 'masalah'
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


        // get project_id
        $("#create-new-user").click(function () {
            $.ajax({
                type: "get",
                url: apiurl+"admin/getAllProject",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $("#project_id").append(
                        '<option selected disabled>--- pilih project ---</option>'
                    );
                    for (var i = 0; i < response.length; i++) {
                        var obj = response[i];
                        console.log(obj.id);
                        $("#project_id").append(
                            '<option value=' + obj.id + '>' + obj.nama_project +
                            '</option>'
                        );
                    }
                }
            });
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
        $('#create-new-user').click(function () {
            $('#btn-save').val("create-user");
            $('#user_id').val('');
            $('#userForm').trigger("reset");
            $('#userCrudModal').html("Add New Project");
            $('#ajax-crud-modal').modal('show');
        });

        // detail masalah detail-masalah
        $('body').on('click', '.detail-masalah', function () {
            var user_id = $(this).data('id');
            $.get('kelolaMasalah/' + user_id + '/edit', function (data) {
                $('#userCruddetailModal').html("Detail Masalah");
                $('#ajax-cruddetail-modal').modal('show');
                $('#isi_masalahdetail').html(data.masalah);
                $('#nama_projectdetail').html(data.project.nama_project);
                $('#isi_solusidetail').html(data.solusi);
                $("#picturedetailmasalah").attr('src', appurl+'uploads/' + data.picture);
            })
        });

        /* When click edit user */
        $('body').on('click', '.edit-user', function () {
            var user_id = $(this).data('id');
            $.get('kelolaMasalah/' + user_id + '/edit', function (data) {
                $('#name-error').hide();
                $('#email-error').hide();
                $('#userCrudeditModal').html("Edit Project");
                $('#btn-save2').val("edit-user");
                $('#ajax-crudedit-modal').modal('show');
                $('#id_masalah').val(data.id);
                $('#project_id2').val(data.project_id);
                $('#isi_masalah').val(data.masalah);
                $('#isi_solusi').val(data.solusi);
                $("#isi_picturelama").val(data.picture);
                $("#isi_picturebaru").val();
                $("#view-gambarlama").attr('src', appurl+'uploads/' + data.picture);
            })
        });


        $('body').on('click', '#delete-user', function () {

            var user_id = $(this).data("id");
            if(!confirm("Anda serius ingin hapus ? data yang telah dihapus tidak bisa dikembalikan !")){
                return false;
            }

            $.ajax({
                type: "get",
                url: apiurl+"admin/hapusdataMasalah/" + user_id,
                success: function (data) {
                    console.log(data);
                    var oTable = $('#user-table').dataTable();
                    oTable.fnDraw(false);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        // tambah data
        $("#tambahdata").submit(function (e) {
            e.preventDefault();
            var project_id = $("#project_id").val();
            var masalah = $("#masalah").val();
            var solusi = $("#solusi").val();
            var picture = $("#picture").val();

            $.ajax({
                type: "post",
                url: apiurl+"admin/tambahMasalah",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.data.statuscode == 2001) {
                        $(".alert-response").css('display', 'block');
                        $(".alert-response").html(response.data.message);
                    } else {
                        $(".alert-response2").css('display', 'block');
                        $(".alert-response2").html(response.data.message);
                    }
                },
                complete: function () {
                    setTimeout(function () {
                        $('#ajax-crud-modal').on('hide.bs.modal');
                        var oTable = $('#user-table').dataTable();
                        oTable.fnDraw(false);
                    }, 2000);

                }
            });
        });
        // end tambah data

        // update masalah
        $("#userForm2").unbind('submit').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: apiurl+"admin/updatedataMasalah",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $(".alert-response3").css('display', 'block');
                        $(".alert-response3").html(response.data.message);
                    } else {
                        $(".alert-response4").css('display', 'block');
                        $(".alert-response4").html(response.data.message);
                    }
                },
                complete: function () {
                    setTimeout(function () {
                        $('#ajax-crud-modal').modal('hide');
                        var oTable = $('#user-table').dataTable();
                        oTable.fnDraw(false);
                    }, 2000);
                }
            });

        });

    });

</script>


<script type="text/javascript" src="{{ asset('assets/css/view.js') }}"></script>


<!-- /.main-section -->


@endsection
