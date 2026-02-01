@include('pdf/fpdf182/fpdf')
   <?php

    $pdf = new FPDF();
    $pdf->AddPage();		
    $pdf->SetDrawColor(0, 0, 0); // Black border color
    $pdf->SetTextColor(0, 0, 0); // Black text color
       $row=$data['student'];
    for ($i = 0; $i < $row->count(); $i++){
     // 2nd part 

      $pdf->Cell(190,5,'',0,1);
      $pdf->SetFont('Times','',20);
      $pdf->Image(public_path('uploads/admin/'.$data['school']->image),15,17,-200);    //School Logu
      $pdf->Image(public_path('uploads/admin/'.$data['school']->image),15,150,-200);   //School Logu

        // if($i % 2 != 0){
        //     if(empty($row[$i]->image)){
        //        }else{
        //     $pdf->Image('uploads/student/'.$row[$i]->image,165,150,-310);
        //       }
        //  }else{
        //       if(empty($row[$i]->image)){
        //        }else{
        //         $pdf->Image('uploads/student/'.$row[$i]->image,165,17,-310);
        //        } 
        //  }
      $pdf->Cell(190,4,'','LRT',1,'R');
      $pdf->SetFont('Times','',$data['school']->ansize);	
      $pdf->Cell(190,10,$data['school']->school,'LR',1 , 'C' );
      $pdf->SetFont('Times','',$data['school']->sasize);	 
      $pdf->Cell(190,7,$data['school']->address,'LR',1 , 'C' );
      $pdf->SetFont('Times','B',15);	    
      $pdf->Cell(190,7,'Admit Card','LR',1 ,'C' );  
      $pdf->SetFont('Times','',13);



      $pdf->Cell(5,5,'','L',0 , 'L' );  
      $pdf->Cell(25,5,'Name ',0,0 , 'L' );
      $pdf->Cell(95,5,': '.$row[$i]->name,0,0 , 'L' );
      $pdf->Cell(15,5,'Exam ',0,0 , 'L' );
      $pdf->Cell(50,5,': '.examName($data['examinfo']->exam),'R',1, 'L' );	



       $pdf->Cell(5,5,'','L',0 , 'L' );  
       $pdf->Cell(25,5,'Roll ',0,0 , 'L' );
       $pdf->Cell(30,5,': '.$row[$i]->roll,0,0 , 'L' );
       $pdf->Cell(20,5,'Stu ID',0,0 , 'L' );
       $pdf->Cell(45,5,': '.$row[$i]->stu_id,0,0 , 'L' );
       $pdf->Cell(15,5,'Class',0,0 , 'L' );
       $pdf->Cell(50,5,': '.$row[$i]->class,'R',1, 'L' );

       $pdf->Cell(5,5,'','L',0 , 'L' );  
       $pdf->Cell(25,5,'Section ',0,0 , 'L' );
       $pdf->Cell(30,5,': '.$data['section'],0,0 , 'L' );
       $pdf->Cell(20,5,'Shift',0,0 , 'L' );
       $pdf->Cell(45,5,': '.shift($data['section'],$data['school']->eiin),0,0,'L' );
       $pdf->Cell(15,5,'Group',0,0 , 'L' );
       $pdf->Cell(50,5,': '.$data['babu'],'R',1, 'L' );

       $pdf->SetFont('Times','B',14);	
       $pdf->Cell(190,7,'Exam Routine','LR',1, 'C');

        $pdf->SetFont('Times','',11);	
        $pdf->Cell(47,5,'Date & Time',1,0 , 'C' );
        $pdf->Cell(48,5,'Subjects',1,0 , 'C' );
        $pdf->Cell(47,5,'Date & Time',1,0 , 'C' );
        $pdf->Cell(48,5,'Subjects',1,1, 'C' );

      

        if($data['sub1s']!=''){
            $pdf->Cell(47,5,date('d/m/y',strtotime($data['admit']->date1)).','.$data['admit']->time1,1,0 , 'L' );
            $pdf->Cell(48,5,$data['sub1s'],1,0 , 'L' );	}else{ 
            $pdf->Cell(47,5,'','L',0 , 'L' ); 
            $pdf->Cell(48,5,'','',0 , 'L' );}
        if($data['sub2s']!=''){
            $pdf->Cell(47,5,date('d/m/y',strtotime($data['admit']->date2)).','.$data['admit']->time2,1,0 , 'L' );
            $pdf->Cell(48,5,$data['sub2s'],1,1 , 'L' );   
                }else{ 
            $pdf->Cell(47,5,'',0,0 , 'L' );
            $pdf->Cell(48,5,'','R',1 , 'L' );    }


        
        $pdf->Cell(190,5,'','RL',1);      
        
          // Odd subject (left side)
    $subKeyOdd  = "sub{$n}s";
    $dateKeyOdd = "date{$n}";
    $timeKeyOdd = "time{$n}";

    if (!empty($data[$subKeyOdd])) {
        $pdf->Cell(47, 5, date('d/m/y', strtotime($data['admit']->{$dateKeyOdd})) . ',' . $data['admit']->{$timeKeyOdd}, 1, 0, 'L');
        $pdf->Cell(48, 5, $data[$subKeyOdd], 1, 0, 'L');
    } else {
        $pdf->Cell(47, 5, '', 1, 0, 'L');
        $pdf->Cell(48, 5, '', 1, 0, 'L');
    }

    // Even subject (right side)
    $subKeyEven  = "sub" . ($n + 1) . "s";
    $dateKeyEven = "date" . ($n + 1);
    $timeKeyEven = "time" . ($n + 1);

    if (!empty($data[$subKeyEven])) {
        $pdf->Cell(47, 5, date('d/m/y', strtotime($data['admit']->{$dateKeyEven})) . ',' . $data['admit']->{$timeKeyEven}, 1, 0, 'L');
        $pdf->Cell(48, 5, $data[$subKeyEven], 1, 1, 'L');
    } else {
        $pdf->Cell(47, 5, '', 1, 0, 'L');
        $pdf->Cell(48, 5, '', 1, 1, 'L');
    }
               
            
        //  $pdf->Image('images/rayhanbabu.jpg',150,110,-250); 
        //  $pdf->Image('images/rayhanbabu.jpg',150,245,-250);   
            
      
                                    

        $pdf->Cell(190,10,'','LR',1);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(170,5,'Head Teacher Signature','L',0,'R');
        $pdf->Cell(20,5,'','R',1,'R');


         $pdf->Cell(190,3,'','LRB',1,'R');

         $pdf->Cell(100,10,'---',0,0);
         $pdf->Cell(90,10,'---',0,1,'R');

       }
        $pdf->Output($data['file'],'I');
        exit;


?>