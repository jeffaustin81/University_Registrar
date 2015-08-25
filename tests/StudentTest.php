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
        protected function tearDown()
        {
            Student::deleteAll();
            // Course::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Ben";
            $id = null;
            $enrollment_date = "2015-12-12";
            $test_student = new Student($name, $enrollment_date, $id);

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
            $enrollment_date = "2015-12-12";
            $test_student = new Student($name, $enrollment_date, $id);

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
            $enrollment_date = "2015-12-12";
            $test_student = new Student($name, $enrollment_date, $id);

            //Act
            $result = $test_student->getEnrollmentDate();

            //Assert
            $this->assertEquals($enrollment_date, $result);
        }
        function test_setDate()
        {
            //Arrange
            $name = "Ben";
            $id = null;
            $enrollment_date = "2015-12-12";
            $test_student = new Student($name, $enrollment_date, $id);

            //Act
            $test_student->setEnrollmentDate("2014-01-01");
            $result = $test_student->getEnrollmentDate();

            //Assert
            $this->assertEquals("2014-01-01", $result);
        }
        function test_getId()
        {
           //Arrange
           $name = "Ben";
           $id = 1;
           $enrollment_date = "2014-01-01";
           $test_student = new Student($name, $enrollment_date, $id);
           //Act
           $result = $test_student->getId();
           //Assert
           $this->assertEquals(1, $result);
        }
        function test_save()
        {
            //Arrange
            $name = "Ben";
            $enrollment_date = "2015-06-07";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();
            //Act
            $result = Student::getAll();
            //Assert
            $this->assertEquals($test_student, $result[0]);
        }
        function test_getAll()
        {
            //Arrange
            $name = "Ben";
            $id = 1;
            $enrollment_date = "2015-05-05";
            $name2 = "Jeff";
            $id2 = 2;
            $enrollment_date2 = "2015-05-06";
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();
            $test_student2 = new Student($name2, $enrollment_date2, $id2);
            $test_student2->save();
            //Act
            $result = Student::getAll();
            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }
        function test_deleteAll()
        {
            //Arrange
            $name = "Ben";
            $id = 1;
            $enrollment_date = "2015-05-05";
            $name2 = "Jeff";
            $id2 = 2;
            $enrollment_date2 = "2015-05-06";
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();
            $test_student2 = new Student($name2, $enrollment_date2, $id2);
            $test_student2->save();
            //Act
            Student::deleteAll();
            $result = Student::getAll();
            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Wesley Pong";
            $enrollment_date = "2015-04-05";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();
            $name2 = "Jon Airpair";
            $enrollment_date2 = "2015-09-09";
            $id = 2;
            $test_student2 = new Student($name2, $enrollment_date2, $id);
            $test_student2->save();
            //Act
            $result = Student::find($test_student->getId());
            //Assert
            $this->assertEquals($test_student, $result);
        }


        function test_getCourses()
        {
            //Arrange
            $name = "Wesley Pong";
            $enrollment_date = "2015-09-09";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $course_name = "History";
            $id2 = 2;
            $course_number = 'HIST:101';
            $test_course = new Course($course_name, $course_number, $id2);
            $test_course->save();

            $course_name2 = "Algebra";
            $id3 = 3;
            $course_number2 = 'MTH:111';
            $test_course2 = new Course($course_name2, $course_number2, $id3);
            $test_course2->save();

            //Act

            $test_student->addCourse($test_course->getId());
            $test_student->addCourse($test_course2->getId());

            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);
        }

        function test_deleteCourse()
        {
            //Arrange
            $name = "Wesley Pong";
            $enrollment_date = "2015-09-09";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $course_name = "History";
            $id2 = 2;
            $course_number = 'HIST:101';
            $test_course = new Course($course_name, $course_number, $id2);
            $test_course->save();

            $course_name2 = "Lit";
            $id3 = 3;
            $course_number2 = 'Lit:101';
            $test_course2 = new Course($course_name2, $course_number2, $id3);
            $test_course2->save();

            $test_student->addCourse($test_course->getId());
            $test_student->addCourse($test_course2->getId());

            //Act
            $test_student->deleteCourse($test_course->getId());
            $result = $test_student->getCourses();

            //Assert
            $this->assertEquals([$test_course2], $result);
        }

        function test_deleteAllCourses()
        {
            //Arrange
            $name = "Wesley Pong";
            $enrollment_date = "2015-09-09";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $course_name = "History";
            $id2 = 2;
            $course_number = 'HIST:101';
            $test_course = new Course($course_name, $course_number, $id2);
            $test_course->save();

            $course_name2 = "Lit";
            $id3 = 3;
            $course_number2 = 'Lit:101';
            $test_course2 = new Course($course_name2, $course_number2, $id3);
            $test_course2->save();

            $test_student->addCourse($test_course->getId());
            $test_student->addCourse($test_course2->getId());

            //Act
            $test_student->deleteAllCourses();
            $result = $test_student->getCourses();

            //Assert
            $this->assertEquals([], $result);
        }

        function testUpdateName()
        {
            //Arrange
            $name = "bob";
            $enrollment_date = "2015-09-16";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();
            $new_name = "Mark Marvel";
            //Act
            $test_student->updateName($new_name);
            //Assert
            $this->assertEquals("Mark Marvel", $test_student->getName());
        }
        function testUpdateEnrollmentDate()
        {
            //Arrange
            $name = "bob";
            $enrollment_date = "2015-09-16";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();
            $new_date = "2015-02-12";
            //Act
            $test_student->updateEnrollmentDate($new_date);
            //Assert
            $this->assertEquals("2015-02-12", $test_student->getEnrollmentDate());
        }


    }
 ?>
