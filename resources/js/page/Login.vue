<template>
    <div>
        <Menu/>
        <div class="homepage-header-background">
            <div class="container-fluid">
                <div class="row">
                    <div class="container">
                        <div class="bg-form-login">
                            <div class="bg-primary p-2 text-center text-white">
                                Halaman Login
                            </div>
                            <form>
                                <div class="mb-3 mt-3">
                                    <input type="text" class="form-control" name="email" id="email" placeholder="masukan email"> <br>
                                    <input type="text" class="form-control" name="password" id="password" placeholder="masukan password"> <br>
                                    <button type="submit" class="btn btn-primary btn-login">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Footer/>
    </div>
</template>

<script>
    import axios from 'axios'
    import Menu from '../components/Menu'

    export default {
        components:{
            Menu
        }
    }
</script>

<style>
    .homepage-header-background{
        margin-top: 100px;
    }
    @media(min-width:992px){
        .bg-form-login{
            width: 50%;
            margin:auto;
        }
    }
    form{
        background:white;
        padding: 20px;
        box-shadow: 0px 2px 4px lightgrey;
    }
    .form-control, .btn-login{
        border-radius: 0px;
    }
</style>
