#
# Table structure for table `xdir_broken`
#

CREATE TABLE `xdir_broken` (
  `reportid` INT(5)           NOT NULL AUTO_INCREMENT,
  `lid`      INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `sender`   INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `ip`       VARCHAR(20)      NOT NULL DEFAULT '',
  PRIMARY KEY (`reportid`),
  KEY `lid` (`lid`),
  KEY `sender` (`sender`),
  KEY `ip` (`ip`)
)
  ENGINE = MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xdir_cat`
#

CREATE TABLE `xdir_cat` (
  `cid`    INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid`    INT(5) UNSIGNED NOT NULL DEFAULT '0',
  `title`  VARCHAR(50)     NOT NULL DEFAULT '',
  `imgurl` VARCHAR(150)    NOT NULL DEFAULT '',
  PRIMARY KEY (`cid`),
  KEY `pid` (`pid`)
)
  ENGINE = MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xdir_links`
# EVU CODE - changed state to varchar(80) from char 2

CREATE TABLE `xdir_links` (
  `lid`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid`         INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  `cidalt1`     INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  `cidalt2`     INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  `cidalt3`     INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  `cidalt4`     INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  `title`       VARCHAR(100)     NOT NULL DEFAULT '',
  `address`     VARCHAR(200)     NOT NULL DEFAULT '',
  `address2`    VARCHAR(100)     NOT NULL DEFAULT '',
  `city`        VARCHAR(80)      NOT NULL DEFAULT '',
  `state`       VARCHAR(80)      NOT NULL DEFAULT '',
  `zip`         VARCHAR(15)      NOT NULL DEFAULT '',
  `country`     VARCHAR(100)     NOT NULL DEFAULT '',
  `mfhrs`       VARCHAR(20)      NOT NULL DEFAULT '',
  `sathrs`      VARCHAR(20)      NOT NULL DEFAULT '',
  `sunhrs`      VARCHAR(20)      NOT NULL DEFAULT '',
  `phone`       VARCHAR(35)      NOT NULL DEFAULT '',
  `fax`         VARCHAR(35)      NOT NULL DEFAULT '',
  `mobile`      VARCHAR(35)      NOT NULL DEFAULT '',
  `home`        VARCHAR(35)      NOT NULL DEFAULT '',
  `tollfree`    VARCHAR(35)      NOT NULL DEFAULT '',
  `email`       VARCHAR(100)     NOT NULL DEFAULT '',
  `url`         VARCHAR(250)     NOT NULL DEFAULT '',
  `admcontname` VARCHAR(35)      NOT NULL DEFAULT '',
  `admcontnumb` VARCHAR(35)      NOT NULL DEFAULT '',
  `logourl`     VARCHAR(60)      NOT NULL DEFAULT '',
  `submitter`   INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `status`      TINYINT(2)       NOT NULL DEFAULT '0',
  `date`        INT(10)          NOT NULL DEFAULT '0',
  `hits`        INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `rating`      DOUBLE(6, 4)     NOT NULL DEFAULT '0.0000',
  `votes`       INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `comments`    INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `premium`     TINYINT(2)       NOT NULL DEFAULT '0',
  PRIMARY KEY (`lid`),
  KEY `cid` (`cid`),
  KEY `status` (`status`),
  KEY `title` (`title`(40))
)
  ENGINE = MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xdir_mod`, holding link modifications to be reviewed
#

CREATE TABLE `xdir_mod` (
  `requestid`       INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lid`             INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `cid`             INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  `title`           VARCHAR(100)     NOT NULL DEFAULT '',
  `address`         VARCHAR(100)     NOT NULL DEFAULT '',
  `address2`        VARCHAR(100)     NOT NULL DEFAULT '',
  `city`            VARCHAR(40)      NOT NULL DEFAULT '',
  `state`           CHAR(2)          NOT NULL DEFAULT '',
  `zip`             VARCHAR(20)      NOT NULL DEFAULT '',
  `country`         VARCHAR(100)     NOT NULL DEFAULT '',
  `mfhrs`           VARCHAR(15)      NOT NULL DEFAULT '',
  `sathrs`          VARCHAR(15)      NOT NULL DEFAULT '',
  `sunhrs`          VARCHAR(15)      NOT NULL DEFAULT '',
  `phone`           VARCHAR(35)      NOT NULL DEFAULT '',
  `fax`             VARCHAR(35)      NOT NULL DEFAULT '',
  `mobile`          VARCHAR(35)      NOT NULL DEFAULT '',
  `home`            VARCHAR(35)      NOT NULL DEFAULT '',
  `tollfree`        VARCHAR(35)      NOT NULL DEFAULT '',
  `email`           VARCHAR(100)     NOT NULL DEFAULT '',
  `url`             VARCHAR(250)     NOT NULL DEFAULT '',
  `admcontname`     VARCHAR(35)      NOT NULL DEFAULT '',
  `admcontnumb`     VARCHAR(35)      NOT NULL DEFAULT '',
  `logourl`         VARCHAR(150)     NOT NULL DEFAULT '',
  `premium`         CHAR(2)          NOT NULL DEFAULT '0',
  `description`     TEXT             NOT NULL,
  `modifysubmitter` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`requestid`)
)
  ENGINE = MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xdir_text`
#

CREATE TABLE `xdir_text` (
  `lid`         INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `description` TEXT             NOT NULL,
  KEY `lid` (`lid`)
)
  ENGINE = MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xdir_votedata`
#

CREATE TABLE `xdir_votedata` (
  `ratingid`        INT(11) UNSIGNED    NOT NULL AUTO_INCREMENT,
  `lid`             INT(11) UNSIGNED    NOT NULL DEFAULT '0',
  `ratinguser`      INT(11) UNSIGNED    NOT NULL DEFAULT '0',
  `rating`          TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `ratinghostname`  VARCHAR(60)         NOT NULL DEFAULT '',
  `ratingtimestamp` INT(10)             NOT NULL DEFAULT '0',
  PRIMARY KEY (`ratingid`),
  KEY `ratinguser` (`ratinguser`),
  KEY `ratinghostname` (`ratinghostname`)
)
  ENGINE = MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xdir_coupon`
#

CREATE TABLE `xdir_coupon` (
  `couponid`    INT(12) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lid`         INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `description` TEXT             NOT NULL,
  `image`       TEXT             NOT NULL,
  `publish`     INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `expire`      INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `heading`     TEXT             NOT NULL,
  `lbr`         INT(1)           NOT NULL DEFAULT '0',
  `counter`     INT(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`couponid`)
)
  ENGINE = MyISAM;
