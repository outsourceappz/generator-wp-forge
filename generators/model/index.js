'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');
var changeCase = require('change-case');
var schemaHelper = require('../../custom/schema/index.js');
var nconf = require('nconf');


module.exports = yeoman.generators.Base.extend({
  loadConfig : function(){
      nconf.use('file', { file: './wp-plugin.json' });
      nconf.load();
  },
  prompting: function () {
    this.loadConfig();
    var done = this.async();

    var prompts = [{
      type: 'text',
      name: 'className',
      message: 'Class Name?',
      default: 'User'
    },
    {
      type: 'text',
      name: 'tableName',
      message: 'Table Name?',
      default: 'users'
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
    this.props.tableName = changeCase.snake(this.props.tableName);
    this.props.fields = schemaHelper.transform(this.props.schema);
    this.props.fieldNames = schemaHelper.fields(this.props.schema);
    this.props.namespace = nconf.get('namespace');

    this.template('_model.txt', 'App/Models/'+ this.props.className +  '.php' );
  },

  install: function () {
    //this.spawnCommand( 'composer', ['dump-autoload'] );
  }
});
