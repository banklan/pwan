<template>
    <v-container>
        <v-row justify="center" class="mt-10">
            <v-col cols="12" md="8">
                <v-alert type="success" :value="testimonialSent" class="mt-10">
                    Thank you for taking out time to submit a testimonial. We do appreciate it.
                    Your testimonial will be viewable once we approve it.
                </v-alert>
                <div class="text-center mt-10 pb-10">
                    <v-btn large text color="primary" to="/">Back To Home</v-btn>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {

        }
    },
    components:{
        testimonialSent(){
            return this.$store.getters.testimonialSent
        }
    }
}
</script>
