<template>
    <div>
        <form class="form" method="post" action="/auth/login">
            <h1>Authorization</h1>
            <input type="hidden" name="_token" :value="csrf">
            <div class="input-form" v-for="(fieldValue,fieldName) in $v.form" v-if="fieldName.indexOf('$') == -1">
                <input :class="{ 'error-input' : isFieldHasErrors(fieldValue)}"
                       @blur="fieldValue.$touch()" v-model="form[fieldName]"
                       type="text" :placeholder="fieldName" :id="fieldName" :name="fieldName">

                <div v-for="(val,valName) in fieldValue" v-if="valName.indexOf('$') == -1 && fieldValue.$dirty" class="error" v-html="errorsLogOut(valName,val,fieldValue,fieldName)">Required field</div>
            </div>
            <div class="input-form">
                <input :disabled="$v.$invalid" type="submit" value="Sign in">
            </div>
        </form>
    </div>
</template>

<script>
    import { required, minLength, } from 'vuelidate/lib/validators'

    export default {
        methods: {
            isFieldHasErrors(field) {
                if (field.$dirty && field.$error) {
                    return true;
                }
            },
            errorsLogOut(valName,val,fieldValue,fieldName) {
               if (valName == 'required' && !val) return 'Required field';
               if (valName == 'minLength' && !val) return `${fieldName} must be at least ${fieldValue.$params.minLength.min} characters`;
            }
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                form: {
                    login: '',
                    password: '',
                },
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
