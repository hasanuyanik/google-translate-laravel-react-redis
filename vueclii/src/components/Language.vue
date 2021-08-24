<template>
  <optgroup>
    <option v-bind:value="language.code" v-if="formOpt.selected === language.code" selected>{{ language.name }}</option>
    <option v-bind:value="language.code" v-if="formOpt.selected !== language.code">{{ language.name }}</option>
  </optgroup>
  </template>

<script>
  export default{
    props:["language","formOpt"]
  }
</script>