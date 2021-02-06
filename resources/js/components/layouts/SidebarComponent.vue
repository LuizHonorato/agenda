<template>
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <router-link class="nav-link active" to="/agendamentos">
                        <span data-feather="calendar"></span>
                        Agendamentos <span class="sr-only">(current)</span>
                    </router-link>
                </li>
            </ul>

            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Cadastros</span>
                <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                    <span data-feather="plus-circle"></span>
                </a>
            </h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <router-link class="nav-link" to="/medicos">
                        <span data-feather="heart"></span>
                        Médicos
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/pacientes">
                        <span data-feather="user"></span>
                        Pacientes
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/usuarios">
                        <span data-feather="users"></span>
                        Usuários
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
name: "SidebarComponent"
}
</script>

<style scoped lang="scss">
    .feather {
        width: 16px;
        height: 16px;
        vertical-align: text-bottom;
    }

    /*
     * Sidebar
     */

    .sidebar {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;

        /* Behind the navbar */
        padding: 48px 0 0;

        /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.1);
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto;

        /* Scrollable contents if viewport is shorter than content. */
    }

    @supports (position: -webkit-sticky) or (position: sticky) {
        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
        }
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: #333;

        .feather {
            margin-right: 4px;
            color: #999;
        }

        &.active {
            color: #007bff;
        }

        &:hover .feather, &.active .feather {
            color: inherit;
        }
    }

    .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
    }
</style>
