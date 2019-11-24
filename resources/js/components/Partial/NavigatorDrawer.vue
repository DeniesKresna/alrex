<template>
<div>
	<v-navigation-drawer
      v-model="drawer"
      app
      clipped
      dark
      color="blue lighten-2"
    >
      <v-list dense>
      	<div v-for="(item, index) in items">
      		<div v-if="item.children">
			    <v-list-group
			        :prepend-icon="'mdi-'+item.icon"
			      >
			        <template v-slot:activator>
			          <v-list-item-title>{{item.text}}</v-list-item-title>
			        </template>

		          <v-list-item
		             v-for="(itemtwo,i) in item.children" :key="i"
		            link :to="itemtwo.link"
		          >
		            <v-list-item-title v-text="itemtwo.text"></v-list-item-title>
		          </v-list-item>
		        </v-list-group>
      		</div>
      		<div v-else>
			    <v-list-item :to="item.link">
			        <v-list-item-action>
			            <v-icon>mdi-{{item.icon}}</v-icon>
			        </v-list-item-action>
			        <v-list-item-content>
			            <v-list-item-title>{{item.text}}</v-list-item-title>
			        </v-list-item-content>
			    </v-list-item>
      		</div>
    	</div>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      app
      clipped-left
      color="indigo darken-1"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Application</v-toolbar-title>
    </v-app-bar>
</div>
</template>
<script>
export default{
	data(){
		return{
			drawer: true,
              items: [
              	{ icon: 'home-variant', link: '/back/home/index', text: 'Home' },
              	//{ icon: 'desktop-tower-monitor', link: '/back/inventory/tabledua', text: 'Tabel' },
                {
                  icon: 'desktop-tower-monitor',
                  text: 'Trade',
                  children: [
                    { link: '/back/trade/alert', text: 'Alert'},
                    //{ link: '/back/inventory/received', text: 'Penerimaan'},
                  ],
                }
              ]
		}
	}
}
</script>