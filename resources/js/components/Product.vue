<template>
    <div class="container-fluid">
        <div class="row">
            <div id="recent-transactions" class="col-12">
                <div class="card">
                    <div class="card-header">
                       <h4 class="card-title">Modulo de productos</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a @click="registerModal"
                                        class="btn btn-info box-shadow-2 round btn-min-width pull-right" href="#">
                                        <i class="fas fa-plus"></i>
                                        Crear producto
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <Table></Table>
                    </div>
                </div>
            </div>
        </div>
        <Modal></Modal>        
    </div>
</template>

<script>
import Table from './Table'
import Modal from './Modal'
export default {
    name: 'Product',
    components: {
        Table,
        Modal
    },
    mounted() {

    },
    data() {
        return {
            
        }
    },
    methods: {
        registerModal() {
            this.$store.commit('changeModalTitle', 'Registrar Producto')
            $("#exampleModal").modal('show');
        }
    }
}
</script>

<style>

</style>