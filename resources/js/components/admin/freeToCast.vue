<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Free to Cast!</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="choice in productionchoices">
                        <td>{{ choice.role }}</td>
                        <td>{{ choice.first }}</td>
                        <td>{{ choice.second }}</td>
                        <td><button type="button" class="btn btn-square btn-danger"><i class="plus"></i>
                            Cast {{choice.id}}</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props:{
        productionchoices:{
            type: Object,
        },
    }
}
</script>
