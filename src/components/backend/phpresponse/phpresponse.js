// import Vue from 'vue';
export default {
    name: 'phpResponse',
    props: ['reponse'],
    computed: {
        theReponse: {
            get() {
                return this.reponse;
            },
            set(newVal) {
                this.$emit('resetReponse', newVal);
            }
        },
    },
    template: `<div v-html="theReponse" style="background:white" @click="theReponse=''"></div>`
}

