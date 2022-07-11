<template>
    <v-container>
        <v-row justify="space-around" class="my-8">
            <v-col cols="12" md="6">
                <div class="left">
                    <div class="pg_header">
                        We would love to hear from you.
                    </div>
                    <div class="illstr_img">
                        <img src="/images/assets/undraw_emails_re_cqen.svg" alt="">
                    </div>
                    <div class="contacts">
                        <div class="loc">
                            <div class="phone">
                                <i class="uil uil-phone"></i>
                                <span>08025886719, 08057165471, 08025886718, 08163451098</span>
                            </div>
                            <div class="address">
                                <i class="uil uil-map-marker"></i>
                                <span>9, Airport road, Opposite Our Ladies School gate, Effurun. Delta State.</span>
                            </div>
                            <div class="email">
                                <i class="uil uil-envelope-alt"></i>
                                <span>pwanplatinumwarri@gmail.com</span>
                            </div>
                        </div>
                        <div class="socials">
                            <a href="https://facebook.com/PWAN-Platinum-Warri-106114298634221/?ref=page_internal" target="_blank"><i class="uil uil-facebook-f"></i></a>
                            <a href="twitter.com/pwan" class="tw" target="_blank"><i class="uil uil-twitter-alt"></i></a>
                            <a href="instagram.com/pwan" class="ig" target="_blank"><i class="uil uil-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </v-col>
            <v-col cols="12" md="6">
                <div class="right">
                    <div class="pg_header">
                        Let us know how we may be of help to you.
                    </div>
                    <div class="contact_form">
                        <v-text-field label="Fullname" v-model="enquiry.fullname" placeholder="Fullname (Last name and First Name)" solo name="fullname" required v-validate="'required|min:5|max:100'" :error-messages="errors.collect('fullname')" data-vv-as="fullname"></v-text-field>
                        <v-text-field label="Organization" placeholder="Name of your organization" v-model="enquiry.organization" solo name="organization" v-validate="'required|min:3|max:50'" :error-messages="errors.collect('organization')" data-vv-as="organization"></v-text-field>
                        <v-text-field label="Position" placeholder="Your position in the organization" v-model="enquiry.position" solo name="position" v-validate="'min:2|max:30'" :error-messages="errors.collect('position')" data-vv-as="position"></v-text-field>
                        <v-row wrap>
                            <v-col cols="12" md="6">
                                <v-text-field label="Email Address" placeholder="Email address" v-model="enquiry.email" solo dense name="email" required v-validate="'required|email'" :error-messages="errors.collect('email')"></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field label="Phone No" placeholder="Phone Number" v-model="enquiry.phone" solo dense name="phone" required v-validate="'required|numeric|max:14'" :error-messages="errors.collect('phone')"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-text-field label="Subject" placeholder="Subject" v-model="enquiry.subject" solo dense name="subject" required v-validate="'required|min:3|max:220'" :error-messages="errors.collect('subject')"></v-text-field>
                        <v-textarea label="Message" placeholder="Enquiry" v-model="enquiry.message" rows="4" auto-grow solo dense name="message" required v-validate="'required|min:5|max:800'" :error-messages="errors.collect('message')"></v-textarea>
                        <v-btn block dark large color="primary" class="my-3" @click="sendEnquiry" :loading="isBusy">Send Enquiry</v-btn>
                    </div>
                </div>
            </v-col>
        </v-row>
        <v-snackbar v-model="enquiryMailSent" :timeout="6000" top dark color="green darken-2">
            Your enquiry has been delivered to us. One of our executives will reach out to you soon. Thank you.
            <v-btn text color="white--text" @click="enquiryMailSent = false">Close</v-btn>
        </v-snackbar>
        <v-snackbar v-model="enquiryFailed" :timeout="6000" top dark color="red darken-2">
            There was an error while trying to send your enquiry. Please ensure all fields are validly filled and your device is connected to the internet before trying again.
            <v-btn text color="white--text" @click="enquiryFailed = false">Close</v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            enquiry: {
                fullname: ''
            },
            isBusy: false,
            enquiryMailSent: false,
            enquiryFailed: false,
        }
    },
    computed:{
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        sendEnquiry(){
            this.$validator.validateAll().then(isValid => {
                if (isValid) {
                    this.isBusy = true
                    axios.post(this.api + '/send_enquiry', {
                        enquiry: this.enquiry
                    }).then(() => {
                        this.isBusy = false
                        this.clearEnquiryForm()
                        this.enquiryMailSent = true
                    }).catch(() =>{
                        this.isBusy = false
                        this.enquiryFailed = true
                    })
                }
            })
        },
        clearEnquiryForm(){
            this.enquiry.fullname = ''
            this.enquiry.organization = ''
            this.enquiry.position = ''
            this.enquiry.email = ''
            this.enquiry.phone = ''
            this.enquiry.subject = ''
            this.enquiry.message = ''
            this.$validator.pause()
            this.$validator.fields.items.forEach(field => field.reset())
            this.$validator.errors.clear()
        }
    }
}
</script>

<style lang="scss" scoped>
    .pg_header{
        font-size: 1.2rem;
        text-align: center;
        FONT-WEIGHT: 400;
        color: #3c4043;
        margin: .6rem auto;
    }
    .left{
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;

        .illstr_img{
            padding: 1rem 3rem;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            img{
                height: 28rem;
            }
        }
        .contacts{
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: flex-start;
            gap: 1rem;

            .loc{
                font-size: 1rem;
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: flex-start;
                gap: .8rem;
               i{
                    padding-right: 1rem;
                }
            }

            .socials{
                padding-top: 1.2rem;
                display: flex;
                gap: 2rem;
                align-items: flex-start;

                a{
                    font-size: 1.1rem;
                    border-radius: 50%;
                    padding: .4rem;
                    color: #fff;
                    transition: all .4s ease;

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
                        transform: scale(1.2);
                    }
                }
            }
        }
    }
    .right{
        box-sizing: border-box;
        margin: 0 auto;
        padding: 0 1rem;

        .contact_form{
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #dadce0;
            overflow: hidden;
            padding: 1.5rem 1rem;
            margin-top: 2.5rem;
        }
    }
</style>
