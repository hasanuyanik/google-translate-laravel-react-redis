<template>
  <div class="col-md-12 border">
      <div class="col-md-12 border-bottom p-2">
        {{ translate.targetLanguage }} -> {{ translate.resultLanguage }}
        <div class="float-right" style="float:right">
          <Button v-for="buttonOpt in Buttons" :key="buttonOpt.icon" :buttonOpt="buttonOpt"/>
        </div>
      </div>
    <div class="col-md-12 p-2">
      <div class="col-md-12 font-weight-normal text-dark">
        {{ translate.targetText }}
      </div>
      <div class="col-md-12 font-weight-light text-muted">
        {{ translate.resultText }}
      </div>
    </div>
  </div>
</template>

<script>
import Button from "./Button";
export default{
  components: {Button},
  props: ["translate"],
  data(){
    return{
      Buttons : [
        {
          class : "btn btn-sm btn-light",
          title : "Kaydet",
          icon : "star_rate",
          action : "saveTranslate"
        },
        {
          class : "btn btn-sm btn-light",
          title : "Sil",
          icon : "delete",
          action : "deleteTranslate"
        }
      ]
    }
  },
  methods:{
    textChange(e){
      if(this.formOpt.name === "targetForm"){
        this.$store.dispatch("updateTargetText", e.target.value);
        return;
      }
      this.$store.dispatch("updateResultText", e.target.value);
    }
  },
  computed:{

  }
}
</script>