<template>
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Create Schedule</h3>
            </div>
            <div class="card-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Name</label>
                                <input
                                    type="text"
                                    v-model="schedule.name"
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Job</label>
                                <select
                                    v-model="schedule.job_id"
                                    class="form-control"
                                >
                                    <option
                                        v-for="job in jobs"
                                        :value="job.id"
                                        >{{ job.name }}</option
                                    >
                                </select>
                            </div>
                            <label
                                v-for="error in errors.job_id"
                                class="col-form-label"
                                for="model"
                                style="color: red;"
                            >
                                <i class="far fa-times-circle"></i>
                                {{ error }}
                            </label>
                            <br />
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Date</label>
                                <Datepicker
                                    v-model="schedule.set_date"
                                ></Datepicker>
                            </div>
                            <label
                                v-for="error in errors.set_date"
                                class="col-form-label"
                                for="model"
                                style="color: red;"
                            >
                                <i class="far fa-times-circle"></i>
                                {{ error }}
                            </label>
                            <br />
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea
                                    v-model="schedule.description"
                                    class="form-control"
                                ></textarea>
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
import Datepicker from "vuejs-datepicker";

export default {
    name: "editSchedule",
    props: ["jobs", "schedule"],
    components: {
        Datepicker
    },
    data() {
        return {
            isLoading: false,
            errors: []
        };
    },
    methods: {
        submit: function() {
            let that = this;
            that.isLoading = true;
            that.errors = [];
            console.log("this.schedule", this.schedule);
            window.axios
                .post(apiUrl + "admin/schedule/edit", {
                    schedule: this.schedule
                })
                .then(function({ data }) {
                    console.log("data", data.success);
                    if (data.success) {
                        that.isLoading = false;
                        that.$toasted.show(data.message, {
                            type: "success"
                        });
                        window.location.href = url + "admin/schedule";
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
        }
    }
};
</script>
