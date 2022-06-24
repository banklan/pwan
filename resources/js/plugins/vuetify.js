import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const opts = {
    theme:{
         themes: {
            light: {
                // primary: '#3E4095',
                primary: '#001659',
                primary_variant: '#3E4095',
                secondary: '#E20000',
                footer_text: '#9ca5af',
                dark: '#080814',
                admin_a: '#7a1893',
                admin_b: '#157868',
                admin_c: '#020070',
                admin_d: '#27aadd',
                admin_e: '#058d76',
                admin_f: '#017724',
                admin_g: '#e35c0e',
                admin_h: '#555a01',
                admin_i: '#006611',
                admin_j: '#310d89',
                green_text: '#00ad07',
                grey_text: '#404040'
            },
        },
    }
}

export default new Vuetify(opts)
