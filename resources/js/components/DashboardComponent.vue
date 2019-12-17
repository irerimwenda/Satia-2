<template>
    <div class="container">
        <div class="row justify-content-center">
        
            <div class="col-md-8 text-center">
                <button @click="addLinkBox" class="btn btn-primary white">Add Website Link</button>
            </div>

            <div class="col-md-8 mx-auto mt-3">
                <div class="card">
                    <div class="card-body">
                         <div class="row" v-for="link in links" :key="link.id">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold blue mb-0">{{link.link_type | capitalize}}</h6>
                                <span class="link mb-4">Link: <a :href="link.link">{{link.link}}</a></span>
                                <h6 class="added-by mt-1">Added by : {{link.user.name}}</h6>
                                
                                <hr>

                            </div>
                         </div>
                    </div>
                </div>
            </div>

        </div>

        <!--Add Website Link Modal-->
            <sweet-modal ref="addLinkModal" overlay-theme="dark">
                <template slot="title">
                    <h4 class="mt-4">Add a Website Link</h4>
                </template>
                 <div class="col-md-12">
                     <form @submit.prevent="saveLink()">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="">Website</label>
                                <select name="link_type" id="link_type" class="form-control" v-model="form.link_type" 
                                    :class="{ 'is-invalid': form.errors.has('link_type') }">
                                    <option value="github">Github</option>
                                    <option value="linkedin">Linkedin</option>
                                    <option value="twitter">Twitter</option>
                                    <option value="blog">Blog</option>
                                </select>
                                <has-error :form="form" field="link_type"></has-error>
                                <small class="form-text text-muted green">Choose a website to add link.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="link">Link</label>
                                <input class="form-control" v-model="form.link" type="text" name="link" id="link" 
                                :class="{ 'is-invalid': form.errors.has('link') }">
                                <has-error :form="form" field="link"></has-error>
                                <small class="form-text text-muted green">Type in the full URL link.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4 mx-auto">
                                <button class="btn btn-success btn-block">Add Link</button>
                            </div>
                        </div>
                    </form>
                 </div>
            </sweet-modal>
        <!--//End Add Website Link Modal-->
    </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform'

    export default {
        components: {
            Form
        },

        data() {
            return {
                links: {},
                form: new Form({
                    link_type: '',
                    link: ''
                })
            }
        },
        mounted() {
            //console.log('Component mounted.')
            this.getLinks()

            Fire.$on('refreshLinkAdded', () => {
                this.getLinks()
            })
        },
        methods: {
            addLinkBox() {
                this.$refs.addLinkModal.open()
                this.form.reset()
            },

            saveLink() {
                this.form.post('/api/save-link')
                    .then(response => {
                        //console.log('link saved')
                        this.$refs.addLinkModal.close()
                        this.form.reset()
                        Fire.$emit('refreshLinkAdded');

                        Toast.fire({
                            type: 'success',
                            title: 'Link added!'
                        })
                    })
                    .catch(error => {
                        //console.log('error')
                        this.form.reset()

                        Toast.fire({
                            type: 'error',
                            title: 'Ooops! Try again'
                        })
                    })
            },

            getLinks() {
                axios.get('api/get-links')
                .then(response => {
                    this.links = response.data
                })
                .catch(error => {
                    //console.log(error)
                })
            }
        }
    }
</script>
