<template>
  <div id="app">
    <transition name="fade"> 
      <router-view/>
    </transition>
  </div>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  background-color: black;
  overflow: hidden;
}
a {
  color: #42b983;
}
.giantCircle {
  position: absolute;
  height: 90vw;
  width: 80vw;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  border-radius: 50%;
  border: 10px #cfd8dc solid;
  box-shadow: 0 0 5rem #cfd8dc, inset 0 0 5rem #cfd8dc;
}
.backBtn {
  padding: 0.3rem 1rem 0.3rem 0.3rem !important;
}
.navItem {
  /* background-color:whitesmoke; */
  padding: 0.5rem 1rem 0.5rem 2.5rem;
  border: 4px white solid;
  border-radius: 5rem;
  text-decoration: none;
  font-size: 1rem;
  font-weight: bolder;
  text-transform: uppercase;
  position: absolute;
  transition: all 1s ease;
  display: flex;
  align-items: center;
}
.navItem:hover {
  background: #2e805b;
  color: white;
  /* border: 4px gray solid; */
  transition: all 2s ease;
}
.item1 {
  top: 14vh;
  left: 11vw;
}
.item2 {
  top: 28vh;
  left: 9.7vw;
}
.item3 {
  top: 42vh;
  left: 8.9vw;
}
.item4 {
  top: 56vh;
  left: 8.6vw;
}
.item5 {
  top: 70vh;
  left:10vw;
}
.item6 {
  top: 84vh;
  left: 12vw;
}
.item7 {
  top: 68vh;
  left: 59.5vw;
}
.item8 {
  top: 77vh;
  left: 70.6vw;
}

.retourBtn {
  top: 2vh;
  left: 2vw;
}
 .fa-2x {
   margin: 0;
   padding: 0;
   font-size: 1.4em !important;
   margin-right: 0.3rem;
 }
</style>
