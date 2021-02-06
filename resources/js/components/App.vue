<template>
    <div>
        <Navbar />
        <Sidebar />
        <ViewComponent />
    </div>
</template>

<script>
    import Navbar from "./layouts/NavbarComponent";
    import Sidebar from "./layouts/SidebarComponent";
    import ViewComponent from "./core/ViewComponent";
export default {
    name: "App",
    components: {Navbar, Sidebar, ViewComponent}
}
</script>

<style scoped>

</style>
