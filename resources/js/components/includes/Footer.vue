<template>
    <footer>
        <div class="cont">
            <article>
                <h3>Quick Links</h3>
                <router-link to="/">Home</router-link>
                <router-link to="/about-us">About Us</router-link>
                <router-link to="/our-services">Our Services</router-link>
                <router-link to="/listings">Listings</router-link>
                <router-link to="/events">Events</router-link>
            </article>
            <article>
                <h3>Quick Links</h3>
                <router-link to="/faq">Freq Asked Qstns</router-link>
                <router-link to="/news">News</router-link>
                <router-link to="/login">Staff Login</router-link>
                <router-link to="/terms-conditions">Terms & Conditions</router-link>
                <router-link to="/privacy-policy">Privacy Policy</router-link>
                <router-link to="/subscription-form">Subscription Form</router-link>
            </article>
            <article>
                <h3>Contact Us</h3>
                <div class="footer__socials">
                    <div class="social_media">
                        <a href="#" class="fb"><i class="uil uil-facebook-f"></i></a>
                        <a href="#" class="tw"><i class="uil uil-twitter-alt"></i></a>
                        <a href="#" class="ig"><i class="uil uil-instagram"></i></a>
                    </div>
                    <p><i class="uil uil-map-marker"></i> 5, Airport road, Warri. Delta State.</p>
                    <p><i class="uil uil-phone"></i> 08052552252</p>
                    <p><i class="uil uil-envelope-alt"></i> pwan@gmail.com</p>
                </div>
            </article>
        </div>
        <div class="copyright">
            <small>&copy; {{ new Date().getFullYear() }} PWAN Group, All Rights Reserved </small>
        </div>
    </footer>
</template>

<style lang="scss" scoped>
    footer{
        background: #0b0b1f;
        color: rgba(#fff, 0.7);
        padding-top: 3rem;
        margin-top: 3rem;

         .cont{
            width: 84%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 5rem;
            font-size: 0.85rem;

            a{
                color: rgba(#fff, 0.7);
                font-size: 1rem;
                text-decoration: none;
                transition: all 400ms ease;
                &:hover{
                    color: #fff;
                }

                & > h3{
                    font-size: 1.3rem;
                    color: #fff;
                }
            }

            article{
                display: flex;
                flex-direction: column;
                gap: 1rem;

                & > div{
                    display: flex;
                    align-items: center;
                    gap: 0.6rem;
                }

                & > h3{
                    font-size: 1.2rem;
                    font-weight: 400;
                    color: #fff;
                }

                .footer__socials{
                    font-size: 1rem;
                    display: flex;
                    flex-direction: column;
                    gap: 5px;
                    // justify-content: start;
                    margin-top: -0.8rem;
                    align-items: flex-start;

                    .social_media{
                        display: flex;
                        gap: 1.5rem;
                        align-items: flex-start;
                        margin: 0.6rem 0;

                        a{
                            font-size: 1rem;
                            // background: #001659;
                            border-radius: 50%;
                            padding: .4rem;
                            color: #fff;
                            transition: all 400ms ease;

                            &.fb{
                                background: #3b5998;
                            }
                            &.tw{
                                background: #1da1f2;
                            }
                            &.ig{
                                background: #c32aa3;
                            }

                            &:hover{
                                background: #fff;
                                color: #001659;
                            }
                        }
                    }

                    p i{
                        font-size: 1.2rem;
                        color: #FFF;
                    }
                }
            }
        }
        .copyright{
            font-size: 1.2rem;
            color: #fff;
            text-align: center;
            padding: 1.5rem;
            margin-top: 4rem;
            border-top: 1px solid rgba(#fff, 0.3);
        }
    }

    // *=================================MEDIA QUERIES (MEDIUM)================================*
    @media screen and (max-width: 1024px){
        footer{
            .cont{
                gap: 2.5rem;
            }
        }
    }

    // / *=================================MEDIA QUERIES (MEDIUM)================================*
    @media screen and (max-width: 600px){
        footer{
            .cont{
                grid-template-columns: 1fr;
                text-align: center;

                .btn-primary, .footer__socials{
                    margin: 0 auto;
                }

                article{
                    & > div{
                        justify-content: center;
                    }
                }
            }
        }
    }
</style>
