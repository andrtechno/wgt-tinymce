<?php

// General
$moxieManagerConfig['general.license'] = 'YOUR-LICENSE-KEY';
$moxieManagerConfig['general.hidden_tools'] = '';
$moxieManagerConfig['general.disabled_tools'] = '';
$moxieManagerConfig['general.plugins'] = 'Favorites,AutoRename';
$moxieManagerConfig['general.demo'] = false;
$moxieManagerConfig['general.debug'] = false;
$moxieManagerConfig['general.language'] = 'ru';
$moxieManagerConfig['general.temp_dir'] = '';
$moxieManagerConfig['general.allow_override'] = 'hidden_tools,disabled_tools';

// Filesystem
$moxieManagerConfig['filesystem.rootpath'] = $_SERVER["DOCUMENT_ROOT"] . "/web/uploads";
$moxieManagerConfig['filesystem.include_directory_pattern'] = '';
$moxieManagerConfig['filesystem.exclude_directory_pattern'] = '/^thumbs$|^upgrade$|^language$|^users$/i';
$moxieManagerConfig['filesystem.include_file_pattern'] = '';
$moxieManagerConfig['filesystem.exclude_file_pattern'] = '';
$moxieManagerConfig['filesystem.extensions'] = '*';
$moxieManagerConfig['filesystem.readable'] = true;
$moxieManagerConfig['filesystem.writable'] = true;
$moxieManagerConfig['filesystem.allow_override'] = '*';

// Createdir
$moxieManagerConfig['createdir.templates'] = 'Image folder=/files/templates/directory';
$moxieManagerConfig['createdir.include_directory_pattern'] = '';
$moxieManagerConfig['createdir.exclude_directory_pattern'] = '';
$moxieManagerConfig['createdir.allow_override'] = '*';

// Createdoc
$moxieManagerConfig['createdoc.templates'] = 'Index page=/files/templates/document.htm,Normal page=/files/templates/another_document.htm';
$moxieManagerConfig['createdoc.fields'] = 'Document title=title';
$moxieManagerConfig['createdoc.include_file_pattern'] = '';
$moxieManagerConfig['createdoc.exclude_file_pattern'] = '';
$moxieManagerConfig['createdoc.extensions'] = '*';
$moxieManagerConfig['createdoc.allow_override'] = '*';

// Upload
$moxieManagerConfig['upload.include_file_pattern'] = '';
$moxieManagerConfig['upload.exclude_file_pattern'] = '';
$moxieManagerConfig['upload.extensions'] = '*';
$moxieManagerConfig['upload.maxsize'] = ini_get('upload_max_filesize');
$moxieManagerConfig['upload.overwrite'] = false;
$moxieManagerConfig['upload.autoresize'] = true;
$moxieManagerConfig['upload.autoresize_jpeg_quality'] = 100;
$moxieManagerConfig['upload.max_width'] = 1200;
$moxieManagerConfig['upload.max_height'] = 1200;
$moxieManagerConfig['upload.chunk_size'] = '5mb';
$moxieManagerConfig['upload.allow_override'] = '*';

// Rename
$moxieManagerConfig['rename.include_file_pattern'] = '';
$moxieManagerConfig['rename.exclude_file_pattern'] = '';
$moxieManagerConfig['rename.include_directory_pattern'] = '';
$moxieManagerConfig['rename.exclude_directory_pattern'] = '';
$moxieManagerConfig['rename.extensions'] = '*';
$moxieManagerConfig['rename.allow_override'] = '*';

// Edit
$moxieManagerConfig['edit.include_file_pattern'] = '';
$moxieManagerConfig['edit.exclude_file_pattern'] = '';
$moxieManagerConfig['edit.extensions'] = 'jpg,jpeg,png,gif,html,htm,txt';
$moxieManagerConfig['edit.jpeg_quality'] = 100;
$moxieManagerConfig['edit.allow_override'] = '*';

// View
$moxieManagerConfig['view.include_file_pattern'] = '';
$moxieManagerConfig['view.exclude_file_pattern'] = '';
$moxieManagerConfig['view.extensions'] = '*';
$moxieManagerConfig['view.allow_override'] = '*';

// Download
$moxieManagerConfig['download.include_file_pattern'] = '';
$moxieManagerConfig['download.exclude_file_pattern'] = '';
$moxieManagerConfig['download.extensions'] = '*';
$moxieManagerConfig['download.allow_override'] = '*';

// Thumbnail
$moxieManagerConfig['thumbnail.enabled'] = false;
$moxieManagerConfig['thumbnail.auto_generate'] = true;
$moxieManagerConfig['thumbnail.use_exif'] = true;
$moxieManagerConfig['thumbnail.width'] = 150;
$moxieManagerConfig['thumbnail.height'] = 150;
$moxieManagerConfig['thumbnail.folder'] = 'upload_thumbs';
$moxieManagerConfig['thumbnail.prefix'] = 'thumb_';
$moxieManagerConfig['thumbnail.delete'] = true;
$moxieManagerConfig['thumbnail.jpeg_quality'] = 100;
$moxieManagerConfig['thumbnail.allow_override'] = '*';

// Authentication
$moxieManagerConfig['authenticator'] = 'BasicAuthenticator';
$moxieManagerConfig['basicauthenticator.users'] = array(
    array(
        "username" => "user",
        "password" => "pwd",
        "email" => "info@pixelion.com.ua",
        "groups" => array("administrator"))
);



// SessionAuthenticator
$moxieManagerConfig['SessionAuthenticator.logged_in_key'] = 'isLoggedIn';
$moxieManagerConfig['SessionAuthenticator.user_key'] = 'user';
$moxieManagerConfig['SessionAuthenticator.config_prefix'] = 'moxiemanager';

// IpAuthenticator
$moxieManagerConfig['IpAuthenticator.ip_numbers'] = '127.0.0.1';

// ExternalAuthenticator
$moxieManagerConfig['ExternalAuthenticator.external_auth_url'] = '/auth.php';
$moxieManagerConfig['ExternalAuthenticator.secret_key'] = 'A000BC77RU';

// Local filesystem
$moxieManagerConfig['filesystem.local.wwwroot'] = '';
$moxieManagerConfig['filesystem.local.urlprefix'] = '{proto}://{host}/';
$moxieManagerConfig['filesystem.local.urlsuffix'] = '';
$moxieManagerConfig['filesystem.local.access_file_name'] = 'mc_access';
$moxieManagerConfig['filesystem.local.allow_override'] = '*';

// Log
$moxieManagerConfig['log.enabled'] = false;
$moxieManagerConfig['log.level'] = 'error';
$moxieManagerConfig['log.path'] = 'data/logs';
$moxieManagerConfig['log.filename'] = '{level}.log';
$moxieManagerConfig['log.format'] = '[{time}] [{level}] {message}';
$moxieManagerConfig['log.max_size'] = '100k';
$moxieManagerConfig['log.max_files'] = '10';
$moxieManagerConfig['log.filter'] = '';

// Storage
$moxieManagerConfig['storage.engine'] = 'json';
$moxieManagerConfig['storage.path'] = './data/storage';

// AutoFormat plugin
$moxieManagerConfig['autoformat.rules'] = '';
$moxieManagerConfig['autoformat.jpeg_quality'] = 100;
$moxieManagerConfig['autoformat.delete_format_images'] = true;

// AutoRename, remember to include it in your plugin config.
$moxieManagerConfig['autorename.enabled'] = true;
$moxieManagerConfig['autorename.spacechar'] = "_";
$moxieManagerConfig['autorename.lowercase'] = true;

// GoogleDrive
$moxieManagerConfig['googledrive.client_id'] = '';

// DropBox
$moxieManagerConfig['dropbox.app_id'] = '';

// Amazon S3 plugin
$moxieManagerConfig['amazons3.buckets'] = array(
    'bucketname' => array(
        'publickey' => '',
        'secretkey' => ''
    )
);

// Ftp plugin
$moxieManagerConfig['ftp.accounts'] = array(
    'ftpname' => array(
        'host' => '',
        'user' => '',
        'password' => '',
        'rootpath' => '/',
        'wwwroot' => '/',
        'passive' => true
    )
);

// Favorites plugin
$moxieManagerConfig['favorites.max'] = 20;

// History plugin
$moxieManagerConfig['history.max'] = 20;
