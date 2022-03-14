-- membuat table ticket_list 

CREATE TABLE `ticket_list` (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(20) NOT NULL,
  tittle varchar(100) NOT NULL,
  priority varchar(10) NOT NULL,
  message varchar(200) NOT NULL,
  c_date timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
  m_date timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- membuat table users 

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

-- membuat table komentar

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL AUTO_INCREMENT,
  `name_komentar` varchar(50) NOT NULL,
  `message_komentar` text NOT NULL,
  `created_date_komentar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_komentar`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8