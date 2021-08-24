<template>
  <router-link v-bind:to="buttonOpt.action" v-bind:class="buttonOpt.class" v-bind:title="buttonOpt.title">
    <i class="material-icons">{{ buttonOpt.icon }}</i><br>{{buttonOpt.title}}
  </router-link>
</template>

<script>
export default{
  props : ["buttonOpt"]
}
</script>