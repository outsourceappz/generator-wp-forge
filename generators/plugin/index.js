'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');
var nconf = require('nconf');
var inflection = require('inflection');
var path = require( 'path' );

module.exports = yeoman.generators.Base.extend({
  loadConfig : function(){
      nconf.use('file', { file: './wp-plugin.json' });
      nconf.load();
  },
  prompting: function () {
    this.loadConfig();
    var done = this.async();

    var prompts = [
    {
      name:    'pluginName',
      message: 'Plugin Name',
      default: 'WP Plugin'
    },
    {
      name:    'pluginDescription',
      message: 'Plugin Description',
      default: 'The best WordPress plugin ever made!'
    },
    {
      name:    'pluginVersion',
      message: 'Plugin Version',
      default: '0.1.0'
    },
    {
      name:    'pluginURI',
      message: 'Plugin URI',
      default: 'http://wordpress.org/plugins'
    },
    {
      name:    'appName',
      message: 'App Namespace',
      default: 'WpPlugin'
    },
    {
      name:    'author',
      message: 'Author name',
      default: this.user.git.name
    },
    {
      name:    'email',
      message: 'Author email',
      default: this.user.git.email
    },
    {
      name:    'authorURI',
      message: 'Author URI',
      default: "http://example.com"
    }

    ];

    this.prompt(prompts, function (props) {
      this.props = props;
      this.props.pluginSlug = path.basename( this.env.cwd );
      this.props.pluginSlug = inflection.dasherize(this.props.pluginSlug);
      this.props.pluginNameSanitized = this.props.pluginSlug.replace('-','');
      this.props.currentYear = new Date().getFullYear();

      done();
    }.bind(this));
  },

  writing: function () {
    // console.log(this.props);
    this._directory('wp-plugin', './');

    this.fs.delete('wp-plugin.php');
    this.fs.delete('assets/css/wp-plugin.css');
    this.fs.delete('assets/js/src/wp-plugin.js');
    this.fs.delete('languages/wpplugin.pot');
    this.fs.delete('composer.lock');

    this.template('wp-plugin/wp-plugin.php', this.props.pluginSlug + '.php');
    this.template('wp-plugin/assets/css/wp-plugin.css', 'assets/css/' + this.props.pluginSlug + '.css');
    this.template('wp-plugin/assets/js/src/wp-plugin.js', 'assets/js/src/' + this.props.pluginSlug + '.js');
    this.template('wp-plugin/languages/wpplugin.pot', 'languages/' + this.props.pluginNameSanitized + '.pot');

    nconf.set('namespace', this.props.appName);
    nconf.save();
  },

  install: function () {
    // this.spawnCommand( 'composer', ['install'] );
  }
});
