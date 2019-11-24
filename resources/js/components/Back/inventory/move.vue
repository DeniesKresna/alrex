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
								<v-col cols="12" sm="12" md="8">
					        		<v-container>
					        			<v-row>
								            <v-col cols="12" sm="6" md="4">
								                <v-text-field v-model="editedMoveItem.asset_name" label="Nama Barang" readonly></v-text-field>
								            </v-col>
								            <v-col cols="12" sm="6" md="4">
								                <v-text-field v-model="editedMoveItem.asset_inventory_code" label="Kode Inventaris" readonly></v-text-field>
								            </v-col>
								            <v-col cols="12" sm="6" md="4">
								                <v-text-field v-model="editedMoveItem.asset_inventory_numb" label="No Inventaris" readonly></v-text-field>
								            </v-col>
								            <v-col cols="12" sm="6" md="4">
								                <v-text-field v-model="editedMoveItem.asset_serial_numb" label="Serial Number" readonly></v-text-field>
								            </v-col>
								            <v-col cols="12" sm="6" md="4">
								                <v-autocomplete v-model="editedMoveItem.mover_id" label="Pemindah" :items="autocompleteUser"
														    ></v-autocomplete>
								            </v-col>
								            <v-col cols="12" sm="6" md="4">
								            	<v-datetime-picker label="Tanggal pindah" v-model="editedMoveItem.move_at"> </v-datetime-picker><!--
											    <v-menu
											        v-model="moveDateTimeMenu"
											        :close-on-content-click="false"
											        :nudge-right="40"
											        transition="scale-transition"
											        offset-y
											        min-width="290px"
											    >
											        <template v-slot:activator="{ on }">
											            <v-text-field
												            v-model="editedMoveItem.move_at"
												            label="Tanggal Dipindah"
												            readonly
												            v-on="on"
												        ></v-text-field>
												    </template>
											        <v-date-picker v-model="editedMoveItem.move_at" @input="moveDateMenu = false"></v-date-picker>
											    </v-menu>-->
											</v-col>
								            <v-col cols="12" sm="6" md="4">
								                <v-autocomplete v-model="editedMoveItem.room_id" label="Dipindah di" :items="autocompleteRoom"
														    ></v-autocomplete>
								            </v-col>
								            <v-col cols="12" sm="6" md="6">
								                <v-text-field v-model="editedMoveItem.move_description" label="Keterangan"></v-text-field>
								            </v-col>
								        </v-row>
								    </v-container>
								</v-col>
								<v-col cols="12" sm="12" md="4">
					        		<v-card flat>
							          <v-card-text>
							          	<v-list-item three-line v-for="move in editedMoveItem.moves" :key="move.id">
								          	<v-list-item-content>
										        <v-list-item-title>ke {{move.room_name}} oleh {{move.mover_name}} <span></span></v-list-item-title>
										        <v-list-item-subtitle><span class="caption">tanggal {{move.move_at}} ({{move.move_description}}) dicatat oleh {{move.created_by}} pada {{move.created_at}}</span></v-list-item-subtitle>
										    </v-list-item-content>
							          	</v-list-item>
							           </v-card-text>
							        </v-card>
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