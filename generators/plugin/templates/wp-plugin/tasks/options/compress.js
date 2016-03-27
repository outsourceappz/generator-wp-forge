module.exports = {
	main: {
		options: {
			mode: 'zip',
			archive: './release/<%- props.pluginNameSanitized %>.<%= props.version %>.zip'
		},
		expand: true,
		cwd: 'release/<%= props.version %>/',
		src: ['**/*'],
		dest: '<%- props.pluginNameSanitized %>/'
	}
};
