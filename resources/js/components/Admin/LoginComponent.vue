<template>
    <section class="login-page" style="min-height: 512.391px;">
        <div class="login-box">
            <div class="login-logo">
                <a href=""><b>Admin </b>Schedule System</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form action="" method="post">
                        <div class="input-group">
                            <input id="email" type="email" class="form-control" v-model="user.email" placeholder="Email">
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
                            <input type="password" class="form-control" id="password" v-model="user.password" placeholder="Password">
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

                        <div class="row mt-3">
                            <div class="col-8">
                                <!--<div class="icheck-primary">-->
                                    <!--<input type="checkbox" id="remember">-->
                                    <!--<label for="remember">-->
                                        <!--Remember Me-->
                                    <!--</label>-->
                                <!--</div>-->
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <a @click="submit()" class="btn btn-primary btn-block" style="color:#fff">
                                    <i v-if="isLoading" class="fa fa-spinner fa-spin float-right"></i>
                                    Sign In
                                </a>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    <p class="mb-0">
                        <a href="/admin/register" class="text-center">Register a new membership</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </section>
</template>
<script>
    import {url,apiUrl} from '../../common/config';
    export default {
        name:'login',
        data(){
            return{
                user:{
                    email:'',
                    password:''
                },
                isLoading: false,
                errors:[]
            }
        },
        methods:{
            submit(){
                let that = this;
                that.isLoading = true;
                that.errors=[];
                window.axios.post(apiUrl + 'admin/login', {'email': this.user.email, 'password': this.user.password})
                    .then(function ({data}) {
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
                        console.log('a',error);
                        that.isLoading = false;
                        that.$toasted.show('Please Try Again ...', {
                            type: 'error'
                        });
                    });
            }
        }
    }
</script>
