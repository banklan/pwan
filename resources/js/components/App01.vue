<template>
    <v-app>
        <template v-if="adminIsLoggedIn">
            <template v-if="$route.path.substring(0, 6) == '/admin'">
                <AdminAuthNavbar />
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

        <!-- <WelcomeNavbar v-if="$route.path == '/'"/>
        <div v-else>
            <template v-if="adminIsLoggedIn && $route.path.substring(0, 6) == '/admin'">
                <AdminNavBar />
            </template>
            <Navbar v-else></Navbar>
        </div> -->
        <!-- <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
            <router-view></router-view>
        </transition> -->
        <Footer />
    </v-app>
</template>

<script>
import WelcomeNavbar from './includes/WelcomeNavbar'
import Navbar from './includes/Navbar'
import AdminNavBar from './includes/AdminNavBar.vue'
import AdminAuthNavbar from './includes/AdminAuthNavbar.vue'
import Footer from './includes/Footer'
export default {
    components: {
        WelcomeNavbar, Navbar, Footer, AdminNavBar, AdminAuthNavbar
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
