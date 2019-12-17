import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)
const state = {
	session:{
	},
	apiUrl: 'http://localhost/alrex/public/',
	overlay: false,
	isLoading: false,
	pair_id: 1,
	limit: 100
}
const getters = {	
	username: state => state.session.name,
	isLoading: state => state.isLoading
}
const mutations = {
	/*changeExpertId: (state,payload) => {
		state.expertId = payload;
		state.tanyakarirfokus={
			expert: false,
			book: true,
			about: false,
			profile: false,
			inbox: false
		}
	},*/
	START_LOADING: state => state.isLoading = true,
  	FINISH_LOADING: state => state.isLoading = false,
}
const actions = {
   	/*INIT_LOGIN: ({commit, state}) => {
   		axios.get(state.apiUrl + 'restdata/user').then(response=>{
   			state.sesi.id = response.data.user.id;
			state.sesi.nama = response.data.user.name;
			state.sesi.nickname = response.data.user.nickname;
			state.sesi.email = response.data.user.email;
   			var id = response.data.user.id;
   			axios.get(state.apiUrl + 'role/user/'+id).then(response=>{
	          	state.sesi.roles = response.data.role;
	          	//console.log(response.data.role);
	          	var datarole = new FormData();
	          	datarole.append('roles',response.data.role);
	          	axios.post(state.apiUrl + 'setting/hak',datarole).then(response=>{
	          		state.sesi.berhak = response.data.berhak;
	          	});
	        });
   		}).catch((error)=>{
   			state.isLogIn = false;
   		});
   	},*/
}
export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions
})