<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Deadlocks</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Show 1</th>
                        <th>Show 2</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="conflict in deadlocks">
                            <td>{{ conflict.name }}</td>
                            <td>{{ conflict.phone }}</td>
                            <td>{{ conflict.firstshow }} - {{conflict.firstrole }} | {{conflict.firsttype }} Week {{conflict.firstweek }} </td>
                            <td>{{ conflict.secondshow }} - {{conflict.secondrole }} | {{conflict.secondtype }} Week {{conflict.secondweek }}</td>
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
        deadlocks:{
            type: Array,
        },
    }
}
</script>
