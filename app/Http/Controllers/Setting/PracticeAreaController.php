<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Services\Setting\PracticeAreaService\PracticeAreaAdd;
use App\Services\Setting\PracticeAreaService\PracticeAreaList;
use App\Services\Setting\PracticeAreaService\PracticeAreaUpdate;
use App\Services\Setting\PracticeAreaService\PracticeAreaDelete;


class PracticeAreaController extends Controller
{

    protected $PracticeAreaAdd;
    protected $PracticeAreaList;
    protected $PracticeAreaUpdate;
    protected $PracticeAreaDelete;


    public function __construct(PracticeAreaAdd $PracticeAreaAdd, PracticeAreaList $PracticeAreaList, PracticeAreaUpdate $PracticeAreaUpdate, PracticeAreaDelete $PracticeAreaDelete)
    {
         $this->PracticeAreaAdd = $PracticeAreaAdd;
         $this->PracticeAreaList = $PracticeAreaList;
         $this->PracticeAreaUpdate = $PracticeAreaUpdate;
         $this->PracticeAreaDelete = $PracticeAreaDelete;
    }

  
     public function practicearea_add(Request $request)
     {
          return $this->PracticeAreaAdd->handle($request);
     }

     public function practicearea(Request $request){
           return $this->PracticeAreaList->handle($request);
     }

      public function practicearea_update(Request $request, $id)
      {
          return $this->PracticeAreaUpdate->handle($request, $id);
      }
   
 
       public function practicearea_delete(Request $request, $id)
       {
           return $this->PracticeAreaDelete->handle($request, $id);
       }




}
