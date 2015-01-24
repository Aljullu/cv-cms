<?php
include 'profile.php';

// Parsing text funcions
function __ ($string) {
    return $string;
}

function compress($string) {
	$string = str_replace(array(' = ', ' =', '= '), '=', $string);
    return $string;
}

function getPath() {
    global $con;
	$result = mysqli_query($con, "SELECT path FROM settings");
	$row = mysqli_fetch_array($result);
	
	return $row["path"];
}

function replace_tokens($string) {
    global $my_profile;
    $tokens = array("[display_name]","[opinions]","[experience]","[work_experience]","[work_professional_experience]","[work_not_professional_experience]","[volunteer_experience]","[education]","[portfolio]","[social-networks]","[portfolio]","[languages]","[slideshow-script]");
    $replacements = array($my_profile->get_name(), $my_profile->print_opinions(), $my_profile->print_experience(), $my_profile->print_work_experience(), $my_profile->print_work_professional_experience(), $my_profile->print_work_not_professional_experience(), $my_profile->print_volunteer_experience(), $my_profile->print_education(), $my_profile->print_portfolio(), $my_profile->print_social_networks(), $my_profile->print_portfolio(), $my_profile->print_languages(), get_slideshow_script());
    return str_replace($tokens,$replacements,$string);
}

// Get profile
function createProfile($uri = "") {
    global $con;
    
    $my_profile = new profile();
    
    if ($uri == "") {

		$result = mysqli_query($con,"SELECT uri_pos FROM settings");
		$row = mysqli_fetch_array($result);
		
		if ($row["uri_pos"] == 0) { // get uri from domain
			$server_name = explode(".",$_SERVER['SERVER_NAME']);
			$my_profile->uri = $server_name[1];
		}
		else { // get uri from subdirectory
		    $request_uri = explode('/',$_SERVER['REQUEST_URI']);
		    $request_uri_b = explode('?',trim($request_uri[2],'/'));
		    $my_profile->uri = trim($request_uri_b[0], '/');
		}
    }
    else {
        $my_profile->uri = $uri;
    }

    $result = mysqli_query($con,"SELECT id, name, last_name, last_name2, title, language, keywords, description, job_title, job_role, job_description, phone, email, display_last_name2_in_title FROM profiles WHERE uri LIKE '".$my_profile->uri."'");

    while($row = mysqli_fetch_array($result)) {
        if ($my_profile->name != "") die(__("Duplicated entry in database."));
        
        $my_profile->name = $row['name'];
        $my_profile->id = $row['id'];
        $my_profile->last_name = $row['last_name'];
        $my_profile->last_name2 = $row['last_name2'];
        $my_profile->title = $row['title'];
        $my_profile->language = $row['language'];
        $my_profile->description = $row['description'];
        $my_profile->keywords = $row['keywords'];
        $my_profile->job_title = $row['job_title'];
        $my_profile->job_role = $row['job_role'];
        $my_profile->job_description = $row['job_description'];
        $my_profile->phone = $row['phone'];
        $my_profile->email = $row['email'];
        $my_profile->display_last_name2_in_title = $row['display_last_name2_in_title'];
    }
    
    if (!$my_profile->id > 0) die(__("Profile not found."));
    
    return $my_profile;
}

// Get Google Analytics UA
function get_analytics() {

    global $con;
    
	$result = mysqli_query($con,"SELECT analytics FROM settings");
	$row = mysqli_fetch_array($result);
	return $row["analytics"];
}

// $date format: 2013-09-05 ("Y-m-d")
function format_date($date, $format = "j F Y") {
	
	if ($format == "Y-m-d") {
		return str_replace("-00","",$date);
	}
    
    $date_array = explode("-",$date);
    
    if ($date_array[2] == "00") {
        $format = str_replace(array("d", "D", "j", "l", "N", "S", "w", "z"), "", $format);
        
        if ($date_array[1] == "00") {
            $format = str_replace(array("F", "m", "M", "nl", "t"), "", $format);
            
            if ($date_array[0] == "0000") {
                return "";
            }
        }
    }
    
    $date = str_replace("-00","-01",$date);
    
    return date($format, strtotime($date));
}

function format_dates($start, $finish) {

    if ($start != "0000-00-00" && $start != "3000-01-01") {
    	$start_formated = "<time class='dtstart' datetime='".format_date($start,"Y-m-d")."'>".format_date($start)."</time>";
	}
    else $start_formated = "<span class='dtstart'>Present</span>";
    if ($finish != "0000-00-00" && $finish != "3000-01-01") {
    	$finish_formated = "<time class='dtend' datetime='".format_date($finish,"Y-m-d")."'>".format_date($finish)."</time>";
	}
    else $finish_formated = "<span class='dtend'>" . __("Present") . "</span>";
    
    return $start_formated." — ".$finish_formated;
}

function create_list($list, $separator) {
    $text = "";
    $previous_element = "";
    
    foreach ($list as $element) {
        if ($previous_element != "" &&
            $element != "") {
            $text .= $separator;
        }
        $text .= $element;
        $previous_element = $element;
    }
    
    return $text;
}

function format_location($city, $region, $country) {
    $place_title = "";
    if ($city != "") {
        $place_title = __("City");
    }
    elseif ($region != "") {
        $place_title = __("Region");
    }
    elseif ($country != "") {
        $place_title = __("Country");
    }
    if ($city != "" && $region != "") {
        $region = ", ".$region;
    }
    if ($city != "" && $country != "" ||
        $region != "" && $country != "") {
        $country = ", ".$country;
    }
    
    return array($place_title, $city . $region . $country);
}

$slideshow_script_loaded = false;
function get_slideshow_script() {
	
	if ($slideshow_script_loaded) return "";
	
	$slideshow_script_loaded = true;
	
    // SLIDESHOW
	$script .= '<script>
		
		// Update slideshow
		var updateSlideshow = function (imageToLoad) {
			activeImage = imageToLoad;
			
			// Stop automatic updating (useful if user has clicked)
			clearInterval(updateSlideshowInterval);
			
			var $img = $(".slideshow li:eq("+imageToLoad+")").find("img");
			var src = $img.attr("src");
			src = src.replace("-small","");
			var alt = $img.attr("alt");
			var title = $img.attr("data-title");
			var link = $img.attr("data-link");
			var body = $img.attr("data-body");
			var video = $img.attr("data-video");
	
			var shallWeReload = true;
			var timeToReload = 7000;
	
			$bigImage = $(".slideshow-big-image").eq(0);
			$bigVideo = $(".slideshow-big-video").eq(0);
			$mainItem = $(".slideshow-main-item").eq(0);
	
			if (!($bigImage.attr("src") === src ||
				  $bigVideo.attr("src") === video)) { // change if we click in a different element
	
				// First, clear text
				$(".slideshow-text").clearQueue().css("height","").slideUp(function () {
			
					// Prevent non-active element
					if ($(".slideshow-main-item .active").length === 0)
						$bigImage.addClass("active");
		
					// Fade out active element
					$(".slideshow-main-item .active").removeClass("active").css("opacity","1").clearQueue().fadeOut(function () {
			
						if (video === undefined) { // image
							$bigImage.attr("src",src).load(function() {
								$bigImage.addClass("active").attr("alt",alt).fadeIn(function () {
								    $mainItem.css("height",$bigImage.height());
								    if (title !== undefined) {
								        $(".slideshow-text-title").html(title).attr("href",link);
								        $(".slideshow-text-body").html(body);
								        // 250 delay, it looks good and prevents the <div>
								        // to change its size when it is visible
								        $(".slideshow-text").delay(250).slideDown();
								    }
								});
							});
							$bigVideo.attr("src",""); // clear old video
						}
						else { // video
							$bigVideo.addClass("active").attr("src",video).attr("poster",src).fadeIn(function() {
							    $mainItem.css("height",$bigVideo.height());
							}).bind("play",function() {
							    clearInterval(updateSlideshowInterval);
							});
							shallWeReload = false;
							$bigImage.attr("src",""); // clear old image
						}
					});
				});
			}
	
			// Perform update again
			var nextImage = parseInt((imageToLoad + 1) % totalImages);
			if (shallWeReload) updateSlideshowInterval = setInterval("updateSlideshow("+nextImage+")", timeToReload);
		}

		$(document).ready(function() {
			totalImages = $(".slideshow li").length;
			$(".slideshow").prepend(\'<div class="slideshow-main-item"><img class="slideshow-big-image" src="" alt=""/><video class="slideshow-big-video" style="display: none;" src="" poster="" controls></video><div class="slideshow-text"><div class="slideshow-text-title-wrapper"><a class="slideshow-text-title" target="_blank"></a></div><span class="slideshow-text-body"></span></div></div>\');
			
			// Handle scroll
			var wasVisible = false;
			var previousInterval = null;
			var activeImage = -1;
		
			// Avoid slideshow animation if not visible
			$(window).scroll(function() {
					var docViewTop = $(window).scrollTop();
					var docViewBottom = docViewTop + $(window).height();
				
					var slideShowHeight = $(".slideshow").height();
					var slideShowTop = $(".slideshow").offset().top;
					var slideShowBottom = slideShowTop + slideShowHeight;
				
					if (((slideShowBottom - slideShowHeight <= docViewBottom) && (slideShowTop + slideShowHeight >= docViewTop))) {
						if (!wasVisible) {
							updateSlideshowInterval = setInterval("updateSlideshow("+parseInt((activeImage+1) % totalImages)+")", 0);
							wasVisible = true;
						}
					}
					else {
						if (wasVisible) {
							clearInterval(updateSlideshowInterval);
							wasVisible = false;
						}
					}
			});
			
			// Move slideshow on click
			$(".slideshow li").click(function () {
				updateSlideshow($(".slideshow li").index($(this)));
			});
		});
		
		</script>';
	
	return compress($script);
}
?>
