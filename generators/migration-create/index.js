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
      name: 'tableName',
      message: 'Database table name?',
      default: 'custom_table_name'
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

    this.template('_migration.php', 'database/migrations/'+ schemaHelper.fileNameDatePrefix() +  '_create_' + this.props.tableName + '_table.php');
  },

  install: function () {
    //this.spawnCommand( 'composer', ['dump-autoload'] );
  }
});
