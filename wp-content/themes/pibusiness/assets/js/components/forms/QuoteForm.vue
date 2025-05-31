<template>
    <div class="quote-form-wrapper">
        <form @submit.prevent="onSubmit" class="bg-dark p-xl-5 text-white rounded">
            <slot></slot>
            <div class="form-group">
                <label for="city">Ciudad:</label>
                <select v-model="currentCity" class="form-control" id="city">
                    <option v-for="city in cities">{{ city.name }}</option>
                </select>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="peso">Peso:</label>
                        <input type="text" v-model="peso" class="form-control" id="peso">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="largo">Largo:</label>
                        <input type="text" v-model="largo" class="form-control" id="largo">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="ancho">Ancho:</label>
                        <input type="text" v-model="ancho" class="form-control" id="ancho">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="form-group">
                        <label for="alto">Alto:</label>
                        <input type="text" v-model="alto" class="form-control" id="alto">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-secondary mt-5" type="submit" v-if="total === 0">
                    Calcular fletes aereos
                </button>

                <button class="btn btn-outline-secondary mt-5" type="reset" v-if="total > 0" @click.prevent="reset">
                    Volver a comenzar
                </button>

                <div class="alert alert-primary my-4" v-if="total > 0">
                    <p class="lead">
                        ${{ parseInt(total) }} Dolares <br>
                    </p>
                </div>
            </div>
            <div class="alert alert-danger">
                Estos precios reflejan únicamente el costo de los fletes aéreos. Si
                desea saber el costo completo que incluye, impuestos, gastos de liberación etc...
                <a href="<?= home_url() ?>/cotizador/">
                    Por favor haga clic aquí y llene el formulario completo.
                </a>
            </div>
        </form>
    </div>
</template>

<script>
import Form from '../../api/form'
import {sweetAlert} from '../../utilities/sweet-alert'

export default {
    name: "QuoteForm",
    data() {
        return {
            peso: 0,
            largo: 0,
            ancho: 0,
            alto: 0,
            currentCity: 'Cali',
            total: 0,
            cities: [
                {
                    name: 'Cali',
                    cost: .77
                },
                {
                    name: 'Medellin',
                    cost: .77
                },
                {
                    name: 'Barranquilla',
                    cost: .77
                },
                {
                    name: 'Bogota',
                    cost: .67
                }
            ]
        }
    },
    computed: {
        volume() {
            return (this.largo * this.ancho * this.alto) / 166
        },
        chargedWeight() {
            if (this.peso > this.volume) {
                return this.peso
            }

            return this.volume
        }
    },
    methods: {
        onSubmit() {
            sweetAlert.fire({
                title: 'Gracias!',
                text: 'Su cotizacion esta lista',
                type: 'success',
            }).then(() => {
                let currentCity = this.cities.find(city => city.name === this.currentCity)
                this.total = currentCity.cost * this.chargedWeight
            })
        },
        reset() {
            this.total = 0
            this.peso = 0
            this.largo = 0
            this.ancho = 0
            this.alto = 0
            this.currentCity = 'Cali'
        }
    }
}
</script>

<style scoped lang="scss">
.quote-form-wrapper {
    h3 {
        color: #fff;
        margin-bottom: 40px !important;
    }
}
</style>