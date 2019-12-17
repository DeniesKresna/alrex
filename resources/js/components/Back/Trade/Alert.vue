<template>
<div>
	<v-row>
		<v-col cols="12">
			<v-expansion-panels>
			    <v-expansion-panel>
			      <v-expansion-panel-header>
			      	Run Auto Predict
				  </v-expansion-panel-header>
			      <v-expansion-panel-content>
			      	  <v-btn class="ma-2 red" tile outlined v-if="is_run" @click="toggleRun">
					      <v-icon>mdi-stop</v-icon>
					  </v-btn>
					  <v-btn class="ma-2 green" tile outlined v-else @click="toggleRun">
					      <v-icon>mdi-play</v-icon>
					  </v-btn>
					  <span class="title" v-if="predictResult!=''">The Prediction is : <strong>{{predictResult.toUpperCase()}}</strong></span>
					  <p v-if="updateTime != ''">Updated At : {{updateTime}}</p>
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
			is_run: false,
			predictResult: "",
			updateTime: ''
		}
	},
	mounted(){
	},
	methods: {
		toggleRun: function(){
			//this.is_run = !this.is_run;
			this.countNaiveBayes();
		},
		countNaiveBayes: function(){
			axios.get(this.$store.state.apiUrl + '/getHistoryAndLastSignal/'+this.$store.state.limit+'/'+this.$store.state.pair_id).then(response=>{
			//axios.get("http://localhost/share/hasil.json").then(response=>{
				var indicators = response.data.lastSignal.responseIndicator
				var histories = response.data.lastSignal.histories;

				var countTemp = 0.00;
				var p_kelas_up, p_kelas_down, p_kelas_neutral = 1;
				var n_kelas_up, n_kelas_down, n_kelas_neutral = 1;
				var totalHistories = histories.length;
				var p_up = {};
				var p_down = {};
				var p_neutral = {};

				n_kelas_up = histories.filter(x=> x.candle_from_before == 'up').length;
				p_kelas_up = n_kelas_up/parseFloat(totalHistories);
				n_kelas_down = histories.filter(x=>x.candle_from_before === 'down').length;
				p_kelas_down = n_kelas_down/parseFloat(totalHistories);
				n_kelas_neutral = histories.filter(x=>x.candle_from_before === 'neutral').length;
				p_kelas_neutral = n_kelas_neutral/parseFloat(totalHistories);
				
				for(let prop in histories[0]){
					if(prop.includes("signal_")){
						let freshprop = prop.replace("signal_","");
						p_up[freshprop] = (histories.filter(x=> x.candle_from_before == 'up' && x[prop] == indicators[freshprop]['s']).length) / parseFloat(n_kelas_up);
						//console.log("p_up["+freshprop+"]=" + p_up[freshprop]);
						p_down[freshprop] = (histories.filter(x=> x.candle_from_before == 'down' && x[prop] == indicators[freshprop]['s']).length) / parseFloat(n_kelas_down);
						//console.log("p_down["+freshprop+"]=" + p_down[freshprop]);
						p_neutral[freshprop] = (histories.filter(x=> x.candle_from_before == 'neutral' && x[prop] == indicators[freshprop]['s']).length) / parseFloat(n_kelas_neutral);
						//console.log("p_neutral["+freshprop+"]=" + p_neutral[freshprop]);
					}
				}

				//console.log(p_down);

				var p_kelas_total = {
					up: 1.0000,
					down: 1.0000,
					neutral: 1.0000
				};

				for(let it in p_up){
					console.log("p_up["+it+"] = "+p_up[it]+" * "+p_kelas_total.up);
					p_kelas_total.up = p_up[it] * (p_kelas_total.up); 
					console.log(p_kelas_total.up + " ok");

				}
				for(let it in p_down){
					console.log("p_down["+it+"] = "+p_down[it]+" * "+p_kelas_total.down);
					p_kelas_total.down *= p_down[it]; 
					console.log(p_kelas_total.down + " ok");
				}
				for(let it in p_neutral){
					console.log("p_neutral["+it+"] = "+p_neutral[it]+" * "+p_kelas_total.neutral);
					p_kelas_total.neutral *= p_neutral[it]; 
					console.log(p_kelas_total.neutral + " ok");
				}

				p_kelas_total.up = p_kelas_total.up*10000000000;
				p_kelas_total.down = p_kelas_total.down*10000000000;
				p_kelas_total.neutral = p_kelas_total.neutral*10000000000;

				console.log("p_kelas_up_total : " + p_kelas_total.up);
				console.log("p_kelas_down_total : " + p_kelas_total.down);
				console.log("p_kelas_neutral_total : " + p_kelas_total.neutral);

				/*const max = data.reduce(function(prev, current) {
				    return (prev.y > current.y) ? prev : current
				})*/
				var keysSorted = Object.keys(p_kelas_total).sort(function(a,b){return p_kelas_total[a]-p_kelas_total[b]});
				console.log(keysSorted);
				this.predictResult = keysSorted[0];
				this.updateTime = new Date();
			})
		}
	},
	computed: {
		
	},
	watch: {
		
	}
}
</script>