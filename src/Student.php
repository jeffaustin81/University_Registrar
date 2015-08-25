<?php

    class Student
    {
        private $name;
        private $enrollment_date;
        private $id;

        function __construct($name, $enrollment_date, $id = null)
        {
            $this->name = $name;
            $this->enrollment_date = $enrollment_date;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setEnrollmentDate($new_enrollment_date)
        {
            $this->enrollment_date = (string) $new_enrollment_date;
        }

        function getEnrollmentDate()
        {
            return $this->enrollment_date;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name, enrollment_date)
            VALUES ('{$this->getName()}', '{$this->getEnrollmentDate()}')");
            $this->id = $GLOBALS['DB']->lastInsertID();
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($returned_students as $student) {
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS ['DB']->exec("DELETE FROM students;");
        }

        static function find($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach($students as $student) {
                $student_id = $student->getId();
                if ($student_id == $search_id) {
                    $found_student = $student;
                }
            }
            return $found_student;
        }

        function addCourse($course_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (course_id, student_id)
                VALUES ({$course_id}, {$this->id})");
        }

        function getCourses()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT courses.* FROM
                students JOIN students_courses ON (students.id = students_courses.student_id)
                JOIN courses ON (courses.id = students_courses.course_id)
                WHERE students.id = {$this->getId()}");

            $courses = array();
            foreach($returned_courses as $course)
            {
                $name = $course['course_name'];
                $course_number = $course['course_number'];
                $id = $course['id'];
                $new_course = new Course($name, $course_number,$id);
                array_push($courses, $new_course);
            }

            return $courses;
        }

        function deleteCourse($course_id)
        {
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE
                course_id = {$course_id} AND student_id = {$this->id}");
        }

        function deleteAllCourses()
        {
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE student_id = {$this->id}");
        }

        //Update student name
        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET name = '{$new_name}'
                WHERE id = {$this->getId()}");
            $this->setName($new_name);
        }
        //Update student enrollment date
        function updateEnrollmentDate($new_date)
        {
            $GLOBALS['DB']->exec("UPDATE students SET enrollment_date = {$new_date}
                WHERE id = {$this->getId()}");
            $this->setEnrollmentDate($new_date);
        }


    }
 ?>
