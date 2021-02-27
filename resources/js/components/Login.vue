<template>
    <div>
        <form method="post" action="/auth/login">
            <input type="hidden" name="_token" :value="csrf">
            <div>
                <label for="login">login</label>
                <input @blur="$v.form.login.$touch()" v-model="form.login" type="text" placeholder="text here..." id="login" name="login">
                <div class="error" v-if="$v.form.login.$dirty && !$v.form.login.required ">Это обязательное поле</div>
                <div class="error" v-if="!$v.form.login.minLength">Логин не должен быть меньше 3 символов</div>
            </div>
            <div>
                <label for="password">password</label>
                <input @blur="$v.form.password.$touch()" v-model="form.password" type="password" placeholder="text here..." id="password" name="password">
                <div class="error" v-if="$v.form.password.$dirty && !$v.form.password.required">Это обязательное поле</div>
                <div class="error" v-if="!$v.form.password.minLength">Пароль не должен быть меньше 6 символов</div>
            </div>
            <button :disabled="!isFormValidated()" type="submit">Вход</button>
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
