<template>
    <div class="footer">
        <div class="wrapper">
            <div class="top">
                <div class="pillar">
                    <ul>
                        <li class="font-weight-bold header">Quick Links</li>
                        <li><router-link to="/">Home</router-link></li>
                        <li><router-link to="/about-us">About Us</router-link></li>
                        <li><router-link to="/our-services">Our Services</router-link></li>
                        <li><router-link to="/blog">Blog</router-link></li>
                        <li><router-link to="/events">Events</router-link></li>
                    </ul>
                </div>
                <div class="pillar">
                    <ul>
                        <li class="font-weight-bold header">Quick Links</li>
                        <li><router-link to="/properties">Properties</router-link></li>
                        <li><router-link to="/news">News</router-link></li>
                        <li><router-link to="/login">Staff Login</router-link></li>
                        <li><router-link to="/terms-conditions">Terms & Conditions</router-link></li>
                        <li><router-link to="/privacy-policy">Privacy Policy</router-link></li>
                    </ul>
                </div>
                <div class="pillar">
                    <ul>
                        <li class="font-weight-bold header">Contact</li>
                        <li class="footer_text--text"><v-icon class="mr-2 pb-3" color="secondary">place</v-icon> 4, Airport Road, Warri. Delta State.</li>
                        <li class="footer_text--text"><v-icon class="mr-2 pb-3" color="secondary">phone</v-icon> 07052898744</li>
                        <li class="footer_text--text"><v-icon class="mr-2 pb-2" color="secondary">email</v-icon> pwan@gmail.com</li>
                        <li class="footer_text--text">Enquiry? <router-link to="/contact-us">Drop us a line</router-link></li>
                    </ul>
                </div>
            </div>
            <div class="bottom">
                <div class="social">
                    <v-btn large v-for="icon in icons" :key="icon.name" class="white--text mx-4" icon :href="`${icon.link}`" target="_blank" link>
                        <v-icon :color="icon.color">{{ icon.name }}</v-icon>
                    </v-btn>
                </div>
                <div class="copy">
                    &copy; {{ new Date().getFullYear() }} PWAN Group, All Rights Reserved
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            icons: [
                {name: 'mdi-facebook', color:'#1877f2', link:'https://www.facebook.com/pwan_platinum'},
                {name: 'mdi-twitter', color: '#1da1f2', link: 'https://www.twitter.com/pwan_platinum'},
                {name: 'mdi-instagram', color: '#c32aa3', link: 'https://www.instagram.com/pwan_platinum'}
            ],
        }
    }
}
</script>

<style lang="scss" scoped>
    .footer{
        min-height: 350px;
        color: #fff;
        width: 100vw;
        .wrapper{
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;

            .top{
                display: flex;
                flex: 2 1 auto;
                flex-wrap: auto;
                box-sizing: border-box;
                justify-content: space-between;
                align-items: center;
                height: 90%;
                margin: 0;
                background: #0a1229;
                .pillar{
                    display: flex;
                    flex-direction: column;
                    flex: 1 0 auto;
                    box-sizing: border-box;
                    vertical-align: baseline;
                    justify-content: center;
                    align-items: center;
                    ul{
                        margin: 0;
                        list-style: none;
                        box-sizing: border-box;
                        padding-left: 0;
                        margin-left: 0;
                        line-height: 1.7;
                        li{
                            box-sizing: border-box;
                            display: list-item;
                            text-align: -webkit-match-parent;

                            a{
                                text-decoration: none;
                                color: #9ca5af;
                                font-size: 17px;

                                &:hover{
                                    color: #fff;
                                }
                            }
                        }
                        li.header{
                            color: #fff;
                            padding-bottom: 5px;
                            text-transform: uppercase !important;
                        }
                    }
                }
            }
            @media screen and (max-width: 767px){
                .top{
                    flex-direction: column;
                    padding-top: 25px;
                    .pillar{
                        margin-bottom: 25px;
                    }
                }
            }
            .bottom{
                display: flex;
                justify-content: space-around;
                align-items: center;
                background: #11123e;
                padding: 15px;
                .v-btn{
                    text-decoration: none;
                }
            }
            @media screen and (max-width: 767px){
                .bottom{
                    flex-direction: column;
                    .copy{
                        padding-top: 10px;
                    }
                }
            }
        }
    }
</style>
