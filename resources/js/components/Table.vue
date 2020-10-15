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
                },
                {
                    label: "Precio",
                    name: "price"
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
            alert(product_id);
        },
        deleteProduct(product_id) {
            alert(product_id);
        }
    }
}
</script>

<style>

</style>