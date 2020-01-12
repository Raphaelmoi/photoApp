<template>
  <section class="corpConnectPage">
    <form id="form" method="post">
      <p>
        <br />
        <input type="text" name="username" v-model="input.username" placeholder="Username" />
      </p>
      <p>
        <br />
        <input type="password" name="password" v-model="input.password" placeholder="Password" />
      </p>
      <input type="submit" value="Se connecter" />
    </form>
  </section>
</template>

<script>
export default {
  name: "LogIn",
  data() {
    return {
      input: {
        username: "",
        password: ""
      }
    };
  },
  methods: {
    login() {
      if (this.input.username != "" && this.input.password != "") {
        if (
          this.input.username == this.$parent.mockAccount.username &&
          this.input.password == this.$parent.mockAccount.password
        ) {
          this.$emit("authenticated", true);
          this.$router.replace({ name: "secure" });
        } else {
          console.log("The username and / or password is incorrect");
        }
      } else {
        console.log("A username and password must be present");
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.corpConnectPage {
  display: flex;
  justify-content: space-around;
  width: 100%;
  height: 100%;
}
.corpConnectPage form {
  position: absolute;
  width: 450px;
  background-color: rgb(55, 185, 79);
  border-radius: 10px;
  border: 2px #ddd solid;
  text-align: center;
  margin-top: 30vh; /* poussé de la moitié de hauteur de viewport */
  transform: translateY(-50%); /* tiré de la moitié de sa propre hauteur */
  padding-bottom: 30px;
}

.corpConnectPage input {
  width: 90%;
  height: 37px;
  border-radius: 10px;
  padding-left: 10px;
}
.corpConnectPage form > input {
  width: 50%;
  border: 2px #26a69a solid;
  font-size: 20px;
}
</style>
