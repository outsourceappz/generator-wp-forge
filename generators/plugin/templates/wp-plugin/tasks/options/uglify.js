module.exports = {
	all: {
		files: {
			'assets/js/<%- props.pluginSlug %>.min.js': ['assets/js/<%- props.pluginSlug %>.js']
		},
		options: {
			banner: '/*! <%= props.pluginName %> - v<%= props.version %>\n' +
			' * <%= props.pluginURI %>\n' +
			' * Copyright (c) <%= props.currentYear %>;' +
			' * Licensed GPLv2+' +
			' */\n',
			mangle: {
				except: ['jQuery']
			}
		}
	}
};
