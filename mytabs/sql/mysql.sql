CREATE TABLE `mytabs_page` (
  `pageid` int(10) unsigned NOT NULL auto_increment,
  `pagetitle` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM;

CREATE TABLE `mytabs_tab` (
  `tabid` int(10) unsigned NOT NULL auto_increment,
  `tabpageid` int(10) unsigned NOT NULL default '0',
  `tabtitle` varchar(255) NOT NULL DEFAULT '',
  `tablink` varchar(255) NOT NULL DEFAULT '',
  `tabrev` varchar(255) NOT NULL DEFAULT '',
  `tabpriority` int(10) unsigned NOT NULL default '0',
  `tabshowalways` enum('yes','no','time') NOT NULL default 'yes',
  `tabfromdate` int unsigned NOT NULL default 0,
  `tabtodate` int unsigned NOT NULL default 0,
  `tabnote` varchar(255) NOT NULL default '',
  `tabgroups` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`tabid`)
) ENGINE=MyISAM;

CREATE TABLE `mytabs_pageblock` (
  `pageblockid` int(10) unsigned NOT NULL auto_increment,
  `blockid` int(10) unsigned NOT NULL default '0',
  `tabid` int(10) unsigned NOT NULL default '1',
  `pageid` int(10) unsigned NOT NULL default '1',
  `title` varchar(255) NOT NULL DEFAULT '',
  `options` longtext NOT NULL,
  `priority` int(10) unsigned NOT NULL default '0',
  `showalways` enum('yes','no','time') NOT NULL default 'yes',
  `placement` enum('left','center','right') NOT NULL default 'center',
  `fromdate` int unsigned NOT NULL default 0,
  `todate` int unsigned NOT NULL default 0,
  `note` varchar(255) NOT NULL default '',
  `pbcachetime` int NOT NULL default 0,
  `cachebyurl` tinyint NOT NULL default 0,
  `groups` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY  (`pageblockid`),
  KEY `page` (`pageid`, `tabid`, `blockid`, `priority`),
  KEY `showalways` (`showalways`)
) ENGINE=MyISAM;

