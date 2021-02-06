<template>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Agenda</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
</template>

<script>
export default {
name: "NavbarComponent"
}
</script>

<style scoped lang="scss">
    .navbar-brand {
        padding-top: .75rem;
        padding-bottom: .75rem;
        font-size: 1rem;
        background-color: rgba(0, 0, 0, 0.25);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.25);
    }

    .navbar {
        .navbar-toggler {
            top: .25rem;
            right: 1rem;
        }

        .form-control {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
        }
    }
</style>
