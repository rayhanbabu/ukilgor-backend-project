<?php 
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\User_role;

  function prx($arr){
       echo "<pre>";
       print_r($arr);
       die();
  }

    function user(){
         $user=User::where('status',1)->with('user_role')->find(Auth::id());
          return $user??null;
     }


    //  function user() {
    //         $userId = Auth::id(); // Get current user ID
    //         return Cache::remember("user_info_{$userId}", now()->addMinutes(60), function () use ($userId) {
    //             return User::with('user_role')->with('agent')->with('school')->with('employee.school_info.school')
    //              ->with('student.school_info.school')->with('permissions')->find($userId);
    //           });
    //     }

   function rayhan(){
       return 'Md Rayhan Babu';
    }



        function sms_send($phonearr,$text) {
                $url = "http://bulksmsbd.net/api/smsapi";
                $api_key = "Eu7TjIcUL3QhhK7qBmdN";
                $senderid = 8809617614712;
                $number = '88'.$phonearr;
                $message = $text;
            
                $data = [
                    "api_key" => $api_key,
                    "senderid" => $senderid,
                    "number" => $number,
                    "message" => $message,
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }

                    


 function formatGpa($value)
    {
        // If null or not numeric, return 0
        if (!is_numeric($value)) {
            return 0;
        }

        // If value is a whole number (like 3.00, 234.00)
        if (intval($value) == $value) {
            return intval($value);
        }

        // If value has one decimal place like 3.50
        if (round($value, 1) == $value) {
            return number_format($value, 1, '.', '');
        }

        // Else — show two decimal places (like 3.57)
        return number_format($value, 2, '.', '');
    }







     function convertNumber($number)
    {
        $integer=$number;
    
        $output = "";
    
        if($integer[0]== "-")
        {
            $output = "negative ";
            $integer    = ltrim($integer, "-");
        }
        else if ($integer[0] == "+")
        {
            $output = "positive ";
            $integer    = ltrim($integer, "+");
        }
    
        if ($integer[0] == "0")
        {
            $output .= "zero";
        }
        else
        {
            $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
            $group   = rtrim(chunk_split($integer, 3, " "), " ");
            $groups  = explode(" ", $group);
    
            $groups2 = array();
            foreach ($groups as $g)
            {
                $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
            }
    
            for ($z = 0; $z < count($groups2); $z++)
            {
                if ($groups2[$z] != "")
                {
                        $output.= $groups2[$z] . convertGroup(11 - $z) . (
                            $z < 11
                            && !array_search('', array_slice($groups2, $z + 1, -1))
                            && $groups2[11] != ''
                            && $groups[11][0] == '0'
                                ? " and "
                                : ", "
                        );
                }
            }
    
            $output = rtrim($output, ", ");
        }
    
       
    
        return $output;
    }
    
    function convertGroup($index)
    {
        switch ($index)
        {
            case 11:
                return " decillion";
            case 10:
                return " nonillion";
            case 9:
                return " octillion";
            case 8:
                return " septillion";
            case 7:
                return " sextillion";
            case 6:
                return " quintrillion";
            case 5:
                return " quadrillion";
            case 4:
                return " trillion";
            case 3:
                return " billion";
            case 2:
                return " million";
            case 1:
                return " thousand";
            case 0:
                return "";
        }
    }
    
    function convertThreeDigit($digit1, $digit2, $digit3)
    {
        $buffer = "";
    
        if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
        {
            return "";
        }
    
        if ($digit1 != "0")
        {
            $buffer .= convertDigit($digit1) . " hundred";
            if ($digit2 != "0" || $digit3 != "0")
            {
                $buffer .= " and ";
            }
        }
    
        if ($digit2 != "0")
        {
            $buffer .= convertTwoDigit($digit2, $digit3);
        }
        else if ($digit3 != "0")
        {
            $buffer .= convertDigit($digit3);
        }
    
        return $buffer;
    }
    
    function convertTwoDigit($digit1, $digit2)
    {
        if ($digit2 == "0")
        {
            switch ($digit1)
            {
                case "1":
                    return "ten";
                case "2":
                    return "twenty";
                case "3":
                    return "thirty";
                case "4":
                    return "forty";
                case "5":
                    return "fifty";
                case "6":
                    return "sixty";
                case "7":
                    return "seventy";
                case "8":
                    return "eighty";
                case "9":
                    return "ninety";
            }
        } else if ($digit1 == "1")
        {
            switch ($digit2)
            {
                case "1":
                    return "eleven";
                case "2":
                    return "twelve";
                case "3":
                    return "thirteen";
                case "4":
                    return "fourteen";
                case "5":
                    return "fifteen";
                case "6":
                    return "sixteen";
                case "7":
                    return "seventeen";
                case "8":
                    return "eighteen";
                case "9":
                    return "nineteen";
            }
        } else
        {
            $temp = convertDigit($digit2);
            switch ($digit1)
            {
                case "2":
                    return "twenty-$temp";
                case "3":
                    return "thirty-$temp";
                case "4":
                    return "forty-$temp";
                case "5":
                    return "fifty-$temp";
                case "6":
                    return "sixty-$temp";
                case "7":
                    return "seventy-$temp";
                case "8":
                    return "eighty-$temp";
                case "9":
                    return "ninety-$temp";
            }
        }
    }
    
    function convertDigit($digit)
    {
        switch ($digit)
        {
            case "0":
                return "zero";
            case "1":
                return "one";
            case "2":
                return "two";
            case "3":
                return "three";
            case "4":
                return "four";
            case "5":
                return "five";
            case "6":
                return "six";
            case "7":
                return "seven";
            case "8":
                return "eight";
            case "9":
                return "nine";
        }
    }
    


?>