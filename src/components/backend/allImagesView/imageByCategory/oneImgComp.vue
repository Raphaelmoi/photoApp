<template>
  <article class="imgAlone" v-on:mouseup="toggleFalse">
    <div class="imgSide">
      <b v-on:click="$emit('setCategory')" class="pointer">X</b>
      <div class="navImg navLeft" v-on:click="navDiapo(-1)">
        <i class="fas fa-arrow-circle-left fa-3x"></i>
      </div>
      <div class="navImg navRight" v-on:click="navDiapo(1)">
        <i class="fas fa-arrow-circle-right fa-3x"></i>
      </div>

      <img
        v-for="(image, index) in imageList"
        :key="image.id"
        :src="require('../../../../public/images/'+ imageList[index].title)"
        v-bind:class="currentImg==index ? '' : 'hide'"
      />
    </div>

    <aside class="myAside" v-on:mouseup="toggleFalse">
      <div
        class="controlBar"
        v-on:mousedown="toggleTrue"
        v-on:mouseup="toggleFalse"
        v-on:mousemove="grabTheBar"
      ></div>
      <h5>Nom de l'image :</h5>
      <h4>{{ imageList[currentImg].title }}</h4>
      <h5>Legende :</h5>
      <div class="inputBox">
        <p v-if="!listStatus">{{ imageList[currentImg].legend }}</p>
        <input
          v-if="listStatus"
          type="text"
          v-model="imageList[currentImg].legend"
          value="imageList[currentImg].legend"
        />
        <button
          v-if="!listStatus"
          v-on:click="declareChange"
        >
          <i class="fas fa-pen"></i>

        </button>
      </div>

      <h5>Balise alt</h5>
      <div class="inputBox">
        <p v-if="!listStatus">{{ imageList[currentImg].alt }}</p>
        <input
          v-if="listStatus"
          type="text"
          v-model="imageList[currentImg].alt"
          value="imageList[currentImg].alt"
        />
        <button
          v-if="!listStatus"
          v-on:click="declareChange"
        >
          <i class="fas fa-pen"></i>
        </button>
      </div>

      <div
        :key="fakerender"
        v-bind:class="currentKeywordDatas[3]== imageList[currentImg].title  ? 'firstPicture activeBtn' : 'firstPicture'"
        v-on:click="currentKeywordDatas[3] = imageList[currentImg].title; fakerender+=1"
      >
        <p>Image à la une</p>
      </div>
      <div
        class="firstPicture deleteImage"
        style="border-color:tomato;"
        @click="deleteImgFromDiapo(currentImg)"
      >
        <p>
          <i class="fas fa-trash"></i>Supprimer cette image dans ce diaporama
        </p>
      </div>

      <keywordComponent  
        :keywords="keywords"
        :imgname="imageList[currentImg].title" 
        :diapoName="currentKeywordDatas[0]"
        v-on:isModified="declareChange" 
        >
      </keywordComponent>

    </aside>
  </article>
</template>

<script>
import keywordComponent from "@/components/backend/allImagesView/imageByCategory/keywordsComp.vue";

export default {
    data() {
        return {
        isHandlerDragging: false,
        fakerender: 0,
        keywordsSendToServer: false,
        };
    },
    props: ["imgList", "currentImage", 'listStatus', 'currentKWData', 'allKeywords'],

    components: {
        keywordComponent, 
    },
    computed: {
        imageList: {
            get() {
                return this.imgList;
            },
            set(newVal) {
                this.$emit('updateImageList', newVal);
            }
        },
        currentImg: {
            get() {
                return this.currentImage;
            },
            set(newVal) {
                this.$emit('setCurrentImg', newVal);
            }
        },
        currentKeywordDatas: {
            get() {
                return this.currentKWData;
            },
            set(newVal) {
                this.$emit('updateKeywordData', newVal);
            }
        },
        keywords: {
            get(){
                return this.allKeywords;
            },
            set(newVal){
                this.$emit('updateAllKeywords', newVal);
            }
        }
    },
    methods: {
        declareChange(){
            this.$emit('ismodified'); 
        },
        //diaporama navigation
        deleteImgFromDiapo(id) {
          if (
            confirm(
              "Etes vous sur de vouloir supprimer cette image de ce diaporama? Cette action est irréverssible"
            )
          ) {
            let oldTitle = this.imageList[id].title;
            this.imageList.splice(id, 1);
            this.currentKeywordDatas[2] = this.imageList;
            // change the main image if it was the deleted img
            if (this.currentKeywordDatas[3] === oldTitle) {
              this.currentKeywordDatas[3] = this.imageList[0].title;
            }
            this.declareChange();
            this.$emit('setCategory')
          }
        },
        navDiapo(direction) {
            let nextvalue = this.currentImg + direction;
            if (nextvalue >= this.currentKeywordDatas[2].length) {
                this.currentImg = 0;
            } else if (nextvalue < 0) {
                this.currentImg = this.currentKeywordDatas[2].length - 1;
            } else {
                this.currentImg = nextvalue;
            }
        },
        // state for grabbing the bar
        toggleTrue() {
            this.isHandlerDragging = true;
        },
        toggleFalse() {
            this.isHandlerDragging = false;
        },
        grabTheBar() {
            var e = e || window.event;
            let bar = document.getElementsByClassName("controlBar")[0];
            let leftSide = document.getElementsByClassName("imgSide")[0];
            let rightSide = document.getElementsByClassName("myAside")[0];

            if (this.isHandlerDragging && e.target === bar) {
                console.log(e);
                let x = e.pageX;
                let screenWidth =
                window.innerWidth ||
                document.documentElement.clientWidth ||
                document.body.clientWidth;

                let percentageX = (x * 100) / screenWidth;
                percentageX = Math.round(percentageX * 100) / 100;
                if (percentageX <= 100 && percentageX >= 0) {
                leftSide.style.width = percentageX + "%";
                rightSide.style.width = 100 - percentageX + "%";
                }
            }
        },
        
    }
}
</script>

<style scoped>

.imgAlone {
  display: flex;
  height: 93vh;
}
.imgSide {
  /* flex: 3; */
  width: 75%;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}
.imgSide img {
  max-width: 90%;
  max-height: 90%;
  object-fit: contain;
}
.imgSide b {
  color: aliceblue;
  font-size: 2rem;
  position: absolute;
  top: 2rem;
  right: 2rem;
}
.navImg {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  color: #FFFFFFcc;
  cursor: pointer;
  border-radius: 50%;
  transition: all .3s ease;
}
.navImg:hover {
  color: #FFF;
  transition: all 1s ease;

}
.navLeft {
  left: 2rem;
}
.navRight {
  right: 2rem;
}
.imgAlone aside {
  width: 25%;
  background: white;
  background-color: rgba(255, 255, 255, 0.8);
  padding: 1rem;
  position: relative;
}
.fas {
  cursor: pointer;
}

.btnSettings {
  position: relative;
}
.btnSettings>a {
 transition: all .3s ease;
}
.btnSettings>a:hover {
  color: tomato;
  transition: all 1s ease;
}
.panel {
  position: absolute;
  top: 0;
  right: -100%;
  width: 350px;
  /* width: 10vw;
    height: 10vh; */
  border-radius: 8px;
  /* border: 1px black solid; */
  border-top-right-radius: 0;
  background-color: white;
  margin: 30px;
  z-index: 1;
  padding: 1rem;
  display: flex;
  justify-content: space-around;
}
.panel a {
  color: black;
}
.arrow-up {
  position: absolute;
  right: 5px;
  top: -10px;
  width: 0;
  height: 0;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  border-bottom: 10px solid white;
}
.controlBar {
  /* background-color: rgb(17, 122, 117); */
  border-left: 8px rgb(17, 122, 117) solid;
  position: absolute;
  font-weight: bold;
  top: 0;
  bottom: 0;
  left: 0;
  width: 40px;
  cursor: grab;
}
.controlBar:active {
  cursor: grabbing;
  border-left: 12px rgb(17, 122, 117) solid;
}
.myAside h4,
.myAside h5,
.myAside p {
  margin: 0;
}
.inputBox {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.inputBox p {
  flex: 3;
  /* background-color: lightblue; */
  height: 100%;
}
.inputBox button {
  /* flex: 1; */
  border: none;
  background: cadetblue;
  color: white;
  font-size: 1rem;
  padding: 0.8rem;
  cursor: pointer;
}
.inputBox input {
  flex: 3;
  padding: 0.5rem 0.4rem;
  margin-right: 4px;
  border: 2px cadetblue solid;
  background-color: transparent;
  color: rgb(27, 77, 74);
  font-size: 0.9rem;
}

.firstPicture {
  /* background-color: lightslategray; */
  color: black;
  /* width: fit-content; */
  padding: 0.5rem;
  text-align: center;
  border: 1px cadetblue solid;
  border-radius: 4px;
  margin: 0.5rem 0;
  cursor: pointer;
  transition: all .3s ease;

}
.firstPicture:hover {
  background-color: cadetblue;
  transition: all .3s ease;

}
.activeBtn {
  background-color: cadetblue;
  color: white;
}
.deleteImage {
  transition: all .3s ease;
}
.deleteImage:hover {
  background-color: tomato;
  /* color: white; */
  transition: all 1s ease;
}
</style>