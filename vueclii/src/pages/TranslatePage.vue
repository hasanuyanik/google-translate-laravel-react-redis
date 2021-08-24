<template>
  <div class="container">
    <div class="col-md-12 text-center">
      <Button v-for="buttonOpt in HeaderButtons" :key="buttonOpt.icon" :buttonOpt="buttonOpt"/>
    </div>
    <div class="col-md-12 d-flex">
      <TextForm v-for="formOpt in Forms" :key="formOpt.name" :formOpt="formOpt"/>
    </div>
    <div class="col-md-12 text-center">
      <RouterButton v-for="buttonOpt in FooterButtons" :key="buttonOpt.icon" :buttonOpt="buttonOpt"/>
    </div>
  </div>

</template>

<script>
import TextForm from "../components/TextForm"
import Button from "../components/Button";
import RouterButton from "../components/RouterButton";
export default {
  data(){
    return{
      FooterButtons : [
        {
          class : "btn m-3 btn-light",
          title : "Geçmiş",
          icon : "history",
          action : "historyList"
        },
        {
          class : "btn m-3 btn-light",
          title : "Kaydedilenler",
          icon : "star_rate",
          action : "registerList"
        }
      ]
    }
  },
  components: {RouterButton, Button, TextForm},
  computed:{
    Forms(){
      return this.$store.getters.getForms
    },
    HeaderButtons(){
      return this.$store.getters.getHeaderButtons
    }
  }
}

</script>