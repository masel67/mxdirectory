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
  AFTER `cidalt3`;
