SET FOREIGN_KEY_CHECKS=0;

/* PUB TYPES */

TRUNCATE TABLE up_pub_types_main;
INSERT INTO up_pub_types_main (pub_type_id) VALUES 
(1), (2), (3);

TRUNCATE TABLE up_pub_types_details;
INSERT INTO up_pub_types_details (pub_type_id, pub_type_title) VALUES 
(1, 'fanzine'), (2, 'newsletter'), (3, 'book');

/* PUB FORMATS */

TRUNCATE TABLE up_pub_formats_main;
INSERT INTO up_pub_formats_main (pub_format_id, pub_format_title) VALUES 
(1, 'A5'), (2, 'A4'), (3, 'A3');

/* PUB CONTENT TYPES */

TRUNCATE TABLE up_pub_content_types_main;
INSERT INTO up_pub_content_types_main (pub_content_type_id, contains_data) VALUES
(1, 1), (2, 1), (3, 1), (4, 1), (5, 0), (6, 0), (7, 0), (8, 0), (9, 0);

TRUNCATE TABLE up_pub_content_types_details;
INSERT INTO up_pub_content_types_details (pub_content_type_id, i18n_locale, pub_content_type_title) VALUES
(1, 'en_US', 'Articles'), (2, 'en_US', 'Bands'), (3, 'en_US', 'Labels / Distros'), (4, 'en_US', 'Scene Reports')
,(5, 'en_US', 'Reviews'), (6, 'en_US', 'Ads'), (7, 'en_US', 'Poetry'), (8, 'en_US', 'Art'), (9, 'en_US', 'Columns')
,(1, 'ro_RO.UTF8', 'Articole'), (2, 'ro_RO.UTF8', 'Formații'), (3, 'ro_RO.UTF8', 'Labels / Distros'), (4, 'ro_RO.UTF8', 'Scene Reports')
,(5, 'ro_RO.UTF8', 'Reviews'), (6, 'ro_RO.UTF8', 'Ads'), (7, 'ro_RO.UTF8', 'Poetry'), (8, 'ro_RO.UTF8', 'Art'), (9, 'ro_RO.UTF8', 'Columns');

/* ISSUES */

TRUNCATE TABLE up_pub_issues_main;
TRUNCATE TABLE up_pub_issues_details;
TRUNCATE TABLE up_pub_issues_content;


SET FOREIGN_KEY_CHECKS=1;
