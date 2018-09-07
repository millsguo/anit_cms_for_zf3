SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `atnightandintransportation` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `atnightandintransportation`;

DROP TABLE IF EXISTS `backofficeaccess`;
CREATE TABLE IF NOT EXISTS `backofficeaccess` (
  `id_access` int(11) NOT NULL AUTO_INCREMENT,
  `user_access` varchar(128) COLLATE utf8_bin NOT NULL,
  `pwd_access` varchar(512) COLLATE utf8_bin NOT NULL,
  `role_access` enum('anonymous','user','admin','') COLLATE utf8_bin NOT NULL,
  `csrf_access` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `honeypot_access` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id_access`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `backofficeaccess` (`id_access`, `user_access`, `pwd_access`, `role_access`, `csrf_access`, `honeypot_access`) VALUES
(1, 'anit_admin', 'a11ce7e53ff6fa2931212979b96e3114bb17ab0632a79f2bd9d68cd0fd8cdc273414c825613295282810daf574da4108a2e3a0796a2c1f4d13bfb8e3646486a1', 'admin', '', ''),
(4, 'anit_user', '315086eaee9fc3f9a2d6d55d407500225ba8b2e4e81d40e0c03293b83673aa7f1097c325d27af3d841b39a1ed4f467f5dcfe2c244d96c505592cf3f563614cf5', 'user', NULL, NULL);

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `commentaire_id` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire_msg` text COLLATE utf8_bin,
  `commentaire_row1` varchar(256) COLLATE utf8_bin DEFAULT '',
  `commentaire_row2` varchar(256) COLLATE utf8_bin DEFAULT '',
  `commentaire_row3` varchar(256) COLLATE utf8_bin DEFAULT '',
  `commentaire_row4` varchar(256) COLLATE utf8_bin DEFAULT '',
  `commentaire_position` int(11) DEFAULT '0',
  `commentaire_type` varchar(128) COLLATE utf8_bin DEFAULT '',
  `commentaire_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `commentaire_status` tinyint(4) NOT NULL,
  `commentaire_contenuid` int(11) NOT NULL,
  PRIMARY KEY (`commentaire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `commentaire` (`commentaire_id`, `commentaire_msg`, `commentaire_row1`, `commentaire_row2`, `commentaire_row3`, `commentaire_row4`, `commentaire_position`, `commentaire_type`, `commentaire_date`, `commentaire_status`, `commentaire_contenuid`) VALUES
(1, 'Great job !', 'John Doe', 'Doe Inc.', 'foo.bar@foo.com', '', 0, 'blog', '2017-09-06 05:42:56', 1, 50),
(2, 'test', 'test', 'test', 'test@test.test', 'test', 0, 'blog', '2017-09-06 05:42:46', 1, 84);

DROP TABLE IF EXISTS `contenu`;
CREATE TABLE IF NOT EXISTS `contenu` (
  `contenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `rang` int(11) DEFAULT NULL,
  `titre` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `soustitre` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `sousrubriques_id` int(11) NOT NULL,
  `contenuhtml` text COLLATE utf8_bin,
  `image` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `image2` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `type` enum('content','gallery','blog','mapcontent') COLLATE utf8_bin DEFAULT NULL,
  `author` varchar(256) COLLATE utf8_bin DEFAULT '',
  `themes` varchar(256) COLLATE utf8_bin DEFAULT '',
  `contenu_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `othertext1` varchar(256) COLLATE utf8_bin DEFAULT '',
  `othertext2` varchar(256) COLLATE utf8_bin DEFAULT '',
  `othertext3` varchar(256) COLLATE utf8_bin DEFAULT '',
  `sousrubriques_preview` int(11) NOT NULL DEFAULT '0',
  `contenu_rank_preview` int(11) NOT NULL DEFAULT '0',
  `gps_coordinates` json DEFAULT NULL,
  PRIMARY KEY (`contenu_id`),
  KEY `sousrubriques_id` (`sousrubriques_id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `contenu` (`contenu_id`, `rang`, `titre`, `soustitre`, `sousrubriques_id`, `contenuhtml`, `image`, `image2`, `type`, `author`, `themes`, `contenu_date`, `othertext1`, `othertext2`, `othertext3`, `sousrubriques_preview`, `contenu_rank_preview`, `gps_coordinates`) VALUES
(20, 1, 'Intro', '', 11, '<div class=\"col-lg-8\">\r\n<p>Hac ex causa conlaticia stipe Valerius humatur ille Publicola et subsidiis amicorum mariti inops cum liberis uxor alitur Reguli et dotatur ex aerario filia Scipionis, cum nobilitas florem adultae virginis diuturnum absentia pauperis erubesceret patris.</p>\r\n<p>Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat.</p>\r\n</div>\r\n<div class=\"col-lg-4\"><img class=\"img-responsive\" src=\"filesbank/homme-tablette1.jpeg\" alt=\"\" /></div>', NULL, NULL, 'content', '', '', '2015-09-23 13:55:12', '', '', '', 0, 0, 'null'),
(21, 2, 'Keep in touch', '', 11, '<div class=\"col-lg-8\">\r\n<p>Hac ex causa conlaticia stipe Valerius humatur ille Publicola et subsidiis amicorum mariti inops cum liberis uxor alitur Reguli et dotatur ex aerario filia Scipionis, cum nobilitas florem adultae virginis diuturnum absentia pauperis erubesceret patris.</p>\r\n<p>Restabat ut Caesar post haec properaret accitus et abstergendae causa suspicionis sororem suam, eius uxorem, Constantius ad se tandem desideratam venire multis fictisque blanditiis hortabatur. quae licet ambigeret metuens saepe cruentum, spe tamen quod eum lenire poterit ut germanum profecta, cum Bithyniam introisset, in statione quae Caenos Gallicanos appellatur, absumpta est vi febrium repentina. cuius post obitum maritus contemplans cecidisse fiduciam qua se fultum existimabat, anxia cogitatione, quid moliretur haerebat.</p>\r\n</div>\r\n<div class=\"col-lg-4\"><img class=\"img-responsive\" src=\"filesbank/cool-meeting.jpg\" alt=\"\" /></div>', NULL, NULL, 'content', '', '', '2015-09-22 11:50:15', '', '', '', 0, 0, 'null'),
(22, -1, 'Projects', '', 12, '<p>In adclinis Berytus Sidon amoenitate.</p>\r\n<p>&nbsp;</p>\r\n<div>\r\n<p>Et est admodum mirum videre plebem innumeram mentibus ardore quodam infuso cum dimicationum curulium eventu pendentem. haec similiaque memorabile nihil vel serium agi Romae permittunt. ergo redeundum ad textum.</p>\r\n<p>Novitates autem si spem adferunt, ut tamquam in herbis non fallacibus fructus appareat, non sunt illae quidem repudiandae, vetustas tamen suo loco conservanda; maxima est enim vis vetustatis et consuetudinis. Quin in ipso equo, cuius modo feci mentionem, si nulla res impediat, nemo est, quin eo, quo consuevit, libentius utatur quam intractato et novo. Nec vero in hoc quod est animal, sed in iis etiam quae sunt inanima, consuetudo valet, cum locis ipsis delectemur, montuosis etiam et silvestribus, in quibus diutius commorati sumus.</p>\r\n<p>Iamque non umbratis fallaciis res agebatur, sed qua palatium est extra muros, armatis omne circumdedit. ingressusque obscuro iam die, ablatis regiis indumentis Caesarem tunica texit et paludamento communi, eum post haec nihil passurum velut mandato principis iurandi crebritate confirmans et statim inquit exsurge et inopinum carpento privato inpositum ad Histriam duxit prope oppidum Polam, ubi quondam peremptum Constantini filium accepimus Crispum.</p>\r\n</div>', NULL, NULL, 'content', '', '', '2017-07-19 17:00:08', '', '', '', 0, 0, 'null'),
(23, 2, 'Conseil', '', 12, '<div class=\"col-md-4 col-sm-6\">\r\n<div class=\"service-block service-block-default\">\r\n<h2 class=\"heading-md\">Conseil</h2>\r\n<p>Quod quosdam et talia et accedente vitant et ut mercede.</p>\r\n<ul class=\"list-unstyled\">\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n</ul>\r\n</div>\r\n</div>', NULL, NULL, 'content', '', '', '2017-07-19 16:59:31', '', '', '', 0, 0, 'null'),
(24, 3, 'Mobility', '', 12, '<div class=\"col-md-4 col-sm-6\">\r\n<div class=\"service-block service-block-default\">\r\n<h2 class=\"heading-md\">Mobility</h2>\r\n<p>Quod quosdam et talia et accedente vitant et ut mercede.</p>\r\n<ul class=\"list-unstyled\">\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n</ul>\r\n</div>\r\n</div>', NULL, NULL, 'content', '', '', '2017-07-19 16:59:31', '', '', '', 0, 0, 'null'),
(25, 4, 'Web', '', 12, '<div class=\"col-md-4 col-sm-12\">\r\n<div class=\"service-block service-block-default\">\r\n<h2 class=\"heading-md\">Web</h2>\r\n<p>Quod quosdam et talia et accedente vitant et ut mercede.</p>\r\n<ul class=\"list-unstyled\">\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n<li>Odisse Scipio est etiam ut.</li>\r\n</ul>\r\n</div>\r\n</div>', NULL, NULL, 'content', '', '', '2017-07-19 16:59:48', '', '', '', 0, 0, 'null'),
(26, 2, 'Quaedam', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/insurance-panel.jpg\" alt=\"Tarificateur assurances\" />\r\n<div class=\"cbp-l-inline-desc\">\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>\r\n</div>', 'filesbank/insurance-panel.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(27, 4, 'Quaedam', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img class=\"cbp-l-project-img\" style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/labox.jpg\" alt=\"application grand public FAI\" />\r\n<div class=\"cbp-l-inline-desc\">\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>\r\n</div>', 'filesbank/labox.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(28, 5, 'Acerbitati', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img class=\"cbp-l-project-img\" style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/electric-car-recharging.jpg\" alt=\"application m&eacute;tier\" />\r\n<div class=\"cbp-l-inline-desc\">\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>\r\n</div>', 'filesbank/electric-car-recharging.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(29, 6, 'Acerbitati', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img class=\"cbp-l-project-img\" style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/electric-car-recharging2.jpg\" alt=\"Dashboard\" />\r\n<div class=\"cbp-l-inline-desc\">\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>\r\n</div>', 'filesbank/electric-car-recharging2.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(30, 7, 'Per cruoris', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img class=\"cbp-l-project-img\" style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/document-management.jpg\" alt=\"tablette gestion documentaire\" />\r\n<div class=\"cbp-l-inline-desc\">\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>\r\n</div>', 'filesbank/document-management.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(31, 10, 'Saepe', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img class=\"cbp-l-project-img\" style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/cms2.jpg\" alt=\"sites internets php\" />\r\n<div class=\"cbp-l-inline-desc\">\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>\r\n</div>', 'filesbank/cms2.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(32, 8, 'Per cruoris', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img class=\"cbp-l-project-img\" style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/comparison.jpg\" alt=\"Dashboard\" />\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>', 'filesbank/comparison.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(33, 9, 'Per cruoris', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img class=\"cbp-l-project-img\" style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/survey.jpg\" alt=\"qualification de prospects\" />\r\n<div class=\"cbp-l-inline-desc\">\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>\r\n</div>', 'filesbank/survey.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(34, 12, 'Saepe', 'Futurum', 13, '<div class=\"cbp-l-inline\">\r\n<div class=\"cbp-l-inline-title\" style=\"text-align: center;\">Lorem Ipsum</div>\r\n<div class=\"cbp-l-inline-subtitle\">&nbsp;</div>\r\n<img class=\"cbp-l-project-img\" style=\"display: block; margin: auto; width: 200px; height: 150px;\" src=\"filesbank/rugby-players.jpg\" alt=\"mobile club sportif\" />\r\n<div class=\"cbp-l-inline-desc\">\r\n<div id=\"TheTexte\" class=\"Texte\">\r\n<p>Sed si ille hac tam eximia fortuna propter utilitatem rei publicae frui non properat, ut omnia illa conficiat, quid ego, senator, facere debeo, quem, etiamsi ille aliud vellet, rei publicae consulere oporteret?</p>\r\n<p>Latius iam disseminata licentia onerosus bonis omnibus Caesar nullum post haec adhibens modum orientis latera cuncta vexabat nec honoratis parcens nec urbium primatibus nec plebeiis.</p>\r\n<p>Oportunum est, ut arbitror, explanare nunc causam, quae ad exitium praecipitem Aginatium inpulit iam inde a priscis maioribus nobilem, ut locuta est pertinacior fama. nec enim super hoc ulla documentorum rata est fides.</p>\r\n</div>\r\n</div>\r\n</div>', 'filesbank/rugby-players.jpg', '', 'gallery', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(35, 1, 'Image Slider 1', '', 17, '<!-- LAYERS -->\r\n<div class=\"tp-caption rs-caption-1 sft start\" data-x=\"center\" data-hoffset=\"0\" data-y=\"100\" data-speed=\"800\" data-start=\"2000\" data-easing=\"Back.easeInOut\" data-endspeed=\"300\">Lorem Ipsum</div>\r\n<!-- LAYER -->\r\n<div class=\"tp-caption rs-caption-2 sft\" style=\"z-index: 6;\" data-x=\"center\" data-hoffset=\"0\" data-y=\"200\" data-speed=\"1000\" data-start=\"3000\" data-easing=\"Power4.easeOut\" data-endspeed=\"300\" data-endeasing=\"Power1.easeIn\" data-captionhidden=\"off\">Cassium viderit etiam magis habemus.<br />Cassium viderit etiam magis habemus</div>\r\n<!-- LAYER -->\r\n<div class=\"tp-caption rs-caption-3 sft\" style=\"z-index: 6;\" data-x=\"center\" data-hoffset=\"0\" data-y=\"360\" data-speed=\"800\" data-start=\"3500\" data-easing=\"Power4.easeOut\" data-endspeed=\"300\" data-endeasing=\"Power1.easeIn\" data-captionhidden=\"off\"><span class=\"page-scroll\"><a class=\"btn-u btn-brd btn-brd-hover btn-u-light\" href=\"#A-propos\">Learn more</a></span> <span class=\"page-scroll\"><a class=\"btn-u btn-brd btn-brd-hover btn-u-light\" href=\"#Portfolio\">Examples</a></span></div>', 'filesbank/1424360037_bg1.jpg', '', 'gallery', '', '', '2016-04-11 20:09:25', '', '', '', 0, 0, 'null'),
(36, 2, 'Image Slider 2', '', 17, '<!-- LAYERS -->\r\n<div class=\"tp-caption rs-caption-1 sft start\" data-x=\"center\" data-hoffset=\"0\" data-y=\"100\" data-speed=\"800\" data-start=\"1500\" data-easing=\"Back.easeInOut\" data-endspeed=\"300\">Lorem Ipsum</div>\r\n<!-- LAYER -->\r\n<div class=\"tp-caption rs-caption-2 sft\" style=\"z-index: 6;\" data-x=\"center\" data-hoffset=\"0\" data-y=\"200\" data-speed=\"1000\" data-start=\"2500\" data-easing=\"Power4.easeOut\" data-endspeed=\"300\" data-endeasing=\"Power1.easeIn\" data-captionhidden=\"off\">Cassium viderit etiam magis habemus<br />Cassium viderit etiam magis habemus</div>\r\n<!-- LAYER -->\r\n<div class=\"tp-caption rs-caption-3 sft\" style=\"z-index: 6;\" data-x=\"center\" data-hoffset=\"0\" data-y=\"360\" data-speed=\"800\" data-start=\"3500\" data-easing=\"Power4.easeOut\" data-endspeed=\"300\" data-endeasing=\"Power1.easeIn\" data-captionhidden=\"off\"><span class=\"page-scroll\"><a class=\"btn-u btn-brd btn-brd-hover btn-u-light\" href=\"#A-propos\">Learn more</a></span> <span class=\"page-scroll\"><a class=\"btn-u btn-brd btn-brd-hover btn-u-light\" href=\"#Portfolio\">Examples</a></span></div>', 'filesbank/1424360106_bg2.jpg', '', 'gallery', '', '', '2016-04-11 20:09:25', '', '', '', 0, 0, 'null'),
(37, 3, 'Image Slider 3', '', 17, '<!-- LAYERS -->\r\n<div class=\"tp-caption rs-caption-1 sft start\" data-x=\"center\" data-hoffset=\"0\" data-y=\"110\" data-speed=\"800\" data-start=\"1500\" data-easing=\"Back.easeInOut\" data-endspeed=\"300\">Lorem Ipsum</div>\r\n<!-- LAYER -->\r\n<div class=\"tp-caption rs-caption-2 sfb\" style=\"z-index: 6;\" data-x=\"center\" data-hoffset=\"0\" data-y=\"210\" data-speed=\"800\" data-start=\"2500\" data-easing=\"Power4.easeOut\" data-endspeed=\"300\" data-endeasing=\"Power1.easeIn\" data-captionhidden=\"off\">Cassium viderit etiam magis habemus.</div>\r\n<!-- LAYER -->\r\n<div class=\"tp-caption rs-caption-3 sfb\" style=\"z-index: 6;\" data-x=\"center\" data-hoffset=\"0\" data-y=\"370\" data-speed=\"800\" data-start=\"3500\" data-easing=\"Power4.easeOut\" data-endspeed=\"300\" data-endeasing=\"Power1.easeIn\" data-captionhidden=\"off\"><span class=\"page-scroll\"><a class=\"btn-u btn-brd btn-brd-hover btn-u-light\" href=\"#A-propos\">Learn more</a></span> <span class=\"page-scroll\"><a class=\"btn-u btn-brd btn-brd-hover btn-u-light\" href=\"#Portfolio\">Examples</a></span></div>', 'filesbank/1424360124_bg3.jpg', '', 'gallery', '', '', '2016-03-04 14:28:34', '', '', '', 0, 0, 'null'),
(38, 1, 'Portfolio title', '', 13, '<h2>Portfolio</h2>\r\n<p>Nullo aruspicem interfecti eodem passim dedit ictibus quin pronuntiante est venenorum constrictus nullo dictos eodem.</p>', NULL, NULL, 'content', '', '', '2015-09-23 13:56:14', '', '', '', 0, 0, 'null'),
(39, 0, 'Specialist', '', 11, '', NULL, NULL, 'content', '', '', '2015-09-30 20:09:31', '', '', '', 0, 0, 'null'),
(40, 1, 'Services', '', 12, '<h2>Services</h2>\r\n<p>Tamquam quidam victitabant opulentae extorres puniti laribus claudebantur quoque aliis.</p>', NULL, NULL, 'content', '', '', '2017-07-19 16:59:31', '', '', '', 0, 0, 'null'),
(42, 3, 'About Parallax', '', 11, '<div class=\"parallax-quote-in\">\r\n<p>Circulo potentia omnia superpositum quoddam Adrastia veteres et atque numinis.</p>\r\n<small>- Foo -</small></div>', NULL, NULL, 'content', '', '', '2015-09-23 13:55:00', '', '', '', 0, 0, 'null'),
(43, 4, 'Contact', '', 14, '<p>2015 &copy; All Right Reserved. Powered by <a href=\"http://framework.zend.com/\" target=\"_blank\">Zend&reg;</a></p>', NULL, NULL, 'content', '', '', '2016-03-07 20:55:07', '', '', '', 0, 0, 'null'),
(44, 1, 'Contact title', '', 14, '<h2>Contact</h2>\r\n<p>Iconium iactitabant cuncta cladibus cuncta cladibus amphitheatrali raris perciti Namque.<br />Duplici generali facinorum.</p>', NULL, NULL, 'content', '', '', '2015-09-23 13:57:44', '', '', '', 0, 0, 'null'),
(45, 2, 'Contact info', '', 14, '<ul class=\"list-unstyled\">\r\n<li><em class=\"fa fa-home\">&nbsp;</em>Duplici generali facinorum</li>\r\n<li><em class=\"fa fa-phone\">&nbsp;</em>Duplici generali facinorum</li>\r\n<li><em class=\"fa fa-envelope\">&nbsp;</em> <a href=\"mailto:duplicigeneralifacinorum@foo.com?Subject=contactus\" target=\"_top\">duplicigeneralifacinorum@foo.com</a></li>\r\n<!--<li><em class=\"fa fa-globe\">&nbsp;</em><a href=\"\"></a></li>--></ul>', NULL, NULL, 'content', '', '', '2016-03-04 14:27:08', '', '', '', 0, 0, 'null'),
(46, 3, 'Portfolio portrait', '', 13, '<ul class=\"list-unstyled owl-ts-v1\">\r\n<li class=\"item\"><img class=\"square-x img-bordered\" src=\"filesbank/me.jpg\" alt=\"Romuald GEBLEUX\" />\r\n<div class=\"testimonials-v3-title\">\r\n<p>Romuald GEBLEUX</p>\r\n<div style=\"color: #777; font-size: 14px;\">Enthusiastic Digital Developper</div>\r\n</div>\r\n<p>Passionn&eacute;, curieux, impliqu&eacute;.<br />Je mets tout en oeuvre pour que vos projets soient une r&eacute;ussite</p>\r\n</li>\r\n</ul>', NULL, NULL, 'content', '', '', '2016-03-04 14:25:38', '', '', '', 0, 0, 'null'),
(50, 1, 'This cms is cool ;-)', 'Absolutely.', 19, '<h2><a href=\"#\">Why you should use my cms :-)</a></h2>\r\n<div class=\"blog-post-tags\">\r\n<ul class=\"list-unstyled list-inline blog-info\">\r\n<li>September 09, 2015</li>\r\n<li>Romuald GEBLEUX</li>\r\n<li><a href=\"#\">10000000 Comments</a></li>\r\n<li>Php, Zend, cms</li>\r\n</ul>\r\n</div>\r\n<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna.</p>\r\n<p>&nbsp;</p>\r\n<div class=\"tag-box tag-box-v2\">\r\n<p>Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet consectetur adipiscing elit. Fusce condimentum eleifend enim a feugiatt non libero consectetur adipiscing elit magna. Sed et quam lacus. Condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat.</p>\r\n</div>\r\n<p>Officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend.</p>\r\n<p>Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum</p>\r\n<p>&nbsp;</p>\r\n<blockquote>\r\n<p>Award winning cms ! ;-)</p>\r\n<small>Romuald GEBLEUX</small></blockquote>\r\n<p>Deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.</p>', 'filesbank/cms.jpg', '', 'blog', 'Romuald GEBLEUX', 'cms, php', '2015-07-14 22:00:00', '', '', '', 0, 0, 'null'),
(79, 1, 'Your comments', '', 30, '<p>Your wonderful comments !</p>', NULL, NULL, 'content', '', '', '2017-03-21 17:35:20', '', '', '', 0, 0, 'null'),
(84, 0, 'Send your comment', '', 32, '<h2><a href=\"blog_item_option1.html\">Why you should use this cms</a></h2>\r\n<div class=\"blog-post-tags\">\r\n<ul class=\"list-unstyled list-inline blog-info\">\r\n<li>September 09, 2015</li>\r\n<li>Romuald GEBLEUX</li>\r\n<li><a href=\"#\">0 Comments</a></li>\r\n<li>Technology, Education, Internet, Media</li>\r\n</ul>\r\n</div>\r\n<div style=\"font-size: 14px;\">\r\n<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna.</p>\r\n<br />\r\n<div class=\"tag-box tag-box-v2\">\r\n<p>Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet consectetur adipiscing elit. Fusce condimentum eleifend enim a feugiatt non libero consectetur adipiscing elit magna. Sed et quam lacus. Condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat.</p>\r\n</div>\r\n<p>Officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum eleifend.</p>\r\n<p>Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus. Fusce condimentum</p>\r\n<br />\r\n<blockquote>\r\n<p>Award winning digital agency. We bring a personal and effective approach to every project we work on, which is why.</p>\r\n<small>CEO Jack Bour</small></blockquote>\r\n<p>Deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio lorem ipsum dolor sit amet, mollitia animi, id est laborum et dolorum fug consectetur adipiscing elit. Ut non libero consectetur adipiscing elit magna. Sed et quam lacus. Fusce condimentum eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non libero magna. Sed et quam lacus.</p>\r\n<div>&nbsp;</div>\r\n</div>', '', '', 'blog', '', '', '2017-03-24 11:00:00', '', '', '', 0, 0, 'null'),
(81, 1, 'Contact us', '', 31, '', NULL, NULL, 'content', '', '', '2017-03-21 08:13:33', '', '', '', 0, 0, 'null'),
(82, 1, 'Information contact update', '', 33, '', NULL, NULL, 'content', '', '', '2017-03-14 17:25:48', '', '', '', 0, 0, 'null'),
(83, 2, 'Body text', 'Lorem ipsum', 34, '<p>Bla bla bla.</p>\r\n<p>Lorem ipsum.</p>', NULL, NULL, 'content', '', '', '2017-03-21 21:50:32', '', '', '', 0, 0, 'null'),
(95, 1, 'vdfbgfhb', 'hfdghf', 17, '<p>GSTGTFDH</p>', NULL, NULL, 'content', '', '', '2018-08-21 17:14:27', '', '', '', 0, 0, 'null'),
(101, -1, 'test', 'test', 14, '<p>test</p>', NULL, NULL, 'mapcontent', '', '', '2018-09-06 06:40:17', '', '', '', 0, 0, '[{\"latitude\": \"90.00\", \"longitude\": \"180\", \"description\": \"none\"}, {\"latitude\": \"45.1234567\", \"longitude\": \"-90.0986665\", \"description\": \"nothing\"}]');

DROP TABLE IF EXISTS `fichiers`;
CREATE TABLE IF NOT EXISTS `fichiers` (
  `fichiers_id` int(11) NOT NULL AUTO_INCREMENT,
  `fichiers_chemin` varchar(384) COLLATE utf8_bin DEFAULT NULL,
  `fichiers_nom` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `fichiers_type` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `fichiers_libelle` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `fichiers_meta` text COLLATE utf8_bin NOT NULL,
  `fichiers_thumbnailpath` varchar(384) COLLATE utf8_bin NOT NULL,
  `fichiers_thumbnail` varchar(128) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`fichiers_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `fichiers` (`fichiers_id`, `fichiers_chemin`, `fichiers_nom`, `fichiers_type`, `fichiers_libelle`, `fichiers_meta`, `fichiers_thumbnailpath`, `fichiers_thumbnail`) VALUES
(1, 'filesbank/', 'bbkiq7x.png', 'png', 'test dfgdg', 'test ghj', 'filesbank/', '1522304702_BBKiq7X.png');

DROP TABLE IF EXISTS `filesupload`;
CREATE TABLE IF NOT EXISTS `filesupload` (
  `filesupload_id` int(11) NOT NULL AUTO_INCREMENT,
  `filesupload_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `filesupload_path` text COLLATE utf8_bin NOT NULL,
  `filesupload_type` varchar(32) COLLATE utf8_bin NOT NULL,
  `filesupload_comment` text COLLATE utf8_bin,
  `filesupload_status` enum('waiting','validated','refused','obsolete') COLLATE utf8_bin NOT NULL DEFAULT 'waiting',
  `filesupload_thumbnail` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_thumbnailpath` text COLLATE utf8_bin,
  `filesupload_author` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_userid` varchar(384) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_email` varchar(384) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `filesupload_lat` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `filesupload_lng` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`filesupload_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `filesupload` (`filesupload_id`, `filesupload_name`, `filesupload_path`, `filesupload_type`, `filesupload_comment`, `filesupload_status`, `filesupload_thumbnail`, `filesupload_thumbnailpath`, `filesupload_author`, `filesupload_userid`, `filesupload_email`, `filesupload_date`, `filesupload_lat`, `filesupload_lng`) VALUES
(46, '1522171336_cv_romuald_gebleux_2017_fullstack_(1).doc', 'uploadedfilesbank/', 'doc', 'test ok', 'refused', 'word.png', 'img/', 'First Name 1 Last Name 2', 'anit_private@anit.org', 'anit_private@anit.org', '2018-03-27 15:22:15', '0', '0'),
(47, 'cv_romuald_gebleux_2017_fullstack_(1).doc', 'uploadedfilesbank/', 'doc', 'test word toto', 'obsolete', 'word.png', 'img/', 'First Name 1 Last Name 2', 'anit_private@anit.org', 'anit_private@anit.org', '2018-03-27 15:22:16', '0', '0'),
(45, '1522171335_cv_romuald_gebleux_2017_fullstack_(1).doc', 'uploadedfilesbank/', 'doc', 'test', 'refused', 'word.png', 'img/', 'First Name 1 Last Name 2', 'anit_private@anit.org', 'anit_private@anit.org', '2018-03-27 15:22:14', '0', '0'),
(44, 'cv_romuald_gebleux_2017_fullstack_(1).doc', 'uploadedfilesbank/', 'doc', 'test toto', 'obsolete', 'word.png', 'img/', 'First Name 1 Last Name 2', 'anit_private@anit.org', 'anit_private@anit.org', '2018-03-27 15:17:43', '0', '0'),
(43, 'bbkiq7x.png', 'uploadedfilesbank/', 'png', 'test', 'refused', 'thumbBBKiq7X.png', 'uploadedfilesbank/thumbnails/', 'First Name 1 Last Name 2', 'anit_private@anit.org', 'anit_private@anit.org', '2018-03-27 15:17:15', '0', '0');

DROP TABLE IF EXISTS `linktocontenu`;
CREATE TABLE IF NOT EXISTS `linktocontenu` (
  `linktocontenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `contenu_id` int(11) NOT NULL,
  `rang` int(11) DEFAULT NULL,
  `titre` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `soustitre` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `sousrubriques_id` int(11) NOT NULL,
  `contenuhtml` text COLLATE utf8_bin,
  `image` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `image2` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `type` enum('linktocontenu') COLLATE utf8_bin NOT NULL,
  `linktosousrubrique_id` int(11) NOT NULL,
  `linktorubrique_id` int(11) NOT NULL,
  `contenu_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`linktocontenu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `linktocontenu` (`linktocontenu_id`, `contenu_id`, `rang`, `titre`, `soustitre`, `sousrubriques_id`, `contenuhtml`, `image`, `image2`, `type`, `linktosousrubrique_id`, `linktorubrique_id`, `contenu_date`) VALUES
(4, 50, 1, 'CMS', 'I mean let\'s try it. Go !', 19, '<div>Why you should use my cms :-) September 09, 2015 Romuald GEBLEUX 10000000 Comments Php, Zend, cms At vero eos et accusamus et iusto odio dignissimo...</div>', 'filesbank/cms.jpg', '', 'linktocontenu', 29, 14, '2018-06-11 16:39:43');

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_msg` text COLLATE utf8_bin NOT NULL,
  `message_row1` varchar(256) COLLATE utf8_bin NOT NULL,
  `message_row2` varchar(256) COLLATE utf8_bin NOT NULL,
  `message_row3` varchar(256) COLLATE utf8_bin NOT NULL,
  `message_row4` varchar(256) COLLATE utf8_bin NOT NULL,
  `message_position` int(11) NOT NULL DEFAULT '0',
  `message_type` varchar(128) COLLATE utf8_bin NOT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `meta`;
CREATE TABLE IF NOT EXISTS `meta` (
  `meta_id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(256) CHARACTER SET latin1 NOT NULL,
  `meta_value` varchar(512) CHARACTER SET latin1 NOT NULL,
  `rubrique_id` int(11) NOT NULL,
  PRIMARY KEY (`meta_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `privatespacelogin`;
CREATE TABLE IF NOT EXISTS `privatespacelogin` (
  `privatespacelogin_id` int(11) NOT NULL AUTO_INCREMENT,
  `space_id_fk` int(11) NOT NULL,
  `privatespacelogin_validate` tinyint(1) NOT NULL DEFAULT '0',
  `privatespacelogin_pwd` varchar(255) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_email` varchar(512) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_firstname` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_lastname` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_company` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_streetnumber` varchar(10) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_streetline_1` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_streetline_2` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_streetline_3` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_zipcode` varchar(15) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_city` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_homephone` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_mobilephone` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_website` varchar(256) COLLATE utf8_bin NOT NULL,
  `privatespacelogin_lastconn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`privatespacelogin_id`),
  KEY `privatespacelogin_email` (`privatespacelogin_email`(333)),
  KEY `privatespacelogin_pwd` (`privatespacelogin_pwd`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `privatespacelogin` (`privatespacelogin_id`, `space_id_fk`, `privatespacelogin_validate`, `privatespacelogin_pwd`, `privatespacelogin_email`, `privatespacelogin_firstname`, `privatespacelogin_lastname`, `privatespacelogin_company`, `privatespacelogin_streetnumber`, `privatespacelogin_streetline_1`, `privatespacelogin_streetline_2`, `privatespacelogin_streetline_3`, `privatespacelogin_zipcode`, `privatespacelogin_city`, `privatespacelogin_homephone`, `privatespacelogin_mobilephone`, `privatespacelogin_website`, `privatespacelogin_lastconn`) VALUES
(1, 3, 0, 'ce26be1f9903f7fbcac01cc28acb63438a4c4d9728a4de9e3606736c4440b4a3824444bf8f154889f0cb880b0c5a1f8c7bac0dd37acb5fa20cc920c7e5fc147b', 'anit_private@anit.org', 'First Name 1', 'Last Name 2', 'my company is nÂ°1', '1', 'Test street 1', 'Test street 2', 'Test street 3', 'H1N2A5', 'My Town', '0010123456789', '001012345689', 'mywebsite.com', '2018-03-27 17:12:40');

DROP TABLE IF EXISTS `rubrique`;
CREATE TABLE IF NOT EXISTS `rubrique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(128) COLLATE utf8_bin NOT NULL,
  `rang` int(11) NOT NULL,
  `scope` enum('public','private') COLLATE utf8_bin NOT NULL DEFAULT 'public',
  `spaceId` int(11) NOT NULL DEFAULT '-1',
  `filename` varchar(128) COLLATE utf8_bin NOT NULL,
  `contactForm` tinyint(1) NOT NULL DEFAULT '0',
  `messageForm` tinyint(1) NOT NULL DEFAULT '0',
  `updateForm` tinyint(4) NOT NULL DEFAULT '0',
  `fileuploadForm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `libelle` (`libelle`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `rubrique` (`id`, `libelle`, `rang`, `scope`, `spaceId`, `filename`, `contactForm`, `messageForm`, `updateForm`, `fileuploadForm`) VALUES
(14, 'One Page', 1, 'public', -1, 'index.phtml', 0, 0, 0, 0),
(15, 'Blog', 2, 'public', -1, 'blog.phtml', 0, 1, 0, 0),
(42, 'first page for testing the extranet', 1, 'private', 3, 'test_private_site.phtml', 1, 0, 0, 0),
(43, 'Update contact information', 2, 'private', 3, 'updatecontactinformation.phtml', 0, 0, 1, 0),
(44, 'Private Blog 2', 3, 'private', 3, 'test_private_blog.phtml', 0, 1, 0, 0),
(46, 'extranet upload file test', 4, 'private', 3, 'test_extranet_upload_file.phtml', 0, 0, 0, 1);

DROP TABLE IF EXISTS `sousrubrique`;
CREATE TABLE IF NOT EXISTS `sousrubrique` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `rang` int(11) NOT NULL,
  `rubriques_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `sousrubrique` (`id`, `libelle`, `rang`, `rubriques_id`) VALUES
(11, 'A propos', 2, 14),
(12, 'Services', 3, 14),
(13, 'Portfolio', 5, 14),
(14, 'Contact', 6, 14),
(17, 'Home', 1, 14),
(19, 'Articles', 1, 15),
(29, 'Articles', 4, 14),
(30, 'comments', 1, 44),
(31, 'Contact us', 2, 42),
(32, 'Send a comment', 2, 44),
(33, 'form for updating contact information', 1, 43),
(34, 'Body Text Section', 1, 42),
(35, 'unique section of the page', 1, 46),
(38, 'testRefacto2', 1, 48);

DROP TABLE IF EXISTS `space`;
CREATE TABLE IF NOT EXISTS `space` (
  `space_id` int(11) NOT NULL AUTO_INCREMENT,
  `space_name` varchar(255) COLLATE utf8_bin DEFAULT '',
  `space_token` varchar(512) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`space_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `space` (`space_id`, `space_name`, `space_token`) VALUES
(3, 'extranet test', '02515c361748ad2dc283acf26ca832b1f5a04bfdfcac083360aeaca4047574f072b4a10c6da5bd8cdb4ec91c5f40187b964e6e3ddf6246353d851ff753e59ce4');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
