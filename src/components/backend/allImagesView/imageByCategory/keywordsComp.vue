<template>
  <section>
    <p>Cette image est présente dans les diaporamas suivant :</p>
    <div class="keywordBox">
      <div
        v-for="(keyword, index) in keywords"
        :class="getKeywordClass(keyword[2], keyword[0])"
        :key="index"
        @click="addKeyWord(index)"
      >{{ keyword[0] }}</div>
    </div>
    <p>
      faire: envoyer modifs bdd
    </p>
  </section>
</template>

<script>

export default {
  name: "keywordComponent",

  props: ["keywords", "imgname", "diapoName"],
  data() {
      return {
        datachanged: false
      }
  },
  methods: {
    //set or unset a keyword for an image
    addKeyWord(index) {
      let imgList = this.keywords[index][2];
      // console.log(this.keywords[index]);
      let isCurrentCategory = false;
      if (this.keywords[index][0] == this.diapoName) {
        isCurrentCategory = true;
      }
      let isAlreadyOnList = false;
      for (let i = 0; i < imgList.length; i++) {
        if (imgList.indexOf(this.imgname) >= 0) {
          isAlreadyOnList = true;
        }
      }
      if (isAlreadyOnList && isCurrentCategory) {
        let a = confirm(
          "Attention! cette action va supprimer l'image de ce diaporama"
        );
        if (a) {
          const indexOfImg = element => element == this.imgname;
          let id = this.keywords[index][2].findIndex(indexOfImg);
          this.keywords[index][2].splice(id, 1);
        }
      } else if (isAlreadyOnList) {
        const indexOfImg = element => element == this.imgname;
        let id = this.keywords[index][2].findIndex(indexOfImg);
        this.keywords[index][2].splice(id, 1);
        // alert('l-action supprime l-image de n-importe qu-elle diaporamas ?' );
      } else {
        this.keywords[index][2].push(this.imgname);
        console.log(this.keywords);
        // alert('l-actionajoute l-image au diaporama' );
      }
      this.datachanged=true;
      this.$emit('isModified')
    },
    //return different class name depend if a keyword is selected or not
    getKeywordClass(imagesList, diapo) {
      for (let i = 0; i < imagesList.length; i++) {
        if (imagesList.indexOf(this.imgname) >= 0) {
          if (diapo == this.diapoName) {
            return "keyword selectedCurrentDiapo";
          } else {
            return "keyword selected";
          }
        } else {
          return "keyword ";
        }
      }
    }
  }
};
</script>

<style scoped>
.keywordBox {
  display: flex;
  justify-content: center;
  margin: 1% 10%;
  flex-wrap: wrap;
}
.keyword {
  flex: 3;
  padding: 2px 10px;
  background-color: rgba(100, 100, 100, 1);
  border: none;
  color: #111;
  outline: none;
  display: flex;
  justify-content: center;
  margin: 4px;
  border-radius: 5px;
  width: fit-content;
  cursor: pointer;
}
.selected {
  background-color: #4db6ac;
  color: white;
}
.selected:hover {
  background-color: #00867d;
  color: white;
}
.selectedCurrentDiapo {
  background: rgb(26, 173, 104);
  color: white;
}
</style>
