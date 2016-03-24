'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');
var changeCase = require('change-case');
var schemaHelper = require('../../custom/schema/index.js');

module.exports = yeoman.generators.Base.extend({
  prompting: function () {
    var done = this.async();

    var prompts = [{
      type: 'text',
      name: 'className',
      message: 'Model Class Name?',
      default: 'User'
    },
    {
      type: 'text',
      name: 'schema',
      message: 'Table schema?',
      default: 'username:string,email:string:unique'
    }
    ];

    this.prompt(prompts, function (props) {
      this.props = props;
      // To access props later use this.props.someOption;

      done();
    }.bind(this));
  },

  writing: function () {
    var date = new Date();
    this.schemaHelper = schemaHelper;
    this.props.fieldNames = schemaHelper.fields(this.props.schema);
    this.props.namespace = schemaHelper.config().get('namespace');

    this.template('_api.php', 'App/Http/Controllers/API/'+ this.props.className +  '.php' );
  },

  install: function () {
    this.spawnCommand( 'composer', ['dump-autoload'] );
  }
});
