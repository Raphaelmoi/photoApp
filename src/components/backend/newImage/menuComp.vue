<template>
  <div class="giantCircle">
    <div class="centerCircle">
      <router-link to="/backend" class="navItem backBtn retourBtn">
        <i class="fas fa-arrow-circle-left backFa"></i>
        Retour
      </router-link>


      <div class="navItem item1">
        <input
          type="file"
          name="file"
          id="file"
          ref="myFiles"
          class="inputfile"
          @change="$emit('upImageOnFront')"
          accept="image/png, image/jpeg"
          multiple="multiple"
        />
        <label for="file">Importer image(s)</label>
      </div>

      <a
        v-if="legend.length !== 0"
        to="/newImage"
        class="navItem backBtn item7"
        v-on:click="deleteImg()"
      >
        <i class="fas fa-skull-crossbones navFa"></i>
        <span v-if="fileIsDeleted[currentImg] === ''">
          Supprimer cette image
        </span>
        <span v-else>
          Récuperer l'image
        </span>
      </a>
      <!-- LEFT NAV BUTON -->
      <a
        v-if="legend.length !== 0"
        class="arrowNavItem item4"
        v-on:click="next(-1)"
      >
        <i class="fas fa-arrow-circle-left fa-4x"></i>
      </a>
      <!-- INDEX OF IMAGE -->
      <a v-if="legend.length !== 0" class="paginationNavItem item8">
        {{ currentImg+1 }} / {{ legend.length }}
      </a>

      <!-- ::::::::::::::::::::::::::::::: -->
      <!-- :::::::::::::RIGHT::::::::::::: -->
      <!-- ::::::::::::::::::::::::::::::: -->
      <a
        v-if="legend.length !== 0 "
        class="navItem right itemR1"
        @click="onClickAddKeyword = !onClickAddKeyword"
      >
        Ajouter un mot-clé
      </a>

      <a
        v-if="legend.length !== 0"
        class="arrowNavItem right itemR4"
        v-on:click="next(1)"
      >
        <i class="fas fa-arrow-circle-right fa-4x"></i>
      </a>

      <!-- <button
        v-if="files.length !== 0 "
        class="submit navItem right itemR8"
        @click="onClicPrepareDataBeforeSending"
      >
        Enregistrer
      </button> -->
    </div>
  </div>
</template>

<script>
export default {
    name: 'menuComponent',
    props: ['legende'],

    computed: {
        legend : {
            get() {
                return this.legende;
            },
            set(newVal) {
                this.$emit('setLegendArray', newVal);
            }
        },
        // files: {
        //     get() {
        //         return this.filesList;
        //     },
        //     set(newVal) {
        //         this.$emit('setFilesList', newVal);
        //     }
        // }
    },
}
</script>