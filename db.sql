CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(10) unsigned NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `add_name` varchar(255) NOT NULL,
  `add_email` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_changed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

ALTER TABLE `reviews`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;