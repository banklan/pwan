<template>
    <v-container>
        <v-row justify="center" class="mt-8">
            <v-col cols="12">
                <div class="headline text-center font-weight-bold"><span class="section_header">|</span>Latest Events</div>
            </v-col>
        </v-row>
        <v-row justify="center" align="center" class="mt-4 pb-10">
            <v-col cols="12" md="9">
                <v-carousel cycle height="250" show-arrows-on-hover hide-delimiters>
                    <v-carousel-item v-for="(item, i) in items" :key="i" reverse-transition="fade-transition" transition="fade-transition">
                        <v-card flat outlined min-height="200" class="px-2 py-3">
                            <v-card-actions class="justify-space-between">
                                <v-img :src="`/images/assets/${item.image}`" height="160" width="160" transition="scale-transition"></v-img>
                                <div class="ml-5">
                                    <div class="subtitle-1 font-weight-bold primary--text darken-3">{{ item.title }}</div>
                                    <div class="subtitle-2">{{ item.content }}</div>
                                </div>
                            </v-card-actions>
                        </v-card>
                    </v-carousel-item>
                </v-carousel>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            items: [
                {title: 'Lorem ipsum dolor sit amet consectetur', content: 'Dolorem adipisci voluptatibus expedita molestias beatae tempore tempora eos repellat ratione corporis dignissimos laborum', image: 'news1.jpg'},
                {title: 'Tempore repellat eum porro facere fugiat nisi', content: 'Dolorem adipisci voluptatibus expedita molestias beatae tempore tempora eos repellat ratione corporis dignissimos laborum', image: 'news2.jpg'},
                {title: 'Aliquid beatae! Atque officia repudiandae quos', content: 'Adipisci quaerat saepe id nostrum voluptatum dolores minima iusto unde laudantium suscipit illo aut exercitationem eveniet tempora?', image: 'news3.jpg'},
                {title: 'Delectus, vitae. Itaque repudiandae mollitia doloremqu', content: 'Dolorem adipisci voluptatibus expedita molestias beatae tempore tempora eos repellat ratione corporis dignissimos laborum', image: 'news1.jpg'},
                {title: 'Ipsum dolor sit amet consectetur orro facere fugiat', content: 'Dolorem adipisci voluptatibus expedita molestias beatae tempore tempora eos repellat ratione corporis dignissimos laborum', image: 'news2.jpg'},
                {title: 'Que officia repudiandae quosorem ipsum dolor sit amet consectetur', content: 'Dolorem adipisci voluptatibus expedita molestias beatae tempore tempora eos repellat ratione corporis dignissimos laborum', image: 'news3.jpg'},
            ]
        }
    },
}
</script>

<style lang="scss" scoped>
    .events_brief{
        padding: 10px;

        .v-card .v-image{
            border-radius: 6px !important;
        }
    }
</style>
