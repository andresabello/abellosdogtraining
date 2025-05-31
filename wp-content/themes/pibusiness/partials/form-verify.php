<div class="verify-insurance">
    <form @submit.prevent="submit">
        <div id="search-group" class="form-groups">
            <h4>Lookup Patient Insurance</h4>
            <div class="form-group">
                <label for="payer_id">Insurance Carrier<span class="text-danger">*</span></label>
                <div class="input-group mb-2">
                    <multiselect id="payer_id"
                                 v-model="payer_id"
                                 :options="carriers"
                                 :searchable="true"
                                 :close-on-select="true"
                                 :show-labels="false"
                                 label="payerName"
                                 track-by="payerId"
                                 :class="{'is-invalid': formError.has('payer_id')}"
                                 required="required"></multiselect>
                </div>
                <p class="invalid-feedback"
                   v-text="formError.get('payer_id')"
                   v-if="formError.has('payer_id')"></p>
            </div>
        </div>

        <div id="information-for" class="form-groups">
            <h4>Information For</h4>

            <div class="form-group">
                <input type="radio" id="myself" name="relation" value="myself" v-model="subscriber_relation"
                       required="required">
                <label for="myself">Myself</label>&nbsp
                <input type="radio" id="loved-one" name="relation" value="loved one" v-model="subscriber_relation">
                <label for="loved-one">Loved One<span class="text-danger">*</span></label>
                <br>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="client_phone">Phone Number<span class="text-danger">*</span></label>
                        <input id="client_phone" type="text"
                               class="form-control"
                               :class="{'is-invalid': formError.has('client_phone')}"
                               required="required"
                               v-model="client_phone">
                        <p class="invalid-feedback"
                           v-text="formError.get('client_phone')"
                           v-if="formError.has('client_phone')"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="client_email">Email<span class="text-danger">*</span></label>
                        <input id="client_email" type="email"
                               class="form-control"
                               :class="{'is-invalid': formError.has('client_email')}"
                               required="required"
                               v-model="client_email">
                        <p class="invalid-feedback"
                           v-text="formError.get('client_email')"
                           v-if="formError.has('client_email')"></p>
                    </div>
                </div>
            </div>
        </div>

        <div id="personal-information" class="form-groups">
            <h4>Patient Information</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                        <input id="first_name" type="text"
                               class="form-control"
                               :class="{'is-invalid': formError.has('first_name')}"
                               required="required"
                               v-model="first_name">
                        <p class="invalid-feedback"
                           v-text="formError.get('first_name')"
                           v-if="formError.has('first_name')"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input id="last_name" type="text"
                               class="form-control"
                               :class="{'is-invalid': formError.has('last_name')}"
                               required="required"
                               v-model="last_name">
                        <p class="invalid-feedback"
                           v-text="formError.get('last_name')"
                           v-if="formError.has('last_name')"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date_of_birth">Date Of Birth<span class="text-danger">*</span></label>
                        <flat-pickr id="date_of_birth"
                                    v-model="date_of_birth"
                                    class="form-control"
                                    :class="{'is-invalid': formError.has('date_of_birth')}"
                                    required="required"></flat-pickr>
                        <p class="invalid-feedback"
                           v-text="formError.get('date_of_birth')"
                           v-if="formError.has('date_of_birth')"></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Gender<span class="text-danger">*</span></label>
                        <br>
                        <input type="radio" id="male" name="gender" value="male" v-model="gender"
                               required="required">
                        <label for="male">Male</label>&nbsp

                        <input type="radio" id="female" name="gender" value="female" v-model="gender">
                        <label for="female">Female</label>&nbsp

                        <input type="radio" id="other" name="gender" value="other" v-model="gender">
                        <label for="other">Other</label>&nbsp

                        <p class="invalid-feedback"
                           v-text="formError.get('gender')"
                           v-if="formError.has('gender')"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="member_id">Member ID<span class="text-danger">*</span></label>
                        <input id="member_id" type="text"
                               class="form-control"
                               :class="{'is-invalid': formError.has('member_id')}"
                               required="required"
                               v-model="member_id">
                        <p class="invalid-feedback"
                           v-text="formError.get('member_id')"
                           v-if="formError.has('member_id')"></p>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="g-recaptcha" id="verify-captcha" :data-sitekey="key"></div>
                    <p class="invalid-feedback"
                       v-text="formError.get('g_recaptcha_response')"
                       v-if="formError.has('g_recaptcha_response')"></p>
                </div>
            </div>
        </div>

        <button class="btn btn-primary mb-lg-5">Submit</button>
    </form>
</div>
