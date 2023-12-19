<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/etomas36/todo-laravel.git');

add('shared_files', ['.env']);
add('shared_dirs', ['storage', 'public/uploads','bootstrap/cache']);
add('writable_dirs', ['bootstrap/cache', 'storage']);

// Hosts

host('172.16.221.102')
    ->set('remote_user', 'ddaw-ud4-deployer')
    ->set('ssh_multiplexing', false)
    ->set('deploy_path', '/var/www/ddaw-ud4-a4/html/todo-laravel');

// Hooks

after('deploy:failed', 'deploy:unlock');

//task('upload:env', function () {
//    upload('.env.production', '{{deploy_path}}/shared/.env');
//})->desc('Environment setup');
   
task('reload:php-fpm', function () {
    run('sudo systemctl restart php8.1-fpm');
});

after('deploy', 'reload:php-fpm');

task('composer:install', function () {
    run('composer --working-dir=/var/www/prod-ud4-a4/html/todo-laravel/current install');
});