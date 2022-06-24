<template>
    <div class="our_directors">
        <h2 class="section_head"><span class="section_header">|</span>Our Directors</h2>
        <div class="directors cont">
            <div class="director">
                <div class="dir_img">
                    <img src="/images/directors/dr_onwumere.jpg" alt="">
                </div>
                <div class="dir_details">
                    <h3>Dr. Augustine Ozioma Onwumere</h3>
                    <p class="text-muted">Chairman, PWAN Group</p>
                </div>
                <div class="dir_socials">
                    <a href="https://facebook.com/PWAN-Platinum-Warri-106114298634221/?ref=page_internal" target="_blank"><i class="uil uil-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="uil uil-twitter-alt"></i></a>
                    <a href="https://instagram.com/" target="_blank"><i class="uil uil-instagram"></i></a>
                </div>
                <a href="https://wa.me/2348025886719" target="_blank" class="dir_whatsapp">
                    <i class="uil uil-whatsapp"></i>
                </a>
            </div>
            <div class="director">
                <div class="dir_img">
                    <img src="/images/directors/mrs_onwumere.jpg" alt="">
                </div>
                <div class="dir_details">
                    <h3>Dr. Jane Obioma Onwumere</h3>
                    <p class="text-muted">Group Managing Director, PWAN Group</p>
                </div>
                <div class="dir_socials">
                    <a href="https://facebook.com/PWAN-Platinum-Warri-106114298634221/?ref=page_internal" target="_blank"><i class="uil uil-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="uil uil-twitter-alt"></i></a>
                    <a href="https://instagram.com/" target="_blank"><i class="uil uil-instagram"></i></a>
                </div>
                <a href="https://wa.me/2348025886719" target="_blank" class="dir_whatsapp">
                    <i class="uil uil-whatsapp"></i>
                </a>
            </div>
            <div class="director">
                <div class="dir_img">
                    <img src="/images/directors/dr_oberabor.jpg" alt="">
                </div>
                <div class="dir_details">
                    <h3>Dr. Dennis Oberabor</h3>
                    <p class="text-muted">Chairman/MD, PWAN Premium</p>
                </div>
                <div class="dir_socials">
                    <a href="https://facebook.com/PWAN-Platinum-Warri-106114298634221/?ref=page_internal" target="_blank"><i class="uil uil-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="uil uil-twitter-alt"></i></a>
                    <a href="https://instagram.com/" target="_blank"><i class="uil uil-instagram"></i></a>
                </div>
                <a href="https://wa.me/2348025886719" class="dir_whatsapp">
                    <i class="uil uil-whatsapp"></i>
                </a>
            </div>
            <div class="director">
                <div class="dir_img">
                    <img src="/images/directors/mrs_oberabor.jpg" alt="">
                </div>
                <div class="dir_details">
                    <h3>Amb. Mrs Vera Oberabor</h3>
                    <p class="text-muted">Executive Director, PWAN Premium</p>
                </div>
                <div class="dir_socials">
                    <a href="https://facebook.com/PWAN-Platinum-Warri-106114298634221/?ref=page_internal" target="_blank"><i class="uil uil-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="uil uil-twitter-alt"></i></a>
                    <a href="https://instagram.com/" target="_blank"><i class="uil uil-instagram"></i></a>
                </div>
                <a href="https://wa.me/2348025886719" class="dir_whatsapp">
                    <i class="uil uil-whatsapp"></i>
                </a>
            </div>
            <div class="director">
                <div class="dir_img">
                    <img src="/images/directors/mr_okogbo.jpg" alt="">
                </div>
                <div class="dir_details">
                    <h3>Mr Henry Okogbo</h3>
                    <p class="text-muted">Managing Director, PWAN Platinum</p>
                </div>
                <div class="dir_socials">
                    <a href="https://facebook.com/PWAN-Platinum-Warri-106114298634221/?ref=page_internal" target="_blank"><i class="uil uil-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="uil uil-twitter-alt"></i></a>
                    <a href="https://instagram.com/" target="_blank"><i class="uil uil-instagram"></i></a>
                </div>
                <a href="https://wa.me/2348057165471" class="dir_whatsapp">
                    <i class="uil uil-whatsapp"></i>
                </a>
            </div>
            <div class="director">
                <div class="dir_img">
                    <img src="/images/directors/mrs_okogbo.jpg" alt="">
                </div>
                <div class="dir_details">
                    <h3>Mrs Ify Okogbo</h3>
                    <p class="text-muted">Executive Director, PWAN Premium</p>
                </div>
                <div class="dir_socials">
                    <a href="https://facebook.com/PWAN-Platinum-Warri-106114298634221/?ref=page_internal" target="_blank"><i class="uil uil-facebook-f"></i></a>
                    <a href="https://twitter.com/" target="_blank"><i class="uil uil-twitter-alt"></i></a>
                    <a href="https://instagram.com/" target="_blank"><i class="uil uil-instagram"></i></a>
                </div>
                <a href="https://wa.me/2348163451098" class="dir_whatsapp">
                    <i class="uil uil-whatsapp"></i>
                </a>
            </div>
        </div>
        <div class="cta">
            <v-btn raised elevation="12" x-large dark color="secondary" class="btn-cta justify-center" :to="{name: 'AboutUs'}">Our Directors</v-btn>
        </div>
    </div>
</template>

<style scoped lang="scss">
    .our_directors{
        margin: 0;
        padding: 0;
        margin-top: 5rem;

        .directors{
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;

            .director{
                border: 1px solid rgba(209, 209, 209, 0.7);
                border-radius: 1rem;
                box-shadow: 0 2rem 2rem rgba(#fff, 0.85);
                overflow: hidden;
                position: relative;
                transition: all 700ms ease;

                &:hover{
                    box-shadow: none;

                    .dir_img::before{
                        left: 0;
                        border-radius: 1rem;
                    }
                    .dir_socials, .dir_whatsapp{
                        opacity: 1;
                        visibility: visible;
                    }
                }

                .dir_img{
                    width: 100%;
                    height: 21rem;

                    img{
                       width: 100%;
                       height: 100%;
                    //    aspect-ratio: 1/1;
                    }

                    &::before{
                        content: '';
                        display: block;
                        width: 100%;
                        height: 100%;
                        position: absolute;
                        top: 0;
                        left: -100%;
                        background: linear-gradient(135deg, rgba(#001659, 0.8), rgba(#3E4095, 0.8));
                        border-radius: 50%;
                        transition: all 1s ease;
                    }
                }

                .dir_details{
                    margin: 1.5rem;
                    text-align: center;

                    h3{
                        font-size: 1.2rem;
                    }

                    p{
                        font-size: 0.9rem;
                    }
                }

                .dir_socials{
                    position: absolute;
                    top: 1.2rem;
                    right: 1.2rem;
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                    opacity: 0;
                    visibility: hidden;
                    transition: all 1s 400ms ease;

                    a{
                        background: #fff;
                        color: #001659;
                        padding: 0.4rem;
                        display: flex;
                        font-size: 0.8rem;
                        border-radius: 50%;
                        transition: all 700ms ease;

                        &:hover{
                            background: #3E4095;
                            color: #fff;
                        }
                    }
                }

                .dir_whatsapp{
                    background: rgb(3, 102, 3);
                    color: #fff;
                    position: absolute;
                    left: 40%;
                    transform: translateY(-50%);
                    bottom: 30%;
                    padding: 1rem;
                    border-radius: 50%;
                    display: flex;
                    opacity: 0;
                    visibility: hidden;
                    transition: all 1s 400ms ease;
                }
            }
        }

        .abt_us_cta{
            text-align: center;
            margin: 2.5rem;
        }
    }

    // media queries
    @media screen and (max-width: 1024px){
        .cont{
            width: 86%;
        }
        .our_directors{
            margin: 0 auto;

            .directors{
                grid-template-columns: 1fr 1fr;
                gap: 3rem;

                .director{
                    .dir_img{
                        height: 18rem;
                        // aspect-ratio: 1/1;
                    }
                }
            }
        }
    }
    @media screen and (max-width: 600px){
        .cont{
            width: 94%;
            margin: 0 auto;
        }
        .our_directors{
            .directors{
                grid-template-columns: 1fr;

                .director{
                    .dir_img{
                        height: 26rem;
                    }
                }
            }
        }
    }

</style>
