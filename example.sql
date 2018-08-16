-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Temps de generació: 16-08-2018 a les 18:50:52
-- Versió del servidor: 10.2.16-MariaDB
-- Versió de PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `cv-cms`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `css`
--

CREATE TABLE `css` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `css` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `css`
--

INSERT INTO `css` (`id`, `pid`, `css`) VALUES
(1, 2, 'specific.css');

-- --------------------------------------------------------

--
-- Estructura de la taula `opinions`
--

CREATE TABLE `opinions` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `reviewer` varchar(255) NOT NULL,
  `reviewer_url` varchar(255) NOT NULL,
  `reviewer_title` varchar(255) NOT NULL,
  `opinion` text NOT NULL,
  `rating` float NOT NULL,
  `date` date NOT NULL,
  `lang` varchar(255) NOT NULL,
  `aproved` tinyint(1) NOT NULL,
  `source_url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `opinions`
--

INSERT INTO `opinions` (`id`, `pid`, `reviewer`, `reviewer_url`, `reviewer_title`, `opinion`, `rating`, `date`, `lang`, `aproved`, `source_url`) VALUES
(1, 2, 'Albus Dumbledore', 'https://www.example.com/', 'Director', 'Harry Potter has been a great student.', 0, '2015-12-22', '', 1, 'https://www.example.com/');

-- --------------------------------------------------------

--
-- Estructura de la taula `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `last_name2` varchar(255) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `language` varchar(5) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_role` varchar(255) NOT NULL,
  `job_description` varchar(255) NOT NULL,
  `phone` varchar(127) NOT NULL,
  `email` varchar(255) NOT NULL,
  `display_last_name2_in_title` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `last_name`, `last_name2`, `uri`, `title`, `language`, `description`, `keywords`, `job_title`, `job_role`, `job_description`, `phone`, `email`, `display_last_name2_in_title`) VALUES
(2, 'Harry', 'Potter', '', 'harrypotter', '[display_name]: Head of Aurors', 'en', '[display_name], Head of Aurors, I survived Voldemort', 'Harry Potter, Auror, Head of Aurors, Voldemort', 'Head of Aurors', 'Director', 'I am the lead of the Aurors', '+34 123 456 789', 'contact@example.com', 0);

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_blocks`
--

CREATE TABLE `profile_blocks` (
  `bid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `zone` varchar(255) NOT NULL,
  `display_title` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `machine_title` varchar(255) NOT NULL,
  `body` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profile_blocks`
--

INSERT INTO `profile_blocks` (`bid`, `pid`, `weight`, `zone`, `display_title`, `title`, `machine_title`, `body`) VALUES
(1, 2, 1, 'body', 0, '', 'summary', '<p>I\'m a wizard.</p><p>Picture from <a href=\"https://unsplash.com/photos/OarD62fNxaI\">https://unsplash.com/photos/OarD62fNxaI</a>.\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque fermentum condimentum condimentum. Vestibulum aliquet, lectus nec vulputate tempor, nunc nisi imperdiet nisi, ut condimentum dolor ipsum ac nisl. Nunc venenatis arcu eget ligula rutrum mattis ut ac urna. Maecenas bibendum, purus eget facilisis dapibus, sem sem faucibus sem, sed cursus purus ipsum sed metus. Nullam eu enim id eros porta elementum. Phasellus dignissim elit eget nibh suscipit finibus. Nam tristique pharetra dui, nec ultrices justo commodo eu. Donec vulputate leo varius pretium placerat. Donec iaculis nibh porttitor mauris consequat rhoncus. Vivamus vitae ultrices lectus. Morbi at metus ac eros semper ultrices. Suspendisse potenti.</p>\r\n<p>Fusce ac mi a augue tincidunt lacinia. Etiam aliquam malesuada massa, ut pulvinar quam blandit id. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent quis ante risus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus id viverra ante, sit amet mollis sapien. Nullam volutpat posuere libero, quis auctor leo tristique a. Vivamus non tincidunt magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris imperdiet augue et risus ullamcorper fringilla. Morbi eros lectus, gravida quis nibh eget, maximus ullamcorper ex. Vivamus viverra nec libero quis dapibus. Aenean ullamcorper urna leo, nec ullamcorper est posuere elementum. Nulla lorem justo, aliquam posuere pellentesque pellentesque, pharetra et felis.</p>'),
(2, 2, 2, 'body', 1, 'Professional experience', 'professional-experience', '[work_professional_experience]<details><summary>More work experience...</summary>[work_not_professional_experience]</details>'),
(3, 2, 3, 'body', 1, 'Education', 'education', '[education]'),
(4, 2, 4, 'body', 1, 'Portfolio', 'portfolio', '[portfolio]'),
(6, 2, 6, 'body', 0, 'Contact', 'contact', '<div class=\"contact-wrapper\">    <div class=\"contact-message\">Do you want to know more?</div>    <a class=\"contact-button not-styled\" href=\"mailto:contact@albertjuhe.com\">Contact me</a></div>'),
(5, 2, 5, 'body', 1, 'Recommendations', 'recommendations', '[opinions]'),
(7, 2, 1, 'primary_bar', 0, 'Social networks', 'social-networks', '[social-networks]'),
(8, 2, 8, 'header', 0, 'CV', 'CV', '<a class=\"pdf-cv not-styled\" href=\"/files/harry-potter-cv.pdf\" title=\"Harry Potter CV in PDF\">    <img class=\"pdf-cv-image\" src=\"/img/pdf-icon.png\" alt=\"\"/>    <span class=\"pdf-cv-text\">Harry Potter PDF Resume</span></a>');

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_education`
--

CREATE TABLE `profile_education` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `degree` varchar(255) NOT NULL,
  `field_of_study` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profile_education`
--

INSERT INTO `profile_education` (`id`, `pid`, `degree`, `field_of_study`, `school`, `city`, `region`, `country`, `start_date`, `finish_date`, `description`) VALUES
(0, 2, 'Degree', 'Magic Education', 'Hogwarts', 'Misterious place', '', 'UK', '2009-09-00', '2013-12-00', '<p>I participated in the Triwizard Tournament</p>\r\n<p>Phasellus non risus at nunc egestas venenatis. Morbi mollis ex est, in eleifend libero egestas vitae. Quisque velit sapien, euismod a felis non, viverra aliquet ligula. Nulla consectetur dapibus turpis ut ultricies. Aliquam eros tortor, tincidunt quis lacus eget, vestibulum porta quam. Sed rutrum lacinia tellus, ac tristique urna. Proin erat lacus, sagittis ut vulputate a, consequat id neque. Quisque eget tempor turpis. Sed gravida mauris ligula, sit amet interdum diam congue at. Phasellus varius, orci in mattis eleifend, neque dui tempor urna, vitae hendrerit libero mi vel magna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tincidunt, neque quis posuere aliquet, sem massa lacinia erat, nec euismod metus risus sed diam. Sed placerat pulvinar dignissim. Sed vitae vulputate arcu.</p>');

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_experience`
--

CREATE TABLE `profile_experience` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `company_website` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `description` text NOT NULL,
  `volunteer` tinyint(1) NOT NULL,
  `not_related` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profile_experience`
--

INSERT INTO `profile_experience` (`id`, `pid`, `weight`, `job_title`, `company`, `company_website`, `city`, `region`, `country`, `start_date`, `finish_date`, `description`, `volunteer`, `not_related`) VALUES
(0, 2, 0, 'Junior Auror', 'Ministry of Magic', 'http://www.example.com/', 'London', '', 'UK', '2010-10-00', '2012-07-00', '<p>I was a Junior Auror</p>\r\n<p>Phasellus vitae sodales eros. Integer dignissim erat dolor, et scelerisque est ornare sed. Mauris suscipit pharetra justo. Donec sagittis aliquet sem vehicula viverra. Integer efficitur dui quis massa eleifend, non gravida tellus scelerisque. In sagittis urna ac nibh faucibus, et varius nunc fermentum. Quisque malesuada rutrum eros id dictum. Maecenas pretium ex cursus quam congue, sed venenatis velit tincidunt. Etiam molestie dui nec ipsum vulputate, et varius enim ornare. Donec ullamcorper erat et risus dictum, a blandit orci rutrum. Integer justo sapien, vulputate in porta vitae, ultricies facilisis justo. Integer id venenatis leo, vitae aliquam justo. Fusce commodo ut velit quis pulvinar. Sed vitae faucibus nisl, sed aliquam mauris.</p>', 0, 0),
(1, 2, 0, 'Auror', 'Ministry of Magic', 'http://www.example.net/', 'London', '', 'UK', '2013-03-00', '2014-02-07', '<p>I was an Auror.</p>\r\n<p>Etiam in venenatis diam. Donec laoreet purus eu odio rhoncus congue. Praesent eros metus, bibendum nec hendrerit sed, auctor non ex. Maecenas feugiat mauris et eleifend dapibus. Nulla quis ligula ac risus elementum feugiat. Curabitur urna urna, tempus quis suscipit blandit, sagittis id lectus. Donec in purus ultrices, fermentum nulla vel, luctus sapien. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque pulvinar ullamcorper purus nec vulputate. Aliquam erat volutpat. Nunc sit amet purus ligula. Mauris dolor justo, convallis eget maximus sed, rhoncus et metus. Aliquam ultrices, diam et pretium porttitor, magna urna semper metus, ut euismod nunc felis facilisis est. Integer elit sapien, egestas a ipsum vel, hendrerit tincidunt turpis. Suspendisse eget nunc et est viverra elementum non vitae eros.</p>', 0, 0),
(2, 2, 0, 'Director of the Aurors', 'Ministry of Magic', 'http://www.example.com/', 'Everywhere', '', '', '2014-03-00', '3000-01-01', '<p>I am currently the Director of the Aurors</p>\r\n<p>Nam sit amet tristique mi. Sed dictum elementum ultrices. Phasellus pulvinar sem eros, quis congue dolor interdum quis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Proin rhoncus ut lectus sit amet ultricies. Proin euismod felis quis tempus eleifend. Morbi pharetra efficitur purus vitae finibus. Mauris tempus diam augue, non vehicula tellus venenatis sit amet. Pellentesque at rutrum odio. Nulla ullamcorper nisl id nisl pharetra pharetra et ut lectus. Vestibulum ac ullamcorper sapien. Vivamus molestie id dui sed tincidunt. Donec id facilisis elit, vel mattis leo. Pellentesque hendrerit ultricies volutpat.</p>', 0, 0),
(3, 2, 0, 'Shop Assistant', 'Weasleys\' Wizard Wheezes', 'http://www.example.com/', 'Number 93', 'Diagon Alley', 'UK', '2004-00-00', '2010-00-00', '<p>I helped in the shop during the summer.</p>\r\n<p>Suspendisse tincidunt mattis facilisis. Ut eget venenatis sapien. Etiam et sapien leo. Vestibulum condimentum vestibulum vehicula. Fusce vestibulum neque sed ex faucibus bibendum. Vestibulum et fermentum felis. Vestibulum sed arcu eget lorem commodo sodales in ac nulla. Vivamus egestas dapibus neque, sed tincidunt mi porta ac.</p>', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_languages`
--

CREATE TABLE `profile_languages` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `language_name` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profile_languages`
--

INSERT INTO `profile_languages` (`id`, `pid`, `weight`, `language_name`, `level`, `qualification`, `notes`) VALUES
(1, 2, 0, 'English', 'native', 'FCE', 'Have been speaking English all my life.'),
(2, 2, 0, 'Catalan', 'high level', '', ''),
(3, 2, 0, 'Spanish', 'high level', '', '');

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_photos`
--

CREATE TABLE `profile_photos` (
  `pid` int(11) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `main_photo` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profile_photos`
--

INSERT INTO `profile_photos` (`pid`, `uri`, `alt`, `main_photo`) VALUES
(2, 'https://images.unsplash.com/photo-1513413834892-36e20da82d39?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=f88cb0cbcaf9ec9484ca1dbd9e7f0ef5&dpr=1&auto=format&fit=crop&w=1000&q=80&cs=tinysrgb', 'Harry Potter', 1);

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_phrases`
--

CREATE TABLE `profile_phrases` (
  `pid` int(11) NOT NULL,
  `phrase` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_portfolio`
--

CREATE TABLE `profile_portfolio` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `weight` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `long_description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `link_android` varchar(255) NOT NULL,
  `link_ios` varchar(255) NOT NULL,
  `link_firefox_os` varchar(255) NOT NULL,
  `link_windows_phone` varchar(255) NOT NULL,
  `link_github` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profile_portfolio`
--

INSERT INTO `profile_portfolio` (`id`, `pid`, `visible`, `weight`, `category`, `name`, `image`, `video`, `short_description`, `long_description`, `link`, `link_android`, `link_ios`, `link_firefox_os`, `link_windows_phone`, `link_github`) VALUES
(1, 2, 0, 2, 1, 'CV CMS', 'https://www.albertjuhe.com/files/portfolio/cvcms-small.png', '', 'Simple CMS to create single-page CV\'s, programmed with PHP and using HTML5 and CSS3.', 'simple CMS to create single-page CV\'s, programmed with PHP and using HTML5 and CSS3. Responsive.', '/', '', '', '', '', 'https://github.com/Aljullu/cv-cms');

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_portfolio_categories`
--

CREATE TABLE `profile_portfolio_categories` (
  `id` int(11) NOT NULL,
  `portfolio_category_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profile_portfolio_categories`
--

INSERT INTO `profile_portfolio_categories` (`id`, `portfolio_category_id`, `weight`, `name`) VALUES
(1, 1, 1, 'Websites');

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_social_networks`
--

CREATE TABLE `profile_social_networks` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `display` tinyint(1) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `profile_social_networks`
--

INSERT INTO `profile_social_networks` (`id`, `pid`, `url`, `display`, `weight`) VALUES
(1, 2, 'https://www.linkedin.com/in/yourname/', 1, 1),
(2, 2, 'https://twitter.com/yourname', 1, 3),
(3, 2, 'https://www.facebook.com/yourname', 0, 1),
(4, 2, 'https://github.com/yourname/', 1, 2),
(5, 2, 'https://plus.google.com/yourname/', 0, 2),
(6, 2, 'http://stackexchange.com/users/yourname?tab=accounts', 1, 4),
(7, 2, 'https://medium.com/@yourname', 1, 6),
(8, 2, 'https://bugzilla.mozilla.org/buglist.cgi?order=Importance&emailtype1=exact&emailassigned_to1=1&query_format=advanced&email1=youremail@example.com&list_id=13540629', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de la taula `profile_urls`
--

CREATE TABLE `profile_urls` (
  `pid` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de la taula `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `get_profile_uri_from` varchar(255) NOT NULL,
  `default_profile` varchar(255) NOT NULL,
  `analytics` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Bolcament de dades per a la taula `settings`
--

INSERT INTO `settings` (`id`, `get_profile_uri_from`, `default_profile`, `analytics`, `path`) VALUES
(0, 'settings', 'harrypotter', 'UA-XXXXXXXX-Y', 'http://www.harrypotter.test/');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `css`
--
ALTER TABLE `css`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `opinions`
--
ALTER TABLE `opinions`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índexs per a la taula `profile_blocks`
--
ALTER TABLE `profile_blocks`
  ADD PRIMARY KEY (`bid`),
  ADD UNIQUE KEY `bid` (`bid`);

--
-- Índexs per a la taula `profile_education`
--
ALTER TABLE `profile_education`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `profile_experience`
--
ALTER TABLE `profile_experience`
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- Índexs per a la taula `profile_languages`
--
ALTER TABLE `profile_languages`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `profile_photos`
--
ALTER TABLE `profile_photos`
  ADD PRIMARY KEY (`uri`);

--
-- Índexs per a la taula `profile_portfolio`
--
ALTER TABLE `profile_portfolio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índexs per a la taula `profile_portfolio_categories`
--
ALTER TABLE `profile_portfolio_categories`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `profile_social_networks`
--
ALTER TABLE `profile_social_networks`
  ADD PRIMARY KEY (`id`);

--
-- Índexs per a la taula `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `css`
--
ALTER TABLE `css`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la taula `opinions`
--
ALTER TABLE `opinions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la taula `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la taula `profile_blocks`
--
ALTER TABLE `profile_blocks`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la taula `profile_languages`
--
ALTER TABLE `profile_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la taula `profile_portfolio`
--
ALTER TABLE `profile_portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la taula `profile_portfolio_categories`
--
ALTER TABLE `profile_portfolio_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la taula `profile_social_networks`
--
ALTER TABLE `profile_social_networks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
