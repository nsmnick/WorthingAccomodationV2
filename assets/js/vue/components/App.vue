<template>
  <div class="app">
    <component :is="component" :config="config" />
  </div>
</template>

<script>
import PropertiesSearch from "./PropertiesSearch.vue";

export default {
  name: "App",
  components: {
    PropertiesSearch,
  },
  props: {
    component: {
      type: String,
      default: "",
    },
    config: {
      type: Object,
      default() {
        return {};
      },
    },
  },
};
</script>
