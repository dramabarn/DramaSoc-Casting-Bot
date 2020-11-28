<template>

    <div class="col">

        <!-- general form elements disabled -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Add Choice to Role</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div role="form" id="createProduction">
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>University Username</label>
                                <input type="text" class="form-control" placeholder="abc500" v-model="username">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" v-model="name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" placeholder="07234 123456" v-model="phone">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Role</label>
                            <select class="dropdown-list form-control mb-3" placeholder="Select Role..." v-model="rolename">
                                <option v-for="role in productionroles" v-bind:value="role.id">
                                    {{ role.role_name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label> Choice</label>
                            <select class="dropdown-list form-control mb-3" v-model="choice">
                                <option value="1st_choice">1st Choice</option>
                                <option value="2nd_choice">2nd Choice</option>
                                <option value="3rd_choice">3rd Choice</option>
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
            rolename:"",
            choice: "1st_choice",
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
                role_id: this.rolename,
                choice: this.choice,

            }
            console.log(data)

            axios.post(`/cast/enter`, data)
                .then(response => {
                    this.errors = {}
                    this.submitting = false
                    Swal.fire({
                        title: 'Choice Added!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                            window.location.href = "/cast/enter"
                        }
                    )
                }).catch(error => {
                console.log(error)
                console.log(response.data.errors)
                this.submitting = false
                Swal.fire({
                    icon: 'error',
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
