module.exports = {
	options: {
		stripBanners: true,
			banner: '/*! <%= props.pluginName %> - v<%= props.version %>\n' +
		' * <%= props.pluginURI %>\n' +
		' * Copyright (c) <%= props.currentYear %>;' +
		' * Licensed GPLv2+' +
		' */\n'
	},
	main: {
		src: [
			'assets/js/src/<%- props.pluginSlug %>.js'
		],
			dest: 'assets/js/<%- props.pluginSlug %>.js'
	}
};
