CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `activity` text NOT NULL,
  `social_web` varchar(255) NOT NULL,
  `social_id` varchar(255) NOT NULL,
  `social_username` varchar(255) NOT NULL,
  `social_url` varchar(255) NOT NULL,
  `social_avatar_url` varchar(255) NOT NULL,
  `devhouse_edition` int(11) unsigned NOT NULL default 0,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;