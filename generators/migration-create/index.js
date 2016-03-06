'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');
var changeCase = require('change-case')


module.exports = yeoman.generators.Base.extend({
  prompting: function () {
    var done = this.async();

    // Have Yeoman greet the user.
    this.log(yosay(
      'Welcome to the good ' + chalk.red('generator-wp-forge') + ' generator!'
    ));

    var prompts = [{
      type: 'text',
      name: 'tableName',
      message: 'Database table name?',
      default: 'custom_table_name'
    }];

    this.prompt(prompts, function (props) {
      this.props = props;
      // To access props later use this.props.someOption;

      done();
    }.bind(this));
  },

  writing: function () {
    var date = new Date();
    this.changeCase = changeCase;
    this.template('_migration.php', 'database/migrations/'+ date.getFullYear() + '_' + ("0" + (date.getMonth() + 1)).slice(-2) + '_'  + ("0" + date.getDate()).slice(-2) + '_' + date.getTime() +  '_create_' + this.props.tableName + '_table.php');
  },

  install: function () {
    this.spawnCommand( 'composer', ['dump-autoload'] );
  }
});
