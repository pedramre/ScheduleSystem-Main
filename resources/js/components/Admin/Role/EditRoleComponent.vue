<template>
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Role</h3>
            </div>
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Name</label>
                                <input
                                    type="text"
                                    v-model="role.name"
                                    class="form-control"
                                    id="model"
                                />
                            </div>
                            <label
                                v-for="error in errors.name"
                                class="col-form-label"
                                for="model"
                                style="color: red;"
                            >
                                <i class="far fa-times-circle"></i>
                                {{ error }}
                            </label>
                            <br />
                        </div>
                        <div class="row">
                            <div
                                class="custom-control custom-switch col-md-3"
                                v-for="permission in permissions"
                            >
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    :id="permission.name"
                                    :name="permission.name"
                                    @change="togglePermission(permission.name)"
                                    :checked="
                                        localPermissions.includes(
                                            permission.name
                                        )
                                    "
                                />
                                <label
                                    class="custom-control-label"
                                    :for="permission.name"
                                    >{{ permission.name }}</label
                                >
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button @click="submit()" type="submit" class="btn btn-primary">
                    <i
                        v-if="isLoading"
                        class="fa fa-spinner fa-spin float-right"
                    ></i>
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { url, apiUrl } from "../../../common/config";

export default {
    name: "editRole",
    props: {
        role: Object,
        permissions: Array
    },
    data() {
        return {
            isLoading: false,
            localPermissions: [],
            errors: []
        };
    },
    created() {
        let that = this;
        this.role.permissions.map(function(value) {
            that.localPermissions.push(value.name);
        });
    },
    methods: {
        submit: function() {
            let that = this;
            that.isLoading = true;
            that.errors = [];
            window.axios
                .post(apiUrl + "admin/role/edit", {
                    role: this.role,
                    localPermissions: this.localPermissions
                })
                .then(function({ data }) {
                    console.log("data", data.success);
                    if (data.success) {
                        that.isLoading = false;
                        that.$toasted.show(data.message, {
                            type: "success"
                        });
                        window.location.href = url + "admin/role";
                    } else {
                        that.isLoading = false;
                        if (data.data.errorMessages) {
                            that.errors = data.data.errorMessages;
                        }
                        that.$toasted.show(data.message, {
                            type: "error"
                        });
                    }
                })
                .catch(error => {
                    console.log(error);
                    that.isLoading = false;
                    that.$toasted.show("Please Try Again ...", {
                        type: "error"
                    });
                });
        },
        togglePermission(index) {
            if (this.localPermissions.includes(index)) {
                this.localPermissions.splice(
                    this.localPermissions.indexOf(index),
                    1
                );
            } else {
                this.localPermissions.push(index);
            }
            console.log(this.localPermissions);
        }
    }
};
</script>
