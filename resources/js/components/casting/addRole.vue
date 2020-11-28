<template>

    <div class="col">

        <!-- general form elements disabled -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Add new Role</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div role="form" id="addRole">
                    <div class="row">
                        <div class="col">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" v-model="name">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary btn-block" :disabled="submitting" @click="addRole" >
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
            choice: "1st_Choice",
            submitting: false,
        }
    },

    methods: {


        addRole() {
            this.submitting = true

            let data = {
                name: this.name,
            }

            axios.post(`/cast/addrole`, data)
                .then(response => {
                    this.errors = {}
                    this.submitting = false
                    Swal.fire({
                        title: 'Role Added!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                            window.location.href = "/cast/addrole"
                        }
                    )
                }).catch(error => {
                console.log(error)
                // console.log(response.data.errors)
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
