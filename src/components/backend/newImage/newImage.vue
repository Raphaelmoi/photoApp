<style src="./newImage.css"></style>
<template src="./newImage.html"></template>

<script>
import phpResponse from "@/components/backend/phpresponse/phpresponse.js";
import currentImgComponent from "@/components/backend/newImage/currentImgComp.vue";

const axios = require("axios");

export default {
  name: "App",
  data() {
    return {
      phpLink: "http://localhost/my-photos/src/php/index.php",
      newKeyword: null,
      selectedKeyWords: [],
      keywords: [],
      files: [],
      imageUrlList: [],
      legend: [],
      description: [],
      qttUtillisation: [],
      fileName: [],
      newKeywords: [],
      phpResponse: null,
      onClickAddKeyword: false,
      currentImg: 0,
      fileIsDeleted: [],
      imgAlreadyOnDb: []
    };
  },
  components: {
    phpResponse,
    currentImgComponent
  },
  created: function() {
    this.getKeyWordsFromServer();
    this.getImgDatasFromServer();
  },
  destroyed: function() {
    document.documentElement.style.setProperty("--circle-radius", "40vw");
  },
  computed: {
    nbrImageLeft: {
      get() {
        return this.nbrImageNeedKW();
      }
    }
  },

  methods: {
    isAlreadyOnDb(value = false) {
        if (value == false) {
          value = this.fileName[this.currentImg];
        }
        for (let i = 0; i < this.imgAlreadyOnDb.length; i++) {
          if (this.imgAlreadyOnDb[i] == value) {
            return true;
          }
        }
        return false;
    },

    missingImgKeywordMsg() {
      let val =
        "Chaque image doit être associée à au moins un diaporama.  Informations manquantes pour les images aux index suivants : ";

      for (let i = 0; i < this.selectedKeyWords.length; i++) {
        if (!this.isAlreadyOnDb(this.fileName[i])) {
          if (
            this.selectedKeyWords[i].length == 0 &&
            this.fileIsDeleted[i] === ""
          ) {
            val += "<br/>" + (i + 1);
          }
        }
      }
      this.$store.commit("increment", val);
    },
    confirmBeforeLeave() {
      if (this.legend.length !== 0) {
        let a = confirm("Etes vous sur de vouloir quitter sans sauvegarder ?");
        if (a) {
          this.$router.push({ name: "BackEndHome" });
        }
      } else {
        this.$router.push({ name: "BackEndHome" });
      }
    },
    nbrImageNeedKW() {
      let val = 0;
      
      for (let i = 0; i < this.selectedKeyWords.length; i++) {
        if (!this.isAlreadyOnDb(this.fileName[i])) {
          if (
            this.selectedKeyWords[i].length == 0 &&
            this.fileIsDeleted[i] === ""
          ) {
            val++;
          }
        }
      }
      return val;
    },

    updateLegend(val) {
      this.legend = val;
    },
    updateDescription(val) {
      this.description = val;
    },
    uploadImgOnFront() {
      let actualLength =  this.files.length
      // this.files = this.$refs.myFiles.files;
      // this.files = []
      for (let i = 0; i < this.$refs.myFiles.files.length; i++) {
        this.files.push(this.$refs.myFiles.files[i])
      }
      for (let index = actualLength; index < this.files.length; index++) {
        // add empty array for each imported element
        this.selectedKeyWords.push([]);
        // associate legend
        this.legend.push("");
        this.description.push("");
        this.fileIsDeleted.push("");
        this.qttUtillisation.push(0);
        this.fileName.push(this.files[index].name)
        // url list image
        this.imageUrlList.push(URL.createObjectURL(this.files[index]));
      }
      document.documentElement.style.setProperty("--circle-radius", "45vw");
      //faire message erreur si 0
    },

    deleteImg() {
      if (this.fileIsDeleted[this.currentImg] === "") {
        this.$set(this.fileIsDeleted, this.currentImg, "deleted");
      } else {
        this.$set(this.fileIsDeleted, this.currentImg, "");
      }
    },
    getKeyWordsFromServer() {
      let req = this.phpLink + "?action=getKeyWords";
      return axios
        .get(req)
        .then(response => {
          for (let index = 0; index < response.data.length; index++) {
            this.keywords.push([
              response.data[index].keywords,
              response.data[index].id
            ]);
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
          this.imgAlreadyOnDb = [];
          for (let i = 0; i < response.data.length; i++) {
            this.imgAlreadyOnDb.push(response.data[i].title);
          }
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    onClicPrepareDataBeforeSending() {
      let tableau = [];
      tableau.push({ newKeywords: this.newKeywords });
      for (let index = 0; index < this.files.length; index++) {
        if (this.fileIsDeleted[index] === "") {
          tableau.push({
            name: this.files[index].name,
            legend: this.legend[index],
            description: this.description[index],
            keyword: this.selectedKeyWords[index],
            qttUtillisation: this.selectedKeyWords[index].length
          });
        }
      }
      var json_arr = JSON.stringify(tableau);
      this.sendToServer(json_arr);
      this.$store.commit(
        "increment",
        "Les nouvelles images ont bien été télécharger"
      );

      this.$router.push({ name: "BackEndHome" });
    },

    sendToServer(tableau) {
      let formData = new FormData();
      formData.append("datas", tableau);
      for (var i = 0; i < this.files.length; i++) {
        if (this.fileIsDeleted[i] === "") {
          let file = this.files[i];
          // let file = this.$refs.myFiles.files[i];
          formData.append("files[" + i + "]", file);
        }
      }
      console.log("...formData : ");
      console.log(...formData);

      let req = this.phpLink + "?action=newdatas";

      axios
        .post(req, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => (this.phpResponse = response.data))
        .catch(function(error) {
          console.log(error);
        });
    },

    createNewKeyWord(closePanel) {
      if (this.newKeyword !== null && this.newKeyword !== "") {
        //this.keyword = la liste lu en front, ajoute le mot sans refaire requte php
        //new.keywords, mots a ajouter avec les nvelles photos requete php
        if (
          this.keywords.indexOf(this.newKeyword) < 0 &&
          this.newKeywords.indexOf(this.newKeyword) < 0
        ) {
          this.keywords.push([this.newKeyword, this.keywords.length + 1]);
          this.newKeywords.push(this.newKeyword);
        }
      }
      // this.newKeyword = null;
      if (closePanel) {
        this.onClickAddKeyword = !this.onClickAddKeyword;
      }
      this.newKeyword = "";
    },
    //Fleches
    next(direction) {
      let nextvalue = this.currentImg + direction;
      if (nextvalue >= this.legend.length) {
        this.currentImg = 0;
      } else if (nextvalue < 0) {
        this.currentImg = this.legend.length - 1;
      } else {
        this.currentImg = nextvalue;
      }
    }
  }
};
</script>
