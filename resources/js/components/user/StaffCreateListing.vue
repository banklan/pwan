<template>
    <v-container>
        <v-row justify="center" class="justify-center">
            <v-col cols="12">
                <v-btn rounded color="secondary" dark elevation="4" left @click="$router.go(-1)"><i class="uil uil-arrow-left"></i> Back</v-btn>
            </v-col>
        </v-row>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="10">
                <v-card light raised elevation="6" min-height="400" class="mx-auto pb-5">
                    <v-card-title class="justify-center subtitle-1 primary white--text">Create New Listing</v-card-title>
                    <v-card-text class="pl-5 mt-6">
                        <v-text-field label="Name" v-model="prop.name" required v-validate="'required|min:5|max:250'" :error-messages="errors.collect('name')" name="name"></v-text-field>
                        <v-text-field label="Location" v-model="prop.location" required v-validate="'required|min:5|max:500'" :error-messages="errors.collect('location')" name="location"></v-text-field>
                        <v-text-field label="Landmark" hint="Close-by recognizable place or building" v-model="prop.landmark" v-validate="'min:5|max:500'" :error-messages="errors.collect('landmark')" name="landmark"></v-text-field>
                        <v-text-field label="Land Title" hint="e.g Registered Survey or Deed of assignment" v-model="prop.title" v-validate="'max:300'" :error-messages="errors.collect('title')" name="title"></v-text-field>
                        <v-textarea label="Detail" rows="2" auto-grow v-model="prop.detail" v-validate="'required|min:10|max:1000'" :error-messages="errors.collect('detail')" name="detail"></v-textarea>
                        <v-text-field label="Price(NGN)" hint="Price in Naira. Please do not add commas" v-model="prop.price" v-validate="'required|decimal'" :error-messages="errors.collect('price')" name="price"></v-text-field>
                        <v-text-field label="Unit(Sq/m or Plot)" hint="The units/size with which the property is sold" v-model="prop.size" v-validate="'max:20'" :error-messages="errors.collect('size')" name="size"></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8">
                        <v-btn dark outlined large color="red darken-1" width="40%" @click="clearForm">Cancel</v-btn>
                        <v-btn dark large color="primary" width="40%" @click="createProp" :loading="isBusy">Submit</v-btn>
                    </v-card-actions>
                    <v-card-text v-if="valErrors.length > 0" class="error_msgs">
                        <div class="text-center">
                            <h4>Please fix the following errors.</h4>
                        </div>
                        <div v-for="err in valErrors" :key="err">
                            <p>*{{ err }}</p>
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            prop: {
                name: '',
                title: '',
                location: '',
                landmark: '',
                detail: '',
                price: '',
                size: ''
            },
            isBusy: false,
            valErrors: []
        }
    },
    computed: {
        authUser(){
            return this.$store.getters.authUser
        },
        api(){
            return this.$store.getters.api
        },
        authHeaders(){
            let headers = {
                headers: {
                    "Authorization": `Bearer ${this.authUser.token}`
                }
            }
            return headers
        },
    },
    methods: {
        clearForm(){
            this.prop.name = ''
            this.prop.title = ''
            this.prop.location = ''
            this.prop.landmark = ''
            this.prop.detail = ''
            this.prop.price = ''
            this.prop.size = ''
            this.$validator.pause()
            this.$validator.fields.items.forEach(field => field.reset())
            this.$validator.errors.clear()
            this.valErrors = []
        },
        createProp(){
             this.$validator.validateAll().then((isValid) => {
                if(isValid) {
                    this.isBusy = true
                    let self = this

                    axios.post(this.api + '/auth/create_property_listing', {
                        prop: this.prop
                    }, this.authHeaders).then((res) => {
                        this.isBusy = false
                        // console.log(res.data)
                        this.$store.commit('CreatePropListing', res.data)
                        this.$router.push({name: 'StaffCreateListingUploads'})
                    }).catch(err =>{
                        this.isBusy = false
                        if(err.response.status === 422){
                            for (const key in err.response.data.errors){
                                this.valErrors.push(err.response.data.errors[key][0] + ' ')
                                console.log(err.response.data.errors[key][0] + ' ')
                            }
                        }
                    })
                }
             })
        }
    },
}
</script>


<style lang="scss" scoped>
    .error_msgs{
        width: 90%;
        margin: 1rem auto;
        padding: 1rem 2rem;
        background: rgba(255,0,0,.61);

        h4{
            font-size: 1rem;
            color: white;
            padding-bottom: 0.6rem;
        }

        p{
            color: #fff;
            font-size: 0.9rem;
            font-style: italic;
        }
    }
</style>
