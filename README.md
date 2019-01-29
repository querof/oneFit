# oneFit API

Hi oneFit!

Here some code developed for you, I hope you'll have the time to take a look :-). 

Here you can find:

- Install instructions.
- General documentation of code.
- Endpoints doc.
- Security.
- Routes.



## Install.

 ### Option 1:

 - Create a Schema in MySql.
 - Run the database script oneFit.sql (it's located in the root of this project).
 - Copy the project folder in the server.
 - Change config in files: conf/database.json and conf/email.json



## General documentation.


  ### Code documentation.

   The code it's documented with PHPDoc Standard, every class, method/function and property have a description of the task/use they has.


Files and Directory structure.

├── conf                  
│   ├── database.json                  
│   ├── email.json                  
│   ├── routes.yml                  
│   └── secure.json                  
├── README.md                  
├── src                  
│   ├── Controller                  
│   │   ├── AuthController.php                  
│   │   ├── ExcercisesController.php                  
│   │   ├── HomeController.php                  
│   │   ├── PlanController.php                  
│   │   ├── UserController.php                  
│   │   ├── UserPlanController.php                  
│   │   ├── WorkoutDaysController.php                  
│   │   └── WorkoutDaysExcercisesController.php                  
│   ├── db                  
│   │   ├── Connection.php                  
│   │   └── orm                  
│   │       ├── adapters                  
│   │       │   ├── AdapterFactory.php                  
│   │       │   └── MySqlAdapter.php                  
│   │       ├── CrudBase.php                  
│   │       ├── EntityMethods.php                  
│   │       ├── Field.php                  
│   │       ├── model                  
│   │       │   ├── EntityFactory.php                  
│   │       │   ├── Excercises.php                  
│   │       │   ├── Plan.php                  
│   │       │   ├── User.php                  
│   │       │   ├── UserPlan.php                  
│   │       │   ├── WorkoutDaysExcercises.php                  
│   │       │   └── WorkoutDays.php                  
│   │       ├── Query.php                  
│   │       └── TableBase.php                  
│   ├── lib                  
│   │   ├── Auth.php                  
│   │   └── EmailService.php                  
│   └── Routing                  
│       └── Routes.php                  



Here the description of the directory structure of the project and main files.


 #### ORM.

 This is a simple approach of a custom made ORM solution. It's made an abstraction of the DB using the following classes:

 ##### Connection.php:

  Location: src\db.

  Description: Class thats generate singleton with th database connection.



##### TableBase.php:

 Location: src\db\orm.

 Description: It's has the main functions, use class src\db\orm\adapters\AdaptersFactory to get the database adapter to performs the CRUD operations, src\db\orm\model\EntityFactory to use the instance o the entity and src\db\orm\Field to make an instance of fields. Also is extended every entity of the model.

 Dependencies: src\db\orm\adapters\AdaptersFactory.php,src\db\orm\model\EntityFactory.php, src\db\orm\Field.php


##### Field.php:

 Location: src\db\orm.

 Description: Used to create fields object, in accordance with the entity abstraction class configuration.


##### Query.php:

  Location: src\db\orm.

  Description: Used to create custom query including: group functions, joins(INNER/LEFT/RIGHT).

  Dependencies:
  src\db\orm\model\EntityFactory


##### EntityMethods.php:

 Location: src\db\orm

 Description: trait thats contains the main common entity methods.


##### CrudBase.php:

 Location: src\db\orm

Description: Interface implemented by all the database adapters (MySqlAdapter).  


##### AdapterFactory.php:

 Location: src\db\orm\adapters.

 Description: Factory pattern implementation thats generate the class adapter in accordance with the provider parameter of the file conf/database.json.

 Dependencies: every database adapters in src\db\orm\adapters\ (MySqlAdapter)


##### "databseprovider"Adapter.php:

  Location: src\db\orm\adapters.

  Description: Class thats implement the src\db\orm\CrudBase interface; to performs the CRUD adapted to the database/datasource implemented (eg. Postgresql).

  Dependencies: src\db\Connection.php, src\db\orm\CrudBase.php,src\db\orm\Field.php, src\db\orm\model\EntityFactory.php, src\db\orm\Query


##### EntityFactory.php:

  Location: src\db\orm\model.

  Description: Factory pattern implementation thats generate the instance of class entity in use.

  Dependencies: every entity class in src\db\model


##### "Entityname".php:

 Location: src\db\orm\model.

 Description: Class thats implement the abstraction of the entity in the database.  Need to be generate one for every entity.

 Dependencies: src\db\orm\TableBase.php, src\db\orm\Field.php, src\db\orm\EntityMethods.php


##### Steps for ORM use.

1.- Create the  <databseprovider>Adapter.php, with the specific implementation in the database thats the system use. Implementing the CrudBase interface and following the example PostgresqlAdapter.php.
2.- Create the <Entityname>.php for every files following the examples(eg. Recipe.php).
3.- Run the ORM test.

#### Controllers:

The folder contains every controller of the app.

##### Lib:

Contains libs of general propose.

##### Conf:

Contains configurations files; the basic are:

  - database.json: contains connections string of the db.
  - routes.yml: it has all the routes of the app, based in symfony route system.
  - secure.json: it has all the protected routes of the app.
  - email.json: config parameters of email server.


##### test:

Folder that contains all test, the solution use PHPunit.

_Note: Sometimes test\Controller\UserControllerTest::testSave fails because of the unique index of the email field. This create an user from a combination of a random number and a string; this happens when you already ran several tests, so dont't worry it's about validation :) ._


## Endpoints.

  ### User:

  | Name   | Method      | URL                   | Protected  |        Params        |
  | ---    | ---         | ---                   | ---        | ---                  |
  | List   | `GET`       | `/user`               | ✘          |                      |
  | Create | `POST`      | `/user`               | ✓          |                      |
  | Get    | `GET`       | `/user/{id}`          | ✘          |                      |
  | Confirm| `GET`       | `/userconfirm/{id}`   | ✘          |                      |
  | Update | `PUT/PATCH` | `/user/{id}`          | ✓          |                      |
  | Delete | `DELETE`    | `/user/{id}`          | ✓          |                      |  
  | Search | `GET`       | `/user/search`        | ✘          | expect a json string   with parameters where database fields are    the index and value   what is needed to be    search. eg.{"user":{"email":{"value":"querof@gmail.com"}}}|

  ### Auth:

  | Name   | Method      | URL                    | Protected |        Params        |
  | ---    | ---         | ---                    | ---       | ---                  |
  | SignIn | `POST`      | `/auth/signin`         | ✘         | generate and return   the token from a valid user           |
  | Check  | `GET`       | `/auth`                | ✘         | validate token       |

  ### Plan:

  | Name   | Method      | URL                   | Protected  |        Params        |
  | ---    | ---         | ---                   | ---        | ---                  |
  | List   | `GET`       | `/plan`               | ✘          |                      |
  | Create | `POST`      | `/plan`               | ✓          |                      |
  | Get    | `GET`       | `/plan/{id}`          | ✘          |                      |  
  | Update | `PUT/PATCH` | `/plan/{id}`          | ✓          |                      |
  | Delete | `DELETE`    | `/plan/{id}`          | ✓          |                      |  
  | Search | `GET`       | `/plan/search`        | ✘          | expect a json string   with parameters where database fields are    the index and value   what is needed to be    search. eg.{"plan":{"name":{"value":"Advanced Plan"}}}|

  ### Excercises:

  | Name   | Method      | URL                   | Protected  |        Params        |
  | ---    | ---         | ---                   | ---        | ---                  |
  | List   | `GET`       | `/excercises`         | ✘          |                      |
  | Create | `POST`      | `/excercises`         | ✓          |                      |
  | Get    | `GET`       | `/excercises/{id}`    | ✘          |                      |  
  | Update | `PUT/PATCH` | `/excercises/{id}`    | ✓          |                      |
  | Delete | `DELETE`    | `/excercises/{id}`    | ✓          |                      |  
  | Search | `GET`       | `/excercises/search`  | ✘          | expect a json string   with parameters where database fields are    the index and value   what is needed to be    search. eg.{"excercises":{"name":{"value":"Curl"}}}|

  ### User Plan:

  | Name   | Method      | URL                 | Protected  |        Params        |
  | ---    | ---         | ---                 | ---        | ---                  |
  | List   | `GET`       | `/userplan`         | ✘          |                      |
  | Create | `POST`      | `/userplan`         | ✓          |                      |
  | Get    | `GET`       | `/userplan/{id}`    | ✘          |                      |  
  | Update | `PUT/PATCH` | `/userplan/{id}`    | ✓          |                      |
  | Delete | `DELETE`    | `/userplan/{id}`    | ✓          |                      |  
  | Search | `GET`       | `/userplan/search`  | ✘          | expect a json string   with parameters where database fields are    the index and value   what is needed to be    search. eg.{"user_plan":{"name":{"value":"Curl"}}}|

  ### Workout Days:

  | Name   | Method      | URL                    | Protected  |        Params        |
  | ---    | ---         | ---                    | ---        | ---                  |
  | List   | `GET`       | `/workoutdays`         | ✘          |                      |
  | Create | `POST`      | `/workoutdays`         | ✓          |                      |
  | Get    | `GET`       | `/workoutdays/{id}`    | ✘          |                      |  
  | Update | `PUT/PATCH` | `/workoutdays/{id}`    | ✓          |                      |
  | Delete | `DELETE`    | `/workoutdays/{id}`    | ✓          |                      |  
  | Search | `GET`       | `/workoutdays/search`  | ✘          | expect a json string   with parameters where database fields are    the index and value   what is needed to be    search. eg.{"work_out_days_excecises":{"id":{"value":34}}}|

  ### Workout Days Excercises:

  | Name   | Method      | URL                              | Protected  |        Params        |
  | ---    | ---         | ---                              | ---        | ---                  |
  | List   | `GET`       | `/workoutdaysexcercises`         | ✘          |                      |
  | Create | `POST`      | `/workoutdaysexcercises`         | ✓          |                      |
  | Get    | `GET`       | `/workoutdaysexcercises/{id}`    | ✘          |                      |  
  | Update | `PUT/PATCH` | `/workoutdaysexcercises/{id}`    | ✓          |                      |
  | Delete | `DELETE`    | `/workoutdaysexcercises/{id}`    | ✓          |                      |  
  | Search | `GET`       | `/workoutdaysexcercises/search`  | ✘          | expect a json string   with parameters where database fields are    the index and value   what is needed to be    search. eg.{"workout_days":{"name":{"value":"Leg day"}}}|



## Security.

The solution use JWT to for security, and a simple user authentication for create ad admin user.

_**Note: The "token" parameter with the generated token need to be send in all protected end points**_.

### Files.

##### Auth.php:

 Location: src\lib.

 Description: Class thats implement the auth system using JWT.

 Dependencies: Firebase\JWT\JWT.php

##### EmailService.php:

  Location: src\lib.

  Description: Class thats implement email send using PHPMailer.

  Dependencies: PHPMailer\PHPMailer\PHPMailer, PHPMailer\PHPMailer\Exception, src\db\orm\model\User, src\lib\Auth;


## Routing.

Based in symfony routing system; this is a custom made routing class.


##### Routes.php:

Location: src\Routing.

Description: Class thats create and return routes of the app, using conf/routes.yml as the source of routes.

Dependencies: use src\lib\Auth, every controller of the app.

Let me know your thoughts.

Best.
