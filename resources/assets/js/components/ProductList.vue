<template>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4" v-for="product in products" :key="product.id">
                <div class="card mb-3" @click="show(product)">
                    <img class="card-img-top" src="https://laravel.kr/assets/images/laravelKr-logo.png" alt="Card image cap" v-if="products.img_path">
                    <div class="card-body">
                        <h5 class="card-title">{{ product.name }}</h5>
                        <p class="card-text" v-if="product.description">{{ product.description }}</p>
                        <p class="card-text" v-if="product.created_at"><small class="text-muted">{{ product.created_at }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                products: [],
            }
        },
        methods: {
            show: function (product) {
                location.href = product.url;
            }
        },
        created: function () {
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data.data;
                });
        }
    }
</script>