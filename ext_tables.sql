/**
 * redirects
 */
CREATE TABLE tx_marketing_redirect (
	uid int(11) NOT NULL auto_increment,
	createdon int(11) DEFAULT '0' NOT NULL,
	modifiedon int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL
	urlhash int(11) DEFAULT '0' NOT NULL,
	url text NOT NULL,
	destination text NOT NULL,
	lasthiton int(11) DEFAULT '0',
	numberofhits int(11) DEFAULT '0',
	lasthttpreferer text,
	httpstatuscode int(11) DEFAULT '0',
	domainrecord int(11) DEFAULT '0',

	PRIMARY KEY (uid),
	UNIQUE KEY sel01 (urlhash,domainrecord)
);
