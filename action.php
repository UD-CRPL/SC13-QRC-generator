<?php

    include "./phpqrcode/qrlib.php";
    
    // you can get your Bitly API access token here: https://bitly.com/a/oauth_apps  
    $BITLY_ACCESS_TOKEN = "[YOUR BITLY API TOKEN]";
    
    
    function main(){
    
        printHeader();
        
        $tempDir = "./tmp/"; 
         
        $input = $_POST["input"];
        
        if( $input == "" ){
            echo "Please provide valid input, input empty.";
            die();
        }
        else{
        
            $qrc_data = array();
        
            $lines = explode("\n", $input);
            
            foreach($lines as $line){
                if( strlen($line) > 0 ){
                    $data = explode("|", $line);
                    
                    if( count($data) == 5 ){
                         $qrc_data[] = newDataElement( $data[0], $data[1] , $data[2], $data[3], $data[4] );          
                    }
                    else{
                        echo "Please provide valid input<br>";
                        echo "line: " . $line;
                        die();
                    }
                }
                
            }
            
            //generate zip filename
            $zipFname = $tempDir.uniqid("QRC_").".zip";
            
            echo "<p>Download zip with all QRC images: <a href='".$zipFname."'>Here</a></p>";
            
            //Print QR Codes
            $i = 0;
            $files = array();
            
            foreach( $qrc_data as $data ){
                
                echo "<div class='qrWrapper' style='float: left;'>";
                echo "<div class='qrHeader'>".$data["title"]."</div>";
                $filename = saveQRC($data,$tempDir);
                $files[] = $filename;
                echo '<div class="QRC"><img src="'.$filename.'" />';
                echo "<div class='bURL'>(".$data["URL"].")</div></div>";
                echo "<div class='bottom'>";
                echo "<div class='bLeft'>".$data["left"]."</p></div>";
                echo "<div class='bRight'>".$data["right"]."</div>";
                echo "</div>";
                echo "<div class='pTitle'>".$data["pTitle"]."</div>";   
                echo "</div>";
                
            }
            
            create_zip($files,$zipFname);
            
        }
        
        printFooter();

    }
    
    function newDataElement($title,$URL,$left,$right,$pTitle){
        return array( "title" => $title, "URL" => getBitlyURL( $URL ), "left" => $left, "right" => $right, "pTitle" => $pTitle );
    }
    
    function saveQRC($data, $tempDir){
        
    
        $paddedNum = str_pad($data["num"], 3, "0", STR_PAD_LEFT);
        
        $name = md5( $data["num"].$data["URL"].$data["cat"] );
        
        $filename = $tempDir.$paddedNum."_".$name.".png";
        
        QRcode::png($data["URL"], $filename, QR_ECLEVEL_H, 10,0);
        
        return $filename;
    }
    
    function printHeader(){
        echo "<html><head>";
        echo '<link rel="stylesheet" type="text/css" href="action.css">';
        echo '<link rel="stylesheet" type="text/css" media="print" href="print.css" />';
        echo "<title>QR Code output</title>";
        echo "</head><body>";
        
    }

    function printFooter(){
        echo "</body></html>";
    }
    
    /* creates a compressed zip file */
    function create_zip($files = array(),$destination = '',$overwrite = false) {
    	//if the zip file already exists and overwrite is false, return false
    	if(file_exists($destination) && !$overwrite) { return false; }
    	//vars
    	$valid_files = array();
    	//if files were passed in...
    	if(is_array($files)) {
    		//cycle through each file
    		foreach($files as $file) {
    			//make sure the file exists
    			if(file_exists($file)) {
    				$valid_files[] = $file;
    			}
    		}
    	}
    	//if we have good files...
    	if(count($valid_files)) {
    		//create the archive
    		$zip = new ZipArchive();
    		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
    			return false;
    		}
    		//add the files
    		foreach($valid_files as $file) {
    			$zip->addFile($file,$file);
    		}
    		//debug
    		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
    		
    		//close the zip -- done!
    		$zip->close();
    		
    		//check to make sure the file exists
    		return file_exists($destination);
    	}
    	else
    	{
    		return false;
    	}
    }
    
    function getBitlyURL( $longURL ){
        global $BITLY_ACCESS_TOKEN;
    
        $longURL = urlencode( $longURL );
        
        $pullURL = "https://api-ssl.bitly.com/v3/shorten?access_token=$BITLY_ACCESS_TOKEN&longUrl=$longURL";
        
        $JSON = file_get_contents( $pullURL );
        
        $response = json_decode($JSON);
        
        return $response->data->url;
    }
    
    main();
    
?>