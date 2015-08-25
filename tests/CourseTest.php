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

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function test_getCourseName()
        {
            //Arrange
            $course_name = "History";
            $id = null;
            $course_number = "HIST:101";
            $test_course = new Course($course_name, $course_number, $id);

            //Act
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals($course_name, $result);
        }
        function test_setCourseName()
        {
            //Arrange
            $course_name = "History";
            $id = null;
            $course_number = "HIST:101";
            $test_course = new Course($course_name, $course_number, $id);

            //Act
            $test_course->setCourseName("Intro to History");
            $result = $test_course->getCourseName();

            //Assert
            $this->assertEquals("Intro to History", $result);
        }
        function test_getCourseNumber()
        {
            //Arrange
            $course_name = "History";
            $id = null;
            $course_number = "HIST:101";
            $test_course = new Course($course_name, $course_number, $id);

            //Act
            $result = $test_course->getCourseNumber();

            //Assert
            $this->assertEquals($course_number, $result);
        }
        function test_setCourseNumber()
        {
            //Arrange
            $course_name = "History";
            $id = null;
            $course_number = "HIST:101";
            $test_course = new Course($course_name, $course_number, $id);

            //Act
            $test_course->setCourseNumber("BIO:111");
            $result = $test_course->getCourseNumber();

            //Assert
            $this->assertEquals("BIO:111", $result);
        }
        function test_getId()
        {
           //Arrange
           $course_name = "Biology";
           $id = 1;
           $course_number = "BIO:111";
           $test_course = new Course($course_name, $course_number, $id);
           //Act
           $result = $test_course->getId();
           //Assert
           $this->assertEquals(1, $result);
        }
        function test_save()
        {
            //Arrange
            $course_name = "Algebra";
            $course_number = "MTH:211";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();
            //Act
            $result = Course::getAll();
            //Assert
            $this->assertEquals($test_course, $result[0]);
        }
        function test_getAll()
        {
            //Arrange
            $course_name = "Algebra";
            $id = 1;
            $course_number = "MTH:211";
            $course_name2 = "History";
            $id2 = 2;
            $course_number2 = "HIST:111";
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();
            $test_course2 = new Course($course_name2, $course_number2, $id2);
            $test_course2->save();
            //Act
            $result = Course::getAll();
            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }
        function test_deleteAll()
        {
            //Arrange
            $course_name = "History";
            $id = 1;
            $course_number = "HIST:111";
            $course_name2 = "Algebra";
            $id2 = 2;
            $course_number2 = "MTH:112";
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();
            $test_course2 = new Course($course_name2, $course_number2, $id2);
            $test_course2->save();
            //Act
            Course::deleteAll();
            $result = Course::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $course_name = "History";
            $course_number = "HIST:111";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();
            $course_name2 = "Albebra";
            $course_number2 = "MTH:112";
            $id = 2;
            $test_course2 = new Course($course_name2, $course_number2, $id);
            $test_course2->save();
            //Act
            $result = Course::find($test_course->getId());
            //Assert
            $this->assertEquals($test_course, $result);
        }

    }
 ?>
