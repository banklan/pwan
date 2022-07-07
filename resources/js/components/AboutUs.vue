<template>
    <div>
        <v-container>
            <v-row justify="center" class="my-5">
                <v-col cols="12" md="10">
                    <div class="wrapper">
                        <div class="about">
                            <div class="abt_title">About Us</div>
                            <div class="about_body">
                                <p>PWAN Platinum was inaugurated on the 11th August, 2021 as an affiliate of PWAN Premium Realtors and Concerns Ltd. under the PWAN group. It launched her first estate called The Platinum View Estate in Warri on the 12th October, 2021. Since the launch of the estate, it has received
                                    unprecedented patronage from clients and PBOs.</p>
                                <p>PWAN Platinum has it's main office located at No. 9, Airport road, Opposite Our Ladies School gate, Airport Road, Effurun. Delta State.</p>
                                <p>In line with the PWAN Group vision of making home ownership dream a reality for everyone, we seemlessly provide affordable lands and housing for both the rich and the poor.</p>
                                <p>The company runs an open-door, down-to-earth, client-friendly and PBO-engaging approach of doing business.</p>
                                <p>We employ an aggresive marketing strategy technic to sales generation. We place our company and brand in the faces and minds of our environment and sphere of operation. We have big dreams and believe in reaching the zenith of Real estate business. Our PBOs and clients are our most cherished resources.</p>
                                <p>We believe in humanity and see them as our greatest asset. We appreciate our staff and we let them know it.
                                    We truly believes <strong>EVERYONE DESERVES A HOME</strong>.
                                </p>
                                <section class="pbo">
                                    <h4>CUSTOMER/PBO ORIENTED </h4>
                                    <p>AT PWAN Platinum, we put our clients/customers and PBOs (PWAN Business Owners) first and strive to serve them better. </p>
                                    <p>Our aim is not only to serve them better, but to establish a long-lasting relationship by helping our customers make the right choices in land purchasing and
                                        helping our PBOs establish sales and close their deals.
                                    </p>
                                </section>
                                 <section class="pbo">
                                    <h4>HIGHLY QUALIFIED STAFF </h4>
                                    <P>We have a team of highly qualified personnel who are proactive, customer-friendly and are set to give clients and PBOs professional advice on real estate
                                        and land acquisition. </P>
                                </section>
                                <section class="pbo">
                                    <h4>WEEKLY TRAINING </h4>
                                    <p>Our weekly trainings are highy interactive, educative and insightful.</p>
                                </section>
                            </div>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-container>
        <div class="our_team">
            <div class="hoz">
                <div class="team_title">
                    Meet Our Board Of Directors
                </div>
                <div class="team_wrap">
                    <div v-for="team in teams" :key="team.id" class="hor_team">
                        <div class="img">
                            <img :src="`/images/directors/${team.img}`" :alt="`team.name`">
                        </div>
                        <div class="details">
                            <div class="titl">
                                <div class="name">{{ team.name }}</div>
                                <div class="desig">{{ team.title }}</div>
                            </div>
                            <div class="body">
                                <p>{{ team.intro }}</p>
                                <p>{{ team.body }}</p>
                                <p>{{ team.closing }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            teams: [
                {id:1, name: 'Dr. Augustine Ozioma Onwumere', title: 'Chairman, PWAN Group',
                    intro: 'Dr. Augustine Ozioma Onwumere is a co-founder of the PWAN Group.',
                    body: 'He serves as the chairman of the PWAN group which is the largest real estate network in Nigeria with estates and offices spread across several states of the federation like Lagos, Ogun, Imo, Rivers and Delta among others.',
                    closing: 'Dr. Augustine Onwumere is married to Dr. Jayne Obioma Onwumere and they are blessed with wonderful children.', img: 'dr_onwumere.jpg'},
                {id:2, name: 'Dr. Jane Obioma Onwumere', title: 'Group Managing Director, PWAN Group',
                    intro: 'Dr. Jane Obioma Onwumere is the Group Managing Director of PWAN Group.',
                    body: 'She leads a team of 12 Managing Directors with over 110 direct staff spread across 12 affiliate companies that make up the PWAN group and over thirty thousand Independent Real Estate professionals gererally called consultants.',
                    closing: 'Dr. (Mrs) Jane Obioma Onwumere is married to Dr. Augustine Ozioma Onwumere and they are blessed with children.', img: 'mrs_onwumere.jpg'},
                {id:3, name: 'Dr. Dennis Oberabor', title: 'Chairman/MD, PWAN Premium',
                    intro: 'Dr. Dennis Oberabor is the erudite, articulate and very experienced MD of PWAN Premium.',
                    body: 'He is a graudate of University of Lagos in 1982 with BSC in Bus. Admin & an MBA from the University of Benin. He has over 25 years of senior banking experience and retired as Chief inspector of Equitorial Trust Bank in 2010. He joined PWAN group in 2012 and became the MD of PWAN Premium in April 2017.',
                    closing: 'Dr. Dennis Oberabor is married to Ambassador Vera Oberabor and they are blessed with children.', img: 'dr_oberabor.jpg'},
                {id:4, name: 'Mrs Vera Oberabor', title: 'Executive Director, PWAN Premium',
                    intro: 'Mrs Vera Oberabor, the enterprising Executive Director of PWAN Premium was born in Abia State.',
                    body: 'She graduated from the University Of Benin with Bachelors in English/Literature. She also obtained a Masters Degree in Industrial Relations and Personnel Mgt. from the University of Lagos. She has extensive experience as a banker before venturing into International business. She joined PWAN Homes in 2012 as an Independent associate.',
                    closing: 'Mrs. Vera Oberabor is married to Dr. Dennis Oberabor and blessed with children.', img: 'mrs_oberabor.jpg'},
                {id:5, name: 'Mr Henry Okogbo', title: 'Managing Director, PWAN Platinum',
                    intro: 'Mr Henry Okogbo, the Managing Director of PWAN Platinum was born in Warri.',
                    body: "He attended the famous Notre Dame college, Ozoro, had his HSC in Hussey College and proceeded to the University of Lagos where he bagged a BSC in Finance in 1990. He worked for 18 years in the oil & gas industry, Supply Chain Management transiting the Escravos and the Onne fields. He is a graduate of African Center For Leadership, Strategy and Management and an astute teacher of God's word. He joined PWAN in 2017.",
                    closing: 'Mr Henry Okogbo is married to Mrs Ify Okogbo and blessed with three wonderful children.', img: 'mr_okogbo.jpg'},
                {id:6, name: 'Mrs Ify Okogbo', title: 'Executive Director, PWAN Platinum',
                    intro: 'Mrs Ify Okogbo, the Executive Director of PWAN Platinum, hails from Enugwu Ukwu of Anambra State.',
                    body: 'She was a reputable teacher of 21 years. She is a graduate of Library & Information Science from the University of Nigeria, Nsukka. She joined PWAN in 2017 where she helped in building a network of marketing team within the PWAN group. She became the team manager and center coordinator of the most popular center in Delta state called "Warri Explosive."',
                    closing: 'She is married to Mr Henry Okogbo and their marriage is blessed with wonderful children.', img: 'mrs_okogbo.jpg'},
            ]
        }
    },
}
</script>

<style lang="scss" scoped>
    .wrapper{
        margin: 0 auto;
        width: 100%;
        box-sizing: border-box;

        .about{
            .abt_title{
                text-align: center;
                font-size: 1.4rem;
                font-weight: 500;
                color: #2c2c2c;
                margin: .5rem 1rem 1rem;
            }
            .about_body{
                font-size: 1rem;
                line-height: 1.9;
                padding: 0.5rem 1rem;
                color: #2e2e2e;

                .pbo{
                    margin-top: 3rem;
                    h4{
                        font-size: 1rem;
                        font-weight: 500;
                    }
                }
            }
        }
    }
    .our_team{
        margin: 0 auto;
        width: 85%;
        .hoz{
            width: 90%;
            padding: 1.2rem .8rem;
            box-sizing: border-box;
            margin: 0 auto;

            .team_title{
                text-align: center;
                font-size: 1.4rem;
                font-weight: 400;
                color: #2c2c2c;
                margin: .5rem 1rem 2rem;;
            }

            .team_wrap{
                margin: 0 auto;

                .hor_team{
                    width: 100%;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    border: 1px solid #e1e1e1;
                    border-radius: 8px;
                    overflow: hidden;
                    height: 20rem;
                    padding: 2rem auto;
                    margin: 2rem 0;
                    box-sizing: border-box;

                    .img{
                        height: 100%;
                        width: 100%;

                        img{
                            max-height: 20rem;
                            height: 100%;
                        }
                    }

                    .details{
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        box-sizing: border-box;

                        .titl{
                            padding: .5rem;
                            text-align: center;
                            margin-top: 1.5rem;

                            .name{
                                font-size: 1rem;
                                font-weight: 400;
                                margin: .5rem auto 0;
                                color: #4e4e4e;
                            }

                            .desig{
                                font-size: .85rem;
                                color: #5e5e5e;
                            }
                        }

                        .body{
                            padding: .5rem 1rem 1rem 1rem;
                            font-size: .9rem;
                            line-height: 1.8;
                            margin-bottom: 1.5rem;
                        }
                    }
                }
            }
        }
    }
    @media screen and (max-width: 1264px){
        .our_team{
            width: 100%;

            .hoz{
                width: 100%;
                 padding: 1.2rem 1rem;
            }
        }
    }
    @media screen and (max-width: 1020px){
        .our_team{
            .hoz{
                .hor_team{
                    .details{
                        .name{
                            font-size: 1rem;
                        }
                        .desig{
                            font-size: .9rem;
                        }
                        .body{
                            font-size: .9rem;
                        }
                    }
                }
            }
        }
    }
    @media screen and (max-width: 900px){
        .our_team{
            width: 96%;
            .hoz{
                width: 100%;
                margin: 0 auto;
                .team_wrap{
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 1.5rem;
                    margin: -1rem auto 2rem;
                    .hor_team{
                        width: 100%;
                        height: fit-content;
                        flex-direction: column;
                        margin-bottom: -2rem;
                        .img{
                            height: 22rem;
                            width: 100%;

                            img{
                                height: 100%;
                                width: 100%;
                            }
                        }
                        .details{
                            margin-top: -1rem;
                            .titl{
                                margin-top: 0;
                            }
                        }
                    }
                }
            }
        }
    }
     @media screen and (max-width: 720px){
         .our_team{
            width: 100%;
            .hoz{
                 .team_wrap{
                     gap: 1.2rem;
                 }
            }
         }
     }
     @media screen and (max-width: 600px){
         .our_team{
            width: 100%;
            .hoz{
                width: 90%;
                .team_wrap{
                    grid-template-columns: 1fr;
                    .hor_team{
                        .img{
                            height: 24rem;
                        }
                    }
                }
            }
         }
     }
     @media screen and (max-width: 520px){
         .our_team{
            width: 100%;
            .hoz{
                width: 100%;
            }
         }
     }
</style>
