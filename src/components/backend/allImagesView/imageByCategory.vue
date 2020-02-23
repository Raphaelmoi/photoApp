<template>
  <section class="myBody mainContainer">
    <router-link to="/allImages" class="navItem backBtn retour">
      <i class="fas fa-arrow-circle-left backFa"></i>
      Retour
    </router-link>

    <div class="head">
      <a v-if="dataToSendToServer" class="validationBtn" @click="sendUpdatedDatas"> Validez les modifications</a>

      <h1 @dblclick="modifyTitle = !modifyTitle; dataToSendToServer=true" v-if="!modifyTitle">{{ currentKeywordDatas[0] }}</h1>
      <input v-if="modifyTitle"             
        v-model="currentKeywordDatas[0]"
        value="currentKeywordDatas[0]" />
      <div>
        <a v-bind:class="category==0 ? 'active' : ''" v-on:click="category = 0">
          <i class="fas fa-th fa-2x"></i>
        </a>
        <a v-bind:class="category==1 ? 'active' : ''" v-on:click="category = 1">
          <i class="fas fa-image fa-2x"></i>
        </a>
        <a>
          <i class="fas fa-bars fa-2x"></i>
        </a>
      </div>
      <div class="btnSettings">
        <a v-on:click="settingPanel = !settingPanel">
          <i class="fas fa-trash fa-2x"></i>
        </a>
        <div v-bind:class="settingPanel ? 'panel' : 'hide'">
          <div class="arrow-up"></div>
          <a style="color:red">
            <i class="fas fa-trash"></i>
            Supprimez le diaporama
            <span style="font-weight: bold;">"{{ currentKeywordDatas[0] }}"</span>
          </a>
          <a style="color:cadetblue" @click="settingPanel = !settingPanel">Annuler</a>
        </div>
      </div>
    </div>
  <div v-html="phpResponse" style="background:white"></div>


    <!-- https://github.com/SortableJS/Vue.Draggable -->
    <draggable v-model="imageDatas" v-if="category == 0" >
      <transition-group  class="imgSquare"> 
        <article v-for="(image, index) in  imageDatas"
          v-bind:key="index"
          v-on:click="zoomOnImg(index)"
          :class="getImgSqureClass(index)"
        >
          <!-- <img :src="image" /> -->
          <!-- <img :src="getImg(image)" /> -->
          <img :src="require('../../../public/images/'+ imageDatas[index].title)" />
          <div class="imgPanel">
            <input type="checkbox" />
            <i class="fas fa-retweet fa-2x"></i>
            <i class="fas fa-trash fa-2x"></i>
          </div>
        </article>

      </transition-group>
    </draggable>
        <!-- <div v-for="element in myArray" :key="element.id">
                {{element.name}}
        </div>-->
    <!-- <article class="imgSquare" v-if="category == 0">
      <div
        v-for="(image, index) in imageList"
        :key="image.id"
        v-on:click="zoomOnImg(index)"
        :class="getImgSqureClass(index)"
      >
        <img :src="image" />
        <div class="imgPanel">
          <input type="checkbox" />
          <i class="fas fa-retweet fa-2x"></i>
          <i class="fas fa-trash fa-2x"></i>
        </div>
      </div>
    </article> -->

    <article class="imgAlone" v-if="category == 1" v-on:mouseup="toggleFalse">
      <div class="imgSide">
        <b v-on:click="category = 0" class="pointer">X</b>
        <div class="navImg navLeft" v-on:click="navDiapo(-1)">
          <i class="fas fa-arrow-circle-left fa-4x"></i>
        </div>
        <div class="navImg navRight" v-on:click="navDiapo(1)">
          <i class="fas fa-arrow-circle-right fa-4x"></i>
        </div>

        <img
          v-for="(image, index) in imageDatas"
          :key="image.id"
          :src="require('../../../public/images/'+ imageDatas[index].title)" 
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
        <h4>{{ imageDatas[currentImg].title }}</h4>
        <h5>Legende :</h5>
        <div class="inputBox">
          <p v-if="!dataToSendToServer">{{ imageDatas[currentImg].legend }}</p>
          <input
            v-if="dataToSendToServer"
            type="text"
            v-model="imageDatas[currentImg].legend"
            value="imageDatas[currentImg].legend"
          />
          <button v-if="!dataToSendToServer" v-on:click="dataToSendToServer = true">modifier</button>
          <button v-if="dataToSendToServer" >Valider</button>
        </div>

        <h5>Balise alt</h5>
        <div class="inputBox">
          <p v-if="!dataToSendToServer">{{ imageDatas[currentImg].alt }}</p>
          <input
            v-if="dataToSendToServer"
            type="text"
            v-model="imageDatas[currentImg].alt"
            value="imageDatas[currentImg].alt"
          />
          <button v-if="!dataToSendToServer" v-on:click="dataToSendToServer = true">modifier</button>
          <button v-if="dataToSendToServer" >Valider</button>
        </div>

        <div
          :key="fakerender"
          v-bind:class="currentKeywordDatas[3]== imageDatas[currentImg].title  ? 'firstPicture activeBtn' : 'firstPicture'"
          v-on:click="currentKeywordDatas[3] = imageDatas[currentImg].title; fakerender+=1"
        >
          <p>Image à la une</p>
        </div>
        <div class="firstPicture" style="border-color:tomato;">
          <p>
            <i class="fas fa-trash"></i>Supprimer cette image dans ce diaporama
          </p>
        </div>
        <div class="firstPicture" style="border-color:tomato;">
          <p>
            <i class="fas fa-trash"></i>Supprimer cette image de tous les diaporamas
          </p>
        </div>
        <p>permettre modifs de mot clef</p>
        <P>ORAGNISER LES PHOtos dans la grille</P>
        <p>Mettre un btn de validation quand chnagement dans données à envoyé au serveur + message d'alerte</p>
        <p>faire un update dans tous les cas a chaque changement ?</p>
        <p>pouvoir modifier le titre d'un diaporama</p>
      </aside>
    </article>
  </section>
</template>

<script>
import draggable from "vuedraggable";

const axios = require("axios");

export default {
  data() {
    return {
      phpLink: "http://localhost/my-photos/src/php/index.php",
      category: 0, //set the kind of view
      currentKeywordDatas: [],
      currentImg: 0,
      imageDatas: [],
      settingPanel: false,
      isHandlerDragging: false,
      dataToSendToServer: false,
      fakerender: 0,
      modifyTitle: false,
      phpResponse: ''
    };
  },
  components: {
    draggable
  },
  mounted: function(){
    this.getImgDatasFromServer();
    this.currentKeywordDatas = this.$route.params.selectedKeyword;
    let imageNames = this.currentKeywordDatas[2].split("|");
    this.currentKeywordDatas[2] = imageNames;

    console.log(this.currentKeywordDatas);
  },
  created: function() {

  },

  methods: {
    sendUpdatedDatas(){
      // recuperer nvelle ordre des images
      let newArray ='';
      for (let i = 0; i < this.imageDatas.length; i++) {
        if (i === 0) {
        newArray += this.imageDatas[i].title                  
        }
        else 
          newArray += '|'+this.imageDatas[i].title      
      }
      // console.log('newArray')
      // console.log(newArray)
      this.currentKeywordDatas[2] = newArray;
      console.log('this.imageDatas')
      console.log(this.imageDatas)
      console.log('this.currentKeywordDatas')
      console.log(this.currentKeywordDatas)
      let formData = new FormData();
      formData.append('currentKeywordDatas', JSON.stringify(this.currentKeywordDatas));
      formData.append('imageDatas', JSON.stringify(this.imageDatas));

      let req = this.phpLink + "?action=updatediaporama";
      axios.post( req , formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
          })
        .then(response => (this.phpResponse = response.data))
        .catch(function (error) {
          console.log(error)
        })
    },

    getImgDatasFromServer() {
      let req = this.phpLink + "?action=getImages";
      return axios
        .get(req)
        .then(response => {
          // this.imageDatas = response.data;
          var parsedobj = JSON.parse(JSON.stringify(response.data))
          // console.log(parsedobj)
          // console.log(response.data)

          let nextarr = [];
          for (let i = 0; i < this.currentKeywordDatas[2].length; i++) {
            let b =-1;
            for (let j = 0; j < parsedobj.length; j++) {
              if (this.currentKeywordDatas[2][i] === parsedobj[j].title) {
                b = j;
              }
            }
            if (b !== -1) {
              nextarr.push(parsedobj[b]);
            }          
          }
          // console.log('nextarr')
          console.log(JSON.parse(JSON.stringify(nextarr)))
          this.imageDatas = nextarr;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    // show image on his index on slideshow
    zoomOnImg(index) {
      this.category = 1;
      this.currentImg = index;
    },
    //diaporama navigation
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
    toggleTrue() {
      console.log("togg true");
      this.isHandlerDragging = true;
    },
    toggleFalse() {
      console.log("togg fa");
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
    getImgSqureClass(index) {
      if (this.currentKeywordDatas[3] == this.imageDatas[index].title) {
        return "selectedImg";
      }
      if (this.imageDatas[index].alt == "") {
        return "missingAlt";
      }
    },
    getImg(image){
          return "/images/assto2.png"

      // var value = require.context('../assets/', false, /\.png$/)
      // return value('./' + image + ".png")
      // return (require("/src/assets/logo.png"))
      // return "https://raphaelmouly.com/photo/image/CANARIES/canaries001.jpg"
      // return image
    },
    // modifyTitle(){
    //   console.log('dsd')
    // }
  }
};
</script>

<style scoped>
.mainContainer {
  background: var(--bkg-color);
  position: absolute;
}
.head {
  display: flex;
  align-items: center;
  justify-content: space-around;
  padding-left: 12%;
  height: 7vh;
}
h1 {
  color: white;
  font-size: 2rem;
  margin: 0;
}
.retour {
  top: 8px;
  left: 8px;
}
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
  cursor:-webkit-grab;
  cursor:-moz-grab;
}
.imgSquare article:active {
    cursor: grabbing;
  cursor:-webkit-grabbing;
  cursor:-moz-grabbing;
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
.active {
  color: cadetblue;
}
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
  color: white;
  cursor: pointer;
  border-radius: 50%;
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
  flex: 1;
  border: none;
  background: cadetblue;
  color: white;
  font-size: 1rem;
  padding: 0.5rem;
  cursor: pointer;
}
.inputBox input {
  flex: 3;
  padding: 0.5rem 0.4rem;
  margin-right: 4px;
  border: 2px cadetblue solid;
  background-color: transparent;
  color: cadetblue;
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
}
.activeBtn {
  background-color: cadetblue;
  color: white;
}
.validationBtn {
  background: white;
  color: cadetblue;
  font-size: 1rem;
  border: 2px cadetblue solid;
  border-radius: 5px;
  padding: 0.5rem
}
</style>
