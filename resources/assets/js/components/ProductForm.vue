<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div v-if="errors[0]" class="alert alert-danger">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <div class="card">
                <div class="card-body">
                    <p>Please add a PHP application</p>
                    <form>
                        <div class="form-group">
                            <label>URI</label>
                            <input v-model="url" class="form-control" placeholder="http://facebook.com" required>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input v-model="name" class="form-control" placeholder="페이스북" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary mb-2" @click="addProduct">Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                url: '',
                name: '',
                errors: [],
            }
        },
        methods: {
            addProduct: function (event) {
                this.validate();

                $('.modal').modal('show');

                if (event) event.preventDefault();

                axios.post('/api/products', {
                    url: this.url,
                    name: this.name
                }).then(response => {
                    location.href = "/";
                }).catch(e => {
                    let errors = e.response.data.errors;
                    if (errors) {
                        console.log(errors);
                        this.errors = errors;
                    } else {
                        let msg = e.response.data.message;
                        if(msg.includes('1062')) {
                            this.errors.push('It\'s already exists');
                        } else {
                            this.errors.push(msg);
                        }
                    }

                    $('.modal').modal('hide');
                });
            },
            validate: function () {
                if (!this.url) {
                    alert('URI is required');
                    return;
                }

                if (!this.name) {
                    alert('Name is required');
                    return;
                }
            }
        }
    }
</script>