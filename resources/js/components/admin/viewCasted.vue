<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Casted Roles</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Show</th>
                        <th>Role</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="choice in casted">
                        <td>{{ choice.show }} | {{ choice.type }}{{ choice.week }}</td>
                        <td>{{ choice.role }}</td>
                        <td>{{ choice.first }}</td>
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
        casted:{
            type: Array,
        },
    }
}
</script>
