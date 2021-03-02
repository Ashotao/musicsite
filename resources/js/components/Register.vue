<template>
    <div>
        <form class="form" method="post" action="/auth/register">
            <h1>Registration</h1>
            <input type="hidden" name="_token" :value="csrf">
            <div class="input-form">
                <input :class="{'error-input': !$v.form.nickname.maxLength}"
                       @blur="$v.form.nickname.$touch()" v-model="form.nickname"
                       type="text" placeholder="Nickname" id="nickname" name="nickname">
                <div class="error" v-if="!$v.form.nickname.maxLength">Никнейм не должен быть больше 25 символов</div>
            </div>
            <div class="input-form">
                <input :class="{ 'error-input': ($v.form.login.$dirty && !$v.form.login.required) || !$v.form.login.minLength}"
                       @blur="$v.form.login.$touch()" v-model="form.login"
                       type="text" placeholder="Login" id="login" name="login">
                <div class="error" v-if="$v.form.login.$dirty && !$v.form.login.required">Это обязательное поле</div>
                <div class="error" v-if="!$v.form.login.minLength">Логин не должен быть меньше 3 символов</div>
            </div>
            <div class="input-form">
                <input :class="{ 'error-input': ($v.form.email.$dirty && !$v.form.email.required) || !$v.form.email.email}"
                       @blur="$v.form.email.$touch()" v-model="form.email"
                       type="text" placeholder="E-mail" id="email" name="email">
                <div class="error" v-if="$v.form.email.$dirty && !$v.form.email.required">Это обязательное поле</div>
                <div class="error" v-if="!$v.form.email.email">Введите корректную почту</div>
            </div>
            <div class="input-form">
                <input :class="{ 'error-input': ($v.form.password.$dirty && !$v.form.password.required) || !$v.form.password.minLength}"
                       @blur="$v.form.password.$touch()" v-model="form.password"
                       type="password" placeholder="Password" id="password" name="password">
                <div class="error" v-if="$v.form.password.$dirty && !$v.form.password.required">Это обязательное поле</div>
                <div class="error" v-if="!$v.form.password.minLength">Пароль не должен быть меньше 6 символов</div>
            </div>
            <div class="input-form">
                <input :class="{ 'error-input': ($v.form.confirm_password.$dirty && !$v.form.password.required) || ($v.form.confirm_password.$dirty && !$v.form.confirm_password.sameAsPass)}"
                       @blur="$v.form.confirm_password.$touch()" v-model="form.confirm_password"
                       type="password" placeholder="Confirm password" id="confirm_password" name="confirm_password">
                <div class="error" v-if="$v.form.confirm_password.$dirty && !$v.form.password.required">Это обязательное поле</div>
                <div class="error" v-if="$v.form.confirm_password.$dirty && !$v.form.confirm_password.sameAsPass">Пароли должны совпадать</div>
            </div>
            <p>* - поля обязательные для заполнения</p>
            <div class="input-form">
                <input :disabled="!isFormValidated()" type="submit" value="Register">
            </div>
        </form>
    </div>
</template>

<script>
import { required, maxLength, sameAs, minLength, email } from 'vuelidate/lib/validators'

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
                nickname: '',
                login: '',
                email: '',
                password: '',
                confirm_password: ''
            }
        }
    },
    validations: {
        form: {
            nickname: {
                maxLength: maxLength(25)
            },
            login: {
                required,
                minLength: minLength(3)
            },
            email: {
                required,
                email
            },
            password: {
                required,
                minLength: minLength(6)
            },
            confirm_password: {
                required,
                sameAsPass: sameAs('password')
            }
        }
    },
}
</script>
