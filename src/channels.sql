CREATE TABLE `channels` (
  `cid` int(11) NOT NULL auto_increment,
  `emptySince` timestamp NOT NULL default '0000-00-00 00:00:00',
  `lastChecked` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `numEmptyChecks` int(11) default NULL,
  `channelName` varchar(255) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8