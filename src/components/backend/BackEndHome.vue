<template>
  <section class="myBody">
    <div class="giantCircle">
      <div class="centerCircle">
        <!-- <div style="position:absolute; top:5vh;left:5vw; background:white;">
        {{ successMsg }}
        </div>-->

        <router-link to="/" class="navItem backBtn retourBtn">
          <i class="fas fa-arrow-circle-left backFa"></i>
          Retour
        </router-link>

        <router-link to="/newImage" class="navItem item1">Ajouter des images</router-link>
        <router-link to="/AllImages" class="navItem item2">Voir les images</router-link>
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
        <router-link to="/newImage" class="navItem right itemR5">item r 5</router-link>
        <router-link to="/newImage" class="navItem right itemR6">item r 6</router-link>
        <router-link to="/newImage" class="navItem right itemR7">item r 7</router-link>
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
      successMsg: "a"
    };
  },
  mounted() {
    //TODO AJouter une possibilité de message global visible quand on change de page et disparait qd on click
    // this.$store.commit('increment', 'mon message')
    console.log(this.$store.state.message); // -> 1
    this.$store.dispatch("loadData");
  },
  methods: {}
};
</script>

<style scoped>
</style>