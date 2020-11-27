<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Cast Choices</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Show</th>
                        <th>Role</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                        <th>Option 3</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="choice in productionchoices">
                        <td>{{ choice.show }}</td>
                        <td>{{ choice.role }}</td>
                        <td>{{ choice.first }}</td>
                        <td>{{ choice.second }}</td>
                        <td>{{ choice.third }}</td>
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
