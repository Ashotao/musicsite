<template>
    <div>
        <form class="form" method="post" action="/auth/register">
            <h1>Registration</h1>
            <input type="hidden" name="_token" :value="csrf">
            <div class="input-form" v-for="(fieldValue,fieldName) in $v.form" v-if="fieldName.indexOf('$') == -1">
                <input :class="{ 'error-input' : isFieldHasErrors(fieldValue)}"
                       @blur="fieldValue.$touch()" v-model="form[fieldName]"
                       type="text" :placeholder="fieldName.replace('_', ' ')" :id="fieldName" :name="fieldName">

                <div v-for="(val,valName) in fieldValue" v-if="valName.indexOf('$') == -1 && fieldValue.$dirty" class="error" v-html="errorsLogOut(valName,val,fieldValue,fieldName)">Required field</div>
            </div>
            <div class="input-form">
                <input :disabled="$v.$invalid" type="submit" value="Register">
            </div>
        </form>
    </div>
</template>

<script>
import { required, maxLength, sameAs, minLength, email } from 'vuelidate/lib/validators'

export default {
    methods: {
        isFieldHasErrors(field) {
           return field.$dirty && field.$error;
        },
        errorsLogOut(valName,val,fieldValue,valueName,fieldName) {
            if (valName == 'email' && !val) return 'Email is invalid';
            if (valName == 'sameAsPass' && !val) return 'The password and confirm password fields do not match'
            if (valName == 'required' && !val) return 'Required field';
            if (valName == 'minLength' && !val) return `${fieldName} must be at least ${fieldValue.$params.minLength.min} characters`;
            if (valName == 'maxLength' && !val) return `${fieldName} is too long (maximum is ${fieldValue.$params.maxLength.max} characters)`;
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
