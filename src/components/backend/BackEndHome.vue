<template>
  <section>
    <div class="giantCircle"></div>
    <router-link to="/" class="navItem backBtn retourBtn"><i class="fas fa-arrow-circle-left fa-2x"></i>Retour</router-link>

    <router-link to="/newImage" class="navItem item1">Ajouter des images</router-link>
    <router-link   to="/newImage" class="navItem item2"> Voir les images</router-link>
    <router-link   to="/newImage" class="navItem item3">autre ...</router-link>
    <router-link   to="/newImage" class="navItem item4">autre ...</router-link>
    <router-link   to="/newImage" class="navItem item5">autre ...</router-link>
    <router-link   to="/newImage" class="navItem item6">autre ...</router-link>
    <router-link   to="/newImage" class="navItem item7">autre ...</router-link>
    <router-link   to="/newImage" class="navItem item8">autre ...</router-link>
  </section>
</template>

<script>
export default {
  name: "App",
  data() {
    return {};
  },
  mounted() {},
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