<template>
    <nav>
        <v-app-bar flat light color="transparent white--text">
            <span class="hidden-md-and-up">
                <v-app-bar-nav-icon class="white--text hidden-md-and-up" @click="navDrawer = true"></v-app-bar-nav-icon>
            </span>
            <v-toolbar-title class="ml-5 my-2">
                <router-link to="/" style="cursor:pointer" exact>
                    <span class="">
                        <img src="/images/assets/logo.png" height="40">
                    </span>
                </router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down align-center">
                <v-btn class="white--text" text v-for="menu in menus" :key="menu.title">
                    <router-link class="white--text" :to="menu.path">{{ menu.title }}</router-link>
                </v-btn>
                <v-btn class="white--text" text>
                    <router-link class="white--text" to="/admin">Dashboard</router-link>

                </v-btn>
                <!-- <v-btn class="primary" text @click="logout">Logout</v-btn> -->
            </v-toolbar-items>
        </v-app-bar>
        <v-navigation-drawer dark v-model="navDrawer" absolute hide-overlay color="primary white--text" class="" disable-resize-watcher>
            <v-toolbar-title class="ml-4 mt-3">
                <router-link to="/" style="cursor: pointer" exact>
                    <span>
                        <img src="/images/assets/logo.png" height="40">
                    </span>
                </router-link>
            </v-toolbar-title>
            <!-- <v-divider></v-divider> -->
            <v-list class="mt-7">
                <v-list-item dark class="white--text" link to="/admin" exact>
                    <v-list-item-content class="pl-5">
                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item dark class="primary--text" v-for="item in menus" :key="item.title" link :to="item.path" exact>
                    <v-list-item-content class="pl-5">
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <!-- <v-list-item dark class="primary--text"  @click="logout"> -->
                    <!-- <v-list-item-title>Logout</v-list-item-title> -->
                <!-- </v-list-item> -->
            </v-list>
        </v-navigation-drawer>
    </nav>
</template>

<script>
export default {
    data(){
        return{
            menus: [
                {title: 'Home', path: '/'},
                {title: 'Our Service', path: '/our-services'},
                {title: "About Us", path: "/about-us"},
                {title: "Blog", path: "/blog"},
                {title: "Events", path: "/events"},
                {title: "Login", path: "/login"},
            ],
            navDrawer: false,
            bg: ''
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        },
        authUser(){
            // return this.$store.getters.authUser
        },
        adminIsLoggedIn(){
            return this.$store.getters.adminIsLoggedIn
        },
    },
    methods: {
        navbarColor(){
            if(document.body.scrollTop > 150 || document.documentElement.scrollTop > 150){
                this.bg = "white"
            }else{
                this.bg = 'transparent'
            }
        }
    },
    mounted() {
        window.onscroll = () =>{
            this.navbarColor()
        }

        console.log('loaded welcome-nabvar')
    },
}
</script>

<style lang="scss" scoped>
    a{
        text-decoration: none;
        text-transform:capitalize;
    }
    a.router-link-exact-active{
        color: #E20000 !important;
    }
    .v-list a.v-list-item{
        &:hover .v-list-item__title{
            margin-left: 3px !important;
        }

        .v-list-item__title{
           transition: all 400ms ease;
        }
    }

    .v-list-item--active{
        background: #142866 !important;
        .v-list-item__title{
            color: #fff !important;
        }
    }
</style>
