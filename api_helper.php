<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
	function jsonOutput($output)
	{
		$CI =& get_instance();
		$CI->output->set_content_type('application/json');
		
		return $CI->output->set_output(cleanUpString($output));
	}
	
	
	function cleanUpString($output)
	{
		$myDirtyString = json_encode(utf8_array_encode($output));
		$myDirtyString = str_replace("\/","/",$myDirtyString);
		$myDirtyString = str_replace('"','\\"',$myDirtyString);
		$myCleanedString = json_decode('"'.$myDirtyString.'"');
		
		return $myCleanedString = jsonReadable($myCleanedString);
	}
	
	
	
	
	// FUNCTION FOR ENCODING
	function utf8_array_encode($input)
	{
	    $return = array();
	
	    foreach ($input as $key => $val)
	    {
	        if( is_array($val) )
	        {
	            $return[$key] = utf8_array_encode($val);
	        }
	        else
	        {
	            $return[$key] = utf8_encode($val);
	        }
	    }
	    return $return;          
	}
	
	
	// this function make json more readable
	function jsonReadable($json, $html=FALSE) {
	    
		$tabcount = 0;
		$result = '';
		$inquote = false;
		$ignorenext = false;
	   
		if ($html) {
			$tab = "&nbsp;&nbsp;&nbsp;";
			$newline = "<br/>";
		} else {
			$tab = "\t";
			$newline = "\n";
		}
	   
		for($i = 0; $i < strlen($json); $i++) {
			
			if($i != 0)
			{
				$previousChar = $json[$i-1];
			}
			else
			{
				$previousChar = "";
			}
			
			$char = $json[$i];
		   
			if ($ignorenext) {
				$result .= $char;
				$ignorenext = false;
			} else {
				switch($char) {
					case '{':
						$tabcount++;
						$result .= $char . $newline . str_repeat($tab, $tabcount);
						break;
					case '[':
						$tabcount++;
						$result .= $char . $newline . str_repeat($tab, $tabcount);
						break;
					 case ']':
						$tabcount--;
						$result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
						break;
					case '}':
						$tabcount--;
						$result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
						break;
					case ',':
						if($previousChar == '"' || $previousChar == '}' || $previousChar == ']')
						{
						$result .= $char . $newline . str_repeat($tab, $tabcount);
						break;
						}
					case '"':
						$inquote = !$inquote;
						$result .= $char;
						break;
					case '\\':
						if ($inquote) $ignorenext = true;
						$result .= $char;
						break;
					default:
						$result .= $char;
				}
			}
		}
	   
	    return $result;
	}

/* End of file api_helper.php */
/* Location: ./application/helpers/api_helper.php */
