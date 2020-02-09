<style src="./newImage.css"></style>
<template src="./newImage.html"></template>

<script>
const axios = require('axios')

export default {
  name: 'App',
  data () {
    return {
      phpLink : 'http://localhost/my-photos/src/php/index.php',
      newKeyword: null,
      selectedKeyWords: [],
      keywords: [],
      files: [],
      imageUrlList: [],
      legend: [],
      description: [],
      newKeywords: [],
      phpResponse: null,
      onClickAddKeyword: false,
      currentImg: 0,
      fileIsDeleted: [],
      // activeNav: true
    }
  },
  mounted : function() {
    this.getKeyWordsFromServer();
  },
  destroyed : function() {
        document.documentElement.style.setProperty('--circle-radius', '40vw');
  },
  methods: {

    uploadImgOnFront () {
      this.files = this.$refs.myFiles.files
      for (let index = 0; index < this.files.length; index++) {
        // add empty array for each imported element
        this.selectedKeyWords.push([])
        // associate legend
        this.legend.push('')
        this.description.push('')
        this.fileIsDeleted.push('')
        // url list image
        this.imageUrlList.push(URL.createObjectURL(this.files[index]))

      }
        document.documentElement.style.setProperty('--circle-radius', '45vw');

    },   
    //set or unset a keyworf for an image
    addKeyWord (imgId, keyword) {
      let id = parseInt(keyword[1]);
      let value = this.selectedKeyWords[imgId].indexOf(id)
      if (value >= 0) {
        this.selectedKeyWords[imgId].splice(value, 1)
      } else {
        this.selectedKeyWords[imgId].push(id)
      }
    },

    deleteImg(){
      if(this.fileIsDeleted[this.currentImg] === ''){
        this.fileIsDeleted[this.currentImg] = 'deleted';
        this.next(1)
      }
      else {
        this.fileIsDeleted[this.currentImg] = '';
        //tricks to re -render the view
        this.next(-1)
        this.next(1)
      }
    },
    getKeyWordsFromServer(){
      let req = this.phpLink + '?action=getKeyWords'
      return axios.get(req)
        .then((response) => {
        for (let index = 0; index < response.data.length; index++) {
          this.keywords.push([response.data[index].keywords, response.data[index].id])
        }
      })
        .catch(function (error) {
          console.log(error)
        });
    },

    onClicPrepareDataBeforeSending () {
      let tableau = []
      tableau.push({ newKeywords: this.newKeywords })
      for (let index = 0; index < this.files.length; index++) {
          if( this.fileIsDeleted[index] === "") {

            tableau.push({
              name: this.files[index].name,
              legend: this.legend[index],
              description: this.description[index],
              keyword: this.selectedKeyWords[index]
            })
          }
      }
      var json_arr = JSON.stringify(tableau);
      this.sendToServer(json_arr);
    },
    
    sendToServer(tableau) {
        let formData = new FormData();
        formData.append('datas', tableau);
        for( var i = 0; i < this.files.length; i++ ){
          if( this.fileIsDeleted[i] === "") {
            let file = this.$refs.myFiles.files[i];
            formData.append('files[' + i + ']', file);
          }
            
        }
        console.log(...formData);

        axios.post( this.phpLink, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            },
          })
        .then(response => (this.phpResponse = response.data))
        .catch(function (error) {
          console.log(error)
        })
    },

    createNewKeyWord () {
      if (this.newKeyword !== null && this.newKeyword !== '') {
        //this.keyword = la liste lu en front, ajoute le mot sans refaire requte php
        //new.keywords, mots a ajouter avec les nvelles photos requete php
        if (
          this.keywords.indexOf(this.newKeyword) < 0 &&
          this.newKeywords.indexOf(this.newKeyword) < 0
        ) {
          this.keywords.push([this.newKeyword, this.keywords.length+1])
          this.newKeywords.push(this.newKeyword)
          // console.log(this.keywords)
        }
      }
      this.onClickAddKeyword = !this.onClickAddKeyword;
    },
    //Fleches
    next(direction) {
      let nextvalue = this.currentImg + (direction);
      console.log(this.currentImg)
      console.log(nextvalue)
      if( nextvalue >= this.legend.length ){
        this.currentImg = 0;
      }else if ( nextvalue < 0) {
        this.currentImg = this.legend.length - 1;
      } else {
        this.currentImg = nextvalue;
      }
    },
    //return different class name depend if a keyword is selected or not
    getClass (imgId, id) {
      id = parseInt(id);
      if (this.selectedKeyWords[imgId].indexOf(id) >= 0) {
        return 'keyword selected'
      } else {
        return 'keyword '
      }
    },
    //class for the div who contain each an image and inputs
    getClassForCurrentEl( id ){
      if( this.currentImg == id ){
        return 'containerImage'
      }
      else return 'hide'
    },
  }
}
</script>
