<template>
  <v-container bg fill-height grid-list-md text-xs-center>
    
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      model: null,
      rucs: []
    };
  },
  mounted() {
    axios.get("/api/connections").then(({ data }) => {
      this.rucs = data;
    });
  },
  methods: {
    onSubmit: function() {
      console.log(this.model);
    }
  }
};
</script>
