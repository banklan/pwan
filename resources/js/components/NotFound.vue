<template>
<v-container>
    <v-row justify="center">
        <v-col cols="12" md="10">
            <div class="wrapper">
                <div class="pg_title">
                    Ooops! Sorry, the page doesn't exist!!
                </div>
               <div class="image">
                    <img src="/images/assets/void.svg" />
               </div>
            </div>
        </v-col>
    </v-row>
</v-container>
</template>

<style lang="scss" scoped>
    .wrapper{
        margin: 0 auto;
        padding: 3.5rem 1.5rem;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        .pg_title{
            color: #3c4043;
            font-size: 1.85rem;
            font-weight: 400;
            text-align: center;
            line-height: 1.8;
        }
        .image{
            margin-top: 2.5rem;
            img{
                height: 21rem;
            }
        }
    }
</style>
