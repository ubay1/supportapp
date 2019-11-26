@extends('baselogin')
@section('content')

<!-- Main Section -->
<section class="main-section">

    @if(\Session::has('alert'))
    <div class="alert alert-danger">
        <div>{{Session::get('alert')}}</div>
    </div>
    @endif
    @if(\Session::has('alert-success'))
    <div class="alert alert-success">
        <div>{{Session::get('alert-success')}}</div>
    </div>
    @endif

    <div class="bg-form-login">
        <form action="{{ url('admin/loginPost') }}" method="post">
        {{-- <form action="login" method="post" id="formsubmit"> --}}
            {{ csrf_field() }}

            <input type="hidden" class="form-control" id="role_id" name="role_id" value="1">

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password"></input>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option selected>Pilih Role</option>
                    <option value="1">Super Admin</option>
                    <option value="2">Teknikal Support</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-md btn-primary">Login</button>
            </div>
        </form>
    </div>
</section>

<script>
    // $("#formsubmit").submit(function (e) {
    //     e.preventDefault();
    //     var email = $("#email");
    //     var password = $("#password");
    //     var role = $("#role");

    //     $.ajax({
    //         type: "post",
    //         url: "http://127.0.0.1:8000/api/admin/loginpost",
    //         data: $(this).serialize(),
    //         dataType: "json",
    //         success: function (response) {
    //             console.log(response);
    //             switch (response.data.statuscode) {
    //                 case 2001:
    //                     Swal.fire({
    //                         type: 'success',
    //                         text: response.data.message,
    //                     }).then( (result) =>{
    //                         if(result){
    //                             window.location.href = "{{URL::to('/admin')}}"
    //                         }
    //                     })
    //                     break;
    //                 case 4001:
    //                     Swal.fire({
    //                         type: 'error',
    //                         text: response.data.message,
    //                     })
    //                     break;
    //                 case 4002:
    //                     Swal.fire({
    //                         type: 'error',
    //                         text: response.data.message,
    //                     })
    //                     break;
    //                 case 4003:
    //                     Swal.fire({
    //                         type: 'error',
    //                         text: response.data.message,
    //                     })
    //                     break;
    //                 default:
    //                     break;
    //             }
    //         }
    //     });
    // });
</script>

<!-- /.main-section -->
@endsection
