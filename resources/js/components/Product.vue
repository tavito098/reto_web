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
                        <div class="row">
                            <div class="col">
                                <input type="date" v-model="initDate" class="form-control"> 
                                <span class="text text-info">Fecha inicio*</span>
                            </div>
                            <div class="col">
                                <input type="date" v-model="endDate" class="form-control">
                                <span class="text text-info">Fecha Fin*</span>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-info" @click="searchProducByDates">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <Table></Table>
                    </div>
                </div>
            </div>
        </div>
        <Modal></Modal>        
    </div>
</template>

<script>
import Table from './products/Table'
import Modal from './products/Modal'
export default {
    name: 'Product',
    components: {
        Table,
        Modal
    },
    mounted() {
        this.$store.dispatch('getProducts');
    },
    data(){
        return {
            initDate: '',
            endDate: '',
        }
    },
    methods: {
        registerModal() {
            this.$store.commit('changeModalTitle', 'Registrar Producto');
            $("#productModal").modal('show');
        },
        searchProducByDates(){
            if(this.initDate > this.endDate) {
                swal('Espera!', 'La fecha fin debe ser mayor a la fecha inicio', 'warning');
            }else{
                let dates = {
                    initDate: this.initDate,
                    endDate: this.endDate
                }
                this.$store.dispatch('searchProducByDates', dates);
            }
        }
    }
}
</script>

<style>

</style>