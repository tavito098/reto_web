<template>
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel" v-text="modalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multiplart\form-data" @submit.prevent="setProduct" autocomplete="off">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div id="searching_div" class="shadow p-1 rounded">
                                    <div class="input-box">
                                        <div class="row-icon">
                                            <i class="fas fa-search icon-searching"></i>
                                        </div>
                                        <div class="div-search">
                                            <input type="text" id="input_search" placeholder="Buscar categoria" v-model="category" @keyup="searchCategories">
                                        </div>
                                    </div>
                                    <div v-for="(element, index) in categories" :key="index">
                                        <div class="row_searching elements">
                                            <div class="result_row" @click="getCategoryId(element.id, element.name)" v-text="element.name"></div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                                <span v-if="errors.category" class="help-block text-danger">Campo requerido</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">Nombre del producto*</label>
                                    <input type="text" id="name" v-model="name" class="form-control">
                                    <span v-if="errors.name" class="help-block text-danger">Campo requerido</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="description">Descripcion</label>
                                    <textarea id="description" v-model="description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="price">Precio*</label>
                                    <input type="text" id="price" v-model="price" class="form-control">
                                    <span v-if="errors.price" class="help-block text-danger">Campo requerido</span>
                                </div>
                            </div>
                            <div class="col">
                                
                                <div class="form-group" >
                                    <label for="name">Imagen</label>
                                    <input type="file" class="form-control" ref="file" @change="onChangeFileUpload">
                                   
                                    <a v-if="image.length > 0"
                                        target="_blank"
                                        :href="'images/products/'+this.image">
                                        Ver imagen
                                    </a>
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
</template>

<script>
export default {
    name: 'Modal',
    data() {
        return {
            headers: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            },
            categories: [],
            category: '',
            category_id: 0,
            name: '',
            description: '',
            price: '',
            image: '',
            errors: [],
            product_id: null,
        }
    },
    computed: {
        modalTitle() {
            return this.$store.state.modalTitle
        },
        product() {
            return this.$store.state.product
        }
    },
    watch: {
        product(newVal, oldVal){
            this.category_id = newVal.category.id;
            this.category = newVal.category.name;
            this.product_id = newVal.id;
            this.name = newVal.name;
            this.description = newVal.description;
            this.price = newVal.price;
            this.image = (newVal.image == null) ? '' : newVal.image;
        },
        modalTitle() {
            this.formClear();
        }
    },
    methods: {
        searchCategories() {
            if(this.category.length > 2) {
                this.$http.get('/categories/'+this.category, this.headers).then((response) => {
                    this.categories = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            }
        },
        getCategoryId(id, name) {
            this.category_id = id;
            this.category = name;
            this.categories = [];
        },
        onChangeFileUpload(){
            this.image = this.$refs.file.files[0];
        },
        setProduct() {
            let formData = new FormData();
            let headers = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            };
            let category = (this.category_id > 0) ? this.category_id : this.category;
            let description = (this.description == '') ? 'Sin descripcion' : this.description;
            formData.append('product_id', this.product_id);
            formData.append('category', category);
            formData.append('name', this.name);
            formData.append('description', description);
            formData.append('price', this.price);
            formData.append('image', this.image);

            this.$http.post('/products-resource', formData, headers).then((response) => {
                this.$store.dispatch('getProducts');
                this.formClear();
                swal('OK', 'registro exitoso', 'success');
            }).catch((error) => {
                this.errors = error.body.errors;
            });
        },
        formClear() {
            this.product_id = '';
            this.categories = [];
            this.category = '';
            this.category_id = 0;
            this.name = '';
            this.description = '';
            this.price = '';
            this.image = '';
            this.errors = [];
            this.image = '';
            $("#productModal").modal('hide');
        }
    }    
}
</script>

<style>
    #searching_div {
        width: 100%;
    }
    .input-box {
        display: flex;
    }
    .row-icon {
        width: 5%;
        display: flex;
        justify-content: center;
        margin-top: 1%;
    }
    .div-search {
        width: 100%;
    }
    .row_searching {
        display: inline-flex;
        width: 100%;
    }
    .elements:hover {
        background-color: #f7f4f4;
        color:black;
        cursor: default;
    }
    #input_search {
        width:100%;
        max-width: 100%;
        border:none;
        padding-top:6px;
    }
    .icon-searching {
        color:silver;
    }
    .icon_row {
        color:silver;
        padding-top:5px;
    }
    .result_row {
        width:100%;
        border:none;
        height: auto;
        padding-left:1em;
    }
</style>