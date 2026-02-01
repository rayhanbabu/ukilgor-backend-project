<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Services\Setting\ProfessionService\ProfessionAdd;
use App\Services\Setting\ProfessionService\ProfessionList;
use App\Services\Setting\ProfessionService\ProfessionUpdate;
use App\Services\Setting\ProfessionService\ProfessionDelete;


class ProfessionController extends Controller
{

    protected $ProfessionAdd;
    protected $ProfessionList;
    protected $ProfessionUpdate;
    protected $ProfessionDelete;


    public function __construct(ProfessionAdd $ProfessionAdd, ProfessionList $ProfessionList, ProfessionUpdate $ProfessionUpdate, ProfessionDelete $ProfessionDelete)
    {
         $this->ProfessionAdd = $ProfessionAdd;
         $this->ProfessionList = $ProfessionList;
         $this->ProfessionUpdate = $ProfessionUpdate;
         $this->ProfessionDelete = $ProfessionDelete;
    }

  
     public function profession_add(Request $request)
     {
          return $this->ProfessionAdd->handle($request);
     }

     public function profession(Request $request){
           return $this->ProfessionList->handle($request);
     }

      public function profession_update(Request $request, $id)
      {
          return $this->ProfessionUpdate->handle($request, $id);
      }
   
 
       public function profession_delete(Request $request, $id)
       {
           return $this->ProfessionDelete->handle($request, $id);
       }




}
