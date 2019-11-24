import axios from 'axios';
import store from './store'

export default function setup() {
    axios.interceptors.request.use(function(config) {
    	store.commit('START_LOADING');
        /*const token = store.getters.token;
        if(token) {
            config.headers.Authorization = `Bearer ${token}`;
        }*/
        return config;
    }, function(err) {
    	store.commit('FINISH_LOADING');
        return Promise.reject(err);
    });

    axios.interceptors.response.use(function (response) {
    	store.commit('FINISH_LOADING');
	    return response;
	}, function (error) {
    	store.commit('FINISH_LOADING');
    	console.log(error.response);
    	if(error.response.data.message){
    		alert(error.response.data.message);
    	}else{
    		alert(error.response.statusText);
    	}
		  if (error.response.status == 401) {
		    location.href = store.state.apiUrl;
		  }
		  return Promise.reject(error)
		/*
	    if (401 === error.response.status) {
	        swal({
	            title: "Session Expired",
	            text: "Your session has expired. Would you like to be redirected to the login page?",
	            type: "warning",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes",
	            closeOnConfirm: false
	        }, function(){
	            window.location = '/login';
	        });
	    } else {
	        return Promise.reject(error);
	    }*/
	});
}