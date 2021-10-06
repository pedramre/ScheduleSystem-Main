<template>
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Job</h3>
            </div>
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" v-model="job.name" class="form-control" id="model">
                            </div>
                            <label v-for="error in errors.name" class="col-form-label" for="model" style="color: red;">
                                <i class="far fa-times-circle"></i>
                                {{ error }}
                            </label> <br>
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
import {url, apiUrl} from '../../../common/config';

export default {
    name: 'editJob',
    props:{
        job:Object
    },
    data() {
        return {
            isLoading: false,
            errors: [],
        }
    },
    created() {
        console.log('user', this.job);
    },
    methods: {
        submit: function () {
            let that = this;
            that.isLoading = true;
            that.errors = [];
            window.axios.post(apiUrl + 'admin/job/edit', {'job': this.job})
                .then(function ({data}) {
                    console.log('data', data.success);
                    if (data.success) {
                        that.isLoading = false;
                        that.$toasted.show(data.message, {
                            type: 'success',
                        });
                        window.location.href = url + "admin/job";

                    } else {
                        that.isLoading = false;
                        if (data.data.errorMessages) {
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
