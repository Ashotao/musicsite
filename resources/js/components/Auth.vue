<template>
    <div>
        <p>Auth page</p>
        <pre>

        </pre>
        <form method="post" action="/api/auth/register">
            <div>
                <label for="nickname">Nickname</label>
                <input @blur="$v.form.login.$touch()" v-model="form.nickname" type="text" placeholder="text here..." id="nickname" name="nickname">
                <div class="error" v-if="!$v.form.nickname.maxLength">Никнейм не должен быть больше 25 символов</div>
            </div>
            <div>
                <label for="login">Login*</label>
                <input @blur="$v.form.login.$touch()" v-model="form.login" type="text" placeholder="text here..." id="login" name="login">
                <div class="error" v-if="$v.form.login.$dirty && !$v.form.login.required ">Это обязательное поле</div>
                <div class="error" v-if="!$v.form.login.minLength">Логин не должен быть меньше 3 символов</div>
            </div>
            <div>
                <label for="email">E-mail*</label>
                <input @blur="$v.form.email.$touch()" v-model="form.email" type="text" placeholder="text here..." id="email" name="email">
                <div class="error" v-if="$v.form.email.$dirty && !$v.form.email.required">Это обязательное поле</div>
                <div class="error" v-if="!$v.form.email.email">Введите корректную почту</div>
            </div>
            <div>
                <label for="password">Password*</label>
                <input @blur="$v.form.password.$touch()" v-model="form.password" type="password" placeholder="text here..." id="password" name="password">
                <div class="error" v-if="$v.form.password.$dirty && !$v.form.password.required">Это обязательное поле</div>
                <div class="error" v-if="!$v.form.password.minLength">Пароль не должен быть меньше 6 символов</div>
            </div>
            <div>
                <label for="confirm_password">Confirm password*</label>
                <input @blur="$v.form.confirm_password.$touch()" v-model="form.confirm_password" type="password" placeholder="text here..." id="confirm_password" name="confirm_password">
                <div class="error" v-if="$v.form.confirm_password.$dirty && !$v.form.password.required">Это обязательное поле</div>
                <div class="error" v-if="$v.form.confirm_password.$dirty && !$v.form.confirm_password.sameAsPass">Пароли должны совпадать</div>
            </div>
            <p>* - поля обязательные для заполнения</p>
            <button type="submit" :disabled="!isFormValidated()">Регистрация</button>
        </form>


        <form method="post" action="/api/auth/login">
            <div>
                <label for="login1">login</label>
                <input type="text" placeholder="text here..." id="login1" name="login">
            </div>
            <div>
                <label for="password1">password</label>
                <input type="password" placeholder="text here..." id="password1" name="password">
            </div>
            <button type="submit">Вход</button>
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
                asd: [],
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
