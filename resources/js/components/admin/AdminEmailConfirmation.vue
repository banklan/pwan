<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <div class="white--text text-center pa-5 mt-8 body_text" :class="`${messageType}`">
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
            axios.post(this.api +`/verify_admin_email`, {
                token: this.$route.query.token
            }).then((res) => {
                if(res.status === 555){
                    this.message = 'The email you are trying to verify has been previously verified!'
                    this.messageType = 'warning'
                }else if(res.status === 200){
                    this.message = 'Your email address has been verified. Kindly wait for an email to notify when you can login. Thank you!'
                    this.messageType = 'success'
                }
            })
        }
    },
    created() {
        this.confirmToken()
    },
}
</script>
