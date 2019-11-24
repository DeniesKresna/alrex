<template>
    <loading :active.sync="isLoading" 
        :is-full-page="fullPage"></loading>
</template>
<script>
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
export default{
	data(){
		return{
			fullPage: true
		}
	},
	components: {
            Loading
        },
	mounted(){
	},
	computed: {
		isLoading: function(){
			return this.$store.getters.isLoading;
		}
	}
}
</script>