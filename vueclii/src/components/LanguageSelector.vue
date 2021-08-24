<template>
      <select class="form-select" @change="languagechange($event)">
        <option value="0" v-if="formOpt.name === 'targetForm'">Dili Algıla</option>
        <Language v-for="language in languages" :key="language.code" :language="language" :formOpt="formOpt"/>
      </select>
</template>

<script>
import Language from "./Language";
export default {
  props : ["formOpt"],
  components: {Language},
  methods: {
    languagechange(e){
      if(this.formOpt.name === "targetForm"){
        this.$store.dispatch("updateTargetLang", e.target.value);
        console.log(e.value);
        return;
      }
      this.$store.dispatch("updateResultLang", e.target.value);
      console.log(e.value);
    }
  },
  computed:{
    languages(){
      return this.$store.getters.getLanguages
    }
  }
}
</script>