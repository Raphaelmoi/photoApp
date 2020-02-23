<template>
  <section>
    <div class="giantCircle">
      <div class="centerCircle">
        <router-link to="/backend" class="navItem item1">backend</router-link>

        <a class="navItem item2" href="http://localhost/my-photos/src/php/index.php">Lien vers php</a>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "HelloWorld",
  data() {
    return {
      msg: "Welcome to Your Vue.js App"
    };
  },
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
  overflow: hidden;
  z-index: -2;
}
</style>
