<template>
    <section class="sing-up">
        <div class="form-sing-in">
            <div class="head-sing-in">
                <p>Войти в Cloud8020</p>
            </div>
            <div class="body-sing-in">
                <form>
                    <div class="form-group mr-auto col-xs-4 col-sm-10 col-md-10">
                        <label for="sing-in-email">Email</label>
                        <input type="text"
                               class="form-control"
                               id="sing-in-email"
                               placeholder="Введите ваше email"
                               v-model.trim="form.email"
                               @blur="$v.form.email.$touch()"
                        >
                    </div>

                    <div class="form-group mr-auto col-xs-4 col-sm-10 col-md-10 error-validator" v-if="$v.form.email.$error">
                        <template v-if="!$v.form.email.required">
                            Поле обязательно к заполнению.
                        </template>
                        <template v-if="!$v.form.email.maxLength">
                            Длина email не должна превышать {{ $v.form.email.$params.maxLength.max }} символов
                        </template>
                        <template v-if="!$v.form.email.email">
                            Email введён не коректно
                        </template>
                    </div>

                    <div
                        class="form-group mr-auto col-xs-4 col-sm-10 col-md-10 error-validator"
                        v-if="this.errors.hasOwnProperty('email')"
                    >
                        <template>
                            {{this.errors.email[0]}}
                        </template>
                    </div>

                    <div class="form-group mr-auto col-xs-4 col-sm-10 col-md-10">
                        <label for="sing-in-password">Пароль</label>
                        <input type="text"
                               class="form-control"
                               id="sing-in-password"
                               placeholder="Введите ваше пароль"
                               v-model.trim="form.password"
                               @blur="$v.form.password.$touch()"
                        >
                    </div>

                    <div class="form-group mr-auto col-xs-4 col-sm-10 col-md-10 error-validator" v-if="$v.form.password.$error">
                        <template v-if="!$v.form.password.required">
                            Поле обязательно к заполнению.
                        </template>
                        <template v-if="!$v.form.password.maxLength">
                            Длина пароля не должна превышать {{ $v.form.password.$params.maxLength.max }} символов
                        </template>
                    </div>

                    <div
                        class="form-group mr-auto col-xs-4 col-sm-10 col-md-10 error-validator"
                        v-if="this.errors.hasOwnProperty('password')"
                    >s
                        <template>
                            {{this.errors.password[0]}}
                        </template>
                    </div>

                    <div class="form-group mr-auto col-xs-4 col-sm-10 col-md-10" style="text-align: center;">
                        <button class="btn btn-primary button-sing-in"
                                @click.prevent="sendData()"
                                :disabled="this.sending"
                        >
                            Подтвердить
                        </button>
                    </div>

                    <div
                        class="form-group mr-auto col-xs-4 col-sm-10 col-md-10 error-validator"
                        v-if="this.errors.hasOwnProperty('database')"
                    >
                        <template>
                            {{this.errors.database[0]}}
                        </template>
                    </div>

                    <div
                        class="form-group mr-auto col-xs-4 col-sm-10 col-md-10 error-validator"
                        v-if="this.errors.hasOwnProperty('verify')"
                    >
                        <template>
                            {{this.errors.verify[0]}}
                        </template>
                    </div>

                    <div class="form-group mr-auto col-xs-4 col-sm-10 col-md-10" style="text-align: center;">
                        <p><router-link to="/sing-up">Регистрация</router-link></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
    import {email, maxLength, required} from "vuelidate/lib/validators";
    import {mapMutations} from 'vuex';

    export default {
        data() {
            return {
                form: {
                    email: null,
                    password: null,
                },
                statusCode: null,
                errors: {},
                sending: false,
            }
        },
        validations: {
            form: {
                email: {
                    required,
                    email,
                    maxLength: maxLength(50),
                },
                password: {
                    required,
                    maxLength: maxLength(30),
                },
            }
        },
        methods: {
            sendData() {
                if (this.checkForm() && !this.$v.$invalid) {
                    this.sending = true;
                    axios.post('/api/user/sing-in', this.form)
                        .then((response) => {
                            this.authenticate(response.data.data.jwt_token);
                            this.setRoles(response.data.data.roles);
                            this.$router.push({name: "main"});
                        }).catch((error) => {
                            this.statusCode = error.response.data.status;
                            this.errors = error.response.data.errors;
                            this.sending = false;
                    });
                }
            },
            checkForm() {
                for (let prop in this.form) {
                    if (this.form[prop] === null) {
                        this.$v.$touch();
                        return false;
                    }
                }

                return true;
            },
            ...mapMutations('user', {
                authenticate: 'AUTHENTICATE',
                setRoles: "SET_ROLES"
            }),
        }
    }
</script>

<style scoped>
    .mr-auto {
        margin-right: auto;
        margin-left: auto;
    }

    .form-sing-in {
        margin-top: 50px;
        margin-right: auto;
        margin-left: auto;
        max-width: 400px;
        border: 1px solid #778899;
        background-color: #F8F8FF;
    }

    .head-sing-in{
        background-color: #406eb4;
        color: #F8F8FF;
        height: 40px;
        line-height: 40px;
        margin-bottom: 20px;
        text-align: center;
    }

    .head-sing-in p {
        height: 20px;
        font-size: 18px;
    }

    .button-sing-in {
        width: 200px;
        background-color: #87CEFA;
        color: #F8F8FF;
    }

    .body-sing-in{
        font-weight: 600;
    }

    .error-validator {
        color: #D8000C;
        text-align: center;
    }

</style>
