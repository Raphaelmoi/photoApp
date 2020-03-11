<style src="./imageByCategory.css" scoped></style>
<template src="./imageByCategory.html"></template>

<script>
import keywordComponent from "@/components/backend/allImagesView/imageByCategory/keywordsComp.vue";

import draggable from "vuedraggable";
// import phpResponse from './../../phpresponse/phpresponse.js'
import phpResponse from "@/components/backend/phpresponse/phpresponse.js";
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
      phpResponse: "",
      keywords: []
    };
  },
  components: {
    draggable,
    phpResponse,
    keywordComponent
  },
  mounted: function() {
    this.getImgDatasFromServer();
    this.getKeyWordsFromServer();

    this.currentKeywordDatas = this.$route.params.selectedKeyword;
    let imageNames = this.currentKeywordDatas[2].split("|");
    this.currentKeywordDatas[2] = imageNames;
    // console.log(this.currentKeywordDatas);
  },
  created: function() {},

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
              response.data[index].imageName.split("|")
            ]);
            // this.selectedKeyWords.push([]);
          }
          console.log(response);
          console.log(this.keywords);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    deleteDiaporama() {
      if (
        confirm(
          "Etes vous sur de vouloir supprimer ce diaporama de ce diaporama? Cette action est irréverssible"
        )
      ) {
        //rajouter id de toutes les images pour leur soustraire 1 ds champs nbr_utilisation
        console.log(this.currentKeywordDatas[1]);
        let formData = new FormData();
        formData.append("id", JSON.stringify(this.currentKeywordDatas[1]));
        formData.append("imageDatas", JSON.stringify(this.imageDatas));

        let req = this.phpLink + "?action=deleteFullDiaporama";
        axios
          .post(req, formData, {
            headers: {
              "Content-Type": "multipart/form-data"
            }
          })
          .then(
            response =>
              (window.location.href = "/AllImages?msg=" + response.data)
          )
          .catch(function(error) {
            console.log(error);
          });
      }
    },

    deleteImgFromDiapo(id) {
      if (
        confirm(
          "Etes vous sur de vouloir supprimer cette image de ce diaporama? Cette action est irréverssible"
        )
      ) {
        let oldTitle = this.imageDatas[id].title;
        this.imageDatas.splice(id, 1);
        this.currentKeywordDatas[2] = this.imageDatas;
        // change the main image if it was the deleted img
        if (this.currentKeywordDatas[3] === oldTitle) {
          this.currentKeywordDatas[3] = this.imageDatas[0].title;
        }

        this.category = 0;
        this.dataToSendToServer = true;
      }
    },

    sendUpdatedDatas() {
      // recuperer nvelle ordre des images
      let newArray = "";
      for (let i = 0; i < this.imageDatas.length; i++) {
        if (i === 0) {
          newArray += this.imageDatas[i].title;
        } else newArray += "|" + this.imageDatas[i].title;
      }
      // console.log('newArray')
      // console.log(newArray)
      this.currentKeywordDatas[2] = newArray;
      console.log("this.imageDatas");
      console.log(this.imageDatas);
      console.log("this.currentKeywordDatas");
      console.log(this.currentKeywordDatas);
      let formData = new FormData();
      formData.append(
        "currentKeywordDatas",
        JSON.stringify(this.currentKeywordDatas)
      );
      formData.append("imageDatas", JSON.stringify(this.imageDatas));

      let req = this.phpLink + "?action=updatediaporama";
      axios
        .post(req, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(
          response => (
            (this.phpResponse = response.data),
            (this.dataToSendToServer = false)
          )
        )
        .catch(function(error) {
          console.log(error);
        });
    },

    getImgDatasFromServer() {
      let req = this.phpLink + "?action=getImages";
      return axios
        .get(req)
        .then(response => {
          // this.imageDatas = response.data;
          var parsedobj = JSON.parse(JSON.stringify(response.data));
          // console.log(parsedobj)
          // console.log(response.data)

          let nextarr = [];
          for (let i = 0; i < this.currentKeywordDatas[2].length; i++) {
            let b = -1;
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
          console.log(JSON.parse(JSON.stringify(nextarr)));
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
    getImgSqureClass(index) {
      if (this.currentKeywordDatas[3] == this.imageDatas[index].title) {
        return "selectedImg";
      }
      if (this.imageDatas[index].alt == "") {
        return "missingAlt";
      }
    }
  }
};
</script>
