<template>
    <v-app>
        <WelcomeNavbar v-if="$route.path == '/'" />
        <div v-else>
            <template v-if="adminIsLoggedIn">
                <template v-if="$route.path.substring(0, 6) == '/admin'">
                    <!-- <AdminAuthNavbar /> -->
                    <AdminAuthNavbar2 />
                </template>
                <template v-else>
                    <Navbar />
                </template>
            </template>
            <Navbar v-else></Navbar>
        </div>
        <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
            <router-view></router-view>
        </transition>
        <Footer />
    </v-app>
</template>

<script>
import WelcomeNavbar from './includes/WelcomeNavbar'
import Navbar from './includes/Navbar'
import Footer from './includes/Footer'
// import AdminAuthNavbar from './includes/AdminAuthNavbar'
import AdminAuthNavbar2 from './includes/AdminAuthNavbar2'
export default {
    components: {
        WelcomeNavbar, Navbar, Footer, AdminAuthNavbar2
    },
    data() {
        return {

        }
    },
    computed:{
        adminIsLoggedIn(){
            return this.$store.getters.adminIsLoggedIn
        },

    },
}
</script>
