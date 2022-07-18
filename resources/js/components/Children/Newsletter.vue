<template>
    <div class="newsletter_landing">
        <div class="wrapper">
            <h1> Be the first to know </h1>
            <p>Subscribe to our newsletter and get new offers, discounted sales, latest trends in real estates and properties, all delivered into your inbox!</p>
            <div class="inputs">
                <input type="text" placeholder="Your name" v-model="name">
                <input type="text" placeholder="Your email address" v-model="email">
                <v-btn type="submit" @click="submit" :loading="isBusy">Subscribe</v-btn>
            </div>
        </div>
        <v-snackbar v-model="subscribed" :timeout="3000" top dark color="green darken-2">
            Thank you for subscribing to our newsletter.
            <v-btn text color="white--text" @click="subscribed = false">Close</v-btn>
        </v-snackbar>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isBusy: false,
            name: '',
            email: '',
            subscribed: false
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        submit(){
            if(this.name !== '' && this.email !== ''){
                this.isBusy = true
                axios.post(this.api + '/subscribe_to_newsletter', {
                    name: this.name,
                    email: this.email
                }).then((res) => {
                    this.isBusy = false
                    // console.log(res.data)
                    this.subscribed = true
                    this.email = ''
                    this.name = ''
                })
            }
        }
    },
}
</script>

<style lang="scss" scoped>
.newsletter_landing{
    text-align: center;
    color: #fff;
    margin: 0 auto;
    margin-bottom: -3rem;

    .wrapper{
        width: 80%;
        padding: 4rem 1.5rem;
        box-sizing: border-box;
        margin: 0 auto;
        text-align: center;
        display: flex;
        flex-direction: column;
        gap: 1rem;

        h1{
            color: #fff;
            font-weight: 400;
            font-size: 1.4rem;
            font-weight: 400;
            // font-size: 1.9rem;
            // margin-top: 2.5rem;
        }
        p{
            font-size: 1rem;
            font-weight: 400;
        }
        .inputs{
            display: flex;
            flex-direction: column;
            gap: .8rem;
            width: 50%;
            margin: 0 auto;
            text-align: center;

            input{
                width: 80%;
                border: 1px solid #fff;
                background-color: transparent;
                color: #fff;
                // border-radius: 4px;
                margin: 0 auto;
                padding: .6rem 1rem;
                display: block;
                // width: 100%;
                border-radius: .8rem;
                resize: none;
                appearance: none;

                &::placeholder{
                    color: white;
                }
                &:focus{
                    outline: none;
                }
            }
            button{
                border: 1px solid #fff;
                border-radius: .8rem;
                padding: .6rem 1rem;
                width: 50%;
                margin: 0 auto;
                background: transparent;
                color: #fff;
                transition: all .4s ease;
                margin-top: .75rem;

                &:hover{
                    background: #fff;
                    color: #E20000;
                    border-radius: 1px solid #E20000;
                }
                &:active{
                    // background: yellow;
                }
            }
        }
    }
}

</style>
