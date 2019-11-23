@extends('header')
@section('content')
<!-- Main Section -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/view_admin.css') }} ">
<link href="https://fonts.googleapis.com/css?family=Hind+Guntur&display=swap" rel="stylesheet">

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

        .img-on{
            box-shadow: 0px 4px 6px grey;
            border-radius: 100%;
        }

        .card-body{
            background: #c7c7c7;
            box-shadow: 0px 2px 4px grey;
        }

        .card-title{
            font-weight: bolder;
            color: white;
            text-shadow: 0px 2px 0px slategrey;
        }

    </style>

    <div id="content">
        @if(\Session::has('alert-sukses'))
        <div class="alert alert-info">
            <div>{{Session::get('alert-sukses')}}</div>
        </div>
        @endif

        <div id="dataproject">
            @foreach ($tmpsupport as $tmp)
                @if ($tmp->tek_support == null)
                    <div class="text-center">
                        <img src="{{ asset('assets/img/oops.png') }}" alt="" width="300">
                        <h4>Belum ada Project</h4>
                    </div>
                @else
                <div class="card" style="width: 18rem; margin:auto;">
                    <div class="text-center">
                        <div class="card-body">
                            <h2 class="card-title title-teknikalproject">{{$tmp->nama_project}}</h2>
                            @if ($tmp->status == 'idle')
                                <img src="{{ asset('assets/img/on.png') }}" class="img-on" alt="" width="100">
                            @else
                                <img src="{{ asset('assets/img/off.png') }}" class="img-on" alt="" width="100">
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div id="tesapi"></div>
    </div>

</section>



{{-- <div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
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
</div> --}}

{{-- modal edit --}}
{{-- <div class="modal fade" id="ajax-crudedit-modal" aria-hidden="true">
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
                            <select name="tek_support_id" id="tek_support_id" class="form-control">
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
</div> --}}

<script>
    // var SITEURL = '{{URL::to('')}}';
    var apiurl = "{{env('API_URL')}}";
    console.log(apiurl);

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
