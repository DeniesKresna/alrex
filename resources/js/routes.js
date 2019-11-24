let routes=[
{
  path: '/',
  name: '',
  component: require('./components/Back/Home/Index.vue').default
},
{
  path: '/back/home/index',
  component: require('./components/Back/Home/Index.vue').default
},
{
  path: '/back/trade/alert',
  component: require('./components/Back/Trade/Alert.vue').default
}
];

/*export default new VueRouter({
        routes,
        mode: 'history'
})*/
export default routes