<div :style="{backgroundColor: backgroundColor}">
    <form v-on:submit.prevent="submit">
        <div class="form-content">
            <slot></slot>
        </div>
        <div class="form-group">
            <label v-if="hasLabels">Name <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control"
                   :class="{'is-invalid': formError.has('name')}"
                   :placeholder="!hasLabels ? 'Name' : ''"
                   required="required"
                   v-model="name">
            <p class="invalid-feedback"
               v-text="formError.get('name')"
               v-if="formError.has('name')"></p>
        </div>
        <div class="form-group">
            <label v-if="hasLabels">Phone <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control"
                   :class="{'is-invalid': formError.has('phone')}"
                   :placeholder="!hasLabels ? 'Phone' : ''"
                   required="required"
                   v-model="phone">
            <p class="invalid-feedback"
               v-text="formError.get('phone')"
               v-if="formError.has('phone')"></p>
        </div>
        <div class="form-group">
            <label v-if="hasLabels">Email <span class="text-danger">*</span></label>
            <input type="email"
                   class="form-control"
                   :class="{'is-invalid': formError.has('email')}"
                   :placeholder="!hasLabels ? 'Email' : ''"
                   required="required"
                   v-model="email">
            <p class="invalid-feedback"
               v-text="formError.get('email')"
               v-if="formError.has('email')"></p>
        </div>
        <div class="form-group">
            <label v-if="hasLabels">How can we help you?</label>
            <textarea class="form-control"
                      :class="{'is-invalid': formError.has('message')}"
                      :placeholder="!hasLabels ? 'How can we help you?' : ''"
                      v-model="message"></textarea>
            <p class="invalid-feedback"
               v-text="formError.get('message')"
               v-if="formError.has('message')"></p>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-secondary" :class="{
                'btn-submitting': submitting,
                'btn-errors': hasErrors,
                'btn-submitted': formSuccess
            }">Get Help Now &nbsp;&nbsp; <i class="fa fa-chevron-right" aria-hidden="true"></i></button>

            <div class="g-recaptcha" data-sitekey="6LdEP-QUAAAAAF4fdbU3mGJ2Vrh-M_fHtcoSBlro" id="contact-captcha"></div>
            <p class="invalid-feedback"
               v-text="formError.get('g_recaptcha_response')"
               v-if="formError.has('g_recaptcha_response')"></p>
        </div>
    </form>
</div>
