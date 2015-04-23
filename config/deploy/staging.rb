server 'safeway-website.sq1dev.co', user: "ubuntu", roles: %w{app}

set :branch, "staging"
set :deploy_to, "/var/www/safeway-website/staging"

set :ssh_options, {
  forward_agent: true,
}

namespace :deploy do

    task :config_file do
      on roles :all do
	    execute "rm -r #{release_path}/wp-config.php"
        execute "mv #{release_path}/wp-config_stage.php #{release_path}/wp-config.php"
      end
    end

    task :clear_opcache do
      on roles :all do
        execute "sudo service php5-fpm restart"
      end
    end

    after :publishing, :config_file
    after :config_file, :clear_opcache
end