

SET @old = 'http://centroinfinito.app';
SET @new = 'http://centroinfinito.test';

UPDATE blpack_options SET option_value = replace(option_value,  'http://centroinfinito.app' ,  'http://centroinfinito.test') WHERE option_name = 'home' OR option_name = 'siteurl';

UPDATE blpack_posts SET guid = replace(guid,  'http://centroinfinito.app' , 'http://centroinfinito.test');

UPDATE blpack_posts SET post_content = replace(post_content,  'http://centroinfinito.app' ,  'http://centroinfinito.test');

UPDATE blpack_postmeta SET meta_value = replace(meta_value, 'http://centroinfinito.app' , 'http://centroinfinito.test');