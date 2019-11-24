<template>
    <v-app id="inspire">
        <navigator-drawer></navigator-drawer>
        <loading-component></loading-component>
        <v-content>
          <v-container
            fluid
          >
          <breadcrumb-component></breadcrumb-component>
          <router-view></router-view>
          </v-container>
        </v-content>
        <footer-component></footer-component>
  </v-app>
</template>

<script>
    import LoadingComponent from './Loading.vue'
    import NavigatorDrawer from './partial/NavigatorDrawer.vue'
    import BreadcrumbComponent from './partial/BreadcrumbComponent.vue'
    import FooterComponent from './partial/FooterComponent.vue'
    export default {
        props: {
          source: String,
        },
        components:{
            NavigatorDrawer, FooterComponent, BreadcrumbComponent, LoadingComponent
        },
        data(){
            return{
            }
        },
    }
</script>
