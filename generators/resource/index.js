'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');
var changeCase = require('change-case');
var schemaHelper = require('../../custom/schema/index.js');


module.exports = yeoman.generators.Base.extend({
  initializing: function(){
  },
  prompting: function () {
    var done = this.async();

    var prompts = [
    {
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
    },
    {
      type: 'text',
      name: 'className',
      message: 'Class Name?',
      default: 'User'
    }
    ];

    this.prompt(prompts, function (props) {
      this.props = props;
      done();
    }.bind(this));
  },

  writing: function () {
      this.composeWith('wp-forge:migration-create', {options: this.props});
      this.composeWith('wp-forge:model', {options: this.props});
      this.composeWith('wp-forge:repository', {options: this.props});
      this.composeWith('wp-forge:transformer', {options: this.props});
      this.composeWith('wp-forge:api', {options: this.props});

  },
  install: function () {
  }
});
