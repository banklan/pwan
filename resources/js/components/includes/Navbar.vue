<template>
    <nav>
        <v-app-bar flat dark class="primary white--text">
            <span class="hidden-md-and-up">
                <v-app-bar-nav-icon class="white--text hidden-md-and-up" @click="navDrawer = true"></v-app-bar-nav-icon>
            </span>
            <v-toolbar-title class="ml-5 my-2 primary--text hidden-sm-and-down">
                <router-link to="/" style="cursor:pointer" exact>
                    <span>
                        <img src="/images/assets/logo.png" height="40">
                    </span>
                </router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down align-center">
                <template v-if="adminIsLoggedIn">
                    <v-btn class="white--text" text v-for="menu in adminMenus" :key="menu.title">
                        <router-link class="white--text" :to="menu.path">{{ menu.title }}</router-link>
                    </v-btn>
                    <v-btn class="white--text" text @click="adminLogout">Logout</v-btn>
                </template>
                <template v-if="userIsLoggedIn">
                    <v-btn class="white--text" text v-for="menu in authMenus" :key="menu.title">
                        <router-link class="white--text" :to="menu.path">{{ menu.title }}</router-link>
                    </v-btn>
                    <v-btn class="white--text" text @click="staffLogout">Logout</v-btn>
                </template>
                <template v-if="!adminIsLoggedIn && !userIsLoggedIn">
                    <v-btn class="white--text" text v-for="menu in menus" :key="menu.title">
                        <router-link class="white--text" :to="menu.path">{{ menu.title }}</router-link>
                    </v-btn>
                </template>
            </v-toolbar-items>
        </v-app-bar>
        <v-navigation-drawer v-model="navDrawer" absolute hide-overlay color="primary white--text" class="" disable-resize-watcher>
            <v-toolbar-title class="primary--text ml-4 mt-3 pb-4">
                <router-link to="/" style="cursor: pointer" exact>
                    <span><img src="/images/assets/logo.png" height="40"></span>
                 </router-link>
            </v-toolbar-title>
            <v-divider></v-divider>
            <v-list class="mt-7">
                <template v-if="adminIsLoggedIn">
                    <v-list-item dark class="primary--text" v-for="item in adminMenus" :key="item.title" link :to="item.path" exact>
                        <v-list-item-content class="pl-5">
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item  @click.prevent="adminLogout">
                        <v-list-item-icon>
                            <i class="uil uil-sign-out-alt"></i>
                        </v-list-item-icon>
                        <v-list-item-title class="body-2">Logout</v-list-item-title>
                    </v-list-item>
                </template>
                <template v-if="userIsLoggedIn">
                    <v-list-item dark class="primary--text" v-for="item in authMenus" :key="item.title" link :to="item.path" exact>
                        <v-list-item-content class="pl-5">
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item  @click.prevent="staffLogout">
                        <v-list-item-icon>
                            <i class="uil uil-sign-out-alt"></i>
                        </v-list-item-icon>
                        <v-list-item-title class="body-2">Logout</v-list-item-title>
                    </v-list-item>
                </template>
                <template v-if="!adminIsLoggedIn && !userIsLoggedIn">
                    <v-list-item dark class="primary--text" v-for="item in menus" :key="item.title" link :to="item.path" exact>
                        <v-list-item-content class="pl-5">
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
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
                {title: 'Listing', path: '/listings'},
                {title: "About Us", path: "/about-us"},
                {title: "Events", path: "/events"},
                {title: "Login", path: "/login"},
            ],
            adminMenus: [
                {title: 'Home', path: '/'},
                {title: 'Dashboard', path: '/admin'},
                {title: 'Listing', path: '/listings'},
                {title: 'Events', path: '/events'},
            ],
            authMenus: [
                {title: 'Home', path: '/'},
                {title: 'Staff Home', path: '/staff'},
                {title: 'Listing', path: '/listings'},
                {title: 'Events', path: '/events'},
            ],
            navDrawer: false,
            bg: ''
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        },
        userIsLoggedIn(){
            return this.$store.getters.userIsLoggedIn
        },
        adminIsLoggedIn(){
            return this.$store.getters.adminIsLoggedIn
        },
        adminHeaders(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authAdmin.token}`
                }
            }
            return headers
        },
        authAdmin(){
            return this.$store.getters.authAdmin
        },
        authUser(){
            return this.$store.getters.authUser
        },
        authHeaders(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authUser.token}`
                }
            }
            return headers
        },
    },
    methods: {
        navbarColor(){
            if(document.body.scrollTop > 150 || document.documentElement.scrollTop > 150){
                this.bg = "white"
            }else{
                this.bg = 'transparent'
            }
        },
        adminLogout(){
            if(this.adminIsLoggedIn){
                axios.post(this.api + `/auth-admin/logout`, {}, this.adminHeaders).then(() =>{
                this.$store.commit('logOutAdmin')
                    this.$router.push('/')
                })
            }
        },
        staffLogout(){
            if(this.userIsLoggedIn){
                axios.post(this.api + `/auth/logout`, {}, this.authHeaders).then(() =>{
                    this.$store.commit('logOutAuthUser')
                    this.$router.push('/')
                })
            }
        }
    },
    mounted() {
        window.onscroll = () =>{
            this.navbarColor()
        }
        // console.log('loaded nabvar')
    },
}
</script>

<style lang="scss" scoped>
    a{
        color: #fff !important;
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
