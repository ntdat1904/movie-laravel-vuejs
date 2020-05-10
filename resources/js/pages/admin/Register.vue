<template>
    <div class="login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="../../../../public/assets/pages/img/logo-big.png" alt=""/> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" autocomplete="on" @submit.prevent="register" method="post">
                <h3 class="font-green">Sign Up</h3>
                <p class="hint"> Enter your account details below: </p>
                <div class="form-group"
                     :class="{ 'has-error': $v.data.name.$error || (has_error && errors.name) }">
                    <label class="control-label visible-ie8 visible-ie9">Username</label>
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username"
                           v-model="data.name"
                           name="username"/>
                    <span class="help-block"
                          v-if="has_error && errors.name" v-for="error in errors.name">
                                    {{error}}
                    </span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': $v.data.email.$error || (has_error && errors.email) }">
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email"
                           v-model="data.email"
                           name="email"/>
                    <span class="help-block"
                          v-if="has_error && errors.email" v-for="error in errors.email">
                                    {{error}}
                    </span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': $v.data.password.$error || (has_error && errors.password) }">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                           v-model="data.password"
                           id="register_password" placeholder="Password" name="password"/>
                    <span class="help-block"
                          v-if="has_error && errors.password" v-for="error in errors.password">
                                    {{error}}
                    </span>
                </div>
                <div class="form-group"
                     :class="{ 'has-error': $v.data.password_confirmation.$error || (has_error && errors.password_confirmation) }">
                    <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off"
                           v-model="data.password_confirmation"
                           placeholder="Re-type Your Password" name="rpassword"/>
                    <span class="help-block"
                          v-if="has_error && errors.password_confirmation"
                          v-for="error in errors.password_confirmation">
                                    {{error}}
                    </span>
                </div>
                <div class="form-actions">
                    <router-link :to="'login'"
                                 class="btn green btn-outline" tag="button">
                        Back
                    </router-link>
                    <button type="submit" class="btn btn-success uppercase pull-right">Submit
                    </button>
                </div>
            </form>
        </div>
        <div class="copyright"> 2014 © Metronic. Admin Dashboard Template.</div>
    </div>
</template>
<script>
    import {required, minLength, sameAs, email} from "vuelidate/lib/validators";

    export default {
        data() {
            return {
                data: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                },
                has_error: false,
                error: '',
                errors: {},
                success: false
            }
        },
        validations: {
            data: {
                name: {required, min: minLength(6)},
                email: {required, email},
                password: {required, min: minLength(6)},
                password_confirmation: {
                    sameAsPassword: sameAs('password')
                },
            }
        },
        methods: {
            register() {
                var app = this
                this.$v.data.$touch();
                if (this.$v.data.$error) return;
                this.$auth.register({
                    data: {
                        email: app.data.email,
                        name: app.data.name,
                        password: app.data.password,
                        password_confirmation: app.data.password_confirmation
                    },
                    success: function () {
                        app.success = true
                        this.$router.push({name: 'login', params: {successRegistrationRedirect: true}})
                    },
                    error: function (res) {
                        app.has_error = true
                        app.error = res.response.data.error
                        app.errors = res.response.data.errors || {}
                    }
                })
            }
        }
    }
</script>

<style scoped>
    .has-error .form-control {
        border-color: red !important;
    }
</style>
