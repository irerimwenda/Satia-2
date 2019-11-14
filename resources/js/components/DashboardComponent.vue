<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Links</div>

                    <div class="card-body">
                        <form @submit.prevent="saveLink()">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="">Link</label>
                                    <select name="link_type" id="link_type" class="form-control">
                                        <option value="github">Github</option>
                                        <option value="linkedin">Linkedin</option>
                                        <option value="twitter">Twitter</option>
                                        <option value="blog">Blog</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input class="form-control" v-model="form.link" type="text" name="link" id="link">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="form-group">
                                    <button class="btn btn-success btn-block">Add Link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
            console.log('Component mounted.')
        },
        methods: {
            saveLink() {
                this.form.post('api/save-link')
                    .then(response => {
                        console.log('link saved')
                    })
                    .catch(error => {
                        console.log('error')
                    })
            },

            getLinks() {
                axios.get('api/get-links')
                .then(response => {
                    this.links = response.data
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>
