<template>
    <div class="row">
        <div class="col-sm">
            <span class="fake-link" @click="removeAll()">
                <div  class="card text-white bg-danger text-center">
                    <div class="card-body">
                        <div>Delete All Casting Data</div>
                    </div>
                </div>
            </span>
        </div>
    </div>
</template>

<script>
export default {

    methods: {
        removeAll() {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'This will remove everything!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Do It!',
                cancelButtonText: 'No! Go back!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/admin/endSeason`)
                        .then(response => {
                            this.errors = {}
                            this.submitting = false
                            Swal.fire({
                                title: 'Removed!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                    window.location.href = "/"
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
            })
        }
    }
}
</script>

<style scoped>
.fake-link{
    cursor: pointer;
}
</style>
