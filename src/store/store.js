// Make sure to call Vue.use(Vuex) first if using a module system
import Vue from 'vue'
import Vuex from 'vuex'
const axios = require("axios");
const phpLink = "http://localhost/my-photos/src/php/index.php"

Vue.use(Vuex)
export default new Vuex.Store({
  state: {
    message: '',
    keywordTable: [],
    imagesTable: [],
    loading: true
  },
  actions: {
    loadData({ commit }) {
      console.log('call loaddata');

      commit('changeLoadingState', true)
      let req = phpLink + "?action=getKeyWords";
      axios
        .get(req)
        .then(response => {
          commit('updateKeyword', response.data)
        })
        .catch(function (error) {
          console.log(error);
        });
      const reqImg = phpLink + "?action=getImages";
      axios
        .get(reqImg)
        .then(response => {
          commit('updateImages', response.data)
          commit('changeLoadingState', false)

        })
        .catch(function (error) {
          console.log(error);
        });
    },
    updateKeywordsTable({ commit }) {
      commit('changeLoadingState', true)
      let arrayToSend = this.state.keywordTable;
      for (let item of arrayToSend) {
        let newArray = "";
        for (let i = 0; i < item.imageName.length; i++) {
          if (i === 0) {
            newArray += item.imageName[i];
          } else newArray += "|" + item.imageName[i];
        }
        item.imageName = newArray;
      }
      console.log(arrayToSend);

      let formData = new FormData();
      formData.append("fullKeywordTable", JSON.stringify(arrayToSend));

      let req = phpLink + "?action=updateFullKWTable";
      axios
        .post(req, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(
          response => commit("increment", response.data),
        )
        .catch(function (error) {
          console.log(error);
        });
    },

    updateImageTable({ commit, dispatch }) {
      commit('changeLoadingState', true)

      let formData = new FormData();
      formData.append("fullImgTable", JSON.stringify(this.state.imagesTable));

      let req = phpLink + "?action=updateFullImgTable";
      axios
        .post(req, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(
          response => commit("increment", response.data),
          dispatch('loadData')
        )
        .catch(function (error) {
          console.log(error);
        });
    },
  },


  mutations: {
    increment(state, msg) {
      state.message = msg
    },
    addKeyword(state, newKw) {
      console.log('addKeyword on state');
      state.keywordTable.push({
        id: "",
        keywords: newKw,
        imageName: "",
        main_image: ""
      })
    },
    updateImages(state, val) {
      state.imagesTable = val
      console.log('upimage on state');
    },
    updateKeyword(state, val) {
      console.log('upLeyword on state');

      for (let i = 0; i < val.length; i++) {
        if (val[i].imageName) {
          val[i].imageName = val[i].imageName.split("|")
        }
      }
      state.keywordTable = val
    },
    changeLoadingState(state, loading) {
      state.loading = loading
    }
  }
})

