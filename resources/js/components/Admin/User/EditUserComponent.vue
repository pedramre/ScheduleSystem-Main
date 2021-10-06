<template>
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>
            </div>
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" v-model="user.name" class="form-control" id="model">
                            </div>
                            <label v-for="error in errors.name" class="col-form-label" for="model" style="color: red;">
                                <i class="far fa-times-circle"></i>
                                {{ error }}
                            </label> <br>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" v-model="user.email" disabled class="form-control">
                            </div>
                            <br>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Role</label>
                                <select v-model="user.roles[0].id" class="form-control">
                                    <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                                </select>
                            </div>
                            <br>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button @click="submit()" type="submit" class="btn btn-primary">
                    <i v-if="isLoading" class="fa fa-spinner fa-spin float-right"></i>
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {url,apiUrl} from '../../../common/config';
export default {
    name:'editUser',
    props:{
        user:{
            type:Object,
        },
        roles:{
            type:Array,
        }
    },
    data(){
        return{
            isLoading:false,
            errors:[],
        }
    },
    created(){
        console.log('user',this.user);
    },
    methods:{
        submit:function(){
            let that = this;
            that.isLoading = true;
            that.errors=[];
            console.log('user',this.user)
            window.axios.post(apiUrl + 'admin/user/edit', {'user': this.user})
                .then(function ({data}) {
                    console.log('data', data.success);
                    if (data.success) {
                        that.isLoading = false;
                        that.$toasted.show(data.message, {
                            type: 'success',
                        });
                        window.location.href = url+"admin/user";

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
