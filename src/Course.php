<?php

    class Course
    {
        private $course_name;
        private $course_number;
        private $id;

        function __construct($course_name, $course_number, $id = null)
        {
            $this->course_name = $course_name;
            $this->course_number = $course_number;
            $this->id = $id;
        }

        function setCourseName($new_course_name)
        {
            $this->course_name = (string) $new_course_name;
        }

        function getCourseName()
        {
            return $this->course_name;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = (string) $new_course_number;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number)
            VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}')");
            $this->id = $GLOBALS['DB']->lastInsertID();
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach($returned_courses as $course) {
                $course_name = $course['course_name'];
                $course_number = $course['course_number'];
                $id = $course['id'];
                $new_course = new Course($course_name, $course_number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function deleteAll()
        {
            $GLOBALS ['DB']->exec("DELETE FROM courses;");
        }

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach($courses as $course) {
                $course_id = $course->getId();
                if ($course_id == $search_id) {
                    $found_course = $course;
                }
            }
            return $found_course;
        }

        function addStudent($student_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (course_id, student_id)
                VALUES ({$this->id}, {$student_id})");
        }

        function getStudents()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT students.* FROM
                students JOIN students_courses ON (students.id = students_courses.student_id)
                JOIN courses ON (courses.id = students_courses.course_id)
                WHERE courses.id = {$this->getId()}");

            $students = array();
            foreach($returned_students as $student)
            {
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date,$id);
                array_push($students, $new_student);
            }

            return $students;
        }

        function deleteStudent($student_id)
        {
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE
                student_id = {$student_id} AND course_id = {$this->id}");
        }

        function deleteAllStudents()
        {
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE course_id = {$this->id}");
        }

        //Update course name
        function updateCourseName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course_name = '{$new_name}'
                WHERE id = {$this->getId()}");
            $this->setCourseName($new_name);
        }
        //Update course enrollment date
        function updateCourseNumber($new_course_number)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course_number = {$new_course_number}
                WHERE id = {$this->getId()}");
            $this->setCourseNumber($new_course_number);
        }
    }
 ?>
