<template>
    <div class="text-center">
        <v-text-field :placeholder="`Search for ${ searchFor }`" v-model="q" outlined dense append-icon="search" clearable @keypress.enter="search"></v-text-field>
    </div>
</template>

<script>
export default {
    props: ['model', 'searchFor'],
    data() {
        return {
            q: ''
        }
    },
    methods: {
        search(){
            if(this.q.trim() !== ''){
                this.$router.push({name: `Staff${this.model}SearchResult`, query:{q: this.q.trim()}})
            }
        }
    }
}
</script>

<style lang="css" scoped>
.v-input__slot{
    border-radius: 50px !important;
}

</style>
