// import Vue from 'vue';
export default {
    name: 'phpResponse',
  

    props: ['reponse'],
    template: `<div v-html="reponse" style="background:white" @click="reponse=''"></div>`
}

