# Alter Table structure for table `xdir_links`
#

ALTER TABLE `xdir_links`
  ADD `mfhrs` VARCHAR(20) NOT NULL DEFAULT ''
  AFTER 'country',
  ADD `sathrs` VARCHAR(20) NOT NULL DEFAULT ''
  AFTER 'mfhrs',
  ADD `sunhrs` VARCHAR(20) NOT NULL DEFAULT ''
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
  ADD `mfhrs` VARCHAR(20) NOT NULL DEFAULT ''
  AFTER 'country',
  ADD `sathrs` VARCHAR(20) NOT NULL DEFAULT ''
  AFTER 'mfhrs',
  ADD `sunhrs` VARCHAR(20) NOT NULL DEFAULT ''
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
