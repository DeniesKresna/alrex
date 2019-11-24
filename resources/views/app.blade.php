
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Trade Alert App</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
<link href="vendors/vuetify/css/googlefont.css" rel="stylesheet">
<link href="vendors/vuetify/css/materialdesignicons.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="vendors/vuetify/css/googlefont2.css">
<link href="vendors/vuetify/css/vuetify.min.css" rel="stylesheet">
<link href="vendors/fontawesome/css/all.min.css" rel="stylesheet">
<style>
	[v-cloak] {display: none}
</style>
</head>
<body>
<div id="app" v-cloak>	
	<div v-bind:class="{overlay: this.$store.state.overlay}">
		<app-component></app-component>
	</div>
</div>

<script type="text/javascript" src="js/app.js"></script>
</body>
</html>