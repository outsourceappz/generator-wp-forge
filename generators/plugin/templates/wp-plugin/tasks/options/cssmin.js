module.exports = {
	options: {
		banner: '/*! <%= props.pluginName %> - v<%= props.version %>\n' +
		' * <%=props.pluginURI %>\n' +
		' * Copyright (c) <%= props.currentYear %>;' +
		' * Licensed GPLv2+' +
		' */\n'
	},
	minify: {
		expand: true,

		cwd: 'assets/css/',
		src: ['<%- props.pluginSlug %>.css'],

		dest: 'assets/css/',
		ext: '.min.css'
	}
};
