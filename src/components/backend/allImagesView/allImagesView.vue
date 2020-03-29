<template >
  <section class="myBody">
    <div class="giantCircle">
      <div class="centerCircle">
        <router-link to="/backend" class="navItem backBtn retourBtn">
          <i class="fas fa-arrow-circle-left backFa"></i>
          Retour
        </router-link>

        <a
          class="navItem item2"
          @click="onClickAddKeyword = !onClickAddKeyword"
        >creer un nouveau diapo</a>

        <newKeyWordComp
          :isOpen.sync="onClickAddKeyword"
          cssPosition="item3"
          :sendToServer="true"
          v-on:change="setClassRightBtns"
        ></newKeyWordComp>

        <div class="right arrowUp" v-on:click="navButtons(-1)">
          <i class="fas fa-arrow-circle-up backFa"></i>
        </div>

        <router-link
          v-for="(keyword, index) in $store.state.keywordTable"
          :key="index"
          :class="classNameDispatcher[index]"
          :to="{ name: 'imageByCategory', params: { id: keyword.keywords}}"
          @mouseover.native="mouseOver(keyword.main_image)"
          @mouseleave.native="mouseLeave"
        >{{ keyword.keywords }}</router-link>

        <div class="right arrowDown" v-on:click="navButtons(1)">
          <i class="fas fa-arrow-circle-down backFa"></i>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import newKeyWordComp from "@/components/backend/newKeyWordComp.vue";

export default {
  data() {
    return {
      classNameDispatcher: [],
      nbrOfButton: 9,
      classNameBtns: "navItem right itemR",
      onClickAddKeyword: false
    };
  },
  components: {
    newKeyWordComp
  },
  watch: {},
  mounted: function() {
    this.setClassRightBtns();
  },
  methods: {
    navButtons(direction) {
      if (direction === 1) {
        let a = this.classNameDispatcher.shift();
        this.classNameDispatcher.push(a);
      } else {
        let b = this.classNameDispatcher.pop();
        this.classNameDispatcher.unshift(b);
      }
    },

    mouseOver: function(imageName) {
      if (imageName) {
        let a = require("@/assets/images/" + imageName);
        let url = "no-repeat 100% 100% url(" + a + ")";

        document.getElementsByClassName(
          "giantCircle"
        )[0].style.background = url;
        document.getElementsByClassName("giantCircle")[0].style.backgroundSize =
          "cover";
      } else {
        document.getElementsByClassName("giantCircle")[0].style.background =
          "rgba(255,255,255,0.3)";
      }
    },
    mouseLeave: function() {
      document.getElementsByClassName("giantCircle")[0].style.background = "";
    },

    setClassRightBtns() {
      console.log(this.$store.state.loading);

      this.classNameDispatcher = [];
      for (
        let index = 0;
        index < this.$store.state.keywordTable.length;
        index++
      ) {
        if (index <= this.nbrOfButton - 1) {
          this.classNameDispatcher.push(this.classNameBtns + index);
        } else {
          this.classNameDispatcher.push("hide");
        }
      }
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
