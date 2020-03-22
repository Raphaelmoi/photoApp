<template>
    <section>
        <div class="itemImg">
      <!-- surcouche si la photo est supprimé -->
      <div v-if="isDelete !== ''" class="deletedItem">
        X
        <br />
        <span style="font-size: 2rem;">photo supprimée</span>
      </div>

      <img id="imageItem" class="currentImg" :src="imgUrl" alt="your image" />

      <div>
        <div class="keywordBox">
          <div
            v-for="keyword in keywords"
            v-bind:class="getClass(currentIndex, keyword[0])"
            :key="keyword[0]"
            @click="addKeyWord(currentIndex, keyword)"
          >{{ keyword[0] }}</div>
            <i class="fas fa-plus" style="background:lightgray;" @click="onClickAddKeyword = !onClickAddKeyword"></i>

        </div>

        <div class="inputBoxInfo">
          <label for="legend">Légende</label>
          <input type="text" name="legend" v-model="legend" />
        </div>
        <div class="inputBoxInfo">
          <label for="description">Description (alt)</label>
          <input type="text" name="description" v-model="description" />
        </div>
      </div>

    </div>
    </section>
</template>

<script>
export default {
  name: "currentImgComp",
  props: ["isDelete", "imgUrl", "kwList", "currentIndex", "selectKW", "legende", "desc", "addKW"],

  computed: {

    onClickAddKeyword:{
        get() {
          return this.addKW;
        },
        set(newVal){
          this.$emit("update:addKW", newVal);
        }
    },
    keywords: {
      get() {
        return this.kwList;
      },
      set() {
      }
    },
    selectedKeyWords: {
        get() {
            return this.selectKW;
        },
        set(newVal){
          this.$emit("update:selectKW", newVal);
        }
    },
    legend: {
        get() {
            return this.legende;
        },
        set(val){
          return this.$emit("update:legende", val)
        }
    },
    description: {
        get() {
            return this.desc;
        },
        set(val){
            return this.$emit('update:desc', val)
        }
    }
  },
  methods: {
    //return different class name depend if a keyword is selected or not
    getClass (imgId,  categoryName) {

        if (this.selectedKeyWords.indexOf(categoryName) >= 0) {
          return 'keyword selected'
        } else {
          return 'keyword '
        }
    }, 
        //set or unset a keyword for an image
    addKeyWord (imgId, keyword) {
      let value = this.selectedKeyWords.indexOf(keyword[0])
      if (value >= 0) {
        this.selectedKeyWords.splice(value, 1)
      } else {
        this.selectedKeyWords.push(keyword[0])
      }
    },
  }
};
</script>


<style>

.currentImg {
  width: 100%;
  height: 50vh;
  object-fit: contain;
}

.itemImg {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  margin: 3rem 0;
}
.itemImg > div {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 2;
  width: 60%;
}
.inputBoxInfo {
  display: flex;
  align-items: center;
  width: 100%;
}
.inputBoxInfo label {
  flex: 1;
}
.inputBoxInfo input {
  height: 30px;
  flex: 3;
  padding: 2px 10px;
  margin: 10px;
  background-color: rgba(100, 100, 100, 0);
  border: none;
  border-bottom: 2px white solid;
  color: white;
  outline: none;
}
.keywordBox {
  display: flex;
  justify-content: center;
  margin: 1% 10%;
  flex-wrap: wrap;
}

.keyword {
  margin: 4px;
  padding: 5px 10px;
  background-color: lightgray;
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
label {
  color: white;
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
</style>