<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$host=base_url();

switch($host)
{
    case "https://www.quesucede.app/":
    case "https://quesucede.app/":
    case "http://www.quesucede.dev/":
    case "http://quesucede.dev/":
    case "http://quesucede.t4b.mx/":
        $grupo="dev";
        break;
    case "https://www.quesucede.com.mx/":
    case "https://quesucede.com.mx/":
        $grupo="prod";
        break;
    default :
        $grupo="default";
}

$active_group = $grupo;
$active_record = TRUE;

$db['default']['hostname'] = '10.20.14.77';
$db['default']['username'] = 'root';
$db['default']['password'] = 'root';
$db['default']['database'] = 'quesucede_main';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['prod']['hostname'] = 'localhost';
$db['prod']['username'] = 'admin_qs';
$db['prod']['password'] = 'pewUgmdmmm9NyqzX';
$db['prod']['database'] = 'quesucede';
$db['prod']['dbdriver'] = 'mysqli';
$db['prod']['dbprefix'] = '';
$db['prod']['pconnect'] = TRUE;
$db['prod']['db_debug'] = TRUE;
$db['prod']['cache_on'] = FALSE;
$db['prod']['cachedir'] = '';
$db['prod']['char_set'] = 'utf8';
$db['prod']['dbcollat'] = 'utf8_general_ci';
$db['prod']['swap_pre'] = '';
$db['prod']['autoinit'] = TRUE;
$db['prod']['stricton'] = FALSE;


$db['dev']['hostname'] = 'localhost';
$db['dev']['username'] = 'quesucede';
$db['dev']['password'] = 'havy4y2y6';
$db['dev']['database'] = 'quesucede_main';
$db['dev']['dbdriver'] = 'mysql';
$db['dev']['dbprefix'] = '';
$db['dev']['pconnect'] = TRUE;
$db['dev']['db_debug'] = TRUE;
$db['dev']['cache_on'] = FALSE;
$db['dev']['cachedir'] = '';
$db['dev']['char_set'] = 'utf8';
$db['dev']['dbcollat'] = 'utf8_general_ci';
$db['dev']['swap_pre'] = '';
$db['dev']['autoinit'] = TRUE;
$db['dev']['stricton'] = FALSE;















/* End of file database.php */
/* Location: ./application/config/database.php */
