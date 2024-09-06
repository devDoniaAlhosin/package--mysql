#  dbwrapper 

dbwrapper is a small php wrapper for mysql databases.

## installation

install once with composer:

```
composer require donia/day6-db
```

then add this to your project:

```php
require __DIR__ . '/vendor/autoload.php';
use Php\Db\db;
$db = new DB();
```

## usage

```php
/* connect to database */
$db = new DB('127.0.0.1', 'username', 'password', 'database', 3306);

/* insert/update/delete */
$db->table('tablename')->insert(['id' => $id])->execute();
$db->table("tablename")->update(['username' => "donia2000" ])->where("username", "=", 'donia')->execute();
$db->delete('tablename')->where(['id' => $id])->excute();

/* select */
$db->table("tablename")->select('columns')->all();
$db->table("tablename")->select('columns')->first();
$db->table("tablename")->select('columns')->where(['id' => $id])->first();

$db->table("tablename")->select('columns')->where(['id' => $id])->andWhere(['id' => $id])->first();

$db->table("tablename")->select('columns')->where(['id' => $id])->orWhere(['id' => $id])->first();

```

