<template>
    <input
        type="submit"
        class="btn btn-danger d-block w-100 mb-2"
        value="Eliminar x"
        @click="eliminarReceta"
    />
</template>

<script>
export default {
    props: ["recetaId"],
    mounted() {
        console.log("receta actual", this.recetaId);
    },
    methods: {
        eliminarReceta() {
            this.$swal({
                title: "Deseas eliinar est receta?",
                text: "Una vez eliinada, no se puede recuperada!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, borrar!"
            }).then(result => {
                if (result.value) {
                    const params = {
                        id: this.recetaId
                    };
                    //enivar petición al servidor
                    axios
                        .post(`/recetas/${this.recetaId}`, {
                            params,
                            _method: "delete"
                        })
                        .then(respuesta => {
                            this.$swal({
                                title: "Receta eliminada",
                                text: "Se eliminará la receta",
                                icon: "success"
                            });

                            //eliminar receta del dom
                            this.$el.parentNode.parentNode.parentNode.removeChild(
                                this.$el.parentNode.parentNode
                            );
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            });
        }
    }
};
</script>
