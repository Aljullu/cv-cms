<?php
include 'connect.php'; // must return a MySQL connection
include 'functions.php';

$my_profile = createProfile();

$reviewable = false;
if ($my_profile->get_number_of_opinions() > 0) {
    $reviewable = true;
}

?>
<!DOCTYPE HTML>
<html lang="<?php echo $my_profile->language; ?>" class="<?php echo $my_profile->uri; ?>">
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700%7CArvo:400,700' rel='stylesheet'>
	<?php $my_profile->print_styles(); ?>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon.png" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <meta name="keywords" content="<?php echo $my_profile->keywords; ?>" />
    <meta name="description" content="<?php echo replace_tokens($my_profile->description); ?>" />
    <title><?php echo replace_tokens($my_profile->title); ?></title>
	<script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
	<div id="wrapper" class="vcard" <?php if ($reviewable) echo 'itemscope itemtype="http://data-vocabulary.org/Review-aggregate"'; ?>>
        <nav id="top-menu">
            <ul>
	            <?php
	                $array = $my_profile->get_block_titles("body");
	                
	                if (count($array) > 3) { // Display menu only if there are more than 3 sections
	                    echo '<li><a href="#wrapper" class="scroll home"><i class="fa fa-home" aria-hidden="true"></i></a>';
	                    foreach ($array as $item) {
	                        echo '<li><a href="#'.$item['machine_title'].'" class="scroll">'.$item['title'].'</a>';
	                    }
                    }
	            ?>
            </ul>
        </nav>
        <div id="primary-bar">
		    <div id="face" >
			    <div id="slideshow">
		            <?php
                    $result = mysqli_query($con,"SELECT uri, alt, main_photo FROM profile_photos WHERE pid = ".$my_profile->id);
                    if ($result) {
                        $first = true;
                        while($row = mysqli_fetch_array($result)) {
                            $attributes = "";
                            $classes = "";
                            if ($first) $classes .= "active ";
                            if ($row['main_photo']) {
                                $classes .= "photo ";
                                $attributes = " itemprop='photo'";
                            }
                            $attributes .= " class='".$classes."'";
                            echo '<img src="'.$row['uri'].'" alt="'.replace_tokens($row['alt']).'" '.$attributes.'/>';
                            echo replace_tokens($row['body']);
                        }
                    }
                    ?>
			    </div>
			    <p class="fn" <?php if ($reviewable) echo 'itemprop="itemreviewed"'; ?>><?php echo $my_profile->get_name(); ?>
			    <?php if ($my_profile->job_title) : ?>
				    <p class="title"><?php echo $my_profile->job_title; ?>
			    <?php endif; ?>
			    <?php if ($my_profile->job_role) : ?>
				    <p class="role"><?php echo $my_profile->job_role; ?>
			    <?php endif; ?>
			    <?php if ($my_profile->job_description) : ?>
			    	<p><?php echo $my_profile->job_description; ?>
			    <?php endif; ?>
			    <p><?php $my_profile->print_email(); ?>
			    <p><?php $my_profile->print_phone(); ?>
			    <p><?php echo $my_profile->print_urls(); ?>
		    </div>
	        <?php
	            echo $my_profile->print_blocks("primary_bar");
	        ?>
		</div>
		<div id="text">
		    <?php
		        echo $my_profile->print_blocks("header");
		    ?>
			<header>
			    <h1><?php echo $my_profile->get_name(); ?></h1>
    <h2 class="subh1"><?php echo create_list(array($my_profile->job_title, $my_profile->job_role, $my_profile->job_description), " | "); ?></h2>
			    <div id="frases">
			    <?php
			    
                    $result = mysqli_query($con,"SELECT phrase FROM profile_phrases WHERE pid = ".$my_profile->id);
                    while($row = mysqli_fetch_array($result)) {
                        echo "<p>".$row['phrase']."</p>";
                    }
			    ?>
			    </div>
            </header>
		    <?php
		        echo $my_profile->print_blocks("body");
		    ?>
		</div>
		<footer>
		    <?php
		        echo $my_profile->print_blocks("footer");
		    ?>
		</footer>
	</div>
<?php echo get_google_analytics_code(); ?>
<script>
$(document).ready(function (){
    // Menu
	$(".scroll").click(function(event) {
		ga('send', 'event', 'navigation', 'topmenu');
		event.preventDefault();
		$('html,body').animate({scrollTop:$(this.hash).offset().top-$("#top-menu").height()-20}, 500);
	});
	
	<?php
	if ($reviewable):
	?>
		// Opinions
		var opinionsShown = 4;
		var opinionsTotals = $(".opinion").length;
		$(".opinion:gt("+opinionsShown+")").hide();
		$("#show-more-opinions").click(function() {
			$(".opinion").slice(opinionsShown,opinionsShown += 5).slideDown();
			if (opinionsShown + 1 >= opinionsTotals) $("a#show-more-opinions, a#show-more-opinions + span.separator").remove();
		});
	<?php
	endif;
	?>
});

$(document).scroll(function (){
	// Add shadow to menu when sticky
    if ($(document).scrollTop() >= 1) {
        $("#top-menu").addClass("scrolled");
    }
    else {
        $("#top-menu").removeClass("scrolled");
    }
});
</script>
<?php
close_connection();
?>
