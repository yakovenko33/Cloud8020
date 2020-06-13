<template>
    <div class="edit-car-park">
        <div class="col-md-12">
            <form>
                <div class="form-group row">
                    <div class="title col-md-12 ">
                        <span class="car-park main-elem color-text-elem">
                            Автопарк
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title-car-park" class="col-md-3 col-form-label color-text-elem">Название</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="title-car-park" v-model.trim="dataForm.car_park.title">
                    </div>
                </div>

                <div class="error-validator" v-if="this.errors.hasOwnProperty('title')">
                    <template >
                        {{this.errors.title[0]}}
                    </template>
                </div>


                <div class="form-group row">
                    <label for="address-car-park" class="col-md-3 col-form-label color-text-elem">Адресс</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="address-car-park" v-model.trim="dataForm.car_park.address">
                    </div>
                </div>

                <div class="error-validator" v-if="this.errors.hasOwnProperty('address')">
                    <template >
                        {{this.errors.address[0]}}
                    </template>
                </div>

                <div class="form-group row">
                    <label for="time-work-car-park" class="col-sm-3 col-form-label color-text-elem">График работы</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="time-work-car-park" v-model.trim="dataForm.car_park.time_work">
                    </div>
                </div>

                <div class="error-validator" v-if="this.errors.hasOwnProperty('time_work')">
                    <template >
                        {{this.errors.time_work[0]}}
                    </template>
                </div>

                <div class="form-group row">
                    <div class="title col-md-12">
                        <span class="car-park main-elem color-text-elem">
                            Машины
                        </span>
                    </div>
                </div>
                <hr>

                <div class="form-group row">
                    <div class="col-md-4 offset-md-1">
                        <label class="color-text-elem">Номер машины</label>

                        <div class="form-group row" v-for="(car, index) in this.dataForm.cars">
                            <input type="text" class="form-control car-elem" v-model.trim="car.number_car">
                            <div v-if="this.errors.hasOwnProperty('cars_errors')">
                                <span v-if="this.errors.cars_errors[index - 1].hasOwnProperty('name_driver')">
                                    {{ this.errors.cars_errors[index - 1].name_driver }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-1">
                        <label class="color-text-elem">Имя водителя</label>

                        <div class="form-group row" v-for="(car, index) in this.dataForm.cars">
                            <input type="text" class="form-control car-elem col-md-8" v-model.trim="car.name_driver">
                            <div class="delete-car offset-md-1 col-md-1" @click="removeCar(index)" id="index"><span>&#x2212</span></div>
                        </div>
                    </div>
                </div>

                <div class="add-car" @click="addCar()">
                    <span>+</span>
                </div>

                <button
                    class="btn save-button mr-20-vertical"
                    @click="sendData()"
                >
                    Сохранить
                </button>
            </form>
        </div>
    </div>
</template>

<script>
    import http from "../../api/api";

    export default {
        data() {
            return {
                dataForm: {
                    car_park: {
                        title: '',
                        address: '',
                        time_work: '',
                    },
                    cars: [
                        {
                            number_car: '',
                            name_driver: '',
                        },
                    ]
                },
                errors: {}
            }
        },
        methods: {
            addCar(){
                this.dataForm.cars.push({
                    number: null,
                    nameDriver: null,
                })
            },
            sendData(){
                console.log(this.dataForm);
                // if("edit-car") {
                //     delete this.dataForm.car_park
                // }
                http.getHttp().post("/car-park", this.dataForm)
                    .then((response) => {
                        console.log(response.data);
                    }).catch((error) => {
                        this.errors = error.response.data.errors;
                });
            },
            removeCar(index){
                this.dataForm.cars.splice(index, 1);
            }
        }
    }
</script>

<style scoped>
    .edit-car-park {
        margin-top: 40px;
        margin-right: auto;
        margin-left: auto;
        max-width: 800px;
        border: 1px solid #778899;
        background-color: #F8F8FF;
    }

    .color-text-elem {
        color: #666e9c;
    }

    .main-elem {
        font-weight: 600;
        font-size: 22px;
    }

    .mr-auto {
        margin-right: auto;
        margin-left: auto;
    }

    .mr-20-vertical {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .car-elem {
        /*margin-top: 15px;*/
    }

    hr {
        border: none;
        background-color: #666e9c;
        color: #666e9c;
        height: 2px;
    }

    .delete-car {
        width: 25px;
        height: 25px;
        background: #fd367b;
        margin-top: 5px;
        content: "&#x2212";
        color: #FFFFFF;
        text-align: center;
        border: 1px solid #fd367b;
        border-radius: 4px;
        cursor: pointer;
    }

    .delete-car:active {
        width: 25px;
        height: 25px;
        background: #800080;
        margin-top: 5px;
        content: "&#x2212";
        color: #FFFFFF;
        text-align: center;
        border: 1px solid #800080;
        border-radius: 4px;
        cursor: pointer;
    }

    .add-car {
        width: 25px;
        height: 25px;
        background: #3549d8;
        margin-top: 5px;
        content: "&#x2212";
        color: #FFFFFF;
        text-align: center;
        border: 1px solid #3549d8;
        border-radius: 4px;
        cursor: pointer;
    }

    .add-car:active {
        width: 25px;
        height: 25px;
        background: #00BFFF;
        margin-top: 5px;
        content: "&#x2212";
        color: #FFFFFF;
        text-align: center;
        border: 1px solid #00BFFF;
        border-radius: 4px;
        cursor: pointer;
    }

    .save-button {
        background: #17cab8;
        color: #ffffff;
    }

    .save-button:active {
        background: #0000CD;
        color: #ffffff;
    }

    .error-validator {
        color: #D8000C;
        text-align: center;
        margin-bottom: 15px;
    }
</style>
