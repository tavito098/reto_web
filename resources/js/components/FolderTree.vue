<template>
    <div class="container-fluid">
        <div class="row">
            <div id="recent-transactions" class="col-12">
                <div class="card">
                    <div class="card-header">
                       <h4 class="card-title">ARBOL DE CARPETAS</h4>
                    </div>
                    <div class="card-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" placeholder="Nombre de la carpeta" v-model="name"> 
                                </div>
                                <div class="col">
                                    <button 
                                        type="button" 
                                        class="btn btn-primary"
                                        @click="verifyAction()"
                                        v-text="(isUpdate) ? 'Actualizar nombre' : 'Crear carpeta'">
                                    </button>
                                    <button type="button" v-if="isUpdate" class="btn btn-secondary" @click="cancelUpdate"><i class="fas fa-times"></i> Cancelar</button>
                                    <button type="button" v-if="isUpdate" class="btn btn-danger" title="Eliminar carpeta" @click="deleteFolder"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"
                                                v-for="(element, index) in nameFolders" :key="index">
                                                <a href="#" @click="backFolder(element.id, element.name, index)" v-text="element.name"></a>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="row" v-if="folders.length > 0">
                                <div class="col-lg-3" 
                                    v-for="(element, index) in folders" 
                                    :key="index" 
                                    @dblclick="getSubFolders(element.id, element.name, element.current_route)"
                                    @click="editFolder(element.id, element.name)"
                                    >
                                    <div class="folder">
                                        <i class="fas fa-folder"></i> {{ element.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-else>
                                <div class="col">
                                    <div class="alert alert-info">No hay carpetas</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'folder-tree',
    mounted() {
        this.getFolders('folders');
    },
    data() {
        return {
            folders: [],
            folder_id: '',
            folderUpdateId: '',
            isUpdate: false,
            name: '',
            nameFolders: [{ id: 0, name: 'Inicio'}], 
            currentRoute: '',
            parentRoute: '',
            headers: {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            },
        }
    },
    methods: {
        getFolders(param) {
            let url = (param == 'folders') ? '/folders' : '/folders/'+this.folder_id;
            this.$http.get(url, this.headers).then((response) => {
                this.folders = response.data;
            }).catch((error) => {
                console.log(error);
            });
        },
        getSubFolders(id, name, currentRoute) {
            this.folder_id = id;
            this.parentRoute = currentRoute;
            let titleName = {id: id, name: name};
            (id == 0) ? '' : this.nameFolders.push(titleName);
            let param = (id == 0) ? 'folders' : 'subfolders';
            this.getFolders(param);
            this.cancelUpdate();
        },
        backFolder(id, name, index) {
            if(id == 0) {
                this.nameFolders = [{ id: 0, name: 'Inicio',}];
                this.getSubFolders(0,'Inicio','');
            }else{
                this.getSubFolders(id, name);
            }
        },
        verifyAction(){
            if(this.isUpdate) {
                this.updateFolder();
            }else{
                this.setFolder();
            }
        },
        setFolder() {
            let formData = {
                name: this.name,
                currentRoute: (this.currentRoute == '') ? '/'+this.name : this.currentRoute,
                parentRoute: this.parentRoute,
            };
            this.$http.post('/folders', formData, this.headers).then((response) => {
                let param = (this.folder_id == 'folders') ? '/folders' : '/folders/'+this.folder_id;
                this.getFolders(param);
                this.name = '';
            }).catch((error) => {
                console.log(error);
            });
        },
        editFolder(id, name) {
            this.isUpdate = true;
            this.name = name;
            this.folderUpdateId = id;
        },
        cancelUpdate() {
            this.isUpdate = false;
            this.name = '';
        },
        updateFolder() {
            let formData = {name: this.name};
            this.$http.put('/folders/'+this.folderUpdateId, formData, this.headers).then((response) => {
                if(this.nameFolders.length == 1) {
                    this.getFolders('folders');
                }else {
                    this.getFolders('subfolders');
                }
                this.cancelUpdate();
            }).catch((error) => {
                console.log(error);
            });
        },
        deleteFolder() {
            this.$http.delete('/folders/'+this.folderUpdateId, this.headers).then((response) => {
                console.log(response.data);
                if(this.nameFolders.length == 1) {
                    this.getFolders('folders');
                }else {
                    this.getFolders('subfolders');
                }
                this.cancelUpdate();
            }).catch((error) => {
                console.log(error);
            });
        }
    }
}
</script>

<style>
    .folder {
        background-color: gray;
        color: white;
        border-radius: 5px;
        height: 3rem;
        font-size: 20px;
        padding-top: 3px;
        padding-left: 10px;
        cursor: pointer;
        margin-top: 15px;
    }
    .folder:hover {
        background-color: silver;
    }
</style>