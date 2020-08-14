<template>
  <span>{{formatearFecha}}</span>
</template>

<script>
export default {
  props: ["fecha"],
  computed: {
    formatearFecha() {
      return moment(this.fecha).locale("es").format("DD [d] MMMM [del] YYYY");
    },
  },
};
</script>