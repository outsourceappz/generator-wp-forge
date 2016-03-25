'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');
var changeCase = require('change-case');
var schemaHelper = require('../../custom/schema/index.js');


module.exports = yeoman.generators.Base.extend({
  prompting: function () {
    var done = this.async();

    var prompts = [];

    this.prompt(prompts, function (props) {
      this.props = props;
      // To access props later use this.props.someOption;

      done();
    }.bind(this));
  },

  writing: function () {
    var date = new Date();
    this.props = this.options;
    this.schemaHelper = schemaHelper;
    this.props.tableName = changeCase.snake(this.props.tableName);
    this.props.fields = schemaHelper.transform(this.props.schema);

    this.template('_migration.php', 'database/migrations/'+ schemaHelper.fileNameDatePrefix() +  '_create_' + this.props.tableName + '_table.php');
  },

  install: function () {
    //this.spawnCommand( 'composer', ['dump-autoload'] );
  }
});
