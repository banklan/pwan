<template>
    <v-container>
        <v-row justify="center" class="mt-10">
            <v-col cols="12" md="8">
                <v-card min-height="400" raised elevation="18" light>
                    <v-card-title class="justify-center subtitle-1 admin_a">Test Page</v-card-title>
                    <v-card-text class="pt-6">
                        <v-text-field label="First Name" v-model="user.fname"></v-text-field>
                        <v-text-field label="Last Name" v-model="user.lname"></v-text-field>
                        <v-text-field label="Email" v-model="user.email"></v-text-field>
                        <v-text-field label="Phone" v-model="user.phone"></v-text-field>
                        <v-text-field label="Age" v-model="user.age"></v-text-field>
                    </v-card-text>
                    <v-card-actions class="justify-center pb-8 px-5">
                        <v-btn dark x-large block color="admin_b" @click="submit">Submit</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            user: {
                name: '',
                email: '',
                age: ''
            },
            prop: {
                name: '',
                title: '',
                location: '',
                detail: '',
                price: '',
                size: ''
            },
        }
    },
    computed: {
        api(){
            return this.$store.getters.api
        }
    },
    methods: {
        submit(){
            // console.log(this.user)
            console.log(typeof(this.user))
            axios.post(this.api + '/test', {
                user: this.user
            }).then((res) => {
                console.log(res.data)
            })
        }
    },
    
}
</script>