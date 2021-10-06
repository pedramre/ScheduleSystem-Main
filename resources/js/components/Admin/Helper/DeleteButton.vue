<template>
    <a @click="submit" class="btn btn-danger white text-white"><i
        class="fa fa-trash"></i></a>
</template>
<script>
import {url, apiUrl} from '../../../common/config';

export default {
    name: 'deleteButton',
    props:{
      address:String,
      id:Number
    },
    data() {
        return {
            isLoading: false,
            errors: []
        }
    },
    methods: {
        submit() {
            let that = this;
            that.isLoading = true;
            that.errors = [];
            window.axios.post(apiUrl + this.address, {'id': this.id})
                .then(function ({data}) {
                    if (data.success) {
                        that.isLoading = false;
                        that.$toasted.show(data.message, {
                            type: 'success',
                        });
                        window.location.reload()
                    } else {
                        that.$toasted.show(data.message, {
                            type: 'error',
                        });
                    }
                })
                .catch(error => {
                    console.log('a', error);
                    that.isLoading = false;
                    that.$toasted.show('Please Try Again ...', {
                        type: 'error'
                    });
                });
        }
    }
}
</script>
