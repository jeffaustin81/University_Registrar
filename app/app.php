<?php

    // This is the initial setup for the app.php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Course.php";
    require_once __DIR__."/../src/Student.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=university_registrar';
    $username = 'root';
    $password = 'root';

    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render("index.html.twig");
    });

    $app->get("/courses", function() use ($app) {
        return $app['twig']->render("courses.html.twig", array("courses" => Course::getAll()));
    });

    $app->post("/courses", function() use ($app) {
        $course_name = $_POST['course_name'];
        $course_number = $_POST['course_number'];
        $new_course = new Course($course_name, $course_number);
        $new_course->save();
        return $app['twig']->render("courses.html.twig", array("courses" => Course::getAll()));
    });


    $app->post("/delete_courses", function() use ($app) {
        Course::deleteAll();
        return $app['twig']->render("courses.html.twig", array("courses" => Course::getAll()));
    });

    /////////
    ////////// STUDENTS
    ////////

    $app->get("/students", function() use ($app)
    {
        return $app['twig']->render("students.html.twig", array("students" => Student::getAll()));
    });

    $app->get("/students/{id}", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render("student.html.twig", array("student" => $student, "courses" => $student->getCourses(), "all_courses" => Course::getAll()));

    });

    $app->post("/students", function() use ($app)
    {
        $name = $_POST['name'];
        $enrollment_date = $_POST['enrollment_date'];
        $new_student = new Student($name, $enrollment_date);
        $new_student->save();

        return $app['twig']->render("students.html.twig", array("students" => Student::getAll()));
    });

    $app->post("/add_courses", function() use ($app) {
        $course = Course::find($_POST["course_id"]);
        $course->addStudent($_POST["student_id"]);
        $student = Student::find($_POST["student_id"]);
        return $app['twig']->render("student.html.twig", array("student" => $student, "courses" => $student->getCourses(), "all_courses" => Course::getAll()));
    });

    $app->post("/delete_students", function() use ($app) {
        Student::deleteAll();
        return $app['twig']->render("students.html.twig", array("students" => Student::getAll()));
    });

    return $app;
?>
