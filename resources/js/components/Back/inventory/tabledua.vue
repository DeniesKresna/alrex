<template>
<div>
	<v-row>
		<v-col cols="12">
			<v-simple-table>
			    <template v-slot:default>
			      <thead>
			        <tr>
			          <th class="text-left">Id</th>
			          <th class="text-left">Nama</th>
			          <th class="text-left">Email</th>
			          <th class="text-left">Telepon</th>
			          <th class="text-left">Action</th>
			        </tr>
			      </thead>
			      <tbody>
			        <tr v-for="user in users" :key="user.id">
			          <td>{{ user.id }}</td>
			          <td>{{ user.name }}</td>
			          <td>{{ user.email }}</td>
			          <td>{{ user.phone }}</td>
				      <td><v-btn icon disabled>
			              <v-icon>mdi-thumb-up</v-icon>
			            </v-btn>
	            		</td>
			        </tr>
			      </tbody>
			    </template>
			</v-simple-table>
		</v-col>
	</v-row>
	
</div>
</template>
<script>
export default{
	data(){
		return{
			users: []
		}
	},
	mounted(){
		this.getData();
	},
	methods:{
		getData: function(){
			axios.get('http://192.168.100.166/pdsuit/public/api/users').then(response=>{
				console.log(response.data);
				this.users = response.data.users;
			});
		}
	}
}
</script>