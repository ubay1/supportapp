<template>
    <div class="table-responsive">

		<router-link to="create" class="btn btn-primary">
			Create new user
		</router-link>

		<hr>

		<table class="table">
			<thead>
				<tr>
					<th>No.</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Created</th>
					<th class="text-right">Actions</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>1</td>
					<td>ubay</td>
					<td>ubay00804@gmail.com</td>
					<td>2019-08-11</td>
					<td class="text-right">
						<router-link :to="{ name: 'adminView', params: {id: 2}}">
							View profile
						</router-link>
					</td>
				</tr>
			</tbody>
		</table>
</template>

<script>
    export default {
		data() {
			return {
				users: []
			}
        }
    }
</script>
