<template>
    <vue-bootstrap4-table :rows="products" :columns="columns" :config="config">
        <template slot="empty-results">
            No hay resultados
        </template>
        <!--sort icons-->
        <template slot="sort-asc-icon">
            <i class="fas fa-sort-up"></i>
        </template>
        <template slot="sort-desc-icon">
            <i class="fas fa-sort-down"></i>
        </template>
        <template slot="no-sort-icon">
            <i class="fas fa-sort"></i>
        </template>
        <!--Imagen-->
        <template slot="image" slot-scope="props">
            <img :src="'images/products/'+props.cell_value" class="media-object img-xl mr-1">
        </template>
        <!--Options-->
        <template slot="options" slot-scope="props">
            <div class="btn-group" role="group" aria-label="Options button">
                <button 
                    @click="edit(props.cell_value)"
                    type="button" 
                    class="btn btn-primary" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Editar">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button 
                    @click="deleteProduct(props.cell_value)"
                    type="button" 
                    class="btn btn-danger" 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </template>
        <!--buttons pagination-->
        <template slot="paginataion-previous-button">
            Anterior
        </template>
        <template slot="paginataion-next-button">
            Siguiente
        </template>
    </vue-bootstrap4-table>
</template>

<script>
import VueBootstrap4Table from 'vue-bootstrap4-table'
export default {
    name: 'Table',
    computed: {
        products() {
            return this.$store.state.products
        }
    },
    components: {
        VueBootstrap4Table
    },
    data() {
        return {
            headers: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            },
            columns: [{
                    label: "Imagen",
                    name: "image",
                },
                {
                    label: "Categoria",
                    name: "category",
                    sort: true,
                },
                {
                    label: "Nombre",
                    name: "name",
                    sort: true,
                },
                {
                    label: "Descripcion",
                    name: "description",
                    sort: true,
                },
                {
                    label: "Precio",
                    name: "price",
                    sort: true,
                },
                {
                    label: 'Opciones',
                    name: 'options'
                }
            ],
            config: {
                checkbox_rows: false,
                rows_selectable: true,
                card_mode: false,
                highlight_row_hover: false,
                global_search: {
                    placeholder: "Buscar producto",
                    visibility: true,
                    case_sensitive: false,
                    showClearButton: false,
                    searchOnPressEnter: false,
                    showRefreshButton: false,
                },
                show_refresh_button: false,
                show_reset_button: false,
                preservePageOnDataChange: false,
                per_page: 5,
                per_page_options: [5],
                loaderText: 'Cargando...',
            }
        }
    },
    methods: {
        edit(product_id) {
            this.$store.commit('changeModalTitle', 'Editar Producto');
            this.$http.get('/products-resource/'+product_id+'/edit', this.headers).then((response) => {
                this.$store.commit('changeProduct', response.data);
                $("#productModal").modal('show');
            }).catch((error) => {
                console.log(error);
            });
        },
        deleteProduct(product_id) {
            swal({
                title: "Estas seguro?",
                text: "El producto se eliminara permanentemente",
                icon: "warning",
                dangerMode: true,
                buttons: true,
            }).then(willDelete => {
                if (willDelete) {
                    this.$http.delete('/products-resource/'+product_id, this.headers).then((response) => {
                        this.$store.dispatch('getProducts');
                        swal("OK", "El producto ha sido eliminado", "success");
                    }).catch((error) => {
                        console.log(error);
                    });
                }
            });
        }
    }
}
</script>

<style>

</style>