#
# Table structure for table 'tx_casatimeline_domain_model_event'
#
CREATE TABLE tx_casatimeline_domain_model_event (
	eventstartdate int(11) DEFAULT '0' NULL,
	titel varchar(255) DEFAULT '' NOT NULL,
	description text,
	image int(11) unsigned NOT NULL default '0',
	tags int(11) unsigned DEFAULT '0' NOT NULL,
	images int(11) unsigned DEFAULT '0' NOT NULL,
	persons int(11) unsigned DEFAULT '0' NOT NULL,
	share smallint(5) unsigned DEFAULT '0' NOT NULL,
	slug varchar(2048),

);

#
# Table structure for table 'tx_casatimeline_domain_model_tag'
#
CREATE TABLE tx_casatimeline_domain_model_tag (

	name varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_casatimeline_event_tag_mm'
#
CREATE TABLE tx_casatimeline_event_tag_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_casatimeline_event_fe_users_mm'
#
CREATE TABLE tx_casatimeline_event_fe_users_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local,uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)

);
