<template>
  <div class="col-md-6 p-2">
    <div class="topBar">
      <LanguageSelector :formOpt="formOpt" />
    </div>
    <div class="col-md-12">
      <div class="form-floating col-md-12">
        <textarea @change="textChange($event)" v-bind:name="formOpt.name" class="form-control col-md-12" style="height:50vh" id="floatingTextarea" v-bind:disabled="formOpt.disabled == 1" v-text="formOpt.text"></textarea>
        <label for="floatingTextarea" >{{formOpt.title}}</label>
      </div>
    </div>
  </div>
</template>

<script>
import LanguageSelector from "./LanguageSelector";
  export default{
    props: ["formOpt"],
    components: {LanguageSelector},
    methods:{
      textChange(e){
        if(this.formOpt.name === "targetForm"){
          this.$store.dispatch("updateTargetText", e.target.value);
          return;
        }
        this.$store.dispatch("updateResultText", e.target.value);
      }
    }
  }
</script>