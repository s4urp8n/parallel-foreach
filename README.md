    
# Package-template

Use this template package structure to build your own packages and tests and composer distribution

## Structure

* files - package files
* src - package src files
* tests - package PHPUnit tests
* tests/classes - classes needed for testing
* tests/files - files needed for testing
* tests/bootstrap.php - PHPUnit autoloading and helpers
* coverage - directory with coverage information, ignored from git

## Helpers

* packageFile($name) - get full name of file with name=$name in **files** folder
* packageTestFile($name) - get full name of file with name=$name in **tests/files** folder
* Package/Test trait added with following methods: 
    * foreachTrue(array $values)
    * foreachFalse(array $values)
    * foreachEquals(array $values)
    * foreachNotEquals(array $values)
    * foreachSame(array $values)
    * foreachNotSame(array $values)
    * assertException(callable $callback, $expectedException = 'Exception', $expectedCode = null, $expectedMessage = null)
    
## Run tests

For testing PHPUnit installed required

```
cd package-template
composer install
php test.php
```

