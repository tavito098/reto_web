<template>
    <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config">
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
    mounted() {

    },
    components: {
        VueBootstrap4Table
    },
    data() {
        return {
            rows: [],
            columns: [{
                    label: "Imagen",
                    name: "image",
                    sort: true,
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
                per_page: 0,
                per_page_options: [],
                loaderText: 'Cargando...',
            }
        }
    },
}
</script>

<style>

</style>