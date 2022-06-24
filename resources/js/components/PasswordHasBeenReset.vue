<template>
    <v-container>
        <v-row justify="center" class="mt-5">
            <v-col cols="12" md="8">
                <v-alert type="success" border="left" v-if="passwordReset">
                    Your password has been reset successfully. You can now <router-link to="/login">&nbsp; login</router-link>
                </v-alert>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    computed: {
        passwordReset(){
            return this.$store.getters.passwordReset
        }
    }
}
</script>

<style lang="scss" scoped>
    a{
        text-decoration: none;

        &:hover{
            color: #f7f7f7 !important;
        }
    }
</style>
