<template>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4" v-for="product in products" :key="product.id">
                <div class="card mb-3" @click="show(product)">
                    <img class="card-img-top" :src="product.screenshot" alt="Card image cap" v-if="product.screenshot">
                    <div class="card-body">
                        <h5 class="card-title">{{ product.name }}</h5>
                        <p class="app-link"><a :href="product.url">{{ product.url }}</a> </p>
                        <p class="card-text app-description" v-if="product.description">{{ product.description }}</p>
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

<style>
    .card-title {
        font-size:2em;
        font-weight:bold;
        margin-bottom:0;
    }

    .app-link > a,
    .app-link > a:hover {
        color: #8894BC;
    }

    .app-description {
        height: 4rem;
        overflow: hidden;
    }
</style>