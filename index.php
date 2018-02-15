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
	<?php $my_profile->print_styles(); ?>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
  <link rel="shortcut icon" href="/favicon.png" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width" />
  <meta name="keywords" content="<?php echo $my_profile->keywords; ?>" />
  <meta name="description" content="<?php echo replace_tokens($my_profile->description); ?>" />
  <title><?php echo replace_tokens($my_profile->title); ?></title>
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
    <aside id="primary-bar">
      <div id="face">
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
      <?php echo $my_profile->print_blocks("primary_bar"); ?>
    </aside>
    <main id="text">
      <?php echo $my_profile->print_blocks("header"); ?>
      <header>
        <?php if ($my_profile->page_title): ?>
          <h1><?php echo $my_profile->page_title; ?></h1>
        <?php else: ?>
          <h1><?php echo $my_profile->get_name(); ?></h1>
        <?php endif; ?>
        <?php if ($my_profile->page_subtitle): ?>
          <h2 class="subh1"><?php echo $my_profile->page_subtitle; ?></h2>
        <?php endif; ?>
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
      <?php echo $my_profile->print_blocks("body"); ?>
		</main>
		<footer>
	    <?php echo $my_profile->print_blocks("footer"); ?>
		</footer>
	</div>
<?php echo get_google_analytics_code(); ?>
<script>
<?php if ($reviewable): ?>
  function hideShowMoreIfOverflow(opinionsShown, opinionsCount) {
		if (opinionsShown + 1 >= opinionsCount) {
      document.querySelector("a#show-more-opinions + span.separator").remove();
      document.querySelector("a#show-more-opinions").remove();
    }
  }
	// Opinions
	var opinionsShown = 5;
  var opinionsLimit = opinionsShown + 1;
	var opinionsCount = document.querySelectorAll(".opinion").length;
	document.querySelectorAll(".opinion:nth-of-type(n + " + opinionsLimit + ")").forEach(opinion => opinion.setAttribute('hidden', true));
  hideShowMoreIfOverflow(opinionsShown, opinionsCount);

	document.querySelector("#show-more-opinions").addEventListener('click', function() {
    opinionsShown += 5;
    document.querySelectorAll(".opinion:nth-of-type(-n + " + opinionsShown + ")").forEach(opinion => opinion.removeAttribute('hidden'));
    hideShowMoreIfOverflow(opinionsShown, opinionsCount);
	});
<?php endif; ?>

document.addEventListener('scroll', function() {
  if (window.scrollY >= 1) {
    document.getElementById("top-menu").classList.add("scrolled");
  }
  else {
    document.getElementById("top-menu").classList.remove("scrolled");
  }
});

// Analytics Menu
document.querySelectorAll('.scroll').forEach(scrollLink => scrollLink.addEventListener('click', function(event) {
	ga('send', 'event', 'navigation', 'topmenu');
}));

// Analytics scroll
const handler = function(entries) {
  for (const entry of entries) {
    if (!entry.isIntersecting) {
      ga('send', 'event', 'page_scroll', entry.target.id, null);
    }
  }
};
const observer = new IntersectionObserver(handler);
const analyticsScroll = document.querySelectorAll('.analytics-scroll');
analyticsScroll.forEach(analyticsScrollSection => observer.observe(analyticsScrollSection));
</script>
<?php
close_connection();
?>
