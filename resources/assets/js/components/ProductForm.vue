<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form>
                        <p>PHP 웹 애플리케이션을 등록해주세요.</p>
                        <div class="form-group">
                            <input v-model="url" class="form-control" placeholder="http://facebook.com" required>
                        </div>
                        <div class="form-group">
                            <input v-model="name" class="form-control" placeholder="페이스북" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary mb-2" @click="addProduct">추가하기
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
                errors: []
            }
        },
        methods: {
            addProduct: function (event) {
                this.validate();

                if (event) event.preventDefault();

                axios.post('/api/products', {
                    url: this.url,
                    name: this.name
                }).then(response => {
                    alert('submitted!');
                }).catch(e => {
                    this.errors.push(e.response.data.errors);
                });
            },
            validate: function () {
                if (!this.url || !this.name) {
                    alert('required');
                    return;
                }
            }
        }
    }
</script>