<style src="./imageByCategory.css" scoped></style>
<template src="./imageByCategory.html"></template>

<script>
import listimgVueComp from "@/components/backend/allImagesView/imageByCategory/listimgVueComp.vue";
import oneImgComp from "@/components/backend/allImagesView/imageByCategory/oneImgComp.vue";

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
      dataToSendToServer: false,
      SendFullKWTable: false,
      modifyTitle: false,
      phpResponse: "",
      keywords: []
    };
  },
  components: {
    phpResponse,
    listimgVueComp,
    oneImgComp
  },
  mounted: function() {
    this.getImgDatasFromServer();
    this.getKeyWordsFromServer();

    this.currentKeywordDatas = this.$route.params.selectedKeyword;
    let imageNames = this.currentKeywordDatas[2].split("|");
    this.currentKeywordDatas[2] = imageNames;
  },
  created: function() {},

  methods: {
    setCurrentImgFromComponent(id) {
      return this.currentImg = id;
    },
    setImgOrderFromComponent(array){
      return this.imageDatas = array;
    },
    updateImageListFromComp(array){ 
      return this.imageDatas = array;
    },
    updateKeywordDataFromComponent(array){
      return this.currentKeywordDatas = array
    },
    updateAllKeywordsFromComponent(array){
      if (!this.dataToSendToServer ) {
        this.dataToSendToServer = true;
      }
      return this.keywords = array;
    },
    
    deleteDiaporama() {
      if (
        confirm(
          "Etes vous sur de vouloir supprimer ce diaporama ? Cette action est irréverssible"
        )
      ) {
        //rajouter id de toutes les images pour leur soustraire 1 ds champs nbr_utilisation
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
    updateKeywordsTable() {
      let arrayToSend = this.keywords;

      for(let item of arrayToSend) {
        let newArray = "";
        for (let i = 0; i < item[2].length; i++) {
          if (i === 0) {
            newArray += item[2][i];
          } else newArray += "|" + item[2][i];
        }
        item[2] = newArray;
      }

      let formData = new FormData();
      formData.append(
        "fullKeywordTable",
        JSON.stringify(arrayToSend)
      );

      let req = this.phpLink + "?action=updateFullKWTable";
      axios
        .post(req, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(
          response => (
            (this.phpResponse = response.data)
          )
        )
        .catch(function(error) {
          console.log(error);
        });
     },



    updateThisDiapo() {
      if(this.SendFullKWTable){
        this.updateKeywordsTable();
      }
      // recuperer nvelle ordre des images

      let newArray = "";
      for (let i = 0; i < this.imageDatas.length; i++) {
        if (i === 0) {
          newArray += this.imageDatas[i].title;
        } else newArray += "|" + this.imageDatas[i].title;
      }
      this.currentKeywordDatas[2] = newArray;
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
        })
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
          this.imageDatas = nextarr;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
  }
};
</script>
