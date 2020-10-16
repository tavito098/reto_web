<template>
    <div class="container-fluid">
        <div class="row">
            <div id="recent-transactions" class="col-12">
                <div class="card">
                    <div class="card-header">
                       <h4 class="card-title">Modulo de cotizaciones</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a
                                        data-toggle="modal" data-target="#quotationModal"
                                        class="btn btn-info box-shadow-2 round btn-min-width pull-right" href="#">
                                        <i class="fas fa-plus"></i>
                                        Crear Cotizacion
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="container">
                            <div class="row" v-if="isLoad">
                                <h1><i class="fa fa-spinner fa-spin"></i> Espere por favor...</h1>
                            </div>
                            <div class="row" v-else>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(element, index) in quotations" :key="index">
                                                <td v-text="element.user.name"></td>
                                                <td v-text="element.product.name"></td>
                                                <td v-text="element.price"></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger"
                                                        @click="downloadPdf(element.id)">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-info"
                                                        @click="sendEmail(element.id)">
                                                        Enviar correo
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="quotationModal" tabindex="-1" aria-labelledby="quotationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quotationModalLabel">Registrar cotizacion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" @submit.prevent="setQuotation" autocomplete="off">
                        <div class="container">
                            <div class="row">
                                 <div class="col">
                                    <div class="form-group">
                                        <label for="client">Seleccionar cliente</label>
                                        <select name="" id="client" v-model="userId" class="custom-select">
                                            <option value="0">Seleccionar</option>
                                            <option v-for="(element, index) in users" :key="index" :value="element.id" v-text="element.name"></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="product">Seleccionar producto</label>
                                        <select name="" id="product" v-model="productId" @change="getPrice()" class="custom-select">
                                            <option value="0">Seleccionar</option>
                                            <option v-for="(element, index) in products" :key="index" :value="element.id" v-text="element.name"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="amount">Cantidad</label>
                                        <input type="text" v-model="amount" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="price">Precio</label>
                                        <input type="text" id="price" v-model="price" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    
                                    <div class="form-group" >
                                        <label for="name">Descuento</label>
                                        <input type="text" v-model="discount" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-info">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Quotation',
    mounted() {
        this.getUsers();
        this.getProducts();
        this.getQuotation();
    },
    data() {
        return {
            headers: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            },
            userId: 0,
            users: [],
            productId: 0,
            products: [],
            price: '',
            discount: '',
            amount: '',
            quotations: [],
            isLoad: false,
        }
    },
    methods: {
        getUsers() {
            this.$http.get('/users', this.headers).then((response) => {
                this.users = response.data; 
                console.log(this.users);
            }).catch((error) => {
                console.log(error);
            });
        },
        getProducts() {
            this.$http.get('/products-resource', this.headers).then((response) => {
                this.products = response.data;
                console.log(this.products);
            }).catch((error) => {      
                console.log(error);
            });
        },
        getPrice() {
            this.$http.get('/products-resource/'+this.productId+'/edit', this.headers).then((response) => {
                this.price = response.data.price;
            }).catch((error) => {      
                console.log(error);
            });
        },
        setQuotation() {
            let formData = {
                clientId: this.userId,
                productId: this.productId,
                productAmount: this.amount,
                price: this.price,
                discount: (this.discount.length > 0) ? this.discount : 0
            };
            this.$http.post('/quotations-resource', formData, this.headers).then((response) => {
                swal('OK', 'Cotizacion registrada', 'success');
                this.getQuotation();
                $("#quotationModal").modal('hide');
            }).catch((error) => {      
                console.log(error);
            });
        },
        getQuotation() {
            this.$http.get('/quotations-resource', this.headers).then((response) => {
                this.quotations = response.data;
            }).catch((error) => {      
                console.log(error);
            });
        },
        downloadPdf(id){
            window.open('/downloadQuotation/'+id);
        },
        sendEmail(id) {
            this.isLoad = true;
            this.$http.get('/sendEmail/'+id, this.headers).then((response) => {
                swal('OK', 'Enviado con exito', 'success');
                this.isLoad = false;
            }).catch((error) => {      
                console.log(error);
                this.isLoad = false;
            });
        }
    }
}
</script>

<style>

</style>