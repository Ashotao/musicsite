<template>
    <div>
        <form class="form" method="post" action="/auth/login">
            <h1>Authorization</h1>
            <input type="hidden" name="_token" :value="csrf">
            <div class="input-form">
                <input :class="{ 'error-input': ($v.form.login.$dirty && !$v.form.login.required) || !$v.form.login.minLength}"
                       @blur="$v.form.login.$touch()" v-model="form.login"
                       type="text" placeholder="Login" id="login" name="login">
                <div class="error" v-if="$v.form.login.$dirty && !$v.form.login.required">Required field</div>
                <div class="error" v-if="!$v.form.login.minLength">Login must be at least 3 characters</div>
            </div>
            <div class="input-form">
                <input :class="{ 'error-input': ($v.form.password.$dirty && !$v.form.password.required) || !$v.form.password.minLength}"
                       @blur="$v.form.password.$touch()" v-model="form.password"
                       type="password" placeholder="Password" id="password" name="password">
                <div class="error" v-if="$v.form.password.$dirty && !$v.form.password.required">Required field</div>
                <div class="error" v-if="!$v.form.password.minLength">Password must be at least 6 characters</div>
            </div>
            <div class="input-form">
                <input :disabled="!isFormValidated()" type="submit" value="Sign in">
            </div>
        </form>
    </div>
</template>

<script>
    import { required, minLength, } from 'vuelidate/lib/validators'

    export default {
        methods: {
            isFormValidated() {
                if (this.$v.$invalid === true) {
                    return false;
                } else {
                    return true;
                }
            }
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                form: {
                    login: '',
                    password: '',
                }
            }
        },
        validations: {
            form: {
                login: {
                    required,
                    minLength: minLength(3)
                },
                password: {
                    required,
                    minLength: minLength(6)
                },
            }
        },
    }
</script>
