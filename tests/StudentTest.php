<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";
    require_once "src/Course.php";

    $server = 'mysql:host=localhost;dbname=university_registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown()
        // {
        //     Student::deleteAll();
        //     Course::deleteAll();
        // }

        function test_getName()
        {
            //Arrange
            $name = "Ben";
            $id = null;
            $date = "2015-12-12";
            $test_student = new Student($name, $date, $id);

            //Act
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($name, $result);
        }
        function test_setName()
        {
            //Arrange
            $name = "Ben";
            $id = null;
            $date = "2015-12-12";
            $test_student = new Student($name, $date, $id);

            //Act
            $test_student->setName("Jeremy");
            $result = $test_student->getName();

            //Assert
            $this->assertEquals("Jeremy", $result);
        }
        function test_getDate()
        {
            //Arrange
            $name = "Ben";
            $id = null;
            $date = "2015-12-12";
            $test_student = new Student($name, $date, $id);

            //Act
            $result = $test_student->getDate();

            //Assert
            $this->assertEquals($date, $result);
        }
        function test_setDate()
        {
            //Arrange
            $name = "Ben";
            $id = null;
            $date = "2015-12-12";
            $test_student = new Student($name, $date, $id);

            //Act
            $test_student->setDate("2014-01-01");
            $result = $test_student->getDate();

            //Assert
            $this->assertEquals("2014-01-01", $result);
        }

    }
 ?>
