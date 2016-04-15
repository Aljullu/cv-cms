<?php
class profile {
    public $id;
    
    // Personal info
    public $name;
    public $last_name;
    public $last_name2;
    public $phone;
    public $email;
    
    // Technical info
    public $uri;
    public $title;
    public $language;
    public $description;
    public $keywords;
    
    // Job info
    public $job_title;
    public $job_role;
    public $job_description;
    
    // Settings
    public $display_last_name2_in_title = false;
    
    function get_name() {
        if ($this->display_last_name2_in_title)
            return $this->name ." ". $this->last_name ." ". $this->last_name2;
        else
            return $this->name ." ". $this->last_name;
    }
    
    function print_styles() {
    	echo '<link href="'. getPath() .'/style.css" rel="stylesheet">';
    	
        global $con;
        $result = mysqli_query($con,"SELECT css FROM css WHERE pid = ".$this->id ."");
        
        while($row = mysqli_fetch_array($result)) {
            echo '<link href="'. getPath() .'/'.$row['css'].'" rel="stylesheet">';
        }
        
    }
    
    function print_phone() {
        echo "<a class='tel' href='tel:".$this->format_phone("plain")."'><i class='icon-phone'></i>".$this->format_phone("styled")."</a>";
    }
        
    function format_phone($style = "default") {
        switch($style) {
            case "plain":
                return str_replace(" ","",$this->phone);
            case "styled":
                return str_replace(" ","&thinsp;",$this->phone);
            default:
                return $this->phone;
        }
    }
    
    function print_email() {
        echo "<a class='email' href='mailto:".$this->email."'>".$this->email."</a>";
    }
    
    function print_urls() {
        
        function style_url($url) {
            $niceurl = str_replace("http://","",$url);
            $niceurl = str_replace("https://","",$niceurl);
            $niceurl = trim($niceurl, '/');
            return "<a href='".$url."'>".$niceurl."</a>";
        }
        
        global $con;
        
        $result = mysqli_query($con,"SELECT url FROM profile_urls WHERE pid = ".$this->id);
        
        $string = "";
        $first = true;
        
        while($row = mysqli_fetch_array($result)) {
            if (!$first) $string .= "<br/>";
            else $first = false;
            
            $string .= style_url($row[0]);
        }
        
        return $string;
    }
    
    function get_block_titles($zone) {
        global $con;
        $result = mysqli_query($con,"SELECT title, machine_title FROM profile_blocks WHERE pid = ".$this->id ." AND zone LIKE '".$zone."' AND display_title = true ORDER BY weight");
        
        $array = array();
        
        while($row = mysqli_fetch_array($result)) {
            array_push($array,$row);
        }
        
        return $array;
    }
    
    function print_blocks($zone) {
        $text = "";
        
        global $con;
        $result = mysqli_query($con,"SELECT display_title, title, machine_title, body FROM profile_blocks WHERE pid = ".$this->id ." AND zone LIKE '".$zone."' ORDER BY weight");
        while($row = mysqli_fetch_array($result)) {
        	$text .= "<section id='".$row['machine_title']."-section'>";
            if ($row['display_title']) {
                $text .= "<h2 id='".$row['machine_title']."'>".$row['title']."</h2>";
            }
            $text .= replace_tokens($row['body']);
            $text .= "</section>";
        }
        
        return $text;
    }
    
    function get_number_of_opinions() {
        $number_of_opinions = 0;
        
        global $con;
        
        $result = mysqli_query($con,"SELECT COUNT(*) AS count FROM opinions WHERE aproved = 1 AND pid = ". $this->id);
        if ($result) {
            $opinions_numbers = mysqli_fetch_array($result);
            $number_of_opinions = $opinions_numbers['count'];
        }
        
        return $number_of_opinions;
    }
    
    function print_opinions() {
        $text = "";
        
        global $con;
        $result = mysqli_query($con,"SELECT reviewer, reviewer_url, reviewer_title, opinion, rating, date, lang, source_url FROM opinions WHERE aproved = 1 AND pid = ". $this->id. " ORDER BY date DESC");

        if ($result) {
            while($opinion = mysqli_fetch_array($result)) {
                $text .= "<article class='opinion'>";
                    $text .= "<div itemscope itemtype='http://data-vocabulary.org/Review'>";
	                    $text .= "<span itemprop='itemreviewed' style='display: none;'>". $this->get_name() ."</span>";
	                        $lang = "";
	                        if ($opinion['lang'] != "") {
	                            $lang .= " lang='". $opinion['lang'] ."'";
	                        }
	                    $text .= "<blockquote class='opinio' itemprop='description'". $lang .">". $opinion['opinion'] ."</blockquote>";
                        $parsed_date = date_parse_from_format("Y-m-d",$opinion['date']);
                        $date = mktime(
                            $parsed_date['hour'], 
                            $parsed_date['minute'], 
                            $parsed_date['second'], 
                            $parsed_date['month'], 
                            $parsed_date['day'], 
                            $parsed_date['year']
                        );
	                    $text .= "<p class='autor'>";
						if ($opinion['reviewer_url']) {
						    $text .= "<a href='". $opinion['reviewer_url'] ."' itemprop='reviewer'>". $opinion['reviewer'] ."</a>";
						} else {
						    $text .= "<span itemprop='reviewer'>". $opinion['reviewer'] ."</span>";
						}
						if ($opinion['reviewer_title']) {
						    $text .= ", ";
						    $text .= "<em>" . $opinion['reviewer_title'] . "</em>";
						}
						$text .= " — ";
						if ($opinion['source_url']) {
						    $text .= "<a href='" . $opinion['source_url'] . "'><time itemprop='dtreviewed' datetime='". $opinion['date'] ."'>". date("j/n/Y",$date) ."</time></a>";
						} else {
						    $text .= "<time itemprop='dtreviewed' datetime='". $opinion['date'] ."'>". date("j/n/Y",$date) ."</time>";
						}
                        if ($opinion['rating'] > 0) {
                            $text .= "(<span itemprop='rating'>". $opinion['rating'] ."</span>/<span itemprop='best'>10</span>)";
                        }
                    $text .= "</div>";
                $text .= "</article>";
            }
        }
        $result = mysqli_query($con,"SELECT COUNT(*) AS count, AVG(rating) AS rating FROM opinions WHERE aproved = 1 AND pid = ". $this->id ." ORDER BY date DESC");
        if ($result) {
            $opinions_numbers = mysqli_fetch_array($result);
            
            $text .= "<p><a id='show-more-opinions' title='" . __('Load more opinions') . "' href='javascript:void(0)'>Mostra més opinions</a><span class='separator'> | </span><span itemprop='votes count'>". $opinions_numbers['count'] ."</span> opinions <span itemprop='rating' itemscope itemtype='http://data-vocabulary.org/Rating'>(<span itemprop='average'>". round(100*$opinions_numbers['rating'])/100 ."</span>/<span itemprop='best'>10</span>)</span></p>";
        }
        
        return $text;
    }
    
    function print_experience($volunteer = -1, $not_related = -1) {
        $text = "";
        
        $where = "";
        if ($volunteer == 0) {
            $where = " AND volunteer = 0";
        }
        elseif ($volunteer == 1) {
            $where = " AND volunteer = 1";
        }
        if ($not_related == 0) {
            $where .= " AND not_related = 0";
        }
        elseif ($not_related == 1) {
            $where .= " AND not_related = 1";
        }
        
        global $con;
        
        $result = mysqli_query($con,"SELECT job_title, company, company_website, city, region, country, start_date, finish_date, description, volunteer FROM profile_experience WHERE pid = ". $this->id. $where ." ORDER BY weight, finish_date DESC, start_date DESC");

        if ($result) {
            while($job = mysqli_fetch_array($result)) {
				$text .= "<div class='job'>";
				$text .= "<div class='job-title'><span class='job-role'>".$job['job_title']."</span>";
		            if ($job['company'] != "") {
		                if ($job['company_website'] != "") {
		                    $company = "<a href='".$job['company_website']."' class='org'>".$job['company']."</a>";
		                }
		                else {
		                    $company = "<span class='org'>".$job['company']."</span>";
		                }
		                $text .= " at ".$company;
		            }
				$text .= "</div>";
                    
                $location = format_location($job['city'], $job['region'], $job['country']);
                
                if ($location[0] != "") {
                    $text .= "<p class='city-wrapper'><span class='city-label'>".$location[0]."</span><span class='city'>".$location[1]."</span></p>";
                }
                if ($job['start_date'] !== $job['finish_date']) {
                  $text .= "<p class='period-wrapper'><span class='period-label'>" . __("Period") . "</span><span class='period'>".format_dates($job['start_date'], $job['finish_date'])."</span></p>";
                } else {
                  $text .= "<p class='period-wrapper'><span class='period-label'>" . __("Date") . "</span><span class='period'>".format_date($job['start_date'])."</span></p>";
                }
				$text .= "<div class='job-description'>".$job['description']."</div>";
				$text .= "</div>";
			}
        }
        
        return $text;
    }
    
    function print_work_professional_experience() {
        return $this->print_experience(0,0);
    }
    
    function print_work_not_professional_experience() {
        return $this->print_experience(0,1);
    }
    
    function print_work_experience() {
        return $this->print_experience(0);
    }
    
    function print_volunteer_professional_experience() {
        return $this->print_experience(1,0);
    }
    
    function print_volunteer_not_professional_experience() {
        return $this->print_experience(1,1);
    }
    
    function print_volunteer_experience() {
        return $this->print_experience(1);
    }
    
    function print_education() {
        $text = "";
        
        global $con;
        
        $result = mysqli_query($con,"SELECT degree, field_of_study, school, city, region, country, start_date, finish_date, description FROM profile_education WHERE pid = ". $this->id ." ORDER BY finish_date DESC, start_date DESC");

        if ($result) {
            while($job = mysqli_fetch_array($result)) {
				$text .= "<div class='education'>";
				$text .= "<div class='education-title'><span class='education-role'>".$job['field_of_study']." ".$job['degree']."</span>";
		            if ($job['school'] != "") {
		                $text .= " at <span class='org'>".$job['school']."</span>";
		            }
				$text .= "</div>";
                    
                $location = format_location($job['city'], $job['region'], $job['country']);
                
                if ($location[0] != "") {
                    $text .= "<p class='city-wrapper'><span class='city-label'>".$location[0]."</span><span class='city'>".$location[1]."</span></p>";
                }
                if ($job['start_date'] !== $job['finish_date']) {
                  $text .= "<p class='period-wrapper'><span class='period-label'>" . __("Period") . "</span><span class='period'>".format_dates($job['start_date'], $job['finish_date'])."</span></p>";
                } else {
                  $text .= "<p class='period-wrapper'><span class='period-label'>" . __("Date") . "</span><span class='period'>".format_date($job['start_date'])."</span></p>";
                }
				$text .= $job['description'];
				$text .= "</div>";
			}
        }
        
        return $text;
    }
    
    function print_social_networks() {
        $text = "";
        
        global $con;
        
        $result = mysqli_query($con,"SELECT url FROM profile_social_networks WHERE pid = ". $this->id ." AND display = 1 ORDER BY weight");

        if ($result) {
            $text .= "<ul id='social-networks'>";
            while($social_network = mysqli_fetch_array($result)) {
                if (strpos($social_network["url"], "linkedin")) {
                    $text .= "<li><a href='".$social_network["url"]."' title='LinkedIn' class='not-styled'><i class='icon-linkedin'></i></a></li>";
                }
                if (strpos($social_network["url"], "twitter")) {
                    $text .= "<li><a href='".$social_network["url"]."' title='Twitter' class='not-styled'><i class='icon-twitter'></i></a></li>";
                }
                if (strpos($social_network["url"], "facebook")) {
                    $text .= "<li><a href='".$social_network["url"]."' title='Facebook' class='not-styled'><i class='icon-facebook'></i></a></li>";
                }
                if (strpos($social_network["url"], "github")) {
                    $text .= "<li><a href='".$social_network["url"]."' title='GitHub' class='not-styled'><i class='icon-github'></i></a></li>";
                }
                if (strpos($social_network["url"], "plus.google")) {
                    $text .= "<li><a href='".$social_network["url"]."?rel=author' title='Google+' class='not-styled'><i class='icon-google-plus'></i></a></li>";
                }
                if (strpos($social_network["url"], "stackexchange.com")) {
                    $text .= "<li><a href='".$social_network["url"]."' title='Stack Exchange' class='not-styled'><i class='icon-stackexchange'></i></a></li>";
                }
            }
            $text .= "</ul>";
        }
        
        return $text;
    }
    
    function print_portfolio() {
        $text = "";
        
        global $con;
        
        // Slider
        $result = mysqli_query($con,"SELECT name, image, video, short_description, link FROM profile_portfolio WHERE pid = ". $this->id ." AND visible = true AND (image != '' OR video != '') ORDER BY weight");
        
        if ($result) {
            $text .= "<ul class='slideshow'>";
            
            while($item = mysqli_fetch_array($result)) {
            	$video = "";
            	if ($item['video']) {
            		$video = ' data-video="'.$item['video'].'"';
            	}
            	$text .= '<li><img src="'.$item['image'].'" height="100" width="150" alt="'.$item['name'].'" title="'.$item['name'].'" data-title="'.$item['name'].'" data-body="'.$item['short_description'].'" data-link="'.$item['link'].'" '.$video.'/>';
            }
            $text .= "</ul>";
        }
        
        $text .= get_slideshow_script();
        
        // List of links
        $result = mysqli_query($con,"SELECT portfolio_category_id, name FROM profile_portfolio_categories ORDER BY weight");

        if ($result) {
            $text .= "<ul>";
            
            while($category = mysqli_fetch_array($result)) {
		        
		        $result2 = mysqli_query($con,"SELECT name, long_description, link, link_android, link_ios, link_firefox_os, link_windows_phone, link_github FROM profile_portfolio WHERE pid = ". $this->id ." AND visible = true AND category = ".$category['portfolio_category_id']." ORDER BY weight");
		        
            	$text .= "<li>".$category['name']."<ul>";
            	
            	if ($result2) {
		        	while($item = mysqli_fetch_array($result2)) {
			        	// Print name
		        		$text .= '<li itemscope itemtype="http://schema.org/SoftwareApplication"><a href="'.$item["link"].'" itemprop="url"><span itemprop="name">'.$item["name"].'</span></a>';
		        		// Print github link
		        		if ($item["link_github"]) {
		        		 $text .= ' <a href="'.$item["link_github"].'" title="Fork me on Github"><i class="icon-github"></i></a>';
		        		}
		        		// Print description
		        		$text .= ': <span itemprop="description">'.$item["long_description"].'</span>';
		        		// Print Android link
		        		if ($item["link_android"]) {
		        			$text .= '<br><a href="'.$item["link_android"].'"><img src="/files/get-android.png" height="45" width="129" alt="Get it on Google Play"/></a>';
		        		}
		        	}
            	}
            	
            	$text .= "</ul></li>";
            }
            $text .= "</ul>";
        }
        
        return $text;
    }
    
    function print_languages() {
        $text = "";
        
        global $con;
        
        // Languages
        $result = mysqli_query($con,"SELECT language_name, level, qualification, notes FROM profile_languages WHERE pid = ". $this->id ." ORDER BY weight");
        
        if ($result) {
            $text .= "<p>Languages<ul>";
            
            while($item = mysqli_fetch_array($result)) {
	            $qualification = "";
            	if ($item['level'] && $item['qualification']) {
            		$qualification .= " —";
            	}
            	$qualification .= $item['qualification'];
	            $notes = "";
            	if (($item['level'] && $item['notes']) ||
            		($item['qualification'] && $item['notes'])) {
            		$notes .= ", ";
            	}
            	$notes .= $item['notes'];
            	$text .= '<li>'.$item['language_name'].' ('.$item['level'].$qualification.$notes.')';
            }
            $text .= "</ul>";
        }
        
        return $text;
    }
}
?>
