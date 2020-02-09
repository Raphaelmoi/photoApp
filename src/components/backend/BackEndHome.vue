<template>
  <section>
    <div class="giantCircle">


      <div class="centerCircle" >
        
      <!-- <div style="position:absolute; top:5vh;left:5vw; background:white;">
        {{ successMsg }}
      </div> -->

      <router-link to="/" class="navItem backBtn retourBtn ">
        <i class="fas fa-arrow-circle-left backFa"></i>
        Retour
      </router-link>

        <router-link to="/newImage" class="navItem item1">Ajouter des images</router-link>
        <router-link to="/newImage" class="navItem item2">Voir les images</router-link>
        <router-link to="/newImage" class="navItem item3">Nouvel article</router-link>
        <router-link to="/newImage" class="navItem item4">Voir les articles</router-link>
        <router-link to="/newImage" class="navItem item5">autre ...</router-link>
        <router-link to="/newImage" class="navItem item6">autre ...</router-link>
        <router-link to="/newImage" class="navItem item7">autre ...</router-link>
        <router-link to="/newImage" class="navItem item8">sqsq8 ...</router-link>

        <router-link to="/newImage" class="navItem right itemR1">item r 0</router-link>
        <router-link to="/newImage" class="navItem right itemR1">item r 1</router-link>
        <router-link to="/newImage" class="navItem right itemR2">item r 2</router-link>
        <router-link to="/newImage" class="navItem right itemR3">item r 3</router-link>
        <router-link to="/newImage" class="navItem right itemR4">item r 4.</router-link>
        <router-link to="/newImage" class="navItem right itemR5"> item r 5 </router-link>
        <router-link to="/newImage" class="navItem right itemR6"> item r 6 </router-link>
        <router-link to="/newImage" class="navItem right itemR7"> item r 7 </router-link>
        <router-link to="/newImage" class="navItem right itemR8">Settings</router-link>
      </div>
      
    </div>
  </section>
</template>

<script>
export default {
  name: "App",

  data() {
    return {
      successMsg: 'ezezez',

    };
  },
  mounted() {
    // this.biggerCircle = false;
  },
  methods: {}
  
};
</script>

<style scoped>
section {
  background-color: #1c313a;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  transition: all 2s ease;
}

</style>