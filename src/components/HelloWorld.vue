<template>
<div>
  <p>hello world</p>
  <router-link to="/backend">backend</router-link>


  <div>
    <p>php call</p>
    <a href="http://localhost/my-photos/src/php/index.php">THE LIEN</a>
  </div>
</div>

</template>

<script>
export default {
  name: 'HelloWorld',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
