<template>
  <div class="contact-form-wrapper">
    <form @submit.prevent="onSubmit" class="bg-dark p-xl-5 text-white rounded">
      <slot></slot>
      <div class="form-group">
        <label for="email">Email:</label>
        <input v-model="email" class="form-control" id="email" type="email"/>
      </div>
      <div class="form-group">
        <label for="message">Message:</label>
        <textarea name="email" class="form-control" id="message" cols="30" rows="10" v-model="message"></textarea>
      </div>
      <div class="form-group">
        <button class="btn btn-danger mt-5" type="submit">
          Submit
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import {sweetAlert} from "../../utilities/sweet-alert";

export default {
  name: "ContactForm",
  data() {
    return {
      email: "",
      message: "",
    }
  },
  methods: {
    onSubmit() {
      sweetAlert.fire({
        title: 'Thank you!',
        text: 'We will get in touch ASAP',
        type: 'success',
      }).then(() => {
        window.location.reload()
      })
    },
  }
}
</script>

<style scoped>

</style>