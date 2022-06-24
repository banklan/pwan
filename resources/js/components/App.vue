<template>
    <v-app>
        <template v-if="$route.path == '/'">
            <WelcomeNavbar />
            <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
                <router-view></router-view>
            </transition>
        </template>
        <template v-else>
            <template v-if="adminIsLoggedIn">
                <template v-if="$route.path.substring(0, 6) == '/admin'">
                    <AdminAuthNavbar />
                </template>
                <template v-else>
                    <Navbar />
                    <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
                        <router-view></router-view>
                    </transition>
                </template>
            </template>
            <template v-if="userIsLoggedIn">
                <template v-if="$route.path.substring(0, 6) == '/staff'">
                    <StaffAuthNavbar />
                </template>
                <template v-else>
                    <Navbar />
                    <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
                        <router-view></router-view>
                    </transition>
                </template>
            </template>
            <template v-if="!adminIsLoggedIn && !userIsLoggedIn">
                <Navbar />
                <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
                    <router-view></router-view>
                </transition>
            </template>
        </template>
        <Footer />
    </v-app>
</template>

<script>
import WelcomeNavbar from './includes/WelcomeNavbar'
import Navbar from './includes/Navbar'
import Footer from './includes/Footer'
import AdminAuthNavbar from './includes/AdminAuthNavbar'
import StaffAuthNavbar from './includes/StaffAuthNavbar'
export default {
    components: {
        WelcomeNavbar, Navbar, Footer, AdminAuthNavbar, StaffAuthNavbar
    },
    data() {
        return {

        }
    },
    computed:{
        adminIsLoggedIn(){
            return this.$store.getters.adminIsLoggedIn
        },
        userIsLoggedIn(){
            return this.$store.getters.userIsLoggedIn
        },
    },
}
</script>
