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
) TYPE = MyISAM;

# --------------------------------------------------------

#
# Alter Table structure for table `xdir_links`
#

ALTER TABLE `xdir_links`
  ADD `cidalt1` INT(5) UNSIGNED NOT NULL
  AFTER `cid`,
  ADD `cidalt2` INT(5) UNSIGNED NOT NULL
  AFTER `cidalt1`,
  ADD `cidalt3` INT(5) UNSIGNED NOT NULL
  AFTER `cidalt2`,
  ADD `cidalt4` INT(5) UNSIGNED NOT NULL
  AFTER `cidalt3`,
  ADD `mfhrs` VARCHAR(15) NOT NULL DEFAULT ''
  AFTER 'country',
  ADD `sathrs` VARCHAR(15) NOT NULL DEFAULT ''
  AFTER 'mfhrs',
  ADD `sunhrs` VARCHAR(15) NOT NULL DEFAULT ''
  AFTER 'sathrs',
  ADD `mobile` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'fax',
  ADD `home` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'mobile',
  ADD `tollfree` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'home',
  ADD `admcontname` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'url',
  ADD `admcontnumb` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'admcontname';

# --------------------------------------------------------

#
# Alter Table structure for table `xdir_mod`
#

ALTER TABLE `xdir_mod`
  ADD `mfhrs` VARCHAR(15) NOT NULL DEFAULT ''
  AFTER 'country',
  ADD `sathrs` VARCHAR(15) NOT NULL DEFAULT ''
  AFTER 'mfhrs',
  ADD `sunhrs` VARCHAR(15) NOT NULL DEFAULT ''
  AFTER 'sathrs',
  ADD `mobile` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'fax',
  ADD `home` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'mobile',
  ADD `tollfree` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'home',
  ADD `admcontname` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'url',
  ADD `admcontnumb` VARCHAR(35) NOT NULL DEFAULT ''
  AFTER 'admcontname';
