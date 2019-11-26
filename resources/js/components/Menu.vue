<template>
        <nav class="navbar navbar-expand-lg  navbar-dark fixed-top bg-primary">
            <router-link class="navbar-brand" to="/">Support APP</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mynavbar" aria-controls="mynavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
						<router-link class="nav-link" to="/about">About</router-link>
					</li>
                </ul>
            </div>
        </nav>
</template>

<style>
</style>

<script>
    export default {
        data() {
            return {

            }
        },
        methods: {
        }
    }

</script>
<style>
	.ml-auto .dropdown-menu {
		left: auto !important;
		right: 0px;
	}

	.navbar-dark .navbar-nav .nav-link{
		color:#fff;
	}

    .navbar-dark .navbar-toggler {
        /* color: rgba(255, 255, 255, 0.5); */
        border-color: rgba(255, 255, 255, 0);
    }

    button:focus {
        outline: none;
    }

</style>
