<template >
  <section class="myBody">

    <div class="giantCircle">
      <div class="centerCircle" >

        <router-link to="/backend" class="navItem backBtn retourBtn">
          <i class="fas fa-arrow-circle-left backFa"></i>
          Retour
        </router-link>

        <div class="right arrowUp " v-on:click="navButtons(-1)"    >       
          <i class="fas fa-arrow-circle-up backFa"></i>
        </div>

        <router-link
          v-for="(keyword, index) in keywords"
          :key="index"
          :class="classNameDispatcher[index]"
          :to="{ name: 'imageByCategory', params: { id: keyword[0], selectedKeyword: keyword }}"
          v-on:mouseover.native="mouseOver(keyword[3])"
          @mouseleave.native="mouseLeave"
        >
          {{ keyword[0] }}
        </router-link>

        <div class="right arrowDown" v-on:click="navButtons(1)">
          <i class="fas fa-arrow-circle-down backFa"></i>
        </div>

      </div>
    </div>

  </section>
</template>

<script>
const axios = require("axios");

// import AxiosMixin from '@/mixins/axios.js'

export default {
  // name: "HelloWorld",
  // mixins: [AxiosMixin],

  data() {
    return {
      phpLink: "http://localhost/my-photos/src/php/index.php",
      keywords: [],
      classNameDispatcher: [],
      imageForKeyword: [],
      position: 0,
      nbrOfButton: 9,
      classNameBtns: "navItem right itemR"
    };
  },
  mounted: function() {
   this.getKeyWordsFromServer();
  },
  methods: {
    getKeyWordsFromServer() {
      let req = this.phpLink + "?action=getKeyWords";
      return axios
        .get(req)
        .then(response => {
          for (let index = 0; index < response.data.length; index++) {
            this.keywords.push([
              response.data[index].keywords,
              response.data[index].id,
              response.data[index].imageName,
              response.data[index].main_image
            ]);
            

            if (index <= this.nbrOfButton - 1) {
              this.classNameDispatcher.push(this.classNameBtns + index);
            } else {
              this.classNameDispatcher.push("hide");
            }
            // console.log(response.data[index].imageName);
          }
          this.imageForKeyword = response.data[2].imageName.split("|");
            // console.log(this.imageForKeyword);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    navButtons(direction) {
      if (direction === 1) {
        let a = this.keywords.shift();
        this.keywords.push(a);
      } else {
        let b = this.keywords.pop();
        this.keywords.unshift(b);
      }
    },

    mouseOver: function(imageName) {
      // console.log(imageName)
      let a = require('@/assets/images/' + imageName)
      let url =
        "no-repeat 100% 100% url(" + a +")";
        
      // let url =
      //   "no-repeat 100% 100% url('https://raphaelmouly.com/photo/image/TOP/top03" +
      //   index +
      //   ".jpg')";
        
      document.getElementsByClassName("giantCircle")[0].style.background = url;
      document.getElementsByClassName("giantCircle")[0].style.backgroundSize =
        "cover";
    },
    mouseLeave: function() {
      document.getElementsByClassName("giantCircle")[0].style.background = "";
    }
  }
};
</script>

<style scoped>
.imageView {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: #1c313a;
  display: none;
}
</style>
