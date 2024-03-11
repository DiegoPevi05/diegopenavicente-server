<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\diegopenavicente\Book;
use App\Models\diegopenavicente\Experience;
use App\Models\diegopenavicente\Project;
use App\Models\diegopenavicente\Skill;
use App\Models\diegopenavicente\WebContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiWebController extends Controller
{

    public function fetchWebData(){

        $webContent = WebContent::all();
        $experiences = Experience::all();
        $projects = Project::all();
        $skills = Skill::all();
        $books = Book::all();

        $experiences->map(function ($experience) {
            $experience->details_es = explode('|', $experience->details_es);
            $experience->details_en = explode('|', $experience->details_en);
            $experience->details_it = explode('|', $experience->details_it);
            return $experience;
        });

        $skills->map(function ($skill) {
            $skill->keywords = explode('|', $skill->keywords);
            return $skill;
        });

        $projects->map(function($project){
            //fetch in $project->skills the skills array but ommit all fields only fetch per skill id and title
            Log::info($project->skills);
            $project->languages = $project->skills()->get()->map(function($skill){
                return [
                    'id' => $skill->id,
                    'title' => $skill->title
                ];
            });

            $project->makeHidden('skills');
    
            return $project;
        });

        return response()->json([
            'webContent' => $webContent,
            'experiences' => $experiences,
            'skills' => $skills,
            'projects' => $projects,
            'books' => $books
        ]);
    }

    
    
}
