CREATE TABLE `mytabs_page` (
  `pageid`    INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pagetitle` VARCHAR(255)     NOT NULL DEFAULT '',
  PRIMARY KEY (`pageid`)
)
  ENGINE = MyISAM;

CREATE TABLE `mytabs_tab` (
  `tabid`         INT(10) UNSIGNED           NOT NULL AUTO_INCREMENT,
  `tabpageid`     INT(10) UNSIGNED           NOT NULL DEFAULT '0',
  `tabtitle`      VARCHAR(255)               NOT NULL DEFAULT '',
  `tablink`       VARCHAR(255)               NOT NULL DEFAULT '',
  `tabrev`        VARCHAR(255)               NOT NULL DEFAULT '',
  `tabpriority`   INT(10) UNSIGNED           NOT NULL DEFAULT '0',
  `tabshowalways` ENUM ('yes', 'no', 'time') NOT NULL DEFAULT 'yes',
  `tabfromdate`   INT UNSIGNED               NOT NULL DEFAULT 0,
  `tabtodate`     INT UNSIGNED               NOT NULL DEFAULT 0,
  `tabnote`       VARCHAR(255)               NOT NULL DEFAULT '',
  `tabgroups`     VARCHAR(255)               NOT NULL DEFAULT '',
  PRIMARY KEY (`tabid`)
)
  ENGINE = MyISAM;

CREATE TABLE `mytabs_pageblock` (
  `pageblockid` INT(10) UNSIGNED                 NOT NULL AUTO_INCREMENT,
  `blockid`     INT(10) UNSIGNED                 NOT NULL DEFAULT '0',
  `tabid`       INT(10) UNSIGNED                 NOT NULL DEFAULT '1',
  `pageid`      INT(10) UNSIGNED                 NOT NULL DEFAULT '1',
  `title`       VARCHAR(255)                     NOT NULL DEFAULT '',
  `options`     LONGTEXT                         NOT NULL,
  `priority`    INT(10) UNSIGNED                 NOT NULL DEFAULT '0',
  `showalways`  ENUM ('yes', 'no', 'time')       NOT NULL DEFAULT 'yes',
  `placement`   ENUM ('left', 'center', 'right') NOT NULL DEFAULT 'center',
  `fromdate`    INT UNSIGNED                     NOT NULL DEFAULT 0,
  `todate`      INT UNSIGNED                     NOT NULL DEFAULT 0,
  `note`        VARCHAR(255)                     NOT NULL DEFAULT '',
  `pbcachetime` INT                              NOT NULL DEFAULT 0,
  `cachebyurl`  TINYINT                          NOT NULL DEFAULT 0,
  `groups`      VARCHAR(255)                     NOT NULL DEFAULT '',
  PRIMARY KEY (`pageblockid`),
  KEY `page` (`pageid`, `tabid`, `blockid`, `priority`),
  KEY `showalways` (`showalways`)
)
  ENGINE = MyISAM;

