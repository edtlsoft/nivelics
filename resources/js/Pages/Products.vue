<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Listado de Proveedores
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                      <div class="flex">
                        <div>
                          <p class="text-sm">{{ $page.props.flash.message }}</p>
                        </div>
                      </div>
                    </div>
                    <button @click="openModal()" dusk="form-create-product" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
                        Crear nuevo producto
                    </button>
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">No.</th>
                                <th class="px-4 py-2">Nombre</th>
                                <th class="px-4 py-2">Precio</th>
                                <th class="px-4 py-2">Cantidad</th>
                                <th class="px-4 py-2">Proveedor</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in data" :key="row.id">
                                <td class="border px-4 py-2">{{ row.id }}</td>
                                <td class="border px-4 py-2">{{ row.name }}</td>
                                <td class="border px-4 py-2">{{ row.price }}</td>
                                <td class="border px-4 py-2">{{ row.quantity }}</td>
                                <td class="border px-4 py-2">{{ row.provider.name }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <button @click="edit(row)" dusk="form-update-product" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                                    <button @click="deleteRow(row)" dusk="form-delete-product" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        
                        <div class="fixed inset-0 transition-opacity">
                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <!-- This element is to trick the browser into centering the modal contents. -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                        <div id="modal-products-form" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form>
                            <div class="bg-white px-4 pt-5 pb-2 sm:p-6 sm:pb-2">
                              <h2>{{ editMode ? 'ACTUALIZAR ' : 'REGISTRAR' }} PRODUCTO</h2>
                            </div>
                          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="">
                                  <div class="mb-4">
                                      <label for="product-name" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                                      <input type="text" dusk="product-name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="product-name" v-model="form.name">
                                      <div v-if="$page.props.errors.name" class="text-red-500">{{ $page.props.errors.name }}</div>
                                  </div>
                                  <div class="mb-4">
                                      <label for="product-price" class="block text-gray-700 text-sm font-bold mb-2">Precio:</label>
                                      <input type="text" dusk="product-price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="product-price" v-model="form.price">
                                      <div v-if="$page.props.errors.price" class="text-red-500">{{ $page.props.errors.price }}</div>
                                  </div>
                                  <div class="mb-4">
                                      <label for="product-quantity" class="block text-gray-700 text-sm font-bold mb-2">Cantidad:</label>
                                      <input type="text" dusk="product-quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="product-quantity" v-model="form.quantity">
                                      <div v-if="$page.props.errors.quantity" class="text-red-500">{{ $page.props.errors.quantity }}</div>
                                  </div>
                                  <div class="mb-4">
                                      <label for="product-provider" class="block text-gray-700 text-sm font-bold mb-2">Provedor:</label>
                                      <select dusk="product-provider" v-model="form.provider_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="product-provider">
                                          <option value=""></option>
                                          <option v-for="provider of providers" :key="provider.id" :value="provider.id">
                                              {{ provider.name }}
                                          </option>
                                      </select>
                                      <div v-if="$page.props.errors.provider" class="text-red-500">{{ $page.props.errors.provider }}</div>
                                  </div>
                            </div>
                          </div>
                          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" dusk="btn-manage-products" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-if="!editMode" @click="save(form)">
                                Guardar
                              </button>
                            </span>
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" dusk="btn-manage-products" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-if="editMode" @click="update(form)">
                                Actualizar
                              </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                              
                              <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                              </button>
                            </span>
                          </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from './../Jetstream/Welcome'
    export default {
        components: {
            AppLayout,
            Welcome,
        },
        props: ['data', 'errors', 'providers'],
        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    name: null,
                    price: null,
                    quantity: null,
                    provider_id: null,
                },
            }
        },
        methods: {
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {
                this.form = {
                    name: null,
                    price: null,
                    quantity: null,
                    provider_id: null,
                }
            },
            save: function (data) {
                let response = this.$inertia.post('/products', data)
                console.log('response:', response)

                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post(`/products/${data.id}`, data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Are you sure want to remove?')) return;
                data._method = 'DELETE';
                this.$inertia.post(`/products/${data.id}`, data)
                this.reset();
                this.closeModal();
            }
        }
    }
</script>