<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Category;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category)
    {
        $category_exam = Category::where('name',$category)->with('exam')->first();
        return view('exam.index',compact('category_exam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('exam.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'question' => ['required','max:255'],
            'category' => ['required'],
            'option1' => ['required'],
            'option2' => ['required'],
            'option3' => ['required'],
            'option4' => ['required'],
        ]);
        $question = Exam::create([
            'question' => $request->question,
            'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
            'option4' => $request->option3,
        ]);
        
        if (isset($question)) {
            $question->category()->sync($request->category);
            $arr = array('status' => 'success');
            return Response()->json($arr,200);
        } else {
            $arr = array('status' => 'error');
            return Response()->json($arr,500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exam = Exam::where('id',$id)->with('category')->first();
        $category_id =[];
        foreach ($exam->category as $tagged)
        {
          array_push($category_id, $tagged->pivot->category_id);
           
        }
        $category = Category::all();
        return view('exam.edit',compact('exam','category','category_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'question' => ['required','max:255'],
            'category' => ['required'],
            'option1' => ['required'],
            'option2' => ['required'],
            'option3' => ['required'],
            'option4' => ['required'],
        ]);
        $question = Exam::whereId($id)->first();
        $question->update([
            'question' => $request->question,
            'option1' => $request->option1,
            'option2' => $request->option2,
            'option3' => $request->option3,
            'option4' => $request->option3,
        ]);
        
        if (isset($question)) {
            $question->category()->sync($request->category);
            $arr = array('status' => 'success');
            return Response()->json($arr,200);
        } else {
            $arr = array('status' => 'error');
            return Response()->json($arr,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $exam = Exam::find( $request->id);
        $exam->delete();
        $arr = array('status' => 'success');
        return  Response()->json($arr,200);
    }
}
