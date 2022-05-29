<template>
    <v-app>
        <template v-if="adminIsLoggedIn">
            <template v-if="$route.path.substring(0, 6) == '/admin'">
                <admin-auth-navbar />
            </template>
            <template v-else>
                <AdminNavBar />
                <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
                    <router-view></router-view>
                </transition>
            </template>
        </template>
        <template v-else>
            <Navbar></Navbar>
            <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
                <router-view></router-view>
            </transition>
        </template>
        <Footer />
    </v-app>
</template>

<script>
// import AdminAuthNavbar from './includes/AdminAuthNavbar.vue'
import Navbar from './includes/Navbar'
import AdminNavDrawer from './includes/AdminNavDrawer'
// import AdminAuthNavbar from './includes/AdminAuthNavbar.vue'
import AdminNavBar from './includes/AdminNavBar.vue'
import Footer from './includes/Footer.vue'
export default {
    components: {
        Navbar, AdminNavDrawer, Footer, AdminNavBar
    },
    computed: {
        AdminAuthNavbar(){
            return this.$store.getters.authUser
        },
        adminIsLoggedIn(){
            return this.$store.getters.adminIsLoggedIn
        },
    },
}
</script>
