<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Notification;
use App\Models\Certificate;
use App\Models\Checkout;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;
use App\Traits\SlugTrait;



class CourseCreateStepController extends Controller
{


    use SlugTrait;

    /**
     * Show the first step of course creation.
     * If a course creation is already in progress, redirect to the next step.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function start()
    {
        if (session()->has('course_id')) {
           session()->forget('course_id');
            return redirect()->to('instructor/courses/create/' . session('course_id'));
        }

        return view('e-learning/course/instructor/create/step-1');
    }

    /**
     * Validate and store the initial course information from step 1.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function startSet(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'language' => 'nullable|string',
            'categories' => 'nullable|string'
        ]);

        try {
            $course = new Course();
            
            $course->fill([
                'user_id' => auth()->id(),
                'instructor_id' => auth()->id(),
                'title' => $request->input('title'),
                'slug' => $this->makeUniqueSlug($request->input('title'), 'Course'),
                'short_description' => $request->input('short_description'),
                'description' => $request->input('description'),
                'curriculum' => $request->input('curriculum'),
                'language' => $request->input('language'),
                'categories' => $request->input('categories'),
            ]);

            $course->save();

            session()->put('course_id', $course->id);

            return redirect()->route('course.create.object', ['id' => $course->id])
                             ->with('success', 'Course facts saved successfully.');

        } catch (\Exception $e) {
            \Log::error('Course creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected server error occurred. Please try again.');
        }
    }

    public function step1a(Request $request, $id){
        $modules = Module::with('lessons')->where('course_id', $id)->where('instructor_id', Auth::user()->id)->orderBy('reorder', "ASC")->get();
        return view('e-learning/course/instructor/create/step-6', compact('modules'));
    }
    public function step1c(Request $request){

        $request->validate([
            'module_name' => 'required|string'
        ],
        [
            'module_name' => 'Module Name is Required',
        ]);

        $course = new Course();
        $course->user_id = Auth::user()->id;
        $course->instructor_id = Auth::user()->id;
        $course->save();

        session()->put('course_id', $course->id);


        $slug = $this->makeUniqueSlug($request->input('module_name'), 'Module');

        if($request->input('module_name')){
            $module = new Module();
            $module->course_id = $course->id;
            $module->instructor_id = Auth::user()->id;
            $module->title = $request->input('module_name');
            $module->slug = $slug;
            $module->status = "draft";
            $module->save();
        }
        return redirect('instructor/courses/create/'.$course->id)->with('success', 'Course Creation Started!');
    }

    public function step1( $id){
        if (session()->has('course_id')) {
            session()->forget('course_id');
        }

        if(!$id){
            return redirect('instructor/courses');
        }

        // session set
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        $course = Course::where('id', $id)->where('instructor_id',Auth::user()->id)->firstOrFail();

        return view('e-learning/course/instructor/create/step-1',compact('course'));
    }

 


    public function step3($id){

        if(!$id){
            return redirect('instructor/courses');
        }

         // session set
         if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        $modules = Module::with('lessons')->where('course_id', $id)->where('instructor_id', Auth::user()->id)->orderBy('reorder', "ASC")->get();
        return view('e-learning/course/instructor/create/step-6',compact('modules'));
    }


    public function moduleResorting( Request $request ){

        $moduleOrder = $request->input('moduleOrder');

        foreach ($moduleOrder as $index => $moduleId) {
            $module = Module::find($moduleId);

            if ($module) {
                $module->reorder = $index + 1;
                $module->save();
            }
        }

        return response()->json(['success' => true]);

    }

    public function moduleLessonResorting( Request $request ){

        $lessonsOrder = $request->input('lessonOrder');

        foreach ($lessonsOrder as $index => $lessionId) {
            $lesson = Lesson::find($lessionId);

            if ($lesson) {
                $lesson->reorder = $index + 1;
                $lesson->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function destroyModule($id)
    {
        $module = Module::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        $module->lessons()->delete();
        $module->delete();

        return back()->with('success', 'Module deleted successfully.');
    }

    public function destroyLesson($id)
    {
        $lesson = Lesson::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        $lesson->delete();

        return back()->with('success', 'Lesson deleted successfully.');
    }


    public function addLesson(Request $request,  $id)
    {

         if(!$id){
            return redirect('instructor/courses');
        }

        $request->validate([
            'lesson_name' => 'required',
            'lesson_type' => 'required'
        ],
        [
            'lesson_name' => 'Lesson Name is Required',
        ]
        );

        $slug = $this->makeUniqueSlug($request->input('lesson_name'), 'Lesson');

        $lesson = new Lesson();
        $lesson->course_id = $id;
        $lesson->instructor_id = Auth::user()->id;
        $lesson->module_id = $request->module_id;
        $lesson->title = $request->input('lesson_name');
        $lesson->slug = $slug;
        $lesson->type = $request->input('lesson_type');
        $lesson->status = "pending";
        $lesson->is_public = $request->has('is_public') ? true : false;
        $lesson->save();

        if ($lesson->type == 'audio') {
            return redirect('instructor/courses/create/'.$lesson->course_id.'/audio/'.$lesson->module_id.'/content/'.$lesson->id)->with('info', 'Set The audio to complete this Lesson');

        }elseif($lesson->type == 'video'){
            return redirect('instructor/courses/create/'.$lesson->course_id.'/video/'.$lesson->module_id.'/content/'.$lesson->id)->with('info', 'Upload The video to complete this Lesson');

        }elseif($lesson->type == 'text'){
            return redirect('instructor/courses/create/'.$lesson->course_id.'/text/'.$lesson->module_id.'/content/'.$lesson->id)->with('info', 'Set The Text to complete this Lesson');
        }else{
            return redirect()->back()->with('error', 'Failed to Create Lesson');
        }

    }

    public function module(Request $request, $id){
        
        if(!$id){
            return redirect('instructor/courses');
        }

        $request->validate([
            'module_name' => 'required|string'
        ],
        [
            'module_name' => 'Module Name is Required',
        ]);

        // Check if module_id is present to determine if this is an update operation
        if ($request->has('module_id') && $request->input('module_id')) {
            // Update existing module
            $module = Module::where('id', $request->input('module_id'))
                           ->where('instructor_id', Auth::user()->id)
                           ->firstOrFail();
            $module->title = $request->input('module_name');
            $module->slug = $this->makeUniqueSlug($request->input('module_name'), 'Module', $module->id);
            $module->publish_at = $request->input('publish_at') ? $request->input('publish_at') : null;
            $module->save();
            
            return redirect()->back()->with('success', 'Module Updated successfully');
        } else {
            // Create new module
            $slug = $this->makeUniqueSlug($request->input('module_name'), 'Module');
            $module = new Module();
            $module->course_id = $id;
            $module->instructor_id = Auth::user()->id;
            $module->title = $request->input('module_name');
            $module->slug = $slug;
            $module->publish_at = $request->input('publish_at') ? $request->input('publish_at') : null;
            $module->save();
            
            return redirect()->back()->with('success', 'Module Created successfully');
        }
    }

    public function step3cu(Request $request, $id){

        if(!$id){
            return redirect('instructor/courses');
        }

        $request->validate([
            'module_name' => 'required'
        ],
        [
            'module_name' => 'Module Name is Required',
        ]);

        $module_id = $request->input('module_id');

        $module = Module::where('id', $module_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        $slug = $this->makeUniqueSlug($request->input('module_name'), 'Module', $module->slug);

        $module->course_id = $id;
        $module->instructor_id = Auth::user()->id;
        $module->title = $request->input('module_name');
        $module->slug = $slug;
        $module->publish_at = $request->input('publish_at') ? $request->input('publish_at') : null;
        $module->save();

        return redirect()->back()->with('success', 'Module Updated successfully');
    }

    public function step3d(Request $request, $id){

        if(!$id){
            return redirect('instructor/courses');
        }

        $request->validate([
            'lesson_name' => 'required',
            'lesson_type' => 'required'
        ],
        [
            'lesson_name' => 'Lesson Name is Required',
        ]);

        $lesson_id = $request->input('lesson_id');
        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        $slug = $this->makeUniqueSlug($request->input('lesson_name'), 'Lesson', $lesson->slug);

        $lesson->course_id = $request->input('course_id');
        $lesson->instructor_id = Auth::user()->id;
        $lesson->module_id = $request->module_id;
        $lesson->title = $request->input('lesson_name');
        $lesson->slug = $slug;
        $lesson->type = $request->input('lesson_type');
        $lesson->is_public = $request->has('is_public') ? true : false;

        if( $request->input('lesson_type') == 'audio' ){
            $lesson->text = NULL;
            $lesson->video_link = NULL;
            $lesson->status = 'pending';
        }else if( $request->input('lesson_type') == 'video_link'){
            $lesson->audio = NULL;
            $lesson->text = NULL;
            $lesson->short_description = NULL;
            $lesson->status = 'pending';
        }else if($request->input('lesson_type') == 'text'){
            $lesson->audio = NULL;
            $lesson->video_link = NULL;
            $lesson->short_description = NULL;
            $lesson->status = 'pending';
        }

        $lesson->save();

        return redirect()->back()->with('success', 'Lesson Updated successfully');
    }

    public function stepLessonText($course_id,$module_id,$lesson_id){

        if(!$lesson_id){
            return redirect('instructor/courses');
        }

         // session set
         if (!session()->has('course_id')) {
            session(['course_id' => $course_id]);
        }

        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        return view('e-learning/course/instructor/create/step-4-text',compact('lesson'));
    }

    public function stepLessonContent(Request $request, $lesson_id)
    {

        if(!$lesson_id){
            return redirect('instructor/courses');
        }

        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        $lesson->text = $request->input('text');

        $request->validate([
            'lesson_file.*' => 'mimes:pdf,doc,docx|max:250240',
        ]);

        if ($request->hasFile('lesson_file')) {
            if ($lesson->lesson_file) {
               $previousLessonPath = public_path($lesson->lesson_file);
                if (file_exists($previousLessonPath)) {
                    unlink($previousLessonPath);
                }
            }

            $file = $request->file('lesson_file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/lessons/files'), $filename);
            $lesson->lesson_file = 'uploads/lessons/files/' . $filename;
        }
        $lesson->status = 'published';
        $lesson->save();

        return redirect('instructor/courses/create/'.$lesson->course_id.'/lesson/'.$lesson->module_id.'/institute/'.$lesson->id)->with('success', 'Lesson Content Added successfully');

    }

    public function stepLessonInstitue($id,$module_id,$lesson_id){

        if(!$id){
            return redirect('instructor/courses');
        }

        // session set
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        return view('e-learning/course/instructor/create/step-3',compact('course','lesson'));
    }

    public function stepLessonAudio($id,$module_id,$lesson_id){

        if(!$id || !$module_id || !$lesson_id){
            return redirect('instructor/courses');
        }

        // session set
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        return view('e-learning/course/instructor/create/step-4',compact('lesson'));
    }

    public function stepLessonAudioRemove($id,$module_id,$lesson_id){

        if(!$id || !$module_id || !$lesson_id){
            return redirect('instructor/courses');
        }

        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        if ($lesson->audio) {
            $previousAudioPath = public_path($lesson->audio);
            if (file_exists($previousAudioPath)) {
                unlink($previousAudioPath);
            }

            $lesson->audio = NULL;
            $lesson->status = 'pending';
            $lesson->duration = false;
            $lesson->save();
            return redirect()->back()->with('success','Lesson Audio Successfully Deleted!');
        }

        return redirect()->back()->with('warning','No Audio Found!');

    }

    public function stepLessonFileRemove($id,$module_id,$lesson_id)
    {
        if(!$id || !$module_id || !$lesson_id){
            return redirect('instructor/courses');
        }

        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        if ($lesson->lesson_file) {
            $previousLessonPath = public_path($lesson->lesson_file);
            if (file_exists($previousLessonPath)) {
                unlink($previousLessonPath);
            }
            $lesson->lesson_file = NULL;
            $lesson->save();
            return redirect()->back()->with('success','Lesson File Successfully Deleted!');
        }

        return redirect()->back()->with('warning','No File Found!');

    }

    public function stepLessonAudioSet(Request $request, $id, $module_id, $lesson_id){

        if (!$id) {
            return redirect('instructor/courses');
        }

        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        if ($lesson->audio) {
            $request->validate([
                'short_description' => 'nullable|string',
                'audio' => 'nullable|mimes:mp3,wav|max:50000',
                'lesson_file.*' => 'mimes:pdf,doc,docx|max:50000',

            ]);
        }else{
            $request->validate([
                'short_description' => 'nullable|string',
                'audio' => 'required|mimes:mp3,wav|max:50000',
                'lesson_file.*' => 'mimes:pdf,doc,docx|max:50000',
            ]);
        }

        $lesson->short_description = $request->input('short_description');

        // Handle audio file upload
        if ($request->hasFile('audio')) {


            $filePath = $request->file('audio')->getPathname();

            $getID3 = new \getID3;

            $audioFile = $getID3->analyze($filePath);

            $audioDuration = round( $audioFile['playtime_seconds']);


            if ($lesson->audio) {
                $previousAudioPath = public_path($lesson->audio);
                if (file_exists($previousAudioPath)) {
                    unlink($previousAudioPath);
                }
            }

            $audio = $request->file('audio');
            $audioName = $lesson->slug . '.' . $audio->getClientOriginalExtension();
            $audio->move(public_path('uploads/audio/'), $audioName);
            $lesson->audio = 'uploads/audio/'.$audioName;
        }

        if ($request->hasFile('lesson_file')) {
            if ($lesson->lesson_file) {
               $previousLessonPath = public_path($lesson->lesson_file);
                if (file_exists($previousLessonPath)) {
                    unlink($previousLessonPath);
                }
            }

            $file = $request->file('lesson_file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/lessons/files'), $filename);
            $lesson->lesson_file = 'uploads/lessons/files/' . $filename;
        }

        $lesson->duration = $request->hasFile('audio') ? $audioDuration : $lesson->duration;
        $lesson->status = 'published';
        $lesson->save();

        $module = Module::find($lesson->module_id);

        if ($module) {
            $module->status = "published";
            $module->save();
        }

        return redirect('instructor/courses/create/'.$lesson->course_id.'/lesson/'.$lesson->module_id.'/institute/'.$lesson->id)->with('success', 'Lesson Content Added successfully');

    }

    public function stepLessonVideo($id,$module_id,$lesson_id)
    {


        if(!$id){
            return redirect('instructor/courses');
        }


        // session set
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }


        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        $course = Course::where('id', $id)
        ->where('user_id', Auth::user()->id)
        ->firstOrFail();






        return view('e-learning/course/instructor/create/step-5',compact('course','lesson'));
    }

    public function stepLessonVideoSet(Request $request, $id,$module_id,$lesson_id)
    {

        ini_set('memory_limit', '1024M');

        $lesson = Lesson::where('id', $lesson_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        $videoType = $request->input('video_type', 'vimeo');

        if ($videoType === 'youtube') {
            $request->validate([
                'video_type' => 'required|in:vimeo,youtube',
                'youtube_url' => [
                    'required',
                    'url',
                    'regex:#^(https?:\/\/)?(www\.)?(youtube\.com/(watch\?v=|embed/)|youtu\.be/)[\w\-]+$#i'
                ],
                'youtube_duration' => 'required|integer|min:1',
                'short_description' => 'nullable|string',
            ], [
                'youtube_url.required' => 'YouTube URL is required!',
                'youtube_url.url' => 'Please enter a valid URL!',
                'youtube_url.regex' => 'Please enter a valid YouTube URL!',
                'youtube_duration.required' => 'Video duration is required for YouTube videos!',
                'youtube_duration.integer' => 'Duration must be a valid number!',
                'youtube_duration.min' => 'Duration must be at least 1 second!',
            ]);
        } else {
            if ($lesson->video_link) {
                $request->validate([
                    'video_link' => 'nullable|mimes:mp4,mov,ogg,qt|max:1000000',
                    'short_description' => 'nullable|string',
                ],
                [
                    'video_link.max' => 'Max file size is 1 GB!',
                ]);

            }else{
                $request->validate([
                    'video_link' => 'required|mimes:mp4,mov,ogg,qt|max:1000000',
                    'short_description' => 'nullable|string',
                ],
                [
                    'video_link.required' => 'Video file is required!',
                    'video_link.max' => 'Max file size is 1 GB!',
                ]);
            }
        }


        $lesson->short_description = $request->input('short_description');
        $lesson->status = 'published';
        $lesson->video_type = $videoType;

        if ($videoType === 'youtube') {
            $lesson->video_link = $request->input('youtube_url');
            $lesson->duration = $request->input('youtube_duration');
            $lesson->save();
            
            $course = Course::find($id);
            $price = $course->price ?? 0;
            response()->json(['uri' => $request->input('youtube_url'), 'price' => $price]);
        }

        $lesson->save();

        if ($request->hasFile('video_link')) {

            $file = $request->file('video_link');
            $videoName = $file->getClientOriginalName();


            $filePath = $request->file('video_link')->getPathname();

            $getID3 = new \getID3;

            $videoFile = $getID3->analyze($filePath);

            $videoDuration = round( $videoFile['playtime_seconds']);

            [$vimeoData, $status, $accountName] = isVimeoConnected($lesson->instructor_id);

            if ($status === 'Connected') {
                $vimeo = new \Vimeo\Vimeo($vimeoData->client_id, $vimeoData->client_secret, $vimeoData->access_key);

                $uri = $vimeo->upload($file->getPathname(), [
                    'name' => $lesson->title,
                    'approach' => 'tus',
                    'size' => $file->getSize(),
                ]);

                if ($uri) {
                    $lesson = Lesson::find($lesson_id);
                    $lesson->video_link = $uri;
                    $lesson->duration = $videoDuration;
                    $lesson->short_description = $request->short_description;
                    $lesson->save();
                    session()->flash('success', 'Video upload success!');
                }
                $course = Course::find($id);
                $price = $course->price ?? 0;
                return response()->json(['uri' => $uri, 'price' => $price]);

            } elseif ($status === 'Invalid Credentials') {
                return response()->json(['error' => 'Invalid Vimeo credentials. Please check your account settings.']);
            } else {
                return response()->json(['error' => 'Vimeo account is not connected.']);
            }
        }

        return redirect('instructor/courses/create/'.$lesson->course_id.'/lesson/'.$lesson->module_id.'/institute/'.$lesson->id)->with('success', 'Element of Module where this lesson will be added. Class');
    }

    public function stepLessonVideoRemove($id,$module_id,$lesson_id)
    {

        $lesson = Lesson::where('id', $lesson_id)->where('module_id',$module_id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        if ($lesson) {
            $lesson->video_link = NULL;
            $lesson->video_type = 'vimeo';
            $lesson->status = 'pending';
            $lesson->save();
            return redirect()->back()->with('success','Video Deleted Successfuly!');
        }

        return redirect()->back()->with('error','Failed to deleted the video !');
    }

    public function courseObjects( $id){

        if(!$id){
            return redirect('instructor/courses');
        }

        // session set
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        try {
            $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect('instructor/courses')->with('error', 'Course not found or you are not authorized to access it.');
        }

        return view('e-learning/course/instructor/create/step-2',compact('course'));
    }

    public function courseObjectsSet(Request $request, $id){

        $data = $request->json()->all();
        
        // Enhanced validation for objectives/learnings
        if (!isset($data['objective']) || empty(trim($data['objective']))) {
            return response()->json([
                'error' => 'লক্ষ্য/শেখার ফলাফল খালি রাখা যাবে না',
                'message' => 'Objective cannot be empty'
            ], 422);
        }
        
        // Basic length validation  
        if (strlen(trim($data['objective'])) > 1000) {
            return response()->json([
                'error' => 'Objective is too long',
                'message' => 'Objective cannot exceed 1000 characters'
            ], 422);
        }
        
        // Clean the objective text
        $cleanObjective = trim(strip_tags($data['objective']));

       if ($data['dataIndex'] != null) {
        // Update existing objective
        $dataIndex = $data['dataIndex'];

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        $existingObjectives = explode('[objective]', $course->objective);
        
        // Validate index exists
        if (!isset($existingObjectives[$dataIndex])) {
            return response()->json([
                'error' => 'অবৈধ ইনডেক্স',
                'message' => 'Invalid objective index'
            ], 422);
        }
        
        $existingObjectives[$dataIndex] = $cleanObjective;

        $updatedObjectiveString = implode('[objective]', $existingObjectives);
        $trimmedStringUp = preg_replace('/^(\ [objective\ ])+|(\ [objective\ ])+$/', '', $updatedObjectiveString);

        $course->objective = $trimmedStringUp;
        $course->save();

        return response()->json([
            'message' => 'UPDATED',
            'success' => 'লক্ষ্য সফলভাবে আপডেট হয়েছে'
        ]);

       } else {
        // Add new objective
        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        // Simply add the new objective
        if ($course->objective) {
            $course->objective = $course->objective . '[objective]' . $cleanObjective;
        } else {
            $course->objective = $cleanObjective;
        }

        $course->save();

        return response()->json([
            'message' => 'ADDED',
            'success' => 'Objective added successfully'
        ]);
       }
    }

    public function deleteObjective(Request $request, $id,$index)
    {
        // Validate course ownership
        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        
        if (!$course->objective) {
            return response()->json([
                'error' => 'কোন লক্ষ্য পাওয়া যায়নি',
                'message' => 'No objectives found'
            ], 422);
        }
        
        $existingObjectives = explode('[objective]', $course->objective);
        
        // Filter out empty objectives
        $existingObjectives = array_filter($existingObjectives, function($objective) {
            return trim($objective) !== '';
        });

        // Validate index
        if (!isset($existingObjectives[$index])) {
            return response()->json([
                'error' => 'অবৈধ ইনডেক্স',
                'message' => 'Invalid index'
            ], 422);
        }

        unset($existingObjectives[$index]);
        $existingObjectives = array_values($existingObjectives);

        // Allow deletion of all items - set to null if empty
        if (empty($existingObjectives)) {
            $course->objective = null;
        } else {
            $course->objective = implode('[objective]', $existingObjectives);
        }
        $course->save();

        return response()->json([
            'message' => 'DONE',
            'success' => 'লক্ষ্য সফলভাবে মুছে ফেলা হয়েছে',
            'remainingObjectives' => $existingObjectives
        ]);
    }

    public function coursePrice($id){

        if(!$id){
            return redirect('instructor/courses');
        }

        // session set
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        return view('e-learning/course/instructor/create/step-price',compact('course'));
    }

    public function coursePriceSet(Request $request, $id){

        if(!$id){
            return redirect('instructor/courses');
        }

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        // Check if course is marked as free
        if ($request->has('is_free') && $request->input('is_free')) {
            // If course is free, set price to 0
            $course->price = 0;
            $course->offer_price = null;
        } else {
            // Validate pricing if not free
            $request->validate([
                'price' => 'required|numeric|min:0',
                'offer_price' => 'nullable|numeric|lt:price',
            ]);

            $course->price = $request->input('price');
            $course->offer_price = $request->input('offer_price');
        }

        $course->save();

        return redirect('instructor/courses/create/'.$course->id.'/design')->with('success', 'Course Price Set successfully');

    }

    public function courseDesign($id){

        if(!$id){
            return redirect('instructor/courses');
        }

        // session set
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        return view('e-learning/course/instructor/create/step-8',compact('course'));
    }

    public function courseDesignSet(Request $request, $id){

        if(!$id){
            return redirect('instructor/courses');
        }

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        $request->validate([
            'thumbnail' => 'nullable|file|mimes:jpg,png,jpg,webp,gif,svg|max:5121',
        ],
        [
            'thumbnail' => 'Max file size is 5 MB!'
        ]);

        $slugg = Str::slug(Auth::user()->name);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
               $oldFile = public_path($course->thumbnail);
               if (file_exists($oldFile)) {
                   unlink($oldFile);
               }
           }
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $uniqueFileName = $slugg . '-' . uniqid() . '.' . $extension;
            $file->move(public_path('uploads/courses/'), $uniqueFileName);
            $image_path = 'uploads/courses/' . $uniqueFileName;
           $course->thumbnail = $image_path;
       }

        $course->promo_video = $request->input('promo_video');
        $course->save();

        return redirect('instructor/courses/create/'.$course->id.'/content')->with('success', 'Course Thumbnail Set successfully');
    }


    public function courseCertificate($id){
        if(!$id){
            return redirect('instructor/courses');
        }

        // session set
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        $certificates = Certificate::where('instructor_id', Auth::user()->id)->with('course')->get();



        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
        return view('e-learning/course/instructor/create/step-9',compact('course','certificates'));
    }

    public function courseCertificateSet(Request $request,  $id){

        if(!$id){
            return redirect('instructor/courses');
        }
        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        $request->validate([
            'sample_certificates' => 'nullable|file|mimes:jpg,png,pdf,svg|max:5121',
        ]);

        $certificateStyle = Certificate::find($request->certificateStyle);

        if ($certificateStyle) {
            $newCertificateStyle = $certificateStyle->replicate();
            $newCertificateStyle->course_id = $id;
            $newCertificateStyle->save();
        }

        $image_path = 'uploads/courses/sample_certificates.jpg';

        if ($request->hasFile('sample_certificates')) {
            $file = $request->file('sample_certificates');
            $extension = $file->getClientOriginalExtension();
            $filename = 'sample_certificates_'.$course->slug . '.' . $extension;
            $file->move(public_path('uploads/courses/'), $filename);
            $image_path = 'uploads/courses/' . $filename;
        }

        // Store other form data
        $course->sample_certificates = $image_path;
        $course->save();

        return redirect('instructor/courses/create/'.$course->id.'/visibility')->with('success', 'Course Certificate Set successfully');
    }

    public function courseCertificateRemove($id)
    {
        if (!$id) {
            return response()->json(['error' => 'Invalid course ID'], 400);
        }

        try {
            $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

            // Remove the physical file if it exists
            if ($course->sample_certificates) {
                $filePath = public_path($course->sample_certificates);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Clear the certificate path from database
            $course->sample_certificates = null;
            $course->save();

            return response()->json([
                'success' => true,
                'message' => 'Certificate removed successfully'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Course not found or unauthorized'], 404);
        } catch (\Exception $e) {
            \Log::error('Certificate removal failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to remove certificate'], 500);
        }
    }

    public function visibility(string  $id){

        if(!$id){
            return redirect('instructor/courses');
        }

        // Set session for course creation flow
        if (!session()->has('course_id')) {
            session(['course_id' => $id]);
        }

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        return view('e-learning/course/instructor/create/step-10',compact('course'));
    }

    public function visibilitySet(Request $request, $id){

        if(!$id){
            return redirect('instructor/courses');
        }

        // if( isConnectedWithStripe()[1] ){
        //     return redirect()->route('account.settings', ['tab' => 'app', 'subdomain' => config('app.subdomain')])->withError(['Your stripe isn\'t connected!!']);
        // }

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        $request->validate([
            'status' => 'required',
        ]);


        $course->status = $request->input('status');
        $course->allow_review = $request->input('allow_review') ?? 0;
        $course->save();

        // if ($course->status == 'published') {

        //     $checkout = new Checkout;
        //     $checkouts = $checkout->getCheckoutByInstructorID();
        //     foreach($checkouts as $checkout){
        //         $notification = new Notification([
        //             'instructor_id' => $checkout->instructor_id,
        //             'course_id' => $checkout->course_id,
        //             'user_id' => $checkout->user_id,
        //             'message' => 'message',
        //             'type' => 'New Course Created'
        //         ]);
        //         $notification->save();
        //     }
        // }

        return redirect('instructor/courses/create/'.$course->id.'/share')->with('success', 'Course Status Set successfully');
    }

    public function courseShare($id){
        if(!$id){
            return redirect('instructor/courses');
        }

        // Clear session
        if (session()->has('course_id')) {
            session()->forget('course_id');
        }

        $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();

        return view('e-learning/course/instructor/create/step-7',compact('course'));
    }

    public function finish($id)
    {
        if(!$id){
            return redirect('instructor/courses');
        }

        // Clear session
        if (session()->has('course_id')) {
            session()->forget('course_id');
        }

        return redirect('instructor/courses')->with('success','Course Creation Completed!');

    }


    public function getProgress(Request $request)
    {
        $uri = $request->input('uri');
        $courseId = $request->input('courseId');

        $course = Course::find($courseId);
        $userId = $course->user_id;

        [$vimeoData, $status, $accountName] = isVimeoConnected($userId);

        if ($status === 'Connected') {
            $vimeo = new \Vimeo\Vimeo($vimeoData->client_id, $vimeoData->client_secret, $vimeoData->access_key);
            $video = $vimeo->request($uri);

            if (isset($video['body']['upload']['upload_status']) && $video['body']['upload']['upload_status'] === 'in_progress') {
                $progress = $video['body']['upload']['upload_progress'] * 100;
            } else {
                $progress = 100;
            }
            return response()->json(['progress' => $progress]);
        }

    }

    public function finishEdit(){
        // Clear course session when finishing
        if (session()->has('course_id')) {
            session()->forget('course_id');
        }
        return redirect('instructor/courses');
    }

    public function facts($id = null)
    {
        // If no ID provided (i.e., accessing /instructor/courses/create)
        if (!$id) {
            // Check if there's an active course creation in session
            if (session()->has('course_id')) {
                // Redirect to the facts route with the session course ID
                return redirect()->route('course.create.facts', ['id' => session('course_id')]);
            }
            // If no session, show empty form for new course creation
            $course = new Course();
        } else {
            // If ID provided, load existing course and set session
            try {
                $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
                session(['course_id' => $id]);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                // Redirect to courses list if course not found or unauthorized
                return redirect('instructor/courses')->with('error', 'Course not found or you are not authorized to access it.');
            }
        }
        
        return view('e-learning/course/instructor/create/step-1', compact('course'));
    }

    public function storeFacts(Request $request, $id = null)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'curriculum' => 'nullable|string',
            'language' => 'nullable|string',
            'categories' => 'nullable|string'
        ], [
            'title.required' => 'Course title is required.',
            'title.max' => 'Course title must not exceed 255 characters.',
            'slug.max' => 'Course slug must not exceed 255 characters.',
            'short_description.max' => 'Short description must not exceed 1000 characters.',
        ]);

        try {
            DB::beginTransaction();

            if ($id) {
                try {
                    $course = Course::where('id', $id)->where('instructor_id', auth()->id())->firstOrFail();
                    $message = 'Course facts updated successfully.';
                } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    return redirect('instructor/courses')->with('error', 'Course not found or you are not authorized to edit it.');
                }
            } else {
                $course = new Course();
                $course->user_id = auth()->id();
                $course->instructor_id = auth()->id();
                $message = 'Course created successfully. You can now proceed to the next step.';
            }

            $course->title = $request->input('title');
            $slug = $request->input('slug') ?: $request->input('title');
            $course->slug = $this->makeUniqueSlug($slug, 'Course', $course->slug ?? null);

            $course->short_description = $request->input('short_description');
            $course->description = $request->input('description');
            $course->curriculum = $request->input('curriculum');
            $course->language = $request->input('language');
            $course->categories = $request->input('categories');

            $course->save();

            session()->put('course_id', $course->id);

            DB::commit();

            // Always redirect to objects page after saving facts (Next step in the flow)
            return redirect()->route('course.create.object', ['id' => $course->id])->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Course facts storage failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An unexpected server error occurred. Please try again.');
        }
    }

    /**
     * Add or update who should join item
     */
    public function whoShouldJoin(Request $request, $id)
    {
        try {
            $data = $request->json()->all();
            $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
            
            // Basic validation
            if (!isset($data['who_should_join']) || empty(trim($data['who_should_join']))) {
                return response()->json(['error' => 'Who should join field cannot be empty'], 422);
            }

            $newItem = trim(strip_tags($data['who_should_join']));
            $dataIndex = isset($data['dataIndex']) ? $data['dataIndex'] : null;

            if ($dataIndex !== null && $dataIndex !== '') {
                // Update existing item
                if (!$course->who_should_join) {
                    return response()->json(['error' => 'No items found to update'], 422);
                }
                
                $existingItems = explode('[who_should_join]', $course->who_should_join);
                
                if (!isset($existingItems[$dataIndex])) {
                    return response()->json(['error' => 'Invalid item index'], 422);
                }
                
                $existingItems[$dataIndex] = $newItem;
                $course->who_should_join = implode('[who_should_join]', $existingItems);
                $course->save();
                
                return response()->json(['message' => 'UPDATED']);
            } else {
                // Add new item
                if ($course->who_should_join) {
                    $course->who_should_join = $course->who_should_join . '[who_should_join]' . $newItem;
                } else {
                    $course->who_should_join = $newItem;
                }
                
                $course->save();
                return response()->json(['message' => 'ADDED']);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while saving'], 500);
        }
    }

    /**
     * Delete who should join item
     */
    public function deleteWhoShouldJoin(Request $request, $id, $index)
    {
        try {
            $course = Course::where('id', $id)->where('instructor_id', Auth::user()->id)->firstOrFail();
            
            if (!$course->who_should_join) {
                return response()->json(['error' => 'No items found'], 422);
            }
            
            $existingItems = explode('[who_should_join]', $course->who_should_join);
            
            // Filter out empty items
            $existingItems = array_filter($existingItems, function($item) {
                return trim($item) !== '';
            });

            if (!isset($existingItems[$index])) {
                return response()->json(['error' => 'Invalid index'], 422);
            }
            
            unset($existingItems[$index]);
            $existingItems = array_values($existingItems);
            
            // Allow deletion of all items - set to null if empty
            if (empty($existingItems)) {
                $course->who_should_join = null;
            } else {
                $course->who_should_join = implode('[who_should_join]', $existingItems);
            }
            
            $course->save();
            
            return response()->json(['message' => 'DONE']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting'], 500);
        }
    }
}
