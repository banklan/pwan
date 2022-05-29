<template>
    <div class="footer">
        <div class="wrapper">
            <div class="top">
                <div class="pillar">
                    <div class="list_header">Quick Links</div>
                    <ul class="text-center" >
                        <li><router-link to="/">Home</router-link></li>
                        <li><router-link to="/">About Us</router-link></li>
                        <li><router-link to="/">Our Services</router-link></li>
                        <li><router-link to="/">Blog</router-link></li>
                    </ul>
                </div>
                <div class="pillar">
                    <div class="list_header">List Header</div>
                    <ul>
                        <li><router-link to="/">Events</router-link></li>
                        <li><router-link to="/">Properties</router-link></li>
                        <li><router-link to="/">Contact Us</router-link></li>
                        <li><router-link to="/">Login</router-link></li>
                    </ul>
                </div>
                <div class="pillar">
                    <div class="list_header">List Header</div>
                    <ul>
                        <li><router-link to="/">Terms & Conditions</router-link></li>
                        <li><router-link to="/">Privacy Policy</router-link></li>
                        <li><router-link to="/">FAQ</router-link></li>
                        <li><router-link to="/">Contact Us</router-link></li>
                    </ul>
                </div>
            </div>
            <div class="bottom">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque dolores asperiores numquam in aut excepturi maiores itaque repellendus totam amet!</div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .footer{
        min-height: 300px;
        background: #141531;
        color: #fff;
        width: 100vw;
        padding: 15px;
        .wrapper{
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;

            .top{
                display: flex;
                justify-content: center;
                align-items: center;
                height: 90%;
                box-sizing: border-box;
                flex-wrap: auto;
                .pillar{
                    display: block;
                    flex-basis: 100%;
                    text-align: center;
                    .list_header{
                        text-align: center;
                    }
                    ul{
                        margin: 0;
                        list-style: none;
                        box-sizing: border-box;
                        margin-top: 8px;
                        // text-align: center;
                        text-align: left;
                        // list-style-type:none;
                        line-height: 1.7;
                        margin-left: -20px;
                        li{
                            display: list-item;
                            text-align: -webkit-match-parent;
                            vertical-align: baseline;
                            padding: 2px;
                        }
                    }
                }
            }
            @media screen and (max-width: 767px){
                .top{
                    flex-direction: column;
                }
            }
            .bottom{
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }
    }
</style>
