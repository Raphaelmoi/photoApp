<template>
  <div v-if="onClickAddKeyword" class="addkeyword" :class="positionClass">
    <span class="closePanel" @click="onClickAddKeyword = false">X</span>
    <label for="newKeyword" class>Créer un diaporama</label>
    <div>
      <input type="text" v-model="newKeyword" v-on:keyup.enter="createNewKeyWord(false)" />
      <i class="fas fa-plus" @click="createNewKeyWord(false)"></i>

      <a class="validateAll" type="submit" @click="createNewKeyWord(true)">valider</a>
    </div>
  </div>
</template>

<script>
const axios = require("axios");

export default {
  data() {
    return {
      newKeyword: null,
      phpLink: "http://localhost/my-photos/src/php/index.php"
    };
  },
  name: "newKeyWordComp",
  props: ["isOpen", "allKW", "newKW", "sendToServer", "cssPosition"],

  computed: {
    needAxios: {
      get() {
        return this.sendToServer;
      }
    },
    positionClass: {
      get() {
        return this.cssPosition;
      }
    },
    onClickAddKeyword: {
      get() {
        return this.isOpen;
      },
      set(newVal) {
        this.$emit("update:isOpen", newVal);
      }
    },
    keywords: {
      get() {
        return this.allKW;
      },
      set(newVal) {
        this.$emit("update:allKW", newVal);
      }
    },
    newKeywordsBox: {
      get() {
        return this.newKW;
      },
      set(newVal) {
        this.$emit("update:newKW", newVal);
      }
    }
  },
  methods: {
    createNewKeyWord(closePanel) {
      if (this.newKeyword !== null && this.newKeyword !== "") {
        //this.keyword = la liste lu en front, ajoute le mot sans refaire requte php
        //new.keywords, mots a ajouter avec les nvelles photos requete php
        console.log(this.newKeyword);
        console.log(this.keywords);

        if (
          this.keywords[0] !== this.newKeyword &&
          this.newKeywordsBox.indexOf(this.newKeyword) < 0
        ) {
          // this.keywords.push([
          //   this.newKeyword,
          //   this.keywords.length + 1,
          //   [],
          //   ""
          // ]);

          this.newKeywordsBox.push(this.newKeyword);

          if (this.needAxios) {
            console.log(this.needAxios);
            this.sendDiapoToServer(this.newKeyword);
          }
          // this.keywords.push([]);
          // this.keywords.splice(-1, 1);
          this.$emit("change");
          this.newKeyword = "";
        }
      }
      // this.newKeyword = null;
      if (closePanel) {
        this.onClickAddKeyword = !this.onClickAddKeyword;
      }
    },
    sendDiapoToServer(newKW) {
      let formData = new FormData();
      formData.append("datas", newKW);

      let req = this.phpLink + "?action=newdiapo";
      console.log("before sending");
      console.log(newKW);

      axios
        .post(req, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => console.log(response.data))
        .catch(function(error) {
          console.log(error);
        });
    }
  }
};
</script>


<style>
.addkeyword {
  top: 0;
  left: 0;
  width: 300px;
  background-color: whitesmoke;
  border-radius: 1rem;
  padding: 0.5rem 1rem;

  /* z-index: 1; */
}
.closePanel {
  position: absolute;
  top: 4px;
  right: 12px;
  font-weight: bold;
  cursor: pointer;
}
.addkeyword > div {
  display: flex;
  align-items: center;
}
.addkeyword label {
  color: black;
  margin-right: 1rem;
}
.addkeyword input {
  padding-left: 0.4rem;
  margin-right: 8px;
  outline: none;
}
.submit {
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  cursor: pointer;
}
.addkeyword input {
  height: 30px;
  border-radius: 8px;
}
.validateAll {
  line-height: 0;
  padding: 0 18px;
  background-color: #4db6ac;
  border-radius: 8px;
  border: none;
  color: white;
  display: flex;
  align-items: center;
  text-align: center;
  justify-content: center;
  height: 30px;
  cursor: pointer;
}
.validateAll:hover {
  background-color: #00867d;
  color: white;
}
.fa-plus {
  background-color: #4db6ac;
  border-radius: 50%;
  padding: 7px;
  margin: 4px;
  height: 1em;
  color: white;
  cursor: pointer;
}
.fa-plus:hover {
  background-color: #00867d;
}
</style>