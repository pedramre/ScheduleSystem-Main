<template>
    <section class="register-page" style="min-height: 586.391px;">
        <div class="register-box">
            <div class="register-logo">
                <a href=""><b>Register </b>Rent Car</a>
            </div>

            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Register a new membership</p>

                    <form action="" method="post">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="user.name" id="name" placeholder="Full name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <label v-for="error in errors.name" class="col-form-label" for="name" style="color: red;">
                            <i class="far fa-times-circle"></i>
                            {{ error }}
                        </label> <br>

                        <div class="input-group mt-3">
                            <input type="email" class="form-control" v-model="user.email" id="email" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <label v-for="error in errors.email" class="col-form-label" for="email" style="color: red;">
                            <i class="far fa-times-circle"></i>
                            {{ error }}
                        </label> <br>

                        <div class="input-group mt-3">
                            <input type="password" class="form-control" v-model="user.password" id="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <label v-for="error in errors.password" class="col-form-label" for="password" style="color: red;">
                            <i class="far fa-times-circle"></i>
                            {{ error }}
                        </label> <br>

                        <div class="input-group mt-3 mb-3">
                            <input type="password" class="form-control" v-model="user.password_confirmation" placeholder="Retype password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-8">
                            </div>

                            <!-- /.col -->
                            <div class="col-4">
                                <a @click="submit()" class="btn btn-primary btn-block" style="color:#fff">
                                    <i v-if="isLoading" class="fa fa-spinner fa-spin float-right"></i>
                                    Register
                                </a>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <a href="/admin/login" class="text-center">I already have a membership</a>
                </div>
                <!-- /.form-box -->
            </div><!-- /.card -->
        </div>
    </section>
</template>

<script>
    import {url,apiUrl} from '../../common/config';
    export default {
        name:'register',
        data(){
            return{
                user:{
                    name:'',
                    email:'',
                    password:'',
                    password_confirmation:'',
                    agreeTerms:false
                },
                isLoading: false,
                errors:[]
            }
        },
        methods:{
            submit:function () {
                let that = this;
                that.isLoading = true;
                that.errors=[];
                window.axios.post(apiUrl + 'admin/register', {'user': this.user})
                    .then(function ({data}) {
                        console.log('data', data.success);
                        if (data.success) {
                            that.isLoading = false;
                            that.$toasted.show(data.message, {
                                type: 'success',
                            });
                            window.location.href = url+"admin/dashboard";
                        }
                        else {
                            that.isLoading = false;
                            if(data.data.errorMessages){
                                that.errors = data.data.errorMessages;
                            }
                            that.$toasted.show(data.message, {
                                type: 'error',
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        that.isLoading = false;
                        that.$toasted.show('Please Try Again ...', {
                            type: 'error'
                        });
                    });

            }
        }
    }
</script>
