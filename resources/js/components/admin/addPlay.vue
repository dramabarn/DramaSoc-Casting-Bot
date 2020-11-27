<template>

    <div class="col">

        <!-- general form elements disabled -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Add Production</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div role="form" id="createProduction">
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" placeholder="play name" v-model="username">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" class="form-control" placeholder="Enter Password" v-model="password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>email</label>
                                <input type="text" class="form-control" placeholder="prod123@york.ac.uk" v-model="email">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Week</label>
                            <select class="dropdown-list form-control mb-3" placeholder="Select Role..." v-model="week">
                                <option v-for="week in 10">
                                    {{ week }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label> Type</label>
                            <select class="dropdown-list form-control mb-3" v-model="type">
                                <option value="odn">ODN</option>
                                <option value="weekendShow">Weekend Show</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>



                    <div class="row justify-content-center mt-4">
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-block" :disabled="submitting" @click="enterCast" >
                                <i class="fas fa-spinner fa-spin" v-if="submitting"></i>Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        productionroles: {
            type: Object,
        },
        actors: {
            type: Object,
        },
    },

    data() {
        return {
            user: {},
            errors: {},
            name: "",
            username: "",
            phone: "",
            week:"1",
            type: "weekendShow",
            submitting: false,
        }
    },

    methods: {


        enterCast() {
            this.submitting = true

            let data = {
                name: this.name,
                username: this.username,
                phone: this.phone,
                role: this.role,
                choice: this.choice,

            }
            console.log(data)

            axios.post(`/api/cast`, data)
                .then(response => {
                    this.errors = {}
                    this.submitting = false
                    Swal.fire({
                        title: 'Production Added!',
                        type: 'success',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                            window.location.href = "cast/enter"
                        }
                    )
                }).catch(error => {
                console.log(error)
                // console.log(response.data.errors)
                this.submitting = false
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                }).then((result) => {
                    location.reload();
                });
            })
        }
    }
}

</script>
