<template>
    <footer>
        <div class="cont">
            <article>
                <h3>Quick Links</h3>
                <router-link to="/">Home</router-link>
                <router-link to="/about-us">About Us</router-link>
                <router-link to="/listings">Listings</router-link>
                <router-link to="/events">Events</router-link>
                <router-link to="/contact-us">Contact Us</router-link>
                <router-link to="/testimonials">Testimonial</router-link>
            </article>
            <article>
                <h3>Quick Links</h3>
                <router-link to="/faq">Freq Asked Qstns</router-link>
                <router-link to="/news-posts">News</router-link>
                <router-link to="/login">Staff Login</router-link>
                <router-link to="/terms-conditions">Terms & Conditions</router-link>
                <router-link to="/privacy-policy">Privacy Policy</router-link>
                <router-link to="/subscription-form">Subscription Form</router-link>
            </article>
            <article>
                <h3>Contact Us</h3>
                <div class="footer__socials">
                    <div class="social_media">
                        <a href="https://facebook.com/PWAN-Platinum-Warri-106114298634221/?ref=page_internal" target="_blank" class="fb"><i class="uil uil-facebook-f"></i></a>
                        <a href="#" class="tw"><i class="uil uil-twitter-alt"></i></a>
                        <a href="#" class="ig"><i class="uil uil-instagram"></i></a>
                    </div>
                    <p><i class="uil uil-map-marker"></i> 9, Airport road, Opposite Our Ladies School gate, Effurun. Delta State.</p>
                    <p><i class="uil uil-phone"></i> 08025886719, 08057165471 </p>
                    <p class="ml-8 mt-n4">08025886718, 08163451098</p>
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

            article{
                display: flex;
                flex-direction: column;
                gap: .8rem;

                & > h3{
                    font-size: 1rem;
                    color: #fff;
                    font-weight: 400;
                    margin-bottom: 1px;
                }

                a{
                    color: rgba(#fff, 0.7);
                    font-size: .9rem;
                    text-decoration: none;
                    transition: all 400ms ease;
                    &:hover{
                        color: #fff;
                    }
                }

                .footer__socials{
                    font-size: .9rem;
                    display: flex;
                    flex-direction: column;
                    gap: 5px;
                    margin-top: -0.6rem;
                    align-items: flex-start;
                    width: 100%;

                    .social_media{
                        width: 100%;
                        display: flex;
                        justify-content: flex-start;
                        gap: 2rem;
                        align-items: center;
                        margin: .6rem auto;

                        a{
                            font-size: .9rem;
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
                        font-size: 1rem;
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

    @media screen and (max-width: 1024px){
        footer{
            .cont{
                width: 92%;
            }
        }
    }

    @media screen and (max-width: 722px){
        footer{
            .cont{
                grid-template-columns: 1fr;
                text-align: center;
                gap: 3rem;

                article{
                    .footer__socials{
                        align-items: center;

                        .social_media{
                            justify-content: center;
                        }
                    }
                }
            }
        }
    }
</style>
