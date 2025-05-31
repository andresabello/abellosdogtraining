<template>
    <div class="currency-converter">
        <form class="bg-light p-xl-5 rounded">
            <slot></slot>
            <div class="form-group">
                <label for="amount">Cantidad (Pesos Colombianos):</label>
                <input type="text" v-model="quantity" class="form-control" id="amount">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Convertir</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "CurrencyConverter",
    data() {
        return {
            quantity: 0
        }
    },
}
</script>

<style scoped lang="scss">
.currency-converter {
    h3 {
        margin-bottom: 40px !important;
    }
}
</style>