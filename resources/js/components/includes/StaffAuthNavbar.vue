<template>
    <nav>
        <v-app-bar :clipped-right="true" color="primary white--text" light elevation="10">
            <v-app-bar-nav-icon @click="sidebarmenu = !sidebarmenu" class="white--text"></v-app-bar-nav-icon>
            <v-toolbar-title class="primary--text pt-3">
                <router-link to="/" style="cursor:pointer" exact>
                    <img src="/images/assets/logo.png" height="40" />
                </router-link>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <span class="pl-m">Staff</span>
            <span class="mx-2"><i class="uil uil-user"></i></span>
            <v-toolbar-items class="">
                <v-menu offset-y bottom nudge-bottom="3" right>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn v-bind="attrs" v-on="on" style="font-size: 28px" icon class="mr-2" :disabled="notifications == 0">
                            <v-badge :value="notifications > 0" color="primary" :content="notifications" overlap>
                                <i class="uil uil-bell"></i>
                                <!-- <v-icon style="font-size: 28px" color="primary">mdi-bell-outline</v-icon> -->
                            </v-badge>
                        </v-btn>
                    </template>
                    <!-- <v-list dense>
                        <v-list-item-group color="primary">
                            <v-list-item link >
                                <v-list-item-icon class="mr-3">
                                    <v-icon color="green">mdi-comment</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>New Enquiry <v-chip small color="green white--text">{{ enquiryNotif }}</v-chip></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item v-if="servNotif > 0" link>
                                <v-list-item-icon class="mr-3">
                                    <v-icon color="orange">mdi-tools</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>New Service <v-chip small color="orange white--text">{{ servNotif }}</v-chip></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item v-if="userNotif > 0" link>
                                <v-list-item-icon class="mr-3">
                                    <v-icon color="purple">mdi-account</v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                    <v-list-item-title>New User <v-chip small color="purple white--text">{{ userNotif }}</v-chip></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list> -->
                </v-menu>
            </v-toolbar-items>
        </v-app-bar>
        <span class="contents">
            <span class="navdrawer">
                <v-navigation-drawer clipped v-model="sidebarmenu" :permanent="sidebarmenu" :mini-variant.sync="mini" color="primary darken-3">
                    <v-list class="mt-5">
                        <v-list-item dark class="px-2">
                            <v-list-item-action>
                                <v-icon @click="sidebarmenu = !sidebarmenu">mdi-chevron-left</v-icon>
                            </v-list-item-action>
                            <v-list-item-content class="text-truncate">
                                <v-list-item-title class="white--text">{{ $vuetify.breakpoint.mobile ? '' : 'Staff Dashboard' }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item class="px-2" dark @click.stop="toggleMini = !toggleMini">
                            <v-list-item-avatar v-if="authUser.picture">
                                <v-img :src="`https://pwanplatinum.s3.amazonaws.com/profiles/${authUser.picture}`" height="30" width="30"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-avatar v-else>
                                <i class="uil uil-user"></i>
                            </v-list-item-avatar>
                            <v-list-item-content class="text-truncate">
                                {{ authUser.fullname }}
                            </v-list-item-content>
                            <v-btn icon small>
                                <i class="uil uil-tachometer-fast-alt"></i>
                            </v-btn>
                        </v-list-item>
                    </v-list>
                    <v-divider light class="my-3"></v-divider>
                    <v-list dark>
                        <v-list-item v-for="menu in authMenu" :key="menu.title" link :to="menu.path" dark class="white--text" exact>
                            <v-list-item-icon>
                                <i :class="`uil uil-${menu.icon}`"></i>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title class="white--text">{{ menu.title }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item  @click="logout">
                            <v-list-item-icon>
                                <i class="uil uil-sign-out-alt"></i>
                            </v-list-item-icon>
                            <v-list-item-title class="body-2">Logout</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-navigation-drawer>
            </span>
            <span class="main">
                <v-main>
                    <v-container class="px-4 py-5 fill-height">
                        <v-row class="fill-height">
                            <v-col cols="12">
                                <transition mode="out-in" enter-active-class="animate__animated animate__fadeIn animate__faster" leave-active-class="animate__animated animate__fadeOut">
                                    <router-view :toggleMini="toggleMini" :smAndDown="smAndDown"></router-view>
                                </transition>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-main>
            </span>
        </span>
    </nav>
</template>

<script>
export default {
    data(){
        return{
            sidebarmenu: true,
            toggleMini: false,
            authMenu: [
                { title: "Staff Home", path: "/staff-dashboard", icon:"dashboard"},
                {title: "Listings", path: "/staff/listings", icon:"building"},
                {title: "Subscriptions", path: "/staff/subscriptions", icon:"invoice"},
                {title: "New Offers", path: "/staff/new-offers", icon:"fire"},
                {title: "Events", path: "/staff/events", icon: "schedule"},
                {title: "News", path: "/staff/news", icon: "newspaper"},
                {title: "Video Rolls", path: "/staff/video-rolls", icon: "video"},
                {title: "Profile", path: "/staff/profile", icon: "cog"},
            ],
            notificationsBadge: true,
        }
    },
    computed: {
        userIsLoggedIn(){
            return this.$store.getters.userIsLoggedIn
        },
        api(){
            return this.$store.getters.api
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
        smAndDown(){
            if(this.$vuetify.breakpoint.smAndDown){
                return true
            }else{
                return false
            }
        },
        itoggleMini(){
            if (this.smAndDown){
                return false
            }else{
                return true
            }
        },
        mini(){
            if(this.smAndDown && this.toggleMini){
                return false
            }else if(!this.smAndDown && this.toggleMini){
                return true
            }else if(this.smAndDown && !this.toggleMini){
                return true
            }else if(!this.smAndDown && !this.toggleMini){
                return false
            }else{
                return false
            }
        },
        notifications(){
            let len = 0;
            // let notifs = [this.enquiryNotif, this.userNotif, this.servNotif]
            // notifs.forEach(el => {
            //     el > 0 ? len++ : len
            // });
            return len
        },

    },
    methods: {
        logout(){
            if(this.userIsLoggedIn){
                axios.post(this.api + `/auth/logout`, {}, this.authHeaders).then(() =>{
                    this.$store.commit('logOutAuthUser')
                    this.$router.push('/')
                })
            }
        },
    },
    created(){
    }
}
</script>

<style lang="css" scoped>
    nav{
        width: 100vw !important
    }
    header{
        height: 70px !important;
        /* padding: 15px 0 !important; */
    }
    header .v-toolbar__content{
        padding: 20px 10px !important;
    }
    a{
        text-decoration: none;
        text-transform:capitalize;
    }
    .contents{
        display: flex;
        justify-content: flex-start;
        background: #f4f2ff;
        background: #f4f2ff;
        height: 97% !important;
        /* background: ; */
    }
    .navdrawer{
        max-width: 25%;
        transition: all .4s ease;
    }
    a.v-list-item{
        min-height: 39px !important;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    .v-list-item__icon{
        font-size: 1.1rem;
    }
    .contents .v-list__item:nth-child(2){
        padding: 10rem !important;
    }
    .v-avatar .v-image{
        height: 50px !important;
        width: 50px !important;
        border-radius: 50% !important;
    }
    .main{
        width: 100%;
        margin: 0 auto !important;
    }
    .v-main{
        margin: 0 auto !important;
    }
    .v-main__wrap {
        margin: 0 auto !;
    }
</style>
