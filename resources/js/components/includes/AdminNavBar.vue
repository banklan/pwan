<template>
    <nav>
        <v-app-bar flat dark color="transparent white--text" class="mb-n6">
            <span class="hidden-md-and-up">
                <v-app-bar-nav-icon class="primary--text hidden-md-and-up" @click="navdrawer = true"></v-app-bar-nav-icon>
            </span>
            <v-toolbar-title class="ml-5 my-2 pt-3 white--text">
                <router-link to="/" style="cursor:pointer" exact>
                    <img src="/images/assets/logo1.png" height="40" />
                </router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <span v-if="$route.path !== '/'">
                <v-toolbar-items>
                    <span v-if="adminIsLoggedIn" class="primary--text mr-5"> Admin {{ authAdmin.first_name }}</span>
                </v-toolbar-items>
            </span>
            <v-toolbar-items class="hidden-sm-and-down align-center">
                <template>
                    <v-btn text v-for="menu in menus" :key="menu.title">
                        <router-link class="transparent" :class="`$route.path == '/' ? 'white--text' : 'primary--text'`" :to="menu.path">{{ menu.title }}</router-link>
                    </v-btn>
                    <v-btn :class="$route.path == '/' ? 'white--text' : 'primary--text'" text @click="logout">Logout</v-btn>
                </template>
            </v-toolbar-items>
        </v-app-bar>
        <v-navigation-drawer absolute v-model="navdrawer" color="primary white--text" class="hidden-md-and-up" height="100%">
            <v-toolbar-title class="headline ml-4 mt-3 pb-4">
                <router-link to="/" style="cursor: pointer" exact>
                    <img src="/images/assets/logo1.png" height="40" />
                </router-link>
            </v-toolbar-title>
            <v-divider></v-divider>
            <v-list dark class="ml-4">
                <v-list-item class="" v-for="menu in menus" :key="menu.title" link :to="menu.path">
                    <v-list-item-content>
                        <v-list-item-title>{{ menu.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item dark class="white--text"  @click="logout">
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            navdrawer: false,
            menus: [
                { title: "Dashboard", path: "/admin"},
                { title: "About Us", path: "/about-us"},
                { title: "Contact Us", path: "/contact-us"},
            ],
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        },
        authAdmin(){
            return this.$store.getters.authAdmin
        },
        adminHeaders(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authAdmin.token}`
                }
            }
            return headers
        },
        smAndDown(){
            if(this.$vuetify.breakpoint.smAndDown){
                return true
            }else{
                return false
            }
        },
        adminIsLoggedIn(){
            return this.$store.getters.adminIsLoggedIn
        },
    },
    methods: {
        logout(){
            if(this.authAdmin){
                axios.post(this.api + `/auth-admin/logout`, {}, this.adminHeaders).then(() =>{
                    this.$store.commit('logOutAdmin')
                    this.$router.push('/')
                })
            }
        },
    }
}
</script>

<style lang="css" scoped>
    a{
        text-decoration: none;
        text-transform:capitalize;
    }
    nav{
        width: 100vw !important;
    }
</style>
