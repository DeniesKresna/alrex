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
			predictResult: ""
		}
	},
	mounted(){
	},
	methods: {
		toggleRun: function(){
			this.is_run = !this.is_run;
			this.countNaiveBayes();
		},
		countNaiveBayes: function(){
			//axios.get(this.$store.state.apiUrl + '/getHistoryAndLastSignal/'+this.$store.state.limit+'/'+this.$store.state.pair_id).then(response=>{
			axios.get("http://localhost/share/hasil.json").then(response=>{
				var indicators = response.data.lastSignal.responseIndicator.response.indicators;
				var sma = response.data.lastSignal.responseMa.response.ma_avg.SMA;
				var ema = response.data.lastSignal.responseMa.response.ma_avg.EMA;
				var histories = response.data.lastSignal.histories;

				var countTemp = 0.00;
				var p_kelas_up, p_kelas_down, p_kelas_neutral = 1.00;
				var n_kelas_up, n_kelas_down, n_kelas_neutral = 1.00;
				var p_rsi14_kelas_up, p_rsi14_kelas_down, p_rsi14_kelas_neutral,
					p_stoch9_6_kelas_up, p_stoch9_6_kelas_down, p_stoch9_6_kelas_neutral,
					p_stochrsi14_kelas_up, p_stochrsi14_kelas_down, p_stochrsi14_kelas_neutral,
					p_macd12_26_kelas_up, p_macd12_26_kelas_down, p_macd12_26_kelas_neutral, 
					p_williamsr_kelas_up, p_williamsr_kelas_down, p_williamsr_kelas_neutral,
					p_cci14_kelas_up, p_cci14_kelas_down, p_cci14_kelas_neutral,
					p_atr14_kelas_up, p_atr14_kelas_down, p_atr14_kelas_neutral,
					p_ultimateoscillator_kelas_up, p_ultimateoscillator_kelas_down, p_ultimateoscillator_kelas_neutral,
					p_roc_kelas_up, p_roc_kelas_down, p_roc_kelas_neutral,
					p_sma5_kelas_up, p_sma5_kelas_down, p_sma5_kelas_neutral,
					p_sma10_kelas_up, p_sma10_kelas_down, p_sma10_kelas_neutral,
					p_sma20_kelas_up, p_sma20_kelas_down, p_sma20_kelas_neutral,
					p_sma50_kelas_up, p_sma50_kelas_down, p_sma50_kelas_neutral,
					p_sma100_kelas_up, p_sma100_kelas_down, p_sma100_kelas_neutral,
					p_sma200_kelas_up, p_sma200_kelas_down, p_sma200_kelas_neutral,
					p_ema5_kelas_up, p_ema5_kelas_down, p_ema5_kelas_neutral,
					p_ema10_kelas_up, p_ema10_kelas_down, p_ema10_kelas_neutral,
					p_ema20_kelas_up, p_ema20_kelas_down, p_ema20_kelas_neutral,
					p_ema50_kelas_up, p_ema50_kelas_down, p_ema50_kelas_neutral,
					p_ema100_kelas_up, p_ema100_kelas_down, p_ema100_kelas_neutral,
					p_ema200_kelas_up, p_ema200_kelas_down, p_ema200_kelas_neutral= 1.00
				var totalHistories = histories.length;
				var p_up, p_down, p_neutral = {};

				n_kelas_up = histories.filter(x=> x.candle_from_before == 'up').length;
				p_kelas_up = n_kelas_up/parseFloat(totalHistories);
				n_kelas_down = histories.filter(x=>x.candle_from_before === 'down').length;
				p_kelas_down = n_kelas_down/parseFloat(totalHistories);
				n_kelas_neutral = histories.filter(x=>x.candle_from_before === 'neutral').length;
				p_kelas_neutral = n_kelas_neutral/parseFloat(totalHistories);
				
				for(let prop in histories[0]){
					if(prop.includes("_signal")){
						p_up[prop.replace("_signal")]
					}
				}

				//rsi
				p_rsi14_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_rsi14 == indicators.RSI14.s).length) / n_kelas_up;
				p_rsi14_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_rsi14 == indicators.RSI14.s).length) / n_kelas_down;
				p_rsi14_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_rsi14 == indicators.RSI14.s).length) / n_kelas_neutral;

				//stoch9_6
				p_stoch9_6_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_stoch9_6 == indicators.STOCH9_6.s).length) / n_kelas_up;
				p_stoch9_6_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_stoch9_6 == indicators.STOCH9_6.s).length) / n_kelas_down;
				p_stoch9_6_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_stoch9_6 == indicators.STOCH9_6.s).length) / n_kelas_neutral;

				console.log("p_stoch9_6 = " + p_stoch9_6_kelas_down);
				//stochrsi14
				p_stochrsi14_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_stochrsi14 == indicators.STOCHRSI14.s).length) / n_kelas_up;
				p_stochrsi14_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_stochrsi14 == indicators.STOCHRSI14.s).length) / n_kelas_down;
				p_stochrsi14_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_stochrsi14 == indicators.STOCHRSI14.s).length) / n_kelas_neutral;

				//macd12_26
				p_macd12_26_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_macd12_26 == indicators.MACD12_26.s).length) / n_kelas_up;
				p_macd12_26_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_macd12_26 == indicators.MACD12_26.s).length) / n_kelas_down;
				p_macd12_26_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_macd12_26 == indicators.MACD12_26.s).length) / n_kelas_neutral;

				//williamsr
				p_williamsr_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_williamsr == indicators.WilliamsR.s).length) / n_kelas_up;
				p_williamsr_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_williamsr == indicators.WilliamsR.s).length) / n_kelas_down;
				p_williamsr_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_williamsr == indicators.WilliamsR.s).length) / n_kelas_neutral;

				//cci14
				p_cci14_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_cci14 == indicators.CCI14.s).length) / n_kelas_up;
				p_cci14_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_cci14 == indicators.CCI14.s).length) / n_kelas_down;
				p_cci14_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_cci14 == indicators.CCI14.s).length) / n_kelas_neutral;

				//atr14
				p_atr14_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_atr14 == indicators.ATR14.s).length) / n_kelas_up;
				p_atr14_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_atr14 == indicators.ATR14.s).length) / n_kelas_down;
				p_atr14_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_atr14 == indicators.ATR14.s).length) / n_kelas_neutral;

				//ultimateoscillator
				p_ultimateoscillator_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_ultimateoscillator == indicators.UltimateOscillator.s).length) / n_kelas_up;
				p_ultimateoscillator_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_ultimateoscillator == indicators.UltimateOscillator.s).length) / n_kelas_down;
				p_ultimateoscillator_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_ultimateoscillator == indicators.UltimateOscillator.s).length) / n_kelas_neutral;

				//roc
				p_roc_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_roc == indicators.ROC.s).length) / n_kelas_up;
				p_roc_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_roc == indicators.ROC.s).length) / n_kelas_down;
				p_roc_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_roc == indicators.ROC.s).length) / n_kelas_neutral;

				//sma5
				p_sma5_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_sma5 == sma.MA5.s).length) / n_kelas_up;
				p_sma5_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_sma5 == sma.MA5.s).length) / n_kelas_down;
				p_sma5_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_sma5 == sma.MA5.s).length) / n_kelas_neutral;

				//sma10
				p_sma10_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_sma10 == sma.MA10.s).length) / n_kelas_up;
				p_sma10_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_sma10 == sma.MA10.s).length) / n_kelas_down;
				p_sma10_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_sma10 == sma.MA10.s).length) / n_kelas_neutral;

				//sma20
				p_sma20_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_sma20 == sma.MA20.s).length) / n_kelas_up;
				p_sma20_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_sma20 == sma.MA20.s).length) / n_kelas_down;
				p_sma20_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_sma20 == sma.MA20.s).length) / n_kelas_neutral;

				//sma50
				p_sma50_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_sma50 == sma.MA50.s).length) / n_kelas_up;
				p_sma50_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_sma50 == sma.MA50.s).length) / n_kelas_down;
				p_sma50_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_sma50 == sma.MA50.s).length) / n_kelas_neutral;

				//sma100
				p_sma100_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_sma100 == sma.MA100.s).length) / n_kelas_up;
				p_sma100_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_sma100 == sma.MA100.s).length) / n_kelas_down;
				p_sma100_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_sma100 == sma.MA100.s).length) / n_kelas_neutral;

				//sma200
				p_sma200_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_sma200 == sma.MA200.s).length) / n_kelas_up;
				p_sma200_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_sma200 == sma.MA200.s).length) / n_kelas_down;
				p_sma200_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_sma200 == sma.MA200.s).length) / n_kelas_neutral;

				//ema5
				p_ema5_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_ema5 == ema.MA5.s).length) / n_kelas_up;
				p_ema5_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_ema5 == ema.MA5.s).length) / n_kelas_down;
				p_ema5_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_ema5 == ema.MA5.s).length) / n_kelas_neutral;

				//ema10
				p_ema10_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_ema10 == ema.MA10.s).length) / n_kelas_up;
				p_ema10_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_ema10 == ema.MA10.s).length) / n_kelas_down;
				p_ema10_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_ema10 == ema.MA10.s).length) / n_kelas_neutral;

				//ema20
				p_ema20_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_ema20 == ema.MA20.s).length) / n_kelas_up;
				p_ema20_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_ema20 == ema.MA20.s).length) / n_kelas_down;
				p_ema20_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_ema20 == ema.MA20.s).length) / n_kelas_neutral;

				//ema50
				p_ema50_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_ema50 == ema.MA50.s).length) / n_kelas_up;
				p_ema50_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_ema50 == ema.MA50.s).length) / n_kelas_down;
				p_ema50_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_ema50 == ema.MA50.s).length) / n_kelas_neutral;

				//ema100
				p_ema100_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_ema100 == ema.MA100.s).length) / n_kelas_up;
				p_ema100_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_ema100 == ema.MA100.s).length) / n_kelas_down;
				p_ema100_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_ema100 == ema.MA100.s).length) / n_kelas_neutral;

				//ema200
				p_ema200_kelas_up = (histories.filter(x=> x.candle_from_before == 'up' && x.signal_ema200 == ema.MA200.s).length) / n_kelas_up;
				p_ema200_kelas_down = (histories.filter(x=> x.candle_from_before == 'down' && x.signal_ema200 == ema.MA200.s).length) / n_kelas_down;
				p_ema200_kelas_neutral = (histories.filter(x=> x.candle_from_before == 'neutral' && x.signal_ema200 == ema.MA200.s).length) / n_kelas_neutral;
			})
		}
	},
	computed: {
		
	},
	watch: {
		
	}
}
</script>