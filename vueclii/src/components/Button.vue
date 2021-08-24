<template>
  <button v-bind:class="buttonOpt.class" @click="buttonAction()" v-bind:title="buttonOpt.title" v-bind:disabled="buttonOpt.disabled == 1" >
    <i class="material-icons">{{ buttonOpt.icon }}</i><br>{{buttonOpt.text ? buttonOpt.title : ""}}
  </button>
</template>

<script>
export default{
  props : ["buttonOpt"],
  methods: {
    buttonAction(){
      if(this.buttonOpt.action === "translate") {
        this.$store.dispatch("translation",this.$store.state.translate)
        return
      }
      this.$store.dispatch(this.buttonOpt.action,this.$store.state.translate)
    }
  }
}
</script>