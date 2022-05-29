<template>
    <section id="testimonials" class="swiper mySwiper">
        <h2 class="section_head"><span class="section_header">|</span>What Our Clients Said</h2>
        <div class="swiper-wrapper">
            <article class="swiper-slide">
                <p>This is what we are Lorem, ipsum dolor sit amet consectetur adipisicing elit. Qui et porro maiores quos quam soluta esse placeat quidem.</p>
                <div class="client">
                    <div class="avatar">
                        <img src="/images/directors/dir1.jpg" alt="Client1">
                    </div>
                    <div class="patient__details">
                        <h5>John Megbele</h5>
                        <small>Patient</small>
                    </div>
                </div>
            </article>
            <article class="swiper-slide">
                <p>We are ipsum, dolor sit amet consectetur adipisicing elit. Repellendus harum laudantium suscipit placeat rem perferendis, ex quia at!</p>
                <div class="client">
                    <div class="avatar">
                        <img src="/images/directors/dir2.jpg" alt="client2">
                    </div>
                    <div class="client__details">
                        <h5>Abigael Shantel</h5>
                        <small>Client</small>
                    </div>
                </div>
            </article>
            <article class="swiper-slide">
                <p>Then and ipsum dolor sit amet consectetur adipisicing elit. Quidem ipsam nam dolore aspernatur omnis odio nesciunt atque nobis?</p>
                <div class="client">
                    <div class="avatar">
                        <img src="/images/directors/dir3.jpg" alt="client3">
                    </div>
                    <div class="client__details">
                        <h5>Mathew Ashim</h5>
                        <small>client</small>
                    </div>
                </div>
            </article>
            <article class="swiper-slide">
                <p>Another ipsum dolor sit amet consectetur, adipisicing elit. Debitis rerum fuga corporis minus? Mollitia nulla recusandae!</p>
                <div class="client">
                    <div class="avatar">
                        <img src="/images/directors/dir4.jpg" alt="client4">
                    </div>
                    <div class="client__details">
                        <h5>Jackie Bambo</h5>
                        <small>client</small>
                    </div>
                </div>
            </article>
        </div>
        <div class="swiper-pagination"></div>
    </section>
</template>

<script>
export default {
    mounted() {
       var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },

        // responsive breakpoints, note that swiperjs is mobile first
            breakpoints: {
                // when window width is >= 600px
                600: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        })
    },
}
</script>


<style lang="scss" scoped>
    .swiper{
        width: 76vw;
        // margin-top: 3rem;

        & > h2{
            margin-bottom: 2.5rem;
            padding-top: 2rem;
            text-align: center;
        }

        & > p{
            text-align: center;
            width: 42%;
            margin: 0.8rem auto;
            padding-bottom: 2rem;
        }

        .swiper-wrapper{
            margin-bottom: 4rem;

            .swiper-slide{
                background: linear-gradient(135deg, #01134e, #3E4095);
                color: #fff;
                padding: 1.5rem 2rem;
                border-radius: 1rem;
                cursor: default;
                font-size: 0.9rem;

                p{
                    margin-bottom: 1.5rem;
                }

                .client{
                    display: flex;
                    align-items: center;
                    gap: 1rem;

                    .avatar{
                        width: 3rem;
                        aspect-ratio: 1/1;
                        border-radius: 50%;
                        overflow: hidden;

                        img{
                            width: 100%;
                            height: 100%;
                        }
                    }
                }
            }
        }
        .swiper-pagination-bullet{
            background: #001659;
        }
    }

// *=================================MEDIA QUERIES (SMALL)================================*
@media screen and (max-width: 600px){
    .swiper{
        .swiper-wrapper{
            .swiper-slide{
                padding: 1.5rem;
            }
        }
    }
}

</style>
