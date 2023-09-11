CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `data` text NOT NULL,
  `create_or_edit_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `redirect` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `create_or_edit_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `license` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `app_id` text NOT NULL,
  `owner_id` text NOT NULL,
  `license` text NOT NULL,
  `eval` text NOT NULL,
  `create_or_edit_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `update` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `version` text NOT NULL,
  `news` text NOT NULL,
  `download` text NOT NULL,
  `create_or_edit_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `token` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `redirect`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `license`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `update`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

ALTER TABLE `redirect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

ALTER TABLE `license`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

ALTER TABLE `update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;