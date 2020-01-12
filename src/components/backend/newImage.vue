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
      phpResponse: null
    }
  },
  mounted : function() {
    this.getKeyWordsFromServer();
  },
  methods: {

    
    previewFiles () {
      this.files = this.$refs.myFiles.files
      // console.log(this.files[0].name)

      for (let index = 0; index < this.files.length; index++) {
        // add empty array for each imported element
        this.selectedKeyWords.push([])
        // associate legend
        this.legend.push('')
        this.description.push('')
        // url list image
        this.imageUrlList.push(URL.createObjectURL(this.files[index]))
      }
    },

    sendPicturesToServer () {
      let tableau = []
      tableau.push({ newKeywords: this.newKeywords })
      for (let index = 0; index < this.files.length; index++) {
        tableau.push({
          name: this.files[index].name,
          legend: this.legend[index],
          description: this.description[index],
          keyword: this.selectedKeyWords[index]
        })
      }
      var json_arr = JSON.stringify(tableau);
      this.submitFiles(json_arr);
    },
    submitFiles(tableau) {
        let formData = new FormData();
        formData.append('datas', tableau);
        for( var i = 0; i < this.files.length; i++ ){
            let file = this.$refs.myFiles.files[i];
            formData.append('files[' + i + ']', file);
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
        if (
          this.keywords.indexOf(this.newKeyword) < 0 &&
          this.newKeywords.indexOf(this.newKeyword) < 0
        ) {
          this.keywords.push(this.newKeyword)
          this.newKeywords.push(this.newKeyword)
        }
      }
    },
    addKeyWord (imgId, keyword) {
      let id = parseInt(keyword[1]);
      let value = this.selectedKeyWords[imgId].indexOf(id)
      if (value >= 0) {
        this.selectedKeyWords[imgId].splice(value, 1)
      } else {
        this.selectedKeyWords[imgId].push(id)
      }
    },
    //return different class name depend if the item is selected or not
    getClass (imgId, id) {
      id = parseInt(id);
      if (this.selectedKeyWords[imgId].indexOf(id) >= 0) {
        return 'keyword selected'
      } else {
        return 'keyword '
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
    }

  }
}
</script>
