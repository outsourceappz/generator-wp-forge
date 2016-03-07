'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');
var changeCase = require('change-case');
var schemaHelper = require('../../custom/schema/index.js');
var inflection = require('inflection');


module.exports = yeoman.generators.Base.extend({
  prompting: function () {
    var done = this.async();

    var prompts = [{
      type: 'text',
      name: 'tableName1',
      message: 'First table name?',
      default: 'users'
    },{
      type: 'text',
      name: 'tableName2',
      message: 'Second table name?',
      default: 'posts'
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
    this.props.tableName1 = changeCase.snake(this.props.tableName1).trim();
    this.props.tableNameSingular1 = inflection.singularize(this.props.tableName1);

    this.props.tableName2 = changeCase.snake(this.props.tableName2).trim();
    this.props.tableNameSingular2 = inflection.singularize(this.props.tableName2);

    this.props.fileNameSuffix = 'create_' + this.props.tableNameSingular1 + '_' + this.props.tableNameSingular2 + '_pivot_table';


    this.template('_migration.php', 'database/migrations/'+ schemaHelper.fileNameDatePrefix() +  '_' +  this.props.fileNameSuffix + '.php');
  },

  install: function () {
    //this.spawnCommand( 'composer', ['dump-autoload'] );
  }
});
