<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <div class="white--text pa-5 mt-8 body_text" :class="`${messageType}`">
                    {{ message }}
               </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            token: this.$route.query.token,
            message: '',
            messageType: ''
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        },
    },
    methods:{
        confirmToken(){
            axios.post(this.api +`/verify_staff_email/`, {
                token: this.$route.query.token
            }).then((res) => {
                if(res.data.code === 0){
                    this.message = 'There was an error while trying to verify your email. Please click the button in the email we sent to you.'
                    this.messageType = 'error'
                }else if(res.data.code === 1){
                    this.message = 'The email you are trying to verify has been previously verified!'
                    this.messageType = 'warning'
                }else if(res.data.code === 2){
                    this.message = 'Your email address has been verified. Kindly wait for an email to notify when you can login. Thank you!'
                    this.messageType = 'success'
                }
                // if(res.status === 555){
                //     this.message = 'The email you are trying to verify has been previously verified!'
                //     this.messageType = 'warning'
                // }else if(res.status === 200){
                //     this.message = 'Your email address has been verified. Kindly wait for an email to notify when you can login. Thank you!'
                //     this.messageType = 'success'
                // }else{
                //     this.message = 'This link is eiter expired or invalid. Please re-register.'
                //     this.messageType = 'error'
                // }
            }).catch(() => {
                this.message = 'There was an error while trying to verify your email. Please try again.'
                    this.messageType = 'error'
            })
        }
    },
    created() {
        this.confirmToken()
        // console.log(this.$route.query.token)
    },
}
</script>
