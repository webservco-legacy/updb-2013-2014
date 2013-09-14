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

SET FOREIGN_KEY_CHECKS=1;
