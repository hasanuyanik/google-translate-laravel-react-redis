<template>
  <div class="container">
    <div class="col-md-12">
      <HistoryTranslate v-for="translate in Translations" :key="translate.targetText" :translate="translate"/>
    </div>
    <div class="col-md-12 text-center">
      <RouterButton v-for="buttonOpt in FooterButtons" :key="buttonOpt.icon" :buttonOpt="buttonOpt"/>
    </div>
  </div>

</template>

<script>
import RouterButton from "../components/RouterButton";
import HistoryTranslate from "../components/HistoryTranslate";
export default {
  data(){
    return{
      FooterButtons : [
        {
          class : "btn m-3 btn-light",
          title : "Çeviri Sayfası",
          icon : "translate",
          action : "translate"
        },
        {
          class : "btn m-3 btn-light",
          title : "Geçmiş",
          icon : "history",
          action : "historyList"
        }
      ]
    }
  },
  components: {HistoryTranslate, RouterButton},
  computed:{
    Translations(){
      return this.$store.getters.getTranslations
    }
  }
}

</script>