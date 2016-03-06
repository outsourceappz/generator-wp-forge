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
      type: 'list',
      name: 'updateType',
      message: 'Type of update?',
      default: 'Add Fields',
      'choices' : ['Add Fields', 'Remove Fields']
    },{
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
    this.props.updateType = changeCase.snake(this.props.updateType);
    this.props.tableName = changeCase.snake(this.props.tableName);
    this.props.fields = schemaHelper.transform(this.props.schema);
    this.props.fieldNames = schemaHelper.fields(this.props.schema);



    if(this.props.updateType == 'add_fields'){
      this.props.fileNameSuffix = 'add_fields_' + this.props.fieldNames.join('_') + '_to_' + this.props.tableName + '_table';
      var fileName = schemaHelper.fileNameDatePrefix() + '_' + this.props.fileNameSuffix + '.php';
      this.template('_add_fields_migration.php', 'database/migrations/' + fileName );
    } else {
      this.props.fileNameSuffix = 'remove_fields_' + this.props.fieldNames.join('_') + '_from_' + this.props.tableName + '_table';
      var fileName = schemaHelper.fileNameDatePrefix() + '_' + this.props.fileNameSuffix + '.php';
      this.template('_remove_fields_migration.php', 'database/migrations/' + fileName );
    }
  },

  install: function () {
    //this.spawnCommand( 'composer', ['dump-autoload'] );
  }
});
