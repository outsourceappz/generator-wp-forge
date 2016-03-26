# WP Forge

**NOTE: This build would be considered ALPHA. Having said that, WordPress plugins and other generated code using this tool has been used in production environment.**

An opinionated scaffolding tool for creating modern WordPress plugin.

It helps you kickstart new WordPress plugin, prescribing best practices and to help you stay productive. Not to say the least, it saves tons of man hours upfront and during the course of development.

The following functionality is provided out-of-the-box.

1. A goodies-filled plugin boilerplate using PHP namespaces and composer.
2. A [dependancy injector container](http://pimple.sensiolabs.org/) for managing plugin service objects and parameters. 
3. A powerful Object Relational Mapper (ORM). Define ORM model and link them to your database tables. Say goodbye to writing raw MySQL queries.
4. An easy to use database schema migrations tool. Easily create and organise database table migrations (create/update table, add/remove columns) using a easy to Schema builder. Yes we do have a scaffolder for this too!
5. A scaffolding command to **WordPress plugin**.
6. A scaffolding command each to create, update and pivot a **database migration** resource.
7. A scaffolding command to create an **ORM model** resource.
8. A scaffolding command to create **resource repository** (Repository Pattern).
9. A scaffolding command to create a **resource transformer** (Fractals from PHPLeague)
10. A scaffoling command to create a **resource API** controller.

## Installation

First, install [Yeoman](http://yeoman.io) and generator-wp-forge using [npm](https://www.npmjs.com/) (we assume you have pre-installed [node.js](https://nodejs.org/)).

```bash
npm install -g yo
git clone git@github.com:outsourceappz/generator-wp-make && cd generator-wp-make
npm link
```

Then generate your new project:

```bash
yo wp-forge
```

## Available Generators

Please note that all the generator commands need to be executed from the root directory of your custom-plugin folder along the lines of the following example

```bash
mkdir wp-content/plugins/my-custom-plugin
cd wp-content/plugins/my-custom-plugin
```

### WordPress Plugin.

```bash
yo wp-forge:plugin
```

### Create Database Migration.

Used to create a database table.

`yo wp-forge:migration-create --tableName=my-database-table-name --schema="schema"`

for example

```bash
yo wp-forge:migration-create --tableName=users --schema="first_name:string,last_name:string"
```

Note: To learn more about the schema database columns, please read [https://laravel.com/docs/5.0/schema](https://laravel.com/docs/5.0/schema) 

Schema is a comma separated value of column-name and column-type key value pair.

So any of these will do:

```
username:string
body:text
age:integer
published_at:date
excerpt:text:nullable
email:string:unique:default('foo@example.com')
```

### Update Database Migration.

Used to update an existing database table.

```bash
yo wp-forge:migration-update
```

### Pivot Database Migration.

Used to create a pivot table for a `has many and belongs to many` relation. 

```bash
yo wp-forge:migration-pivot
```

### ORM Model.

Used to create an ORM model file in App/Models folder.

`yo wp-forge:model --tableName=my-database-table-name --className=model-name --schema="schema"`

```bash
yo wp-forge:model --tableName=users --className=User --schema="first_name:string,last_name:string"
```

### Repository class.

We recommend using a repository class which deals with the ORM model and abstracts away the database for other parts of the plugin.

`yo wp-forge:repository --className=my-orm-class-name --schema="schema"`

```bash
yo wp-forge:repository --className=User --schema="first_name:string,last_name:string"
```

### Transformer class.

Used to create a transformer class, which is used to define the ORM database table fields and its related data. We use [fractals](http://fractal.thephpleague.com/) package for this.

` yo wp-forge:transformer --className=my-database-table-name --schema="schema"`

```bash
 yo wp-forge:transformer --className=User --schema="first_name:string,last_name:string"
```

Note: This currently works correctly for only string data types. Work in progress.


### API class.

Used to create an API class (which utilises the transformer) which can be used by the `wp_ajax_` WordPress action to create JSON based REST endpoints.

`yo wp-forge:api --className=my-model-class-name --schema="schema"`

```bash
yo wp-forge:api --className=User --schema="first_name:string,last_name:string"
```

### Resource

This is a composite generator which can be used to generator `migration-create`, `model`, `repository`, `transformer` and `api` generators at one go.

```bash
yo wp-forge:resource
```

## License

GPLv2 - [https://wordpress.org/about/gpl/](https://wordpress.org/about/gpl/)

 © [Outsource Appz](https://outsourceappz.com)
