<template>
  <draggable v-model="imageList" @end="sendToParents">
    <transition-group class="imgSquare">
      <article
        v-for="(image, index) in  imageList"
        v-bind:key="`image-${index}`"
        v-on:click="zoomOnImg(index)"
        :class="getImgSqureClass(index)"
      >
        <img :src="require('@/assets/images/'+ imageList[index].title)" />
        <div class="imgPanel">
          <input type="checkbox" />
          <i class="fas fa-retweet fa-2x"></i>
          <i class="fas fa-trash fa-2x"></i>
        </div>
      </article>
    </transition-group>
  </draggable>
</template>

<script>
import draggable from "vuedraggable";

export default {
  name: "listimgVueComponent",
  props: ["imgList", "currentTitle"],
  components: {
    draggable
  },
  data() {
    return {
        // imageList: this.imgList
    };
  },
  computed: {
        imageList: {
            get() {
                return this.imgList;
            },
            set(newVal) {
                this.$emit('setImgOrder', newVal);
            }
        }
    },
  methods: {
    getImgSqureClass(index) {
      if (this.currentTitle == this.imageList[index].title) {
        return "selectedImg";
      }
      if (this.imageList[index].alt == "") {
        return "missingAlt";
      }
    },
    // show image on his index on slideshow
    zoomOnImg(index) {
      this.$emit("setCategory");
      this.$emit("setCurrentImg", index);
    },
    sendToParents(){
        this.$emit('ismodified'); 
    }
  }
};
</script>


<style>
.imgSquareContainer {
  width: 100%;
  height: 100%;
}
.imgSquare {
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  width: 100%;
  max-height: 93vh;
  /* background: teal; */
  overflow-y: auto;
}
.imgSquare article {
  width: 18%;
  height: 30vh;
  margin: 1%;
  object-fit: cover;
  overflow: hidden;
  position: relative;
}
.imgSquare img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top left;
  transition: all 3s ease;
  cursor: grab;
  cursor: -webkit-grab;
  cursor: -moz-grab;
}
.imgSquare article:active {
  cursor: grabbing;
  cursor: -webkit-grabbing;
  cursor: -moz-grabbing;
  box-shadow: 0 0 0 3px white;
  opacity: 0.2;
  /* transition: all 1s ease-in */
}
.imgSquare img:hover {
  object-position: bottom right;
  transition: all 1s ease;
}
.imgSquare > div:hover .imgPanel {
  display: flex;
}

.imgPanel {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  width: 20%;
  background: rgba(255, 255, 255, 0.6);
  /* display: flex; */
  flex-direction: column;
  justify-content: space-around;
  align-items: center;
  display: none;
  transition: all 1s ease;
}
.imgPanel i {
  margin: 8px 0;
}
.selectedImg {
  /* border: 2px white solid; */
  box-shadow: 0 0 0 5px lightseagreen;
}
.missingAlt {
  box-shadow: 0 0 0 1px tomato;
}
</style>