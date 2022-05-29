<template>
    <v-app>
        <WelcomeNavbar v-if="$route.path == '/'"/>
        <div v-else>
            <template v-if="adminIsLoggedIn && $route.path.substring(0, 6) == '/admin'">
                <AdminAuthNavbar />
            </template>
            <Navbar v-else></Navbar>
        </div>
        <transition v-if="!adminIsLoggedIn" mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
            <router-view></router-view>
        </transition>
        <Footer />
    </v-app>
</template>

<script>
import WelcomeNavbar from './includes/WelcomeNavbar'
import Navbar from './includes/Navbar'
import Footer from './includes/Footer'
import AdminAuthNavbar from './includes/AdminAuthNavbar'
export default {
    components: {
        WelcomeNavbar, Navbar, Footer, AdminAuthNavbar
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
