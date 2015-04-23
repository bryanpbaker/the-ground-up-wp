# config valid only for Capistrano 3.1
lock '>=3.2.1'

set :application, 'safeway-website'
set :repo_url, 'git@github.com:sq1agency/safeway-website.git'
set :linked_dirs, %w{wp-content/uploads}

