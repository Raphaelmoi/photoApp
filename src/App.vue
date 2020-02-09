<template>
  <div id="app">
    <transition name="fade"> 
      <router-view />
    </transition>
  </div>
</template>

<script>
export default {
  name: 'App',
  biggerCircle: false,
  mounted () {
      // this.$el.querySelectorAll('.navItem').forEach( (button) => {
      // button.addEventListener('click', (e) => {
      //   this.biggerCircle = !this.biggerCircle;
      //   if(this.biggerCircle) {
      //     // button.setAttribute('right', '100%')
      //     // document.documentElement.style.setProperty('--circle-radius', '50vw');
      //   }else {
      //     console.log('false')
      //     document.documentElement.style.setProperty('--circle-radius', '40vw');
      //   }
      // })
      // } );
    },
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
:root {
  --circle-radius: 40vw;
  --circle-diameter: calc(var(--circle-radius) * 2);
}
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

.fade-leave-active .navItem {
  /* transition: transform .5s; */
  /* transform: unset; */
}
.fade-enter .navItem, .fade-leave-to .navItem /* .fade-leave-active below version 2.1.8 */ {
  transform: unset;
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
  color: white;
}
.giantCircle {
  position: absolute;
  height: var(--circle-diameter);
  width: var(--circle-diameter);
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  border-radius: 50%;
  border: 10px #cfd8dc solid;
  box-shadow: 0 0 5rem #cfd8dc, inset 0 0 5rem #cfd8dc;
  transition: all 1s ease;

}

.centerCircle {
  position: absolute;
  top: 50%;
  left: 50%;
  /* background: red; */
  width: 30px;
  height: 30px;
  transform: translate(-50%, -50%);
}
.backBtn {
  padding: 0 1rem 0 0 !important;
  /* border-color: #aaa !important;  */
  background-color: rgba(0, 0, 0, 0) !important;
  /* padding: 0.3rem 1rem 0.3rem 0.3rem !important; */
}
.navItem {
  position: absolute;
  padding: 0.5rem 1rem 0.5rem 2.5rem;
  border: 4px white solid;
  border-radius: 5rem;
  text-decoration: none;
  font-size: 1rem;
  font-weight: bolder;
  text-transform: uppercase;
  transition: all 1s ease;
  display: flex;
  align-items: center;
  white-space: nowrap;
  background-color: rgba(0, 0, 0, 0.5);
  
  /* background-color: rgba(255, 255, 255, 0.9); */

}

.navItem:hover {
  background: #2e805b;
  color: white;
  /* border: 4px gray solid; */
  transition: all 0.4s ease;
}
.right {
  right: 0;
}
.retourBtn {
 transform: rotate(204deg) translate(var(--circle-radius)) rotate(-204deg);
}

.item1 {
  transform: rotate(198deg) translate(var(--circle-radius)) rotate(-198deg); 
}
.item2 {
   transform: rotate(192deg) translate(var(--circle-radius)) rotate(-192deg);
}
.item3 {
   transform: rotate(186deg) translate(var(--circle-radius)) rotate(-186deg);
}
.item4 {
   transform: rotate(180deg) translate(var(--circle-radius)) rotate(-180deg);
}
.item5 {
   transform: rotate(174deg) translate(var(--circle-radius)) rotate(-174deg);
}
.item6 {
   transform: rotate(168deg) translate(var(--circle-radius)) rotate(-168deg);
}
.item7 {
   transform: rotate(162deg) translate(var(--circle-radius)) rotate(-162deg);
}
.item8 {
   transform: rotate(156deg) translate(var(--circle-radius)) rotate(-156deg);
}
.itemR0 {
   transform: rotate(-24deg) translate(var(--circle-radius)) rotate(24deg);
}
.itemR1 {
   transform: rotate(-18deg) translate(var(--circle-radius)) rotate(18deg);
}
.itemR2 {
   transform: rotate(-12deg) translate(var(--circle-radius)) rotate(12deg);
}
.itemR3 {
   transform: rotate(-6deg) translate(var(--circle-radius)) rotate(6deg);
}
.itemR4 {
   transform: rotate(0deg) translate(var(--circle-radius)) rotate(0deg);
}
.itemR5 {
   transform: rotate(6deg) translate(var(--circle-radius)) rotate(-6deg);
}
.itemR6 {
   transform: rotate(12deg) translate(var(--circle-radius)) rotate(-12deg);
}
.itemR7 {
   transform: rotate(18deg) translate(var(--circle-radius)) rotate(-18deg);
}
.itemR8 {
   transform: rotate(24deg) translate(var(--circle-radius)) rotate(-24deg);
}

.backFa {
  font-size: 2em;
  border-radius: 50%;
  margin-right: 1rem;
}
 .fa-2x {
   margin: 0;
   padding: 0;
   font-size: 1.4em !important;
   margin-right: 0.3rem;
 }
</style>
