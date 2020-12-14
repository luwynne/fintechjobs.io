<?php

namespace App\Http\Controllers;

use App\Http\Requests\{
    CreateCourseRequest,
    EditCourseRequest
};
use App\Course;
use Auth;

class CourseController extends Controller{

    private function _saveCourse($request, $course_id):Course{

        if(isset($course_id)){
            $course = Course::find($course_id);
        }else{
            $course = new Course();
        }

        $course->institute_id = Auth::user()->company->education_institute->id;
        $course->name = $request->input('name');
        $course->description = $request->input('description');
        $course->url = $request->input('url');
        $course->save();

        return $course;
    }

    public function getCourses(){
        $courses = Auth::user()->company->education_institute->courses;
        return response()->json($courses);
    }

    public function createCourse(CreateCourseRequest $request){
        $course = $this->_saveCourse($request, null);
        return response()->json($course);
    }
    
    public function editCourse(EditCourseRequest $request, $course_id){
        $course = $this->_saveCourse($request, $course_id);
        return response()->json($course);
    }
    
}
