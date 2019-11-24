<template>
<div>
	<v-row>
		<v-col cols="12">
			<v-expansion-panels v-model="show_panel" multiple>
				<v-expansion-panel>
			      <v-expansion-panel-header>Penerimaan Asset Baru</v-expansion-panel-header>
			      <v-expansion-panel-content>
			      	<v-form>
						<v-container>
							<v-row>
								<v-col cols="12" sm="6" md="4">
				                    <v-text-field v-model="editedItem.asset_name" label="Nama"></v-text-field>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-text-field v-model="editedItem.asset_brand" label="Merk"></v-text-field>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-autocomplete v-model="editedItem.group_id" @change="setCategoriesEdit(editedItem.group_id)" label="Group" :items="autocompleteData"
									    ></v-autocomplete>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-autocomplete v-model="editedItem.assettype_id" label="Tipe" :items="editCategories"
									    ></v-autocomplete>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-autocomplete v-model="editedItem.room_id" label="Ruang" :items="autocompleteRoom"
									    ></v-autocomplete>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-text-field v-model="editedItem.asset_inventory_code" label="Kode Inventaris"></v-text-field>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-text-field v-model="editedItem.asset_inventory_numb" label="No Inventaris"></v-text-field>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-text-field v-model="editedItem.asset_serial_numb" label="Serial Number"></v-text-field>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
							      <v-menu
							        v-model="receiveBillDateMenu"
							        :close-on-content-click="false"
							        :nudge-right="40"
							        transition="scale-transition"
							        offset-y
							        min-width="290px"
							      >
							        <template v-slot:activator="{ on }">
							          <v-text-field
							            v-model="editedItem.receive_bill_date"
							            label="Tanggal Kirim"
							            readonly
							            v-on="on"
							          ></v-text-field>
							        </template>
							        <v-date-picker v-model="editedItem.receive_bill_date" @input="receiveBillDateMenu = false"></v-date-picker>
							      </v-menu>
							    </v-col>
				                <v-col cols="12" sm="6" md="4">
				                	<v-datetime-picker label="Select Datetime" v-model="editedItem.receive_at"> </v-datetime-picker>
							    </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-text-field v-model="editedItem.receive_bill_number" label="Nomor Pengiriman"></v-text-field>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-text-field v-model="editedItem.receive_sender_identity" label="Pengirim"></v-text-field>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-autocomplete v-model="editedItem.conditiontype_id" label="Kondisi" :items="autocompleteConditiontype"
									    ></v-autocomplete>
				                </v-col>
				                <v-col cols="12" sm="6" md="4">
				                    <v-autocomplete v-model="editedItem.receiver_id" label="Penerima" :items="autocompleteUser"
									    ></v-autocomplete>
				                </v-col>
				                <v-col cols="12">
				                  	<v-textarea label="Keterangan"
							          v-model="editedItem.asset_description"
							        ></v-textarea>
				                </v-col>
							</v-row>
							<v-row>
								<v-col>
				                  	<v-btn color="info" dark tile @click="addReceive"><v-icon>mdi-plus</v-icon> {{saveModeText}}</v-btn>
				                </v-col>
				                  	<div class="flex-grow-1"></div>
				                <v-col>
				                  	<v-btn color="primary" text dark tile @click="resetEditedItem"><v-icon>mdi-flask-empty-outline</v-icon> Reset</v-btn>
				                </v-col>
							</v-row>
						</v-container>
					</v-form>
			      </v-expansion-panel-content>
			    </v-expansion-panel>
			</v-expansion-panels>
		</v-col>
	</v-row>
</div>
</template>
<script>
export default{
	data(){
		return{
			show_panel: [],
			editedItem: {
				receive_at: new Date(),
				receive_bill_date: new Date().toISOString().substr(0, 10)
			},
			editCategories: [],
			autocompleteData: [],
			autocompleteRoom: [],
			autocompleteUser: [],
			autocompleteConditiontype: [],
			receiveDateMenu: false,
			receiveBillDateMenu: false,
			saveModeText: 'Tambah'
		}
	},
	mounted(){
		//console.log(this.$route.params.id);
		if(typeof this.$route.params.id !== 'undefined'){
			this.saveModeText = "Simpan"
			this.getData(this.$route.params.id);
		}
		this.getAutocomplets();
	},
	methods:{
		getData: function(asset_id = 1){
			axios.get(this.$store.state.apiUrl + 'receive/show/' + asset_id).then(response=>{
				if(!response.data.receive){
					this.resetEditedItem;
				}
				else{
					this.editedItem	= response.data.receive;
				}
			});
		},
		getAutocomplets: function(){
			axios.get(this.$store.state.apiUrl + 'group/assettypeAutocomplete').then(response=>{
				this.autocompleteData = response.data.autocompletes;
				axios.get(this.$store.state.apiUrl + 'room/autocomplete').then(response=>{
					this.autocompleteRoom = response.data.rooms;
					axios.get(this.$store.state.apiUrl + 'user/autocomplete').then(response=>{
						this.autocompleteUser = response.data.users;
						axios.get(this.$store.state.apiUrl + 'conditiontype/autocomplete').then(response=>{
							this.autocompleteConditiontype = response.data.conditiontypes;
						});
					});
				});
			});
		},
		setCategoriesEdit: function(groupId){
			var groupIndex = this.autocompleteData.map(e=>e.value).indexOf(groupId);
			this.editCategories = this.autocompleteData[groupIndex].children;
		},
		addReceive: function(){
			axios.post(this.$store.state.apiUrl + 'asset',{
				editedItem: this.editedItem
			}).then(response=>{
				var asset_id = response.data.asset_id;
				axios.post(this.$store.state.apiUrl + 'receive/' + asset_id,{
					editedItem: this.editedItem
				}).then(response=>{
					this.$swal("Good job!", response.data.message, "success");
				});
			});
		},
		resetEditedItem: function(){
			this.editedItem = {
				receive_at: new Date().toISOString().substr(0, 10),
				receive_bill_date: new Date().toISOString().substr(0, 10)
			}
		}
	}
}
</script>