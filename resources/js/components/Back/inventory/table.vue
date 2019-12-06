<template>
<div>
	<v-row>
		<v-col cols="12">
			<v-expansion-panels v-model="show_search">
			    <v-expansion-panel>
			      <v-expansion-panel-header>
				  </v-expansion-panel-header>
			      <v-expansion-panel-content>
					<download-excel
					    :data = "candles_data">
					    Download 1000 EURUSD candle
					</download-excel>        
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
			show_search: true,
			candles_data: []
		}
	},
	mounted(){
		this.getSignalData();
	},
	methods: {
		getSignalData: function(){
			axios.get(this.$store.state.apiUrl + 'candle/latest/fiveminutes/signals/1000/1').then(response=>{
				this.candles_data = response.data.candles;
			});
		}
	},
	computed: {
		
	},
	watch: {
		
	}
}
</script>